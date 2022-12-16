<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionCancelled;
use App\Mail\SubscriptionPlanChanged;
use App\Mail\SubscriptionResumed;
use App\Mail\UserSubscribed;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\MyApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use PDF;

class SubscriptionController extends Controller
{
    public function create_subscription(Request $request, $id, $coupon = null){
        // try{
       
	        if(!empty($coupon)){
	            $coupon = strtolower($coupon);
	        }
	        $newplan = Plan::findOrFail($id);
	        $user = Auth::user();
	        $paymentMethod = $user->defaultPaymentMethod();
	        $current_plan = $user->plan->get();
	         
	        if($user->current_subscription != 'Free'){
	            if(!empty($coupon)){
	                $subscription = $user->subscription('default')->withCoupon($coupon)->swap([$newplan->pricing_id]);
	            }else{
	                $subscription = $user->subscription('default')->swap([$newplan->pricing_id]);
	            }
	            foreach ($user->sub_users as $sub_user){
	                $sub_user->plan_id = $id;
	                $sub_user->save();
	            }
	            Mail::to($user->email)->send(new SubscriptionPlanChanged(['first_name' => $user->first_name, 'plan' => $newplan->title]));
	        }else{
	            if(!empty($coupon)){
	                $subscription = $user->newSubscription('default',$newplan->pricing_id)->withCoupon($coupon)->create($paymentMethod->id);
	            }else{
	                $subscription = $user->newSubscription('default',$newplan->pricing_id)->create($paymentMethod->id);
	            }
	            foreach ($user->sub_users as $sub_user){
	                $sub_user->plan_id = $id;
	                $sub_user->save();
	            }
	            
	            Mail::to($user->email)->send(new UserSubscribed(['first_name' => $user->first_name, 'plan' => $newplan->title]));
	        }
	        
	        $user->plan_id = $newplan->id;
	        $user->save();
	        
	        $user_campaigns = $user->campaigns()->whereNull('campaigns.campaign_id')->get();
	        $apps = $user->apps()->get();
	        $user_campaign_count = $user_campaigns->count();
	        
	        
	        if($apps->count() > $newplan->no_of_templates){
	        	$used_template_ids = $user_campaigns->sortByDesc('updated_at')->unique('template_id')->take($newplan->no_of_campaigns)->pluck('template_id');
	        	
	        	if($used_template_ids->count() > $newplan->no_of_templates){
	        		$used_template_ids = $apps->whereIn('id',$used_template_ids)->sortByDesc('pivot_created_at')->take($newplan->no_of_templates)->pluck('id')->toArray();
	        	}
	        	    
	        	$user->apps()->sync($used_template_ids);
	        	
	        }else if($apps->count() < $newplan->no_of_templates){
	        	
				$diff_template = $newplan->no_of_templates-$apps->count();
				if($user_campaign_count < $newplan->no_of_campaigns){
					$new_template_id = $user->trashedCampaigns()->groupBy('template_id')->whereNull('campaigns.campaign_id')->limit($diff_template)->pluck('template_id');
				}else{
					$new_template_id = MyApp::where('user_id',$user->id)->whereNull('apps.deleted_at')->limit($diff_template)->pluck('template_id');
				}
				
				$used_template_ids = $user->apps()->pluck('templates.id');
				// dd($used_template_ids);
				
				$diff = $new_template_id->diff($used_template_ids);
				if(count($diff->all())){
	        		$user->apps()->attach($diff->all());
				}
	        	
	        	$used_template_ids = $user->apps()->distinct('templates.id')->pluck('templates.id');
	        	
	        }else{
	        	$used_template_ids = $user->apps()->distinct('templates.id')->pluck('templates.id');
	        }
	        
	        
	        if($user_campaign_count > $newplan->no_of_campaigns){
	        	$selected_campaign_ids = $user_campaigns->whereIn('template_id',$used_template_ids)->sortBy('updated_at')->take($newplan->no_of_campaigns)->pluck('id')->toArray();
	        	$user->campaigns()->where(function($query) use ($selected_campaign_ids){
	        		$query->whereNotIn('campaigns.id',$selected_campaign_ids);	
	        	})->where(function ($query) use ($selected_campaign_ids){
            		$query->whereNotIn('campaigns.campaign_id',$selected_campaign_ids)->orWhereNull('campaigns.campaign_id');
	        	})->delete();
	        	
	        	$selected_campaign_ids = $user->campaigns()->pluck('id');
	        }else{
	        	
	        	if($used_template_ids->count()){
	        		$user->campaigns()->whereNotIn('template_id',$used_template_ids)->delete();
	        	}
	        	$limit = ($newplan->no_of_campaigns - $user->campaigns()->whereNull('campaigns.campaign_id')->count())*2;
	        	// dd($limit);
	        	$cm_ids = $user->trashedCampaigns()->whereIn('template_id',$used_template_ids)->limit($limit)->restore();
	        	// dd($cm_ids);
	        	//restore();
	        	$selected_campaign_ids = $user->campaigns()->pluck('id');
	        }
	        
	        $user_devices = $user->alldevices()->get();
	        
	        if($user_devices->count() > $newplan->no_of_device){
	        	$selected_devices_id = $user->alldevices()->whereIn('campaign_id',$selected_campaign_ids)->orWhereNull('campaign_id')->orderBy('updated_at','desc')->skip($newplan->no_of_device)->delete();
	        	// $selected_devices_id->delete();
	        }
	        
	        
	        
	
	        return response()->json($subscription, 200);
        // }
        // catch(Exception $e){
        // 	return response()->json($e, 400);
        // }
    }

