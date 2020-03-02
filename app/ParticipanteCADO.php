<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipanteCADO extends Model
{


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_PARTICIPANTE_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_PARTICIPANTE_CADO';
}
