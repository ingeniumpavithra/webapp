<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHillstripDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hillstrip_details', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->default(1);
            $table->string('cus_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('trip_from')->nullable();
            $table->string('trip_to')->nullable();
            $table->integer('payment')->nullable();
            $table->integer('members')->nullable();
            $table->integer('trip_days')->nullable();
            $table->integer('driver_batta')->nullable();
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
        Schema::dropIfExists('hillstrip_details');
    }
}
