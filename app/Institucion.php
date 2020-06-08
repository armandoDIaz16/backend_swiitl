<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_INSTITUCION';

    /**
     * @var string
     */
    protected $table = 'CAT_INSTITUCION';
}
