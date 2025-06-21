<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('ad',150)->nullable();
            $table->string('soyad',150)->nullable();
            $table->integer('sub_id');
            $table->date('izin_tarihi');
            $table->integer('yillik_izin_hakki');
            $table->string('aciklama',550)->nullable();
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
        Schema::dropIfExists('annual_leaves');
    }
}
