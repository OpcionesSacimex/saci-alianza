<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('ine')->nullable();
            $table->string('actaNacimiento')->nullable();
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('comprobanteDomicilio')->nullable();
            $table->string('fotografia')->nullable();
            //$table->integer('idcliente')->nullable();
            $table->foreignId('idcliente')->constrained('clientes');
            //$table->foreignId('idcliente')->constrained('clientes');
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
        Schema::dropIfExists('documentos');
    }
}
