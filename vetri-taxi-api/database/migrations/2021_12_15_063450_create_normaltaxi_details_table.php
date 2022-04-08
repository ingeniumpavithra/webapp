<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNormaltaxiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normaltaxi_details', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->default(1);
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('cus_name')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('w_hour')->default(0);
            $table->integer('w_charge')->default(0);
            $table->integer('driver_batta')->default(0);
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
        Schema::dropIfExists('normaltaxi_details');
    }
}
