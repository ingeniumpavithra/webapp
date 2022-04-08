<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnedaytripDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onedaytrip_details', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->default(1);
            $table->string('cus_name')->nullable();
            $table->string('mobile')->nullable();
            $table->bigInteger('fixed_payment')->default(1800);
            $table->integer('distance')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('onedaytrip_details');
    }
}
