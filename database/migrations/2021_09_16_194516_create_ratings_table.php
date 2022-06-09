<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->bigInteger('rating_to')->unsigned()->nullable();
            $table->foreign('rating_to')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('rating_by')->unsigned()->nullable();
            $table->foreign('rating_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('ratings')->nullable();
            $table->string('reviews')->nullable();
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
        Schema::drop('ratings');
    }
}
