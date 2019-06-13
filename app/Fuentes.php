<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Fuentes extends Model{
    protected $fillable = [
        'NOMBRE_FAMILY',
        'NOMBRE_STYLE_NORMAL',
        'NOMBRE_STYLE_BOLD',
        'NOMBRE_STYLE_ITALIC'
        ];

    protected $table = 'CAT_FUENTE';
}
