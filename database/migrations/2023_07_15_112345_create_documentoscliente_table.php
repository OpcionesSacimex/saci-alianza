<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosclienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentoscliente', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->integer('tipodocumento');
            $table->string('estado')->default('En revisión');
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('documentoscliente');
    }
}
