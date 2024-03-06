<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetallescreditoToSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->float('montoretenido')->after('prestamosolicitado')->nullable()->default(0);
            $table->float('coberturariesgo')->after('montoretenido')->nullable()->default(0);
            $table->float('montorecibido')->after('coberturariesgo')->nullable()->default(0);
            $table->float('pagoplazo')->after('montorecibido')->nullable()->default(0);
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
            $table->dropColumn('montoretenido');
            $table->dropColumn('coberturariesgo');
            $table->dropColumn('montorecibido');
            $table->dropColumn('pagoplazo');
        });
    }
}
