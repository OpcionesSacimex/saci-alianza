<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenciaPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencia_personals', function (Blueprint $table) {
            $table->id();
            $table->string('nombrecompletoreferencia');
            $table->string('domicilioreferencia');
            $table->string('telefonoreferencia');
            $table->string('tiporelacion');
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
        Schema::dropIfExists('referencia_personals');
    }
}
