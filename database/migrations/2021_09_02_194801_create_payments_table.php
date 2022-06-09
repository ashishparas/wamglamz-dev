<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('card_no');
            $table->string('zipcode');
            $table->string('expiry_month');
            $table->string('expiry_date');
            $table->string('cvv');
            $table->enum('set_default',[0,1])->default(0)->comment('0->No, 1->Yes');
            $table->enum('status',[0,1])->default(0)->comment("0->Inactive, 1->Active");
            $table->string('payment_token')->nullable();
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
        Schema::drop('payments');
    }
}
