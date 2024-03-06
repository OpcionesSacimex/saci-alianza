<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechanacEstadocivEntEtcToClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->date('fechanacimiento')->nullable();
            $table->string('estadocivil')->nullable();
            $table->string('entidadnacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('escolaridad')->nullable();
            $table->string('tipovivienda')->nullable();
            $table->integer('edad')->nullable();
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
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
            $table->dropColumn('fechanacimiento');
            $table->dropColumn('estadocivil');
            $table->dropColumn('entidadnacimiento');
            $table->dropColumn('sexo');
            $table->dropColumn('escolaridad');
            $table->dropColumn('tipovivienda');
            $table->dropColumn('edad');
            $table->dropColumn('latitud');
            $table->dropColumn('longitud');
        });
    }
}
