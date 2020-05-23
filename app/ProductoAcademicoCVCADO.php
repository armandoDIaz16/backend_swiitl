<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoAcademicoCVCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_PRODUCTOS_ACADEMICOS_CV';

    /**
     * @var string
     */
    protected $table = 'CAT_PRODUCTOS_ACADEMICOS_CV_CADO';

}
