<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfMatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_mats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prof')->unsigned()->nullable();
            $table->foreign('id_prof')->references('id')->on('cad_adms')->nullable();
            $table->integer('id_mat')->unsigned()->nullable();
            $table->foreign('id_mat')->references('id')->on('cad_materias')->nullable();
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
        Schema::dropIfExists('prof_mats');
    }
}
