<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatDeleteTBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_deleteTB', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('deleteByuserID')->nullable();
            $table->integer('ChatParticipantID')->nullable();
            $table->timestamp('deletedDate');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_deleteTB');
    }
}
