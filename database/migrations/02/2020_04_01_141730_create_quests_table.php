<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questnum')->unsigned()->nullable();
            $table->integer('idprova')->unsigned()->nullable();
            $table->foreign('idprova')->references('id')->on('provas')->nullable();
            $table->integer('idpesq')->unsigned()->nullable();
            $table->foreign('idpesq')->references('id')->on('pesquisas')->nullable();
            $table->enum('TIPO',[
                'EU',
                'ME',
                'SN',
                'TX',
                'ZD',
                ]);
            $table->string('enunciado', 100);
            $table->integer('qtdOps')->unsigned()->nullable();
            $table->string('op_1', 100)->nullable();
            $table->string('op_2', 100)->nullable();
            $table->string('op_3', 100)->nullable();
            $table->string('op_4', 100)->nullable();
            $table->string('op_5', 100)->nullable();
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
        Schema::dropIfExists('quests');
    }
}
