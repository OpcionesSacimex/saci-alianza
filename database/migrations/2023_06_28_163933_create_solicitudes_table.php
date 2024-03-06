<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->float('pagominimo');
            $table->float('pagomaximo');
            $table->float('pagodeseado');
            $table->integer('plazo');
            $table->float('creditomaximo');
            $table->float('prestamosolicitado');
            $table->string('estado')->nullable()->default('En proceso');
            //$table->integer('idcliente')->nullable();
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
        Schema::dropIfExists('solicitudes');
    }
}
