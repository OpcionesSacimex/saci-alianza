<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conyuge extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idcliente','nombrecompleto', 'fechanacimientoconyuge','regimenmatrimonial', 'telefonoconyuge','actividadcomercial', 'tipovivienda', 'valorvivienda','dependienteseconomicos'];
}
