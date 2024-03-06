<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    use HasFactory;

    static $rules = [
		'calle' => 'required',
		'numeroexterior' => 'required',
        'municipio' => 'required',
        'entidadresidencia' => 'required',
		'colonia' => 'required',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idcliente','calle', 'numeroexterior', 'numerointerior','colonia', 'municipio','entidadresidencia'];
}
