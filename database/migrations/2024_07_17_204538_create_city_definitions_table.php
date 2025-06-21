<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('cikis_il',150)->nullable();
            $table->string('cikis_ilce',150)->nullable();
            $table->string('varis_il',150)->nullable();
            $table->string('varis_ilce',150)->nullable();
            $table->string('sefer_harcirah',150)->nullable();
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
        Schema::dropIfExists('city_definitions');
    }
}
