<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('artist_id')->unsigned()->nullable();
            $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->Integer('main_category_id')->unsigned()->nullable();
            $table->foreign('main_category_id')->references('id')->on('main_categories')->onDelete('cascade');
            
            
            
            
            $table->bigInteger('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('sub_category_id')->unsigned()->nullable();
            $table->foreign('sub_category_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->string('price');
            $table->enum('status', [0,1])->default(1)->comment('0->Not_added, 1->Added');
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
        Schema::dropIfExists('artist_services');
    }
}
