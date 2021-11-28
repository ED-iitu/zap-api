<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('vin')->unique();
            $table->string('mark');
            $table->string('model');
            $table->integer('year')->nullable();
            $table->string('car_image')->nullable();
            $table->float('capacity')->nullable();
            $table->timestamp('year_created')->nullable();
            $table->string('region');
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
        Schema::dropIfExists('garages');
    }
}
