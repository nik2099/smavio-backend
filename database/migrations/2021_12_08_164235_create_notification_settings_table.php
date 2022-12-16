<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('campaign_created')->default(true);
            $table->boolean('campaign_paused')->default(true);
            $table->boolean('device_connected')->default(true);
            $table->boolean('device_removed')->default(true);
            $table->boolean('report_available')->default(true);
            $table->boolean('app_added')->default(true);
            $table->boolean('app_published')->default(true);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
