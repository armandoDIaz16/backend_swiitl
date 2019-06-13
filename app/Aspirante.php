<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
    protected $fillable = [
    'PERIODO',
    'PADRE_TUTOR',
    'MADRE',
    'FK_BACHILLERATO',
    'ESPECIALIDAD',
    'PROMEDIO',


    'NACIONALIDAD',
    'FK_CIUDAD',

    'FK_CARRERA_1',
    'FK_CARRERA_2',
    'FK_PROPAGANDA_TECNOLOGICO',

    'FK_CARRERA_UNIVERSIDAD',

    'FK_DEPENDENCIA',
    'TRABAJAS_Y_ESTUDIAS',
    'AVISO_PRIVACIDAD',
    'FK_PADRE'
    ];
    public $timestamps = false;

    protected $table = 'CATR_ASPIRANTE';


}
