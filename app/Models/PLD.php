<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PLD extends Model
{
    protected $table = 'plds';
    use HasFactory;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idcliente','cuentapropia', 'representaciontercero','terceropaga', 'jobgobierno','nombrejobgobierno', 'familiarjobgobierno', 'familiarnombregobierno'];
}
