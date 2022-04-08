<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create7seaterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('7seater_details', function (Blueprint $table) {
         $table->id();
        $table->integer('car_id')->default(1);
        $table->string('cus_name')->nullable();
        $table->string('mobile')->nullable();
        $table->string('kmrupees')->nullable();
        $table->integer('distance')->nullable();
        $table->integer('tollcharge')->nullable();
        $table->string('xtra_desc')->nullable();
        $table->integer('xtracharge')->nullable();
        $table->integer('discount')->nullable();
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
        Schema::dropIfExists('7seater_details');
    }
}
