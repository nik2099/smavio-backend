<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Models\TemplateField;
use App\Models\Campaign;
use App\Models\Device;
use App\Models\CampaignField;
use App\Models\Category;
use App\Models\PersonalAccessToken;
use App\Models\NotificationSettings;
use App\Models\CampaignSubscription;
use Illuminate\Support\Str;
use App\Mail\CampaignPaused;
use App\Mail\CampaignCreated;
use App\Mail\UserDeviceLogout;
use Mail;

class CampaignController extends Controller
{
	public function getCampaignList(Request $request){
        $user = $request->user();
        
        $campaigns = $user->campaigns()->whereNull('campaigns.campaign_id')->with('template')->get();
        return response()->json(['campaigns'=>$campaigns], 200);
    }
    
    public function getDeviceList(Request $request){
        $user = $request->user();
        
        $devices = $user->alldevices()->with('user')->get();
        return response()->json(['devices'=>$devices], 200);
    }
    
    public function getAssignedDevices(Request $request, $campaign_id){
    	
    	$user = $request->user();
        $campaign = Campaign::find($campaign_id);
        
    	$device_ids = $user->alldevices()->whereIn('campaign_id',[$campaign_id , $campaign->childCampaign->id])->pluck('id');
    	return response()->json(['device_ids' => $device_ids], 200);
    }
    
