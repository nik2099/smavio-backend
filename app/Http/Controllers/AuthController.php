<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationComplete;
use App\Mail\UserProfileDeleted;
use App\Mail\UserPasswordChange;
use App\Models\Plan;
use App\Models\User;
use App\Models\Device;
use App\Models\NotificationSettings;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgetPassword;
use App\Mail\UserDeviceLogin;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    public function user(Request $request){
        $user = User::where('id', Auth::id())->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
        $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
        foreach($user->sub_user_invitations as $key => $invitation){
        	if($invitation->status = "invited"){
        		$user->sub_user_invitations[$key]->status = "Pending";
        	}
        }
        $billingProfile = $user->billing_profile;
        $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
        $userDetails['site_url']=env('SITE_URL', "https://sandbox.smavio.de");
        return response()->json($userDetails, 200);
    }

    public function register (Request $request){
        $user = $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required|unique:users,email',
            'password' => 'string|required|min:6|max:18',
            'pucode' => 'string',
            'privacy' => 'required|boolean|accepted',
            'newsletter' => 'required|boolean'
        ]);
        
        // $user['pucode'] = Crypt::encryptString($user['password']);
        $user['pucode'] = $user['password'];
        $user['password'] = Hash::make($user['password']);
        
        $existing_user = User::where('email', $user['email'])->get();
        if(count($existing_user) > 0){
            return response()->json([
                'errors' => [
                    'user' => ["User already exists!"]
                ]
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $freePlan = Plan::where('title', 'Free')->first();
        $user['plan_id'] = $freePlan->id;
        $createdUser = User::create($user);
        $token = $createdUser->createToken('token')->plainTextToken;

        $cookie = cookie( 'jwt', $token, 60*24);
        $createdUser->createAsStripeCustomer();
        Mail::to($user['email'])->send(new RegistrationComplete(['first_name' => $user['first_name']]));
        
        $user = User::where('id', $createdUser->id)->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
        $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
        foreach($user->sub_user_invitations as $key => $invitation){
        	if($invitation->status = "invited"){
        		$user->sub_user_invitations[$key]->status = "Pending";
        	}
        }
        $billingProfile = $user->billing_profile;
        $user->token = $token;
        $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
        return response()->json($userDetails, Response::HTTP_CREATED)->withCookie($cookie);
        
    }

    public function login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'string|min:6|max:18|required'
        ]);
   
        if($validator->fails()){
            return response()->json([
                'errors' => ['Invalid credentials!']
                // 'errors' =>$validator->errors()
            ],Response::HTTP_UNAUTHORIZED);
        }
        
        $credentials = $request->only('email', 'password');
        
        if(!Auth::attempt($credentials)){
        	
            return response()->json([
                'errors' => ['Invalid credentials!']
            ],Response::HTTP_UNAUTHORIZED);
            
        }
        
        $user = User::where('id', Auth::id())->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
         //return response()->json($user, 200);
        
        $parent_id = $user->id;
        $device_type = ($request->get('device_type') == 'app')?'app':'web';
        
        if($device_type == 'app'){
	        
	        $allocated_campaign = null;
	        $device_details = $request->get('device_detail');
	        $device_uuid = $request->get('deviceId');
	        if(is_array($device_uuid)){
	        	$device_uuid = $device_uuid['uuid'];
	        }
	        $app_version = $request->get('appversion');
	        
	        $locality = $request->get('locality');
	       
	        $subAdministrativeArea = $request->get('subAdministrativeArea');
	        
	         	// return response()->json([$device_uuid]);
	         	// return response()->json(['locality'=>$locality]);
	         
	        if($user->user_id){
	        
	        	$parent =(!empty($user->user_id))? $user->parent_user:$user;
	        	$parent_id = $parent->id;
	        	// return json_encode($parent->plan,200);
	        	// exit;
	        	
	        	if($parent->plan->no_of_device <= $parent->alldevices()->where('device_type','app')->whereIn('status',[1,2])->count()){
	        		
	        		return response()->json([
		                'errors' => [$parent->alldevices()->whereIn('status',[1,2])->count().'Devices already login. Please contect your Admin']
		            ],Response::HTTP_UNAUTHORIZED);
	        	}
	        }
	        
	    	if($user->mydevices()->where('device_type','app')->count() > 0){
	        	
	        	$token_ids = $user->mydevices()->where('device_type','app')->pluck('token_id');
	        	$user->tokens()->whereIn('id',$token_ids)->delete();
	        	$allocated_campaign = $user->mydevices()->where('device_uuid','=',$device_uuid)->first();
				if($allocated_campaign){
				$allocated_campaign=$allocated_campaign->campaign_id;
				}

	        	// $user->mydevices()->delete();
	        	Device::where('device_uuid','=',$device_uuid)->delete();
	        	
	        }
        }else{
        	if($user->user_id != null){
        		return response()->json([
		                'errors' => ["You are subuser, you don't have permission to login in user panel"]
		            ],Response::HTTP_UNAUTHORIZED);
        		
        	}
        }
        
        $token = $user->createToken('token');
        $user->token = $token->plainTextToken;
        $cookie = cookie( 'jwt', $user->token, 60*24 );
        $device_type = ($request->get('device_type') == 'app')?'app':'web';
     
        if($device_type == 'app'){
	        
	        	// return response()->json(['user'=>$user]);
	        
	        $device = $user->mydevices()->create([
	        	'token_id'=>$token->accessToken->id,
	        	'parent_user_id'=>$parent_id,
	            'name'=>(array_key_exists("name",$device_details)) ? $device_details['name']:'browser',
	            'manufacturer'=>$device_details['manufacturer'],
	            'device_type'=>$device_type,
	            'platform'=>$device_details['platform'],
	            'model'=>$device_details['model'],
	            'operating_system'=>$device_details['operatingSystem'],
	            'osversion'=>$device_details['osVersion'],
	            'device_uuid'=>$device_uuid,
	            'app_version'=>$app_version,
	            'campaign_id'=>$allocated_campaign
	            
	            //default status = 1; status 0 for logout, 1 for loginn and online, 2 for login but offline
	            
	        ]);
	        
	        if(!empty($locality)){
	            $device->locality = $locality;
	            $device->subAdministrativeArea = $subAdministrativeArea;
		        $device->save();
	        }
	        
        	$notification_settings = NotificationSettings::where('user_id',$user->id)->first();
			 if($notification_settings && $notification_settings->device_connected == 1){
	        	Mail::to($user['email'])->send(new UserDeviceLogin(['first_name' => $user['first_name'],'device'=>$device]));
	        }
        }
         //$user = User::where('id', Auth::id())->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
        $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
        foreach($user->sub_user_invitations as $key => $invitation){
        	if($invitation->status = "invited"){
        		$user->sub_user_invitations[$key]->status = "Pending";
        	}
        }
        $billingProfile = $user->billing_profile;
        $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
        $userDetails['site_url']= env('SITE_URL', "https://sandbox.smavio.de");
        return response()->json($userDetails, 200)->withCookie($cookie);
    }

    public function logout (Request $request){
        Cookie::expire('jwt');
        Cookie::expire('XSRF-TOKEN');
        Cookie::expire('smavio_session');
        $user = request()->user(); //or Auth::user()
		
		// Revoke current user token
		$user->mydevices()->where('token_id', $user->currentAccessToken()->id)->update(['status'=>0]);
		$user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json(['message' => 'Logout successful!'], 200)->withoutCookie('jwt');
    }

    public function forget_password(Request $request){
        $validated = $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $validated['email'])->first();
        $otp = rand(111111, 999999);
        $user->otp = $otp;
        $user->save();
        try{
            Mail::to($user->email)->send(new ForgetPassword([
                'first_name' => $user->first_name,
                'code' => $otp,
                'email' => $user->email
            ]));
            return response()->json([
                'message' => 'Password request code sent via email!'
            ], 200);
        }catch(\Exception $error){
            return response()->json($error->getMessage());
        }

    }

    public function reset_password(Request $request){
        $errors = [];
        $successes = [];
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|min:6|max:6',
            'password' => 'required|confirmed'
        ]);
        $user = User::where('email', $validated['email'])->first();
        if($user->otp == $validated['otp']){
            $user->pucode = $validated['password'];
            $user->password = Hash::make($validated['password']);
            $user->save();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie( 'jwt', $token, 60*24 );
            Mail::to($user['email'])->send(new UserPasswordChange(['first_name' => $user['first_name']]));
            return response()->json($user, 200)->withCookie($cookie);
        }else{
            return response()->json([
                'errors' => [['Invalid code or email!']]
            ], 422);
        }
    }

    public function delete_profile(Request $request){
        $user = Auth::user();
        $billingProfile = $user->billing_profile;
        if(isset($billingProfile)){
            $billingProfile->delete();
        }
        $invitations = $user->sub_user_invitations;
        if(isset($invitations)){
            foreach ($invitations as $invitation){
                $invitation->delete();
            }
        }
        $sub_users = $user->sub_users;
        if(isset($sub_users)){
            foreach ($sub_users as $sub_user){
                $sub_user->delete();
            }
        }
        $user->subscription('default')->cancel();
        $user->delete();
        Mail::to($user['email'])->send(new UserProfileDeleted(['first_name' => $user['first_name']]));
        return response()->json(['message' => 'Successfully Deleted!'], 204)->withCookie(Cookie::forget('jwt'));
    }

    public function update_profile_picture(Request $request){
        $user = Auth::user();
        $validated = $request->validate([
            'image' => 'file|required'
        ]);
      	
      	if(!$request->hasFile('image')) {
	        return response()->json(["message"=>'upload file not found'], 400);
	    }
        $file = $request->file('image');
        $fileExt = $request->file('image')->getClientOriginalExtension();
        $fileName = $user->id."".time(). "." . $fileExt;
        $result = $file->move(public_path('profile_pictures'), $fileName);
        $user->profile_picture = '/profile_pictures/'.$fileName;
		$user->save();
        
        if($result){
        	
		    $user = User::where('id', $user->id)->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
            $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
            foreach($user->sub_user_invitations as $key => $invitation){
            	if($invitation->status = "invited"){
            		$user->sub_user_invitations[$key]->status = "Pending";
            	}
            }
            $billingProfile = $user->billing_profile;
            $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
            	
		    return response()->json([
		        'profile_picture' => $user->profile_picture,
		        'user' =>$userDetails
		    ], 200);
        }else{
        	return response()->json(["message"=>'file not uploaded'], 400);
        }
    }
    
    public function delete_profilepic(Request $request){
        $user = Auth::user();
        
        $user->profile_picture = '';
		$result = $user->save();
        
	    $user = User::where('id', $user->id)->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
        $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
        foreach($user->sub_user_invitations as $key => $invitation){
        	if($invitation->status = "invited"){
        		$user->sub_user_invitations[$key]->status = "Pending";
        	}
        }
        $billingProfile = $user->billing_profile;
        $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
        	
	    return response()->json([
	        'user' =>$userDetails
	    ], 200);
    
    }
    
}
