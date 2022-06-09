<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_chat', function (Blueprint $table) {
           $table->increments('id');
           $table->string('roomID')->nullable();
           $table->bigInteger('source_user_id')->nullable();
           $table->bigInteger('target_user_id')->nullable();
           $table->text('message')->nullable();
           $table->integer('status')->nullable();
           $table->string('MessageType')->nullable();
           $table->timestamp('modified_on')->nullable();
           $table->timestamp('created_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('user_chat');
    }
}
