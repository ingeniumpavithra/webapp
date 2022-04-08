<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocaltripDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localtrip_details', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->default(1);
            $table->string('cus_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('triphr')->nullable();
            $table->string('distance')->nullable();
            $table->integer('payment')->default(0);
            $table->integer('xtrakm')->default(0);
            $table->integer('xtracharge')->default(0);
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
        Schema::dropIfExists('localtrip_details');
    }
}
