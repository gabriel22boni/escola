<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcob')->unsigned()->nullable();
            $table->foreign('idcob')->references('id')->on('cad_cobs')->nullable();
            $table->integer('idadm')->unsigned()->nullable();
            $table->foreign('idadm')->references('id')->on('cad_adms')->nullable();
            $table->integer('idmas')->unsigned()->nullable();
            $table->foreign('idmas')->references('id')->on('cad_admasters')->nullable();
            $table->integer('idceo')->unsigned()->nullable();
            $table->foreign('idceo')->references('id')->on('cad_ceos')->nullable();
            $table->string('name');
            $table->enum('nivel',[
                'CLI'/*CLIENTE*/,
                'COB'/*COBRADOR*/,
                'ADM'/*ADMINISTRADOR*/,
                'MAS'/*MASTER ADM*/,
                'CEO'/*CEO*/,
            ]);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image',100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
