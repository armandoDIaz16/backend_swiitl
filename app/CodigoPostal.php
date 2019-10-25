<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CodigoPostal
 * @package App
 */
class CodigoPostal extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'PK_CODIGO_POSTAL',
        'FK_CIUDAD',
        'NUMERO',
        'ESTADO'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CODIGO_POSTAL';

    /**
     * @var string
     */
    protected $table = 'CAT_CODIGO_POSTAL';

}
