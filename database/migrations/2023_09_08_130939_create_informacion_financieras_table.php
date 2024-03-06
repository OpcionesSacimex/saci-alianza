<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionFinancierasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_financieras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idcliente')->constrained('clientes');
            $table->double('ingresoquincenal');
            $table->double('disponiblequincenal');
            $table->double('ajuste')->nullable()->default(0);
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
        Schema::dropIfExists('informacion_financieras');
    }
}
