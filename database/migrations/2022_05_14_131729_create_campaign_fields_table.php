<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('property')->nullable();
            $table->longText('value')->nullable();
            
            $table->enum('type',['css','text','image','video']);
            $table->enum('component',['navbar','welcome','product','product2','gallery','contact','common','question1','question2','question3']);
            $table->foreignId('template_id')->nullable();
            $table->foreignId('campaign_id');
            $table->foreignId('template_field_id')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('campaign_fields');
    }
}
