<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingProfileController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\PaymentIntentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/', function(){
    return response()->json([
        'status' => 'ok',
        'version' => '1.1',
        'key' => Crypt::encryptString('qwedsa'),
        'hi' => 'qwedsa'
    ], 200);
});

// Route::get('/', function(){
    
//     return response()->json([
//         'status' => 'ok',
//         'version' => '1.1'
//     ], 200);
// });

/*
 * Authentication
 */

// Registration
Route::post('/register', [AuthController::class, 'register']);
// Login
Route::post('/login', [AuthController::class, 'login']);
// App Login
Route::post('/appLogin', [AuthController::class, 'appLogin']);
// Forget Password
Route::post('/forget-password', [AuthController::class, 'forget_password']);
// Reset Password
Route::post('/reset-password', [AuthController::class, 'reset_password']);
// Sub User Check Invitation
Route::post('/sub-user/check-invitation', [SubUserController::class, 'check_invitation']);
// Sign Up Sub User
Route::post('/sub-user/sign-up', [SubUserController::class, 'sign_up']);

Route::middleware(['auth:sanctum'])->group(function(){
    // Logout
    Route::get('/logout', [AuthController::class, 'logout']);
    // User Details
    Route::get('/user', [AuthController::class, 'user']);
    // Update Profile
    Route::post('/profile', [BillingProfileController::class, 'update']);
    // Update Profile Picture
    Route::post('/profile-picture', [AuthController::class, 'update_profile_picture']);
    // Delete Profile
    Route::delete('/delete-user', [AuthController::class, 'delete_profile']);
    // Delete Profile
    Route::delete('/delete_profilepic', [AuthController::class, 'delete_profilepic']);

    Route::prefix('/sub-user')->group(function(){
        // Invite Sub User
        Route::post('/invite', [SubUserController::class, 'invite']);
        // Get Sub Users
        Route::get('/', [SubUserController::class, 'index']);
        // Remove Sub User
        Route::delete('/{id}', [SubUserController::class, 'delete']);
        // Remove Invitation
        Route::delete('/invitation/{id}', [SubUserController::class, 'delete_invitation']);

    });

    Route::prefix('/notification-settings')->group(function(){
        // Get Notification Settings
        Route::get('/', [NotificationSettingsController::class, 'get_settings']);
        Route::post('/', [NotificationSettingsController::class, 'update']);
    });

    Route::get("/plans", [PlansController::class, 'index']);

    Route::get("/create-setup-intent", [PaymentIntentController::class, 'create_setup_intent']);
    Route::post('/update-payment-method', [PaymentIntentController::class, 'update_payment_method']);
    Route::get('/create-subscription/{id}/{coupon?}', [SubscriptionController::class, 'create_subscription']);
    Route::get('/cancel-subscription', [SubscriptionController::class, 'cancel_subscription']);
    Route::get('/resume-subscription', [SubscriptionController::class, 'resume_subscription']);
    Route::get('/invoices', [SubscriptionController::class, 'invoices']);

    Route::get('/subscription', [SubscriptionController::class, 'get_subscription']);
    Route::post('/paypalResponse', [SubscriptionController::class, 'paypalResponse']);
    Route::get('/retriveInvoice/{id}', [SubscriptionController::class, 'retriveInvoice']);
    
    Route::get('/getTemplateList', [TemplateController::class, 'getTemplateList']);

	Route::get('/getTemplate/{template_id}', [TemplateController::class, 'getTemplate']);
	Route::post('/updateTemplateData/{template_name}', [TemplateController::class, 'updateTemplateData']);
	
	Route::get('/getCampaignList', [CampaignController::class, 'getCampaignList']);
	
	Route::post('/saveCampaign', [CampaignController::class, 'store']);
	
	Route::post('/updateCampaign/{campaign_id}', [CampaignController::class, 'update']);
	
	Route::post('/updateCampaignData/{campaign_id}', [CampaignController::class, 'updateCampaignData']);
	
	Route::get('/getDeviceList', [CampaignController::class, 'getDeviceList']);
	
	Route::get('/getAssignedDevices/{campaign_id}', [CampaignController::class, 'getAssignedDevices']);
	
	Route::post('/assignCampaign', [CampaignController::class, 'assignCampaign']);
	
	Route::get('/pauseCampaign/{campaign_id}', [CampaignController::class, 'pauseCampaign']);
	
	Route::get('/activateCampaign/{campaign_id}', [CampaignController::class, 'activateCampaign']);
	
	Route::get('/deleteCampaign/{campaign_id}', [CampaignController::class, 'deleteCampaign']);
	
	Route::post('/user/getCampaign', [AppUserController::class, 'getCampaign']);
	
	Route::post('/user/updateCampaign', [AppUserController::class, 'updateCampaign']);
	
	
	Route::get('/getSubUser', [AppUserController::class, 'getSubUser']);
	
	Route::get('/getCampaignSubscription', [AppUserController::class, 'getCampaignSubscription']);
	
	Route::post('/deviceLogout', [CampaignController::class, 'deviceLogout']);
	
	Route::get('/getCategory', [CampaignController::class, 'getCategoryList']);
	
	Route::post('/shareDetail', [SubUserController::class, 'sendDetails']);
	
	Route::get('/getAppsList', [AppsController::class, 'getAppsList']);
	
	Route::get('/getMyAppsIds', [AppsController::class, 'getMyAppsIds']);
	
	Route::post('/setMyApps', [AppsController::class, 'setMyApps']);
	
	Route::post('/create-paypal-subscription/{id}', [SubscriptionController::class, 'create_paypal_subscription']);
	
	Route::post('/getDeviceRecords', [AppsController::class, 'getDeviceRecords']);
	Route::post('/getResult', [AppsController::class, 'getResult']);
	
	Route::get('/user/invoices', [PaymentIntentController::class, 'getUserInvoices']);
	
	
Route::get('/admin/getUser', [AdminController::class, 'getUser']);
Route::post('/admin/profile', [AdminController::class, 'updateProfile']);


});

// Route::get('/user/invoices', [PaymentIntentController::class, 'getUserInvoices']);

Route::post('/user/campaignEnquiry', [AppUserController::class, 'campaignSubscription']);

Route::get('/getCampaign/{campaign_id}', [CampaignController::class, 'getCampaign']);

Route::get('/getCampaignData/{campaign_id}', [CampaignController::class, 'getCampaignData']);

Route::get('/getTemplateData/{template_name}', [TemplateController::class, 'getTemplateData']);


Route::post('/test', function(){return 'test';});
// Route::get('/cron', [AppUserController::class, 'cronTest']);

//test commit

