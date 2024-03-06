<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveQuincenaContactoFromClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('ingresoquincenal');
            $table->dropColumn('disponiblequincenal');
            $table->dropColumn('ajuste');
            $table->dropColumn('confirmaciontelefono');
            $table->dropColumn('metodocomunicacion');
            $table->dropColumn('verificado');
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
            $table->double('ingresoquincenal');
            $table->double('disponiblequincenal');
            $table->double('ajuste');
            $table->string('confirmaciontelefono');
            $table->string('metodocomunicacion');
            $table->boolean('verificado');
        });
    }
}
