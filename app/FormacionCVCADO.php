<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormacionCVCADO extends Model
{

    /**
     * @var \App\TipoFormacionCVCADO
     */
    protected $with = ['tipo_formacion'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_FORMACION_ACADEMICA_CV';

    /**
     * @var string
     */
    protected $table = 'CAT_FORMACION_ACADEMICA_CV_CADO';

    /**
     * @return \App\TipoFormacionCVCADO
     * @description: OBTIENE el tipo de fornacion
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function tipo_formacion(){
        return $this->belongsTo('App\TipoFormacionCVCADO',
            'TIPO_FORMACION',
            'PK_TIPO_FORMACION_ACADEMICA')->where('BORRADO', 0);
    }
}
