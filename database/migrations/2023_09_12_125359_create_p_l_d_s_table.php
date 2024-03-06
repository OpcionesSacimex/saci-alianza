<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePLDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plds', function (Blueprint $table) {
            $table->id();
            $table->boolean('cuentapropia');
            $table->boolean('representaciontercero');
            $table->boolean('terceropaga');
            $table->boolean('jobgobierno');
            $table->string('nombrejobgobierno')->nullable();
            $table->boolean('familiarjobgobierno');
            $table->string('familiarnombregobierno')->nullable();
            $table->foreignId('idcliente')->constrained('clientes');
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
        Schema::dropIfExists('plds');
    }
}
