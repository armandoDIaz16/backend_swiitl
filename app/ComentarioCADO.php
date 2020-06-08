<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioCADO extends Model
{

    /**
     * @var \App\ParticipanteCADO
     */
    protected $with = ['participante'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_COMENTARIO_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_COMENTARIO_FICHA_CADO';


    /**
     * @return \App\ParticipanteCADO
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function participante(){
        return $this->belongsTo('App\ParticipanteCADO',
            'FK_PARTICIPANTE_REGISTRO',
            'PK_PARTICIPANTE_CADO');
    }
}
