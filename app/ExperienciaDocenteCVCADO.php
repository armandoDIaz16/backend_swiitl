<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaDocenteCVCADO extends Model
{

    /**
     * @var \App\Institucion
     */
    protected $with = ['instituto'];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_EXPERIENCIA_DOCENTE_CV';

    /**
     * @var string
     */
    protected $table = 'CAT_EXPERIENCIA_DOCENTE_CV_CADO';

    /**
     * @return \App\Institucion
     * @description: OBTIENE el tipo de fornacion
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function instituto(){
        return $this->belongsTo('App\Institucion',
            'FK_INSTITUCION',
            'PK_INSTITUCION')->where('BORRADO', 0);
    }
}
