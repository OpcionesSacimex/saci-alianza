<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConyugesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conyuges', function (Blueprint $table) {
            $table->id();
            $table->string('nombrecompleto');
            $table->date('fechanacimientoconyuge');
            $table->string('regimenmatrimonial');
            $table->string('telefonoconyuge');
            $table->string('actividadcomercial');
            $table->string('tipovivienda');
            $table->double('valorvivienda');
            $table->string('dependienteseconomicos');
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
        Schema::dropIfExists('conyuges');
    }
}
