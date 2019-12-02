<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableBussiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bussiness', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("uniq_id");
            $table->string("alias")->nullable();
            $table->string("name")->nullable();
            $table->string("image_url")->nullable();
            $table->boolean("is_closed")->nullable();
            $table->string("url")->nullable();
            $table->string("rating")->nullable();
            $table->string("lat")->nullable();
            $table->string("long")->nullable();
            $table->string("phone")->nullable();
            $table->string("display_phone")->nullable();
            $table->string("distance")->nullable();
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
        Schema::dropIfExists('bussiness');
    }
}
