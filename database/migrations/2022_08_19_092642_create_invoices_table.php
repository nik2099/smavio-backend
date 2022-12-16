<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('start_time')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('admin_area_1')->nullable();
            $table->string('admin_area_2')->nullable();
            $table->string('country_code')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamp('next_billing_time')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency_code')->nullable();
            $table->timestamp('last_payment_time')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
