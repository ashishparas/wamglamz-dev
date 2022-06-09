<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->bigInteger('artist_id')->unsigned()->nullable();
            $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('booking_for',[1,2])->default(1)->comment('1->mobile, 2->studio');
            $table->text('distance_range_price')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone_no')->nullable();
            $table->enum('prefer_type',[0, 1,2,3])->default(0)->comment('0->default, 1->Male, 2->Female, 3->Both');
            $table->string('how_many')->nullable();
            $table->string('number_of_male')->nullable();
            $table->string('number_of_female')->nullable();
            
            
            $table->text('services')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            
            $table->string('date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('card_id')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('total_amt')->nullable();
            $table->enum('status',[0,1,2,3])->default(0)->comment('0->Default, 1->Accept, 2->Reject,Cancel');
            $table->enum('job_status',[0,1,2,3])->default(0)->comment('0->default,1->On_going, 2->cancel, 3->completed');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
