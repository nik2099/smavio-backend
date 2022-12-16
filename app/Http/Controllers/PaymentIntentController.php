<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class PaymentIntentController extends Controller
{
    public function create_setup_intent(Request $request){
        return response()->json([
            'intent' => Auth::user()->createSetupIntent()
        ],200);
    }

    public function update_payment_method(Request $request){
        $validated = $request->validate([
            'payment_method_id' => 'string|required'
        ]);
        $user = Auth::user();
        $user->deletePaymentMethods();
        $user->addPaymentMethod($validated['payment_method_id']);
        $user->updateDefaultPaymentMethod($validated['payment_method_id']);
        return response()->json([
            'successes' => ['Payment method added!']
        ], 200);
    }
    
    public function getUserInvoices(Request $request){
    	// $user = User::find(8);
    	$user = $request->user();
    	$stripe_invoices = $user->invoicesIncludingPending();
    	$invoices = [];
    	
    	foreach($stripe_invoices as $invoice){
    		$invoiceObj = new \stdClass();
    		$invoiceObj->id = $invoice->id;
    		$invoiceObj->paid = $invoice->paid;
    		$invoiceObj->amount = number_format($invoice->total/100,2);
    		$invoiceObj->created = Carbon::createFromTimestamp($invoice->created)->toDateTimeString();
    		$invoiceObj->pdf = $invoice->invoice_pdf;
    		$invoiceObj->currency = $invoice->currency;
    		$invoiceObj->status = ($invoice->paid)?'Paid':'Unpaid';
    		$invoiceObj->hosted_url = $invoice->hosted_invoice_url;
    		
    		
    		
    		$invoices[] = $invoiceObj;
    		
    	}
    	
    	return response()->json([
            'success' => true,
            "invoices" => $invoices
        ], 200);
    }
    
    

}
