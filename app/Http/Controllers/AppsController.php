<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyApp;
use App\Models\NotificationSettings;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Device;
use App\Models\CampaignSubscription;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAddMyApps;

class AppsController extends Controller
{
    public function getAppsList(Request $request){
        $user = $request->user();
        
        $apps = $user->apps()->with('category')->get();
        return response()->json(['apps'=>$apps], 200);
    }
    
    public function getMyAppsIds(Request $request){
        $user = $request->user();
        
        $apps = $user->apps()->pluck('templates.id');
        return response()->json(['apps'=>$apps], 200);
    }
    
    
    public function setMyApps(Request $request){
    	
    	 $validated = $request->validate([
            'template_id' => 'required|array',
            'template_id.*'=> 'required|exists:templates,id'
        ]);
        
        $user = $request->user();
        $template_ids = array_unique($request->template_id);
        $no_of_campaigns = $request->no_of_campaigns;
        
        $apps = $user->apps()->pluck('templates.id');
        
        $user->apps()->sync($template_ids);
     
		$apps = $user->apps()->pluck('templates.id');
	    
    	$notification_settings = NotificationSettings::where('user_id',$user->id)->first();
		 if($notification_settings && $notification_settings->app_added == 1){
        	Mail::to($user['email'])->send(new UserAddMyApps(['first_name' => $user['first_name'],'apps'=>$apps]));
        }
	        
		return response()->json(['apps'=>$apps], 200);
		
        
	
    }
    
    
    public function getDeviceRecords(Request $request){
       	
       	$validated = $request->validate([
            'device_id' => 'required'
        ]);
        
        $device_id = $request->device_id;
        $user = $request->user();
        // $user = User::find(6);
        $device = $user->alldevices()->where('id', $device_id)->first();
        
        if(!$device){
        	return response()->json(['msg'=>'Device not found','success'=>false], 200);
        }
        
        $date_7_day_before = Carbon::now()->subDays(6);
        
        $daywise_data = [];
        $date_label_list = [];
        $date = $date_7_day_before->copy();
    
        for($day=1; $day<=7; $day++){
    
        	$date_label_list[] = $date->format('Y-m-d');
        	$date = $date->addday();
        	$daywise_data[]=0;
        	
        }
    
        $date = $date_7_day_before->copy();
        $histories = History::where('device_id',$device_id)->where('user_id',$device->user_id)->where(function($query){
        	$query->whereNull('logout_time')->orWhere('logout_time','>',Carbon::now()->subDays(7));
        })->get();
    	
    	foreach($histories as $history){
    		
    		$selected_date = $date->format('Y-m-d');
    		if($history->logout_time == null){
    			$history->logout_time =	Carbon::now();
    		}
    		$logout_date = $history->logout_time->copy()->format('Y-m-d');
    		$login_date = $history->login_time->copy()->format('Y-m-d');
    		
    		
    		$key = array_search($login_date , $date_label_list);
    		
    		if($key){
    			
    			
    			if($login_date < $logout_date){
    				echo 1;
    				exit;
	    			$endofday = $history->login_time->copy()->endOfDay();
					$daywise_data[$j] = $history->login_time->diffInMinutes($endofday);
	    			$diff = $endofday->diffInMinutes($history->logout_time);
	    			$j = $key;
	    			
	    			while($diff> 0){
	    			
	    				if($diff>1440){
	    					$daywise_data[$j] = $daywise_data[$j] + 1440;
	    				}else{
	    					$daywise_data[$j] = $daywise_data[$j] + $diff;
	    				}
					
						$diff -= 1440;
	    			
	    			}
    				
    			}elseif($login_date == $logout_date){
    				
	    			$daywise_data[$key] = $daywise_data[$key] + $history->login_time->diffInMinutes($history->logout_time);
	    		
	    		}
    			
    		}else{
    			
    			$key = 0;
    			$startofday = $date->copy()->startOfDay();
    			
    			if($selected_date < $logout_date){
	    			$diff = $startofday->diffInMinutes($history->logout_time);
	    			$j = $key;
    			
	    			while($diff> 0){
	    			
	    			
	    				if($diff>1440){
	    					$daywise_data[$j] = $daywise_data[$j] + 1440;
	    				}else{
	    					$daywise_data[$j] = $daywise_data[$j] + $diff;
	    				}
					
						$diff -= 1440;
						
						$j++;
	    				
	    			}
    			}elseif($selected_date == $logout_date){
    			
	    			$daywise_data[$key] = $daywise_data[$key] + $startofday->diffInMinutes($history->logout_time);
	    		
	    		}
    			
    			
    		}
    		
    	}
    	
    	
    	foreach($daywise_data as $key => $data_in_minute){
    		$hours = (float)($data_in_minute/60);
    		$daywise_data[$key] = 	round($hours,2);
    	}
    	
    	$subuser_ids = $user->sub_users()->pluck('id');
    	$subuser_ids[]=$user->id;
    	$campaignSubscription = CampaignSubscription::whereIn('user_id',$subuser_ids)->get();
        // $campaignSubscription = $user->allcampaignSubscription()->get();
        return response()->json(['subscription'=>$campaignSubscription,'total'=>count($campaignSubscription),'daywise_data'=>$daywise_data,'date_label_list'=>$date_label_list], 200);

    }
    
    
    public function getResult(Request $request){
       	
        $user = $request->user();
        $from_date = $request->input('date');
        // dd($from_date);
        if(empty($from_date)){
        	$start_date =	Carbon::today();
        	$end_date =	Carbon::today()->addDay();
        }else{
        	if(!empty($from_date[0])){
        		$start_date = Carbon::parse($from_date[0]);
        	}
        	if(!empty($from_date[1])){
        		$end_date = Carbon::parse($from_date[1])->addDay();
        	}else{
        		$end_date = $start_date->addDay()->copy();	
        	}
        }
        // $date_7_day_before = Carbon::now()->subDays(6);
        
        $daywise_data = [];
        $date_label_list = [];
        $date = $start_date->copy();
    	$diff = $start_date->diffInDays($end_date);
    	
        for($day=1; $day<=$diff; $day++){
    
        	$date_label_list[] = $date->format('Y-m-d');
        	$date = $date->addday();
        	$daywise_data[]=0;
        	
        }
    
        $date = $start_date->copy();
        $histories = History::where('user_id',$user->user_id)->where(function($query) use ($end_date){
        	$query->whereNull('logout_time')->orWhere('logout_time','>',$end_date);
        })->get();
    	
    	foreach($histories as $history){
    		
    		$selected_date = $date->format('Y-m-d');
    		if($history->logout_time == null){
    			$history->logout_time =	$end_date;
    		}
    		$logout_date = $history->logout_time->copy()->format('Y-m-d');
    		$login_date = $history->login_time->copy()->format('Y-m-d');
    		
    		
    		$key = array_search($login_date , $date_label_list);
    		
    		if($key){
    			
    			
    			if($login_date < $logout_date){
    				echo 1;
    				exit;
	    			$endofday = $history->login_time->copy()->endOfDay();
					$daywise_data[$j] = $history->login_time->diffInMinutes($endofday);
	    			$diff = $endofday->diffInMinutes($history->logout_time);
	    			$j = $key;
	    			
	    			while($diff> 0){
	    			
	    				if($diff>1440){
	    					$daywise_data[$j] = $daywise_data[$j] + 1440;
	    				}else{
	    					$daywise_data[$j] = $daywise_data[$j] + $diff;
	    				}
					
						$diff -= 1440;
	    			
	    			}
    				
    			}elseif($login_date == $logout_date){
    				
	    			$daywise_data[$key] = $daywise_data[$key] + $history->login_time->diffInMinutes($history->logout_time);
	    		
	    		}
    			
    		}else{
    			
    			$key = 0;
    			$startofday = $date->copy()->startOfDay();
    			
    			if($selected_date < $logout_date){
	    			$diff = $startofday->diffInMinutes($history->logout_time);
	    			$j = $key;
    			
	    			while($diff> 0){
	    			
	    			
	    				if($diff>1440){
	    					$daywise_data[$j] = $daywise_data[$j] + 1440;
	    				}else{
	    					$daywise_data[$j] = $daywise_data[$j] + $diff;
	    				}
					
						$diff -= 1440;
						
						$j++;
	    				
	    			}
    			}elseif($selected_date == $logout_date){
    			
	    			$daywise_data[$key] = $daywise_data[$key] + $startofday->diffInMinutes($history->logout_time);
	    		
	    		}
    			
    			
    		}
    		
    	}
    	
    	
    	foreach($daywise_data as $key => $data_in_minute){
    		$hours = (float)($data_in_minute/60);
    		$daywise_data[$key] = 	round($hours,2);
    	}
    	
    	$subuser_ids = $user->sub_users()->pluck('id');
    	$subuser_ids[]=$user->id;
    	$campaignSubscription = CampaignSubscription::whereIn('user_id',$subuser_ids)->whereBetween('created_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 00:00:00"])->with('user')->with('campaign')->get();
        // $campaignSubscription = $user->allcampaignSubscription()->get();
        return response()->json(['subscription'=>$campaignSubscription,'total'=>count($campaignSubscription),'daywise_data'=>$daywise_data,'date_label_list'=>$date_label_list], 200);

    }
    
}
