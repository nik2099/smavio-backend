<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationComplete;
use App\Mail\SubuserInvitationDeleted;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SubUserInvitation;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubUserInvitationMail;
use App\Mail\SubUserLoginDetailShareMail;

class SubUserController extends Controller
{
    public function invite(Request $request){
        $validated = $request->validate([
            'emails' => 'array|required',
            'emails.*' => 'required|string|distinct'
        ]);

        $errors = [];
        $successes = [];

        $user = Auth::user();
        foreach ($validated['emails'] as $email){
            $existing_user = User::where('email', $email)->first();
            if($existing_user){
                 return response()->json(['errors' => ['User with '.$email.' already exists!','success'=>false]], 422);
            }
            
            $invitation = SubUserInvitation::where('email', $email)->where('user_id',Auth::id())->first();
            if(!$invitation){
	            $invitation = new SubUserInvitation();
	            $invitation->user_id = Auth::id();
	            $invitation->email = $email;
	            $invitation->save();
	            Mail::to($email)->send(new SubUserInvitationMail(['user' => $user, 'invitee' => $email]));
            }else{
            	 Mail::to($email)->send(new SubUserInvitationMail(['user' => $user, 'invitee' => $email]));
            	 return response()->json(['errors' => ['User with '.$email.' already invited!','success'=>false]], 422);
            }
            
            array_push($successes, 'User with email `'.$email.'` invited!');
        }
        return response()->json([
            'errors' => $errors,
            'success'=>true,
            'successes' => $successes
        ], 200);
    }

    public function sign_up(Request $request){
        
        $validated = $request->validate([
            'email' => 'required|email',
            'user_id' => 'required|integer|exists:users,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dataProtection' => 'required|boolean|accepted',
            'newsletter' => 'boolean',
            'password' => 'required|string|min:6'
        ]);
        
        $existing_user = User::where('email', $validated['email'])->first();
        
        if($existing_user){
            return response()->json([
                'errors' => [
                    'user' => ['User with this email already exists!']
                    ]
                ], 422);
        }
        
        $validated['password'] = Hash::make($validated['password']);
        $invitation = SubUserInvitation::where('email', $validated['email'])->where('user_id', $validated['user_id'])->first();
        
        if(!$invitation){
            return response()->json(['errors' => ['Invalid invitation!']], 422);
        }
        
        $parentUser = User::findOrFail($validated['user_id']);
        $parentPlanId = $parentUser->plan->id;
        $validated['plan_id'] = $parentPlanId;
        
        $createdUser = User::create($validated);
        SubUserInvitation::where('email', $validated['email'])->delete();
        $invitation->delete();
        Mail::to($createdUser['email'])->send(new RegistrationComplete(['first_name' => $createdUser['first_name']]));
        $token = $createdUser->createToken('token')->plainTextToken;
        $cookie = cookie( 'jwt', $token, 60*24 );
        $createdUser->createAsStripeCustomer();
        return response()->json($createdUser, Response::HTTP_CREATED)->withCookie($cookie);
    }

    public function index (Request $request){
        $user = Auth::user();
        $subusers = $user->sub_users;
        return response()->json($subusers, 200);
    }

    public function delete(Request $request, $id){
        $user = Auth::user();
        $subuser_ids = [];
        foreach($user->sub_users as $sub_user){
            array_push($subuser_ids, $sub_user->id);
        }
        if(!in_array($id, $subuser_ids)){
            return response()->json(['errors' => ['You can not delete this user without permission']], 403);
        }
        $subuser = User::find($id);
        $subuser->delete();
        return response()->json([
            'successes' => ['Successfully removed!'],
            'errors' => []
        ], 200);
    }

    public function check_invitation(Request $request){
        $email = $request->validate(['email' => 'required|string']);
        $invitation = SubUserInvitation::where('email', $email)->first();
        if(!$invitation){
            return response()->json([
                'errors' => ['No invitation found!']
            ], 422);
        }
        $user = $invitation->user;
        return response()->json([
            'name' => $user->first_name . ' ' . $user->last_name,
            'company_name' => $user->company_name
        ]);
    }

    public function delete_invitation(Request $request, $id){
        $invitation = SubUserInvitation::findOrFail($id);
        $invitation->delete();
        Mail::to($invitation->email)->send(new SubuserInvitationDeleted(['user' => $invitation->user, 'invitee' => $invitation->email]));
        return response()->json([
            'successes' => ['Invitation deleted!']
        ]);
    }
    
    
    public function sendDetails(Request $request){
        $validated = $request->validate([
            'emails' => 'array|required',
            'emails.*' => 'required|string|distinct'
        ]);

     
        $successes = [];

        $user = Auth::user();
        foreach ($validated['emails'] as $email){
        	$password = 'qwedsa';
            $existing_user = User::where('email', $email)->first();
            $existing_user->password = Hash::make($password);
            $existing_user->save();
            Mail::to($email)->send(new SubUserLoginDetailShareMail(['user' => $user,'subuser' => $existing_user,'password'=>$password]));
            $successes = 'Sub User with email `'.$email.'` login detail send!';
        }
        return response()->json(['successes' => $successes], 200);
    }
}
