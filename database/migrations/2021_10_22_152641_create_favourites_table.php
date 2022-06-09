<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('like_by')->unsigned()->nullable();
            $table->foreign('like_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('like_to')->unsigned()->nullable();
            $table->foreign('like_to')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status',[0,1,2])->default(0)->comment('0->default, 1->like, 2->dislike');
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
        Schema::dropIfExists('favourites');
    }
}
