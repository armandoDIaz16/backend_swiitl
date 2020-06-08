<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipanteCADO extends Model
{

    /**
     * @var \App\Usuario
     * * @var \App\CurriculumCADO
     */
    protected $with = ['usuario','cv'];

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


    /**
     * @return \App\Usuario
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function usuario(){
        return $this->belongsTo('App\Usuario',
            'FK_USUARIO',
            'PK_USUARIO');
    }

    /**
     * @return \App\CurriculumCADO
     * @description: OBTIENE LA EL CV  RELACIONADA CON EL PARTICIPANTE
     *               HasMany ES PARA RELACIONES 1 A n EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 2/5/2020
     */
    public function cv(){
        return $this->hasMany('App\CurriculumCADO',
            'FK_PARTICIPANTE_CADO')
            ->where('BORRADO', 0);
    }
}
