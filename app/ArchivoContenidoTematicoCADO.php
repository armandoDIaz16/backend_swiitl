<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoContenidoTematicoCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_ARCHIVO_CONTENIDO_TEMATICO';

    /**
     * @var string
     */
    protected $table = 'CAT_ARCHIVO_CONTENIDO_TEMATICO_CADO';

}
