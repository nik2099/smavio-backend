<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Models\TemplateField;
use App\Models\Campaign;
use App\Models\CampaignField;
use App\Models\CampaignSubscription;
use App\Models\User;
use App\Models\Device;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppUserController extends Controller
{
	
    public function getCampaign(Request $request){

		$user = $request->user();
		
        $device_uuid = $request->get('device_uuid');
        // return response()->json(['device_uuid'=>$device_uuid,'success'=>false], 200);
        $device = $user->mydevices()->where('device_uuid','=',$device_uuid)->first();
        
        if(!$device){
        	return response()->json(['error'=>"something went wrong with device. Please login Again",'success'=>false], 200);
        }else{
        	
        	$campaign_id = $device->campaign_id;
        	$device->status = 1;
        	$device->save();
        	
        	$history = History::where('device_id',$device->id)->where('user_id',$user->id)->whereNull('logout_time')->first();
        
        	if(!$history){
        		$history = new History();
        		$history->user_id = $user->id;
        		$history->device_id = $device->id;
        		$history->login_time = Carbon::now();
        		$history->save();
        		
        	}
        	
        	if(!empty($campaign_id)){
	        	
	        	if($user->user_id == null){
	        		$campaign = $user->campaigns()->where('id',$campaign_id)->first();
        		}else{
        			$campaign = $user->parent_user->campaigns()->where('id',$campaign_id)->first();
        		}
	        	if(!$campaign){
	        		return response()->json(['error'=>"something went wrong with campaign. Please Contact with Admin",'success'=>false], 200);
	        	}else{
	        	
	        		if(!empty($campaign->campaign_id)){
	        			$history->campaign_id = $campaign->campaign_id;
	        			$history->updated_at = Carbon::now();
	        			$history->save();
	        			
	        			$device->updated_at = Carbon::now();
	        			$device->save();
	        			return response()->json(['campaign_id'=>$campaign_id,'history'=>$history,'campaign_name'=>$campaign->name,'update_available'=>true,'success'=>true,'error'=>''], 200);		
	        		}else{
	        			$history->campaign_id = $campaign_id;
	        			$history->updated_at = Carbon::now();
	        			$history->save();
	        			
	        			$device->updated_at = Carbon::now();
	        			$device->save();
	        			return response()->json(['campaign_id'=>$campaign_id,'history'=>$history,'campaign_name'=>$campaign->name,'update_available'=>false,'success'=>true,'error'=>''], 200);
	        		}	
	        	}
	        	
        	}else{
        		return response()->json(['error'=>"Campaign is not assign to you. Please Contact with Admin",'success'=>false], 200);	
        	}
        }
        
    }
    
    public function updateCampaign(Request $request){

		$user = $request->user();
		
        $device_uuid = $request->get('device_uuid');
        $device = $user->mydevices()->where('device_uuid','=',$device_uuid)->first();
        
        if(!$device){
        	return response()->json(['error'=>"something went wrong with device. Please login Again",'success'=>false], 200);
        }else{
        	
        	$campaign_id = $device->campaign_id;
        	
        	if(!empty($campaign_id)){
	        	
	        	$campaign = $user->campaigns()->where('id',$campaign_id)->first();
	        	
	        	if(!$campaign){
	        		return response()->json(['error'=>"something went wrong with campaign. Please Contect with Admin",'success'=>false], 200);
	        	}else{
	        		
	        		if(!empty($campaign->campaign_id)){
	        			
	        			$device->campaign_id = $campaign->campaign_id;
	        			$device->save();
	        			
	        			return response()->json(['campaign_id'=>$campaign->campaign_id,'campaign_name'=>$campaign->name, 'update_available'=>false, 'success'=>true, 'msg'=> "Campaign Update Successfully", 'error'=>''], 200);		
	        		
	        		}else{
	        			return response()->json(['error'=>'campaign already updated','success'=>false], 200);
	        		}	
	        	}
	        	
        	}else{
        		return response()->json(['error'=>"Campaign is not assign to you. Please Contect with Admin",'success'=>false], 200);	
        	}
        }
        
    }
    
    public function campaignSubscription(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'campaign_id' => 'required|exists:campaigns,id'
        ]);
        
       
        $subscription = new CampaignSubscription();
        $subscription->campaign_id = $request->campaign_id;
        $subscription->name = $request->name;
        $subscription->email = $request->email;
        $subscription->question1 = $request->question1;
        $subscription->question2 = $request->question2;
        $subscription->question3 = $request->question3;
        $subscription->save();
        
        return response()->json(['success' => true,'msg' => 'Thank you for subscription'],200);
    }
    
    public function getSubUser(Request $request){
    	$user = Auth::user();
    	$subusers = $user->sub_users;
    	return response()->json(['subuser'=>$subusers], 200);
    }
    
     public function cronTest(){
    
    	$devices = Device::where('status',1)->get();
    	$notupdated_history_ids = [];

 

    	foreach($devices as $device){
    		$updated_at = $device->updated_at;
			$now = Carbon::now();
			
			$histories = History::where('device_id',$device->id)->where('user_id',$device->user_id)->whereNull('logout_time')->get();
    	  
    		if($updated_at->diffInMinutes($now) > 1){
    			$device->status = 0;
    			$device->save();
    			
    			
    			foreach($histories as $history){
    				$history->logout_time = time();
    				$history->save();
    				$updated_history_ids[] = $history->id;
    			}
    		}else{
    			$notupdated_history_ids = array_merge($notupdated_history_ids, $histories->pluck('id')->toArray());
    		}
    		
    		
    	}
    	$histories = History::whereNotIn('id',$notupdated_history_ids)->whereNull('logout_time')->update(['logout_time'=>time()]);
        
        return 0;
    }
    
     public function getCampaignSubscription(Request $request){
        $user = $request->user();
        
        
        $campaignSubscription = $user->allcampaignSubscription()->get();
        return response()->json(['subscription'=>$campaignSubscription,'total'=>count($campaignSubscription)], 200);
    }
    
    
    
}


