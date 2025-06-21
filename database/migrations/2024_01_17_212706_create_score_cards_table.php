<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_cards', function (Blueprint $table) {
            $table->id();
            $table->string('ad',150)->nullable();
            $table->string('soyad',150)->nullable();
            $table->integer('sub_id');
            $table->string('tc_no',11)->nullable();
            $table->string('giris_saati',150)->nullable();
            $table->string('cikis_saati',150)->nullable();
            $table->string('gun',150)->nullable();
            $table->string('ay',150)->nullable();
            $table->string('yil',150)->nullable();
            $table->string('calisma_durumu',150)->nullable();
            $table->string('aciklama',550)->nullable();
            $table->string('log_id',150)->nullable();
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
        Schema::dropIfExists('score_cards');
    }
}
