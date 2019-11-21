<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario_Rol
 * @package App
 */
class Usuario_Rol extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'PER_TR_ROL_USUARIO';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_ROL_USUARIO';

}
