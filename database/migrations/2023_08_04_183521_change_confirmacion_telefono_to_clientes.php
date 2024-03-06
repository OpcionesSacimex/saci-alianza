<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeConfirmacionTelefonoToClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->float('ingresoquincenal')->nullable()->change();
            $table->float('disponiblequincenal')->nullable()->change();
            $table->float('ajuste')->nullable()->change();
            $table->string('confirmaciontelefono')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->integer('confirmaciontelefono')->change();
        });
    }
}
