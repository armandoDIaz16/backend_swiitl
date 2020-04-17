<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialDidacticoCADO extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_MATERIAL_DIDACTICO';

    /**
     * @var string
     */
    protected $table = 'CAT_MATERIAL_DIDACTICO_CADO';

}