    public function cancel_subscription(Request $request){
        $user = Auth::user();
        if($user->current_subscription != 'Free') {
            $user->subscription('default')->cancel();
            Mail::to($user->email)->send(new SubscriptionCancelled(['first_name' => $user->first_name, 'plan' => $user->current_subscription]));
        }
        return response()->json([
            'successes' => ['Subscription cancelled!']
        ], 200);
    }

    public function resume_subscription(Request $request){
        $user = Auth::user();
        if($user->current_subscription != 'Free') {
            $user->subscription('default')->resume();
            Mail::to($user->email)->send(new SubscriptionResumed(['first_name' => $user->first_name, 'plan' => $user->current_subscription]));
        }
        return response()->json([
            'successes' => ['Subscription resumed!']
        ], 200);
    }

    public function invoices(Request $request){
        $user = Auth::user();
        $invoices = $user->invoicesIncludingPending();
        return response()->json($invoices, 200);
    }
    
     public function retriveInvoice(Request $request, $id){
        $user = Auth::user();
        $invoices = $user->findInvoice($id);
        $pdf = PDF::loadView('invoice', ['invoice'=>$invoices]);
		$path = public_path('invoice/');
		$filename =  $id.'.pdf';
		$pdf->save($path . '/' .$filename);
		// $pdf->download('invoice.pdf');
        return response()->json(['invoiceData'=>$invoices, "URL" => asset("invoice/".$filename)], 200);
        return response()->json($invoices, 200);
    }
    
    
     public function create_paypal_subscription(Request $request, $id){
      
        $newplan = Plan::findOrFail($id);
        $user = Auth::user();
        $subscription_id = $request->get('subscription_id');
       
        $user->plan_id = $newplan->id;
        $user->paypal_subscription_id =$subscription_id;
        $user->save();
        
        // $apiURL = 'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_id;
        
        // $headers = [
        //     "Authorization"=> 'Bearer A21AAL1Qk_Ro_S-6qdvgSpkPz5sVUqpQp_dtYyh67MUfJxdL7qb_PDiIabYCNLldxTE8dsr4oISd4q2U1mU7Pa64anxTGPxRw'
        // ];
        
        // $response = Http::withHeaders($headers)->get($apiURL);
  
        // $statusCode = $response->status();
        // $responseBody = json_decode($response->getBody(), true);
        
        // echo $statusCode;  // status code
        // dd($responseBody);
        // Mail::to($user->email)->send(new UserSubscribed(['first_name' => $user->first_name, 'plan' => $newplan->title]));

        return response()->json($user,200);
    }
    
    
    public function paypalResponse(Request $request){
		$user = $request->user();
		
		$billing_info = $request->get('billing_info');
		$start_time = $request->get('start_time');
		$shipping_amount = $request->get('shipping_amount');
		$subscriber = $request->get('subscriber');
		$subscription_id = $request->get('id');
		$plan_id = $request->get('plan_id');
		$status = $request->get('status');
		$quantity = $request->get('quantity');
		$subscriber = $request->get('subscriber');
		
		// $subscription = new Invoice();
		// $subscription->user_id = $user->id;
		// $subscription->subscription_id = $subscription_id;
		// $subscription->plan_id = $plan_id;
		// $subscription->quantity = $quantity;
		// $subscription->start_time = $start_time;
		// $subscription->status = $status;
		// $subscription->address_line_1 = $subscriber['shipping_address']['address']['address_line_1'];
		// $subscription->admin_area_1 = $subscriber['shipping_address']['address']['admin_area_1'];
		// $subscription->admin_area_2 = $subscriber['shipping_address']['address']['admin_area_2'];
		// $subscription->country_code = $subscriber['shipping_address']['address']['country_code'];
		// $subscription->postal_code = $subscriber['shipping_address']['address']['postal_code'];
		// $subscription->next_billing_time = $billing_info['next_billing_time'];
		// $subscription->amount = $billing_info['last_payment']['amount']['value'];
		// $subscription->currency_code = $billing_info['last_payment']['amount']['currency_code'];
		// $subscription->last_payment_time = $billing_info['last_payment']['time'];
		// $subscription->save();
		
		$user->paypal_id = $subscriber['payer_id'];
		$user->paypal_subscription_id =$subscription_id;
		$user->save();
		
		return response()->json(200);
    }

}
