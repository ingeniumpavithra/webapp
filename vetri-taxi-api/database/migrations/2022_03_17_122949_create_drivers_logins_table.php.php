<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversLoginsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_logins', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->default(1);
            $table->date('login_date')->nullable();
            $table->string('login_time')->nullable();
            $table->string('login_kilometer')->nullable();
            $table->date('logout_date')->nullable();
            $table->string('logout_time')->nullable();
            $table->string('logout_kilometer')->nullable();
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
        Schema::dropIfExists('driver_logins');
    }
}