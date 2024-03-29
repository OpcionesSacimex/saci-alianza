<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaPersonal extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idcliente','nombrecompletoreferencia', 'domicilioreferencia','telefonoreferencia', 'tiporelacion'];
}
