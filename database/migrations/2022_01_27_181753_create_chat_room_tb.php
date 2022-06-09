<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRoomTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ChatRoomTb', function (Blueprint $table) {
            
             $table->increments('ID');
             $table->string('roomID')->nullable();
             $table->integer('UserJoinID')->nullable();
             $table->integer('status')->nullable();
             $table->timestamp('createdDate');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ChatRoomTb');
    }
}
