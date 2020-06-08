<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoCADO extends Model
{
    /**
     * @var \App\FichaTecnicaCADO
     */
    protected $with = ['ficha_tecnica','periodo','edificio','area_academica'];



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

    /**
     * @return \App\PeriodoCADO
     * @description: OBTIENE EL PERIODO RELATED CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function periodo(){
        return $this->belongsTo('App\PeriodoCADO',
            'FK_PERIODO_CADO',
            'PK_PERIODO_CADO')->where('BORRADO', 0);
    }
    /**
     * @return \App\Edificio
     * @description: OBTIENE EL EDIFICIO RELATED CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function edificio(){
        return $this->belongsTo('App\Edificio',
            'FK_EDIFICIO',
            'PK_EDIFICIO')->where('BORRADO', 0);
    }
    /**
     * @return \App\AreaAcademica
     * @description: OBTIENE EL EDIFICIO RELATED CON EL CURSO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function area_academica(){
        return $this->belongsTo('App\AreaAcademica',
            'FK_AREA_ACADEMICA',
            'PK_AREA_ACADEMICA')->where('BORRADO', 0);
    }

}