    public function assignCampaign(Request $request){

        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'device_ids' => 'required',
            'device_ids.*' => 'required|exists:devices,id'
        ]);
		
		$user = $request->user();
        $campaign_id = $request->get('campaign_id');
        $campaign = $user->campaigns()->where('id',$campaign_id)->first();
        
        
        if(!$campaign){
        	return response()->json(['error'=>"campaign not available"], 200);
        }
        
        $device_ids = $request->device_ids;
        $devices = $user->alldevices()->get();
        
        foreach($devices as $device){
        	
        	if(in_array($device->id, $device_ids)){
	        	if($device->campaign_id != $campaign->childCampaign->id){
		        	$device->campaign_id = $campaign->id;
		        	$device->save();
	        	}
        	}else{
        		if($device->campaign_id == $campaign->id || $device->campaign_id == $campaign->childCampaign->id){
		        	$device->campaign_id = null;
		        	$device->save();
	        	}
        	}
        }
        
        
        return response()->json(['message'=>'campaign publish successfully'], 200);
    }
    
    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required',
            'template_id' => 'required|exists:templates,id'
        ]);
		
		$user = $request->user();
        $template = Template::find($request->template_id);
        $template_fields = $template->fields()->get();
        
        $campaign = $template->campaigns()->create(['name'=>$request->name,'user_id'=>$user->id]);
        $newcampaign = new Campaign();
        $newcampaign = $campaign->replicate();
        $newcampaign->campaign_id = $campaign->id;
        $newcampaign->save();
        // $campaign = new Campaign();
        // $campaign->name = $request->name;
        // $campaign->template_id = $template->id;
        // $campaign->user_id = Auth::id();
        // $campaign->save();
        
        
        
        foreach($template_fields as $template_field){
        	$campaign_field = new CampaignField();
        	$campaign_field->name = $template_field->name;
        	$campaign_field->value = $template_field->value;
        	$campaign_field->property = $template_field->property;
        	$campaign_field->type = $template_field->type;
        	$campaign_field->component = $template_field->component;
        	$campaign_field->template_id = $template_field->template_id;
        	$campaign_field->campaign_id = $campaign->id;
        	$campaign_field->template_field_id = $template_field->id;
        	$campaign_field->save();
        	
        	$newcampaign_field = new CampaignField();
	        $newcampaign_field = $campaign_field->replicate();
	        $newcampaign_field->campaign_id = $newcampaign->id;
	        $newcampaign_field->save();
	        
        }
        
        $campaign_fields = $campaign->fields()->get();
        $template=$campaign->template->get();
        
        $device_ids = $request->device_ids;
        $devices = $user->alldevices()->get();
        
        foreach($devices as $device){
        	
        	if(in_array($device->id, $device_ids)){
	        	$device->campaign_id = $campaign->id;
	        	$device->save();
	        }
        }
        
        $notification_settings = NotificationSettings::where('user_id',$user->id)->first();
        if($notification_settings && $notification_settings->campaign_created == 1){
        	Mail::to($user['email'])->send(new CampaignCreated(['first_name' => $user['first_name'],'campaign'=>$request->name]));
        }
        
        return response()->json(['fields'=>$campaign_fields,'campaign'=>$campaign], 200);
    }
    
    public function update(Request $request, $campaign_id){

        $validated = $request->validate([
            'name' => 'required',
            'template_id' => 'required|exists:templates,id'
        ]);
		
		$user = $request->user();
        $template = Template::find($request->template_id);
        $template_fields = $template->fields()->get();
        
        $campaign = $user->campaigns()->find($campaign_id);
        // return response()->json($campaign, 200);
        
        
        if(!$campaign){
    		return response()->json(['status'=>false,'message'=>"Campaign is not available"], 200);   	
        }
        
        $child_campaign = $user->campaigns()->where('campaign_id',$campaign_id)->first();
        
        $campaign->name = $request->name;
        $child_campaign->name = $request->name;
        
        if($campaign->template_id != $template->id){
    		
    		$campaign->template_id = $template->id;
    		
    		
    		$child_campaign->template_id = $template->id;
    		
    		
    		$campaign->fields()->delete();
    		$child_campaign->fields()->delete();
    		
	        foreach($template_fields as $template_field){
	        	$campaign_field = new CampaignField();
	        	$campaign_field->name = $template_field->name;
	        	$campaign_field->value = $template_field->value;
	        	$campaign_field->property = $template_field->property;
	        	$campaign_field->type = $template_field->type;
	        	$campaign_field->component = $template_field->component;
	        	$campaign_field->template_id = $template_field->template_id;
	        	$campaign_field->campaign_id = $campaign->id;
	        	$campaign_field->template_field_id = $template_field->id;
	        	$campaign_field->save();
	        	
	        	$newcampaign_field = new CampaignField();
		        $newcampaign_field = $campaign_field->replicate();
		        $newcampaign_field->campaign_id = $child_campaign->id;
		        $newcampaign_field->save();
		        
	        }
        }
        
        $campaign->save();
        $child_campaign->save();
        
        $campaign_fields = $campaign->fields()->get();
        $template=$campaign->template->get();
        
        $device_ids = $request->device_ids;
        $devices = $user->alldevices()->get();
        
        foreach($devices as $device){
        	
        	if(in_array($device->id, $device_ids)){
	        	if($device->campaign_id != $child_campaign->id){
		        	$device->campaign_id = $campaign->id;
		        	$device->save();
	        	}
        	}else{
        		if($device->campaign_id == $campaign->id || $device->campaign_id == $child_campaign->id){
		        	$device->campaign_id = null;
		        	$device->save();
	        	}
        	}
        }
        
        return response()->json(['fields'=>$campaign_fields,'campaign'=>$campaign], 200);
    }

    public function getCampaign(Request $request,  $campaign_id){
    	// $user = $request->user();
        $campaign = Campaign::with('template')->find($campaign_id);
        $campaign_ids = [$campaign_id];
        if($campaign->childCampaign){
        	$campaign_ids[] = $campaign->childCampaign->id;	
        }else{
        	$campaign_ids[] = $campaign->campaign_id;
        }
        $device_ids = Device::whereIn('campaign_id',$campaign_ids)->pluck('id');
      
        return response()->json(['campaign'=>$campaign, 'device_ids' => $device_ids], 200);
    }

    public function getCampaignData(Request $request, $campaign_id){
        
        $campaign = Campaign::find($campaign_id);
        $campaign_fields = $campaign->fields()->get();
        return response()->json($campaign_fields, 200);
    }

    public function updateCampaignData(Request $request, $campaign_id){
        
        $user = $request->user();
        $campaign = $user->campaigns()->find($campaign_id);
        // return response()->json($campaign, 200);
        $child_campaign = $user->campaigns()->where('campaign_id',$campaign_id)->first();
        
        $params = $request->all();
        $devices = $user->alldevices()->where('campaign_id',$campaign_id)->update(['campaign_id' => $child_campaign->id]);
        foreach($params['data'] as $componentname => $component_property){
            foreach($component_property as $propertyname => $property_value){
                
                $campaign_field = $campaign->fields()->where('component',$componentname)->where('property',$propertyname)->first();
                $child_campaign_field = $child_campaign->fields()->where('component',$componentname)->where('property',$propertyname)->first();
                
                if($campaign_field){
                	
                	$child_campaign_field = $campaign_field->replicate();
			        $child_campaign_field->campaign_id = $child_campaign->id;
			        $child_campaign_field->save();
			        
                    if($campaign_field->type != 'image'){
                        $campaign_field->value = $property_value;
                        $campaign_field->save();
                    }else{
            
                    	
                    	if(isset($request->data[$componentname][$propertyname])) {
						    
						    $name= substr(md5(Str::random(10)), 0, 8).time();
			                $imageName = $name.'.'.$request->data[$componentname][$propertyname]->getClientOriginalExtension();;
			                $request->data[$componentname][$propertyname]->move(public_path('images/'), $imageName);
			                
	                    	$campaign_field->value = 'images/'.$imageName;
	                        $campaign_field->save();
	                        
					    }
                    }
                }
            }
        }
        
        $campaign_fields = $campaign->fields()->get();
        return response()->json($campaign_fields, 200);
    }

    public function pauseCampaign(Request $request, $campaign_id){

        $user = $request->user();
        $campaign = $user->campaigns()->find($campaign_id);
        $notification_settings = NotificationSettings::where('user_id',$user->id)->first();
        $child_campaign = $user->campaigns()->where('campaign_id',$campaign_id)->first();

        $campaign->status = 0;
        $campaign->save();

        $child_campaign->status = 0;
        $child_campaign->save();

        $devices = $user->alldevices()->whereIn('campaign_id',[$campaign_id , $child_campaign->id])->update(['campaign_id' => null]);
        if($notification_settings && $notification_settings->campaign_paused == 1){
        	Mail::to($user['email'])->send(new CampaignPaused(['first_name' => $user['first_name'],'campaign'=>$campaign['name']]));
        }
        
        return response()->json(["message"=>"Campaign Pause Successfully"], 200);
    }
    
    public function activateCampaign(Request $request, $campaign_id){

        $user = $request->user();
        $campaign = $user->campaigns()->find($campaign_id);
        $child_campaign = $user->campaigns()->where('campaign_id',$campaign_id)->first();

        $campaign->status = 1;
        $campaign->save();

        $child_campaign->status = 1;
        $child_campaign->save();

        return response()->json(["message"=>"Campaign Activated Successfully"], 200);
    }

    public function deleteCampaign(Request $request, $campaign_id){

        $user = $request->user();
        $campaign = $user->campaigns()->find($campaign_id);
        $child_campaign = $user->campaigns()->where('campaign_id',$campaign_id)->first();

        // $campaign->delete();
        $campaign->forceDelete();

        $child_campaign->status = 0;
        $child_campaign->save();
        
		$child_campaign->forceDelete();
        
        $devices = $user->alldevices()->whereIn('campaign_id',[$campaign_id , $child_campaign->id])->update(['campaign_id' => null]);

        return response()->json(["message"=>"Campaign Deleted Successfully"], 200);
    }
    
   
    public function deviceLogout(Request $request){
    	
        $device_id = $request->get('device_id');
        
        $user = request()->user();
        
        
		$device = $user->alldevices()->where('id', $device_id)->first();
		PersonalAccessToken::where('id', $device->token_id)->delete();
		$device->status = 0;
		$device->token_id = NULL;
		$device->save();
		$notification_settings = NotificationSettings::where('user_id',$user->id)->first();
		 if($notification_settings && $notification_settings->device_removed == 1){
        	Mail::to($user['email'])->send(new UserDeviceLogout(['first_name' => $user['first_name'],'device'=>$device]));
        }
		
        return response()->json(["message"=>"Device Logout Successfully"], 200);
    }
    
    
     public function getCategoryList(Request $request){
        $categories = Category::where('status',1)->get();
        return response()->json(['categories' => $categories], 200);
    }
}
