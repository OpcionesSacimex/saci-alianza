<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosLaborales extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idcliente','ocupacion', 'tipocontrato', 'antigüedad','centrodetrabajo', 'domicilio'];

}
