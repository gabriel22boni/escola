<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('TIPO',[
                'EU',
                'ME',
                'SN',
                'TX',
                'ZD',
                ]);
            $table->integer('questnum')->unsigned()->nullable();
            $table->integer('idprova')->unsigned()->nullable();
            $table->foreign('idprova')->references('id')->on('provas')->nullable();
            $table->integer('idpesq')->unsigned()->nullable();
            $table->foreign('idpesq')->references('id')->on('pesquisas')->nullable();
            $table->integer('RespEU')->unsigned()->nullable();
            $table->enum('Resp1ME',[
                true,
                false,
            ])->nullable();
            $table->enum('Resp2ME',[
                true,
                false,
            ])->nullable();
            $table->enum('Resp3ME',[
                true,
                false,
            ])->nullable();
            $table->enum('Resp4ME',[
                true,
                false,
            ])->nullable();
            $table->enum('Resp5ME',[
                true,
                false,
            ])->nullable();
            $table->integer('RespSN')->unsigned()->nullable();
            $table->integer('RespZD')->unsigned()->nullable();    
            $table->string('RespTX', 255)->nullable();
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
        Schema::dropIfExists('respostas');
    }
}
