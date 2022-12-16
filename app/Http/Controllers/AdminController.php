<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
      public function getUser(Request $request){
        $user = User::whereNull("role")->orWhere("role","!=","admin")->get();
        
        return response()->json(['users'=>$user], 200);
    }
    
    public function updateProfile(Request $request){
        $validated = $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'phone' => 'string',
            'email' => 'email|required',
            'password' => 'nullable|string|min:6',
            
        ]);
        
        
        $user = $request->user();
         //return response()->json(['message' => 'error successful!', 'validated' => $user], 400);
        
        
        $user->first_name = $request->first_name ? $request->first_name : null;
        $user->last_name = $request->last_name ? $request->last_name : null;
        
        $user->mobile = isset($validated['phone']) ? $validated['phone'] : null;
    
        $user->save();
        if(!empty($validated['password'])){
            $user->password = Hash::make($validated['password']);
            $user->save();
            // $cookie = Cookie::forget('jwt');
            // return response()->json(['message' => 'Logout successful!'], 200)->withCookie($cookie);
        }
        
        $id= $user->id;
        $user = User::where('id', $id)->with(['parent_user', 'sub_users', 'sub_user_invitations', 'plan'])->first();
        $user->profile_picture = !empty($user->profile_picture) ? asset($user->profile_picture):'';//asset('profile_pictures/default.png');
        foreach($user->sub_user_invitations as $key => $invitation){
        	if($invitation->status = "invited"){
        		$user->sub_user_invitations[$key]->status = "Pending";
        	}
        }
        $billingProfile = $user->billing_profile;
        $userDetails = isset($billingProfile) ? array_merge($user->toArray(), $billingProfile->toArray()) : $user->toArray();
        
        return response()->json($userDetails, 200);
    }
}
