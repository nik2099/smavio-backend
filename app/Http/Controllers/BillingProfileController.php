<?php

namespace App\Http\Controllers;

use App\Models\BillingProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class BillingProfileController extends Controller
{
    public function update(Request $request){
        $validated = $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'phone' => 'string',
            'email' => 'email|required',
            'password' => 'string|min:6',
            'company_name' => 'string',
            'industry' => 'string',
            'role' => 'string',
            'newsletter' => 'boolean',
            'billing_first_name' => 'string|required_with:billing_first_name,tax_id',
            'billing_last_name' => 'string|required_with:billing_first_name,tax_id',
            'billing_company_name' => 'string',
            'street' => 'string',
            'house_no' => 'string',
            'postcode' => 'string',
            'city' => 'string',
            'country' => 'string',
            'tax_id' => 'string',
        ]);
        $user = Auth::user();
        $user->first_name = isset($validated['first_name']) ? $validated['first_name'] : null;
        $user->last_name = isset($validated['last_name']) ? $validated['last_name'] : null;
        $user->newsletter = isset($validated['newsletter']) ? $validated['newsletter'] : 0;
        $user->email = isset($validated['email']) ? $validated['email'] : null;
        $user->mobile = isset($validated['phone']) ? $validated['phone'] : null;
        $user->company_name = isset($validated['company_name']) ? $validated['company_name'] : null;
        $user->industry = isset($validated['industry']) ? $validated['industry'] : null;
        $user->role = isset($validated['role']) ? $validated['role'] : null;
        $billingProfile = $user->billing_profile;
        if(!$billingProfile && isset($validated['first_name']) && isset($validated['last_name']) && isset($validated['tax_id'])){
            $billingProfile = new BillingProfile();
        }
        if($billingProfile){
            $billingProfile->billing_first_name = isset($validated['first_name']) ? $validated['first_name'] : null;
            $billingProfile->billing_last_name = isset($validated['last_name']) ? $validated['last_name'] : null;
            $billingProfile->phone = isset($validated['phone']) ? $validated['phone'] : null;
            $billingProfile->billing_company_name = isset($validated['billing_company_name']) ? $validated['billing_company_name'] : null;
            $billingProfile->street = isset($validated['street']) ? $validated['street'] : null;
            $billingProfile->house_no = isset($validated['house_no']) ? $validated['house_no'] : null;
            $billingProfile->postcode = isset($validated['postcode']) ? $validated['postcode'] : null;
            $billingProfile->city = isset($validated['city']) ? $validated['city'] : null;
            $billingProfile->country = isset($validated['country']) ? $validated['country'] : null;
            $billingProfile->taxId = isset($validated['tax_id']) ? $validated['tax_id'] : null;
            $billingProfile->user_id = Auth::id();
            $billingProfile->save();
            $user->billing_profile_id = $billingProfile->id;
        }


        $user->save();
        if(isset($validated['password'])){
            $user->password = Hash::make($validated['password']);
            $user->save();
            $cookie = Cookie::forget('jwt');
            return response()->json(['message' => 'Logout successful!'], 200)->withCookie($cookie);
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
