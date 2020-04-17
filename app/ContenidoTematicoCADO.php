<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContenidoTematicoCADO extends Model
{

    /**
     * @var \App\ArchivoContenidoTematicoCADO
     */
    protected $with = ['archivo_contenido_tematico'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CONTENIDO_TEMATICO';

    /**
     * @var string
     */
    protected $table = 'CAT_CONTENIDO_TEMATICO_CADO';

    /**
     * @return \App\ArchivoContenidoTematicoCADO
     * @description: OBTIENE EL ARCHIVO ADJUNTO RELACIONADA CON EL TEMA DEL CURSO
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function archivo_contenido_tematico(){
        return $this->hasMany('App\ArchivoContenidoTematicoCADO',
            'FK_CONTENIDO_TEMATICO')
            ->where('BORRADO', 0);
    }
}
