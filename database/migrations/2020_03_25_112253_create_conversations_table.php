<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');

            // $table->bigInteger('user_id')->unsigned()->index();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->integer('send_to')->nullable();

            $table->string('local_message_id')->nullable();
            $table->string('message_id')->nullable();
            $table->bigInteger('reply_id')->default(0);
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->bigInteger('receiver_id')->default(0);
            $table->text('attachment')->nullable();
            $table->text('message')->nullable();
            $table->enum('type', ['text', 'attachment'])->default('text');
            $table->text('details')->nullable();
            App\Helpers\DbExtender::defaultParams($table);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conversations');
    }
}
