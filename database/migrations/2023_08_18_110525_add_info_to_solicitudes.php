<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->date('fechainicio')->nullable()->after('idcliente');
            $table->date('fechavencimiento')->nullable()->after('fechainicio');
            $table->float('ajustePasivos')->default(0)->after('pagomaximo');
            $table->bigInteger ('convenio')->nullabe()->after('estado');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn('fechainicio');
            $table->dropColumn('fechavencimiento');
            $table->dropColumn('ajustePasivos');
            $table->dropColumn('convenio');
        });
    }
}
