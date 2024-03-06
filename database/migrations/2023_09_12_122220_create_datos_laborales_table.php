<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_laborales', function (Blueprint $table) {
            $table->id();
            $table->string('ocupacion');
            $table->string('tipocontrato');
            $table->string('antigüedad');
            $table->string('centrodetrabajo');
            $table->string('domicilio');
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
        Schema::dropIfExists('datos_laborales');
    }
}
