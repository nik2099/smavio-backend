<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('osversion')->nullable();
            $table->string('platform')->nullable();
            $table->string('app_version')->nullable();
            $table->string('device_type')->nullable();
            $table->string('model')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('device_uuid')->nullable();
            $table->string('token_id')->nullable();
            $table->boolean('status')->default(true);
            $table->string('locality')->nullable();
            $table->string('subAdministrativeArea')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('parent_user_id')->nullable();
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
        Schema::dropIfExists('devices');
    }
}
