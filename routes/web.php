<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});



// Route::get('/getPDF/{id}/{invoice_id}', function ($id,$invoice_id) {
// 	$user = User::find($id);
//     $invoices = $user->findInvoice($invoice_id);
    
//     return view('invoice',['invoice'=>$invoices]);
    
    
// });


// Route::get('/getPDF/{id}/{invoice_id}', function ($id,$invoice_id) {
// 		$user = User::find($id);
// 		$invoices = $user->findInvoice($invoice_id);
	
// 		return view('invoice',['invoice'=>$invoices]);
// 		// $pdf = PDF::loadView('invoice', ['invoice'=>$invoices]);
// 		// $path = public_path('invoice/');
// 		// $pdf->save($path . '/' . $invoice_id.'.pdf');
// 		// return $pdf->download('invoice.pdf');
	
// });


