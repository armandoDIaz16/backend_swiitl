<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
    'NOMBRE',
    'ESTADO',
    'PRIMER_APELLIDO',
    'SEGUNDO_APELLIDO',
    'FECHA_NACIMIENTO',
    'SEXO',
    'CURP',
    'FK_ESTADO_CIVIL',

    'CALLE',
    'NUMERO_EXTERIOR',
    'NUMERO_INTERIOR',
    'FK_COLONIA',
    'TELEFONO_CASA',
    'TELEFONO_MOVIL',
    'CORREO1',

    'FK_INCAPACIDAD',
    'AYUDA_INCAPACIDAD'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_USUARIO';

    protected $table = 'users';
}
