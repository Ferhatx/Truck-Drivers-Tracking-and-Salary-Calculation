<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanimlamalarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanimlamalars', function (Blueprint $table) {
            $table->id();
            $table->string('yil',150)->nullable();
            $table->string('asgari_ucret',400)->nullable();
            $table->string('resmi_tatil',400)->nullable();
            $table->string('dini_tatil',150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanimlamalars');
    }
}
