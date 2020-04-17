<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoCADO extends Model
{
    /**
     * @var \App\FichaTecnicaCADO
     */
    protected $with = ['ficha_tecnica'];



    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CAT_CURSO_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_CURSO_CADO';

    /**
     * @return \App\FichaTecnicaCADO
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function ficha_tecnica(){
        return $this->belongsTo('App\FichaTecnicaCADO',
            'FK_FICHA_TECNICA_CADO',
            'PK_CAT_FICHA_TECNICA')->where('BORRADO', 0);
    }


}
