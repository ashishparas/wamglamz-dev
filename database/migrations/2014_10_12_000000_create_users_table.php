<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phonecode')->nullable();
                $table->string('mobile_no')->nullable();
                $table->integer('otp')->nullable();
                $table->enum('mobile_verified',[0, 1])->default(0)->comment('0->No, 1->Yes');
                $table->string('profile_picture');
                $table->string('dob')->nullable();
                $table->string('zipcode')->nullable();
                $table->string('gender')->nullable();
                $table->text('description');
                $table->string('experience')->nullable();
                $table->string('license_no')->nullable();
                $table->string('upload_id');
                $table->enum('type',[1,2,3])->default(1)->comment('1->client, 2->artist,3->admin');
                $table->enum('active_status',[0,1])->default(1)->comment('0->Inactive, 1->Active');       
                $table->enum('status',[0,1,2,3,4,5,6,7,8])->default(0)->comment('0-> default, 1->signup,2->create_profile,3->social_link, 4->availability 5->schedule_added, 6-> added_services,7->payment_added, 8->profile_submitted');
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('google_id')->nullable();
                $table->string('apple_id')->nullable();
                $table->string('token')->nullable();
                $table->string('custom_id ')->nullable();
                
                $table->rememberToken();
                $table->integer('email_otp')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
