<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_materias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('id_escola')->unsigned();
            $table->foreign('id_escola')->references('id')->on('cad_admasters');
            $table->enum('status',[
                'A'/*ATIV0*/,
                'I'/*INATIVO*/
                ]);
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
        Schema::dropIfExists('cad_materias');
    }
}
