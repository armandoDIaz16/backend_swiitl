<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Situacion_Residencia
 * @package App
 */
class Situacion_Residencia extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'NOMBRE',
        'ESTADO'
    ];

    /**
     * @var string
     */
    protected $table = 'CAT_SITUACION_RESIDENCIA';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_SITUACION_RESIDENCIA';
}
