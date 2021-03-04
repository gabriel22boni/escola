<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesquisas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('url');
            $table->integer('qtdeQuest')->unsigned()->nullable();
            $table->integer('qtdeResps')->unsigned()->nullable();
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
        Schema::dropIfExists('pesquisas');
    }
}
