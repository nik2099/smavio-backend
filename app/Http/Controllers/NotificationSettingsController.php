<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSettings;
use Illuminate\Support\Facades\Auth;

class NotificationSettingsController extends Controller
{
    public function get_settings(Request $request) {
        $user = Auth::user();
        $notification_settings = $user->notification_settings;
        if(isset($notification_settings)){
            return response()->json($notification_settings, 200);
        }
        $notification_settings = new NotificationSettings();
        $notification_settings->campaign_created = true;
        $notification_settings->campaign_paused = true;
        $notification_settings->device_connected = true;
        $notification_settings->device_removed = true;
        $notification_settings->report_available = true;
        $notification_settings->app_added = true;
        $notification_settings->app_published = true;
        $notification_settings->user_id = Auth::id();
        $notification_settings->save();
        return response()->json($notification_settings, 200);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'campaign_created' => 'boolean|required',
            'campaign_paused' => 'boolean|required',
            'device_connected' => 'boolean|required',
            'device_removed' => 'boolean|required',
            'report_available' => 'boolean|required',
            'app_added' => 'boolean|required',
            'app_published' => 'boolean|required',
        ]);
        $user = Auth::user();
        $notification_settings = $user->notification_settings;
        $notification_settings->campaign_created = $validated['campaign_created'];
        $notification_settings->campaign_paused = $validated['campaign_paused'];
        $notification_settings->device_connected = $validated['device_connected'];
        $notification_settings->device_removed = $validated['device_removed'];
        $notification_settings->report_available = $validated['report_available'];
        $notification_settings->app_added = $validated['app_added'];
        $notification_settings->app_published = $validated['app_published'];
        $notification_settings->save();
        return response()->json($notification_settings, 200);
    }
}
