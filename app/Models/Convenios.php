<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenios extends Model
{
    use HasFactory;
    protected $table = 'convenios' ;
    protected $primarykey = 'id';
    public $timestamps = false;
    protected $fillable=['id','sucursal_id','InstitucionNominaID',
                         'nombreAlianza','nombreCorto','montoMinimo','montoMaximo','plazoMinimo','plazoMaximo',
                         'tasa','retenciones','created_at','updated_at'];
}
