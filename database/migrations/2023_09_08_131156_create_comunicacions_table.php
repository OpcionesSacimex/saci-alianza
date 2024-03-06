<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idcliente')->constrained('clientes');
            $table->string('metodocomunicacion')->default('');
            $table->string('codigoverificacion')->nullable();
            $table->boolean('verificado')->default(0);
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
        Schema::dropIfExists('comunicacions');
    }
}
