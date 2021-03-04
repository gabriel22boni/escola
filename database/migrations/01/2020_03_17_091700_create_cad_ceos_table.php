<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadCeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_ceos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idceo')->unsigned()->nullable();
            $table->string('nome')->nullable();
            $table->string('fnome')->nullable();
            $table->string('razsoc')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('email')->unique();
            $table->string('image',100)->nullable();
            $table->enum('pessoa',[
            'F'/*FISICA*/,
            'J'/*JURIDICA*/
            ]);
            $table->enum('status',[
            'A'/*ATIV0*/,
            'I'/*INATIVO*/
            ]);
            $table->string('endereco');
            $table->integer('numero')->unsigned();
            $table->string('bairro');
            $table->string('password')->nullable();
            $table->string('cel');
            $table->string('fone');
            $table->string('cep');
            $table->integer('cidade')->unsigned();
            $table->foreign('cidade')->references('id')->on('cities');
            $table->integer('estado')->unsigned();
            $table->foreign('estado')->references('id')->on('states');
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
        Schema::dropIfExists('cad_ceos');
    }
}
