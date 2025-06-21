<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('ad',150)->nullable();
            $table->string('soyad',150)->nullable();
            $table->string('adres',350)->nullable();
            $table->string('telefon',25)->nullable();
            $table->string('departman',150)->nullable();
            $table->string('tc_no',11)->nullable();
            $table->string('start_date',350)->nullable();
            $table->integer('yillik_izin_hakedis');
            $table->string('log_id',150)->nullable();
            $table->string('status' , 5)->nullable()->default('True');
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
        Schema::dropIfExists('truck_drivers');
    }
}
