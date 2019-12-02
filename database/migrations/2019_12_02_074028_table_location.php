<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("uniq_id");
            $table->string("address1")->nullable();
            $table->string("address2")->nullable();
            $table->string("address3")->nullable();
            $table->string("city")->nullable();
            $table->string("zip_code")->nullable();
            $table->string("country")->nullable();
            $table->string("state")->nullable();
            $table->string("display_address")->nullable();
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
        Schema::dropIfExists('location');
    }
}
