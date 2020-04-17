<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaCADO extends Model
{

    /**
     * @var \App\FichaTecnicaCADO
     */
    protected $with = ['contenido_tematico','material_didactico','criterios_evaluacion','competencias','fuentes_informacion'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CAT_FICHA_TECNICA';

    /**
     * @var string
     */
    protected $table = 'CAT_FICHA_TECNICA_CADO';

    /**
     * @return \App\ContenidoTematicoCADO
     * @description: OBTIENE EL CONTENIDO TEMATICO RELACIONADO CON LA FICHA
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function contenido_tematico(){
        return $this->hasMany('App\ContenidoTematicoCADO',
            'FK_CAT_FICHA_TECNICA')->where('BORRADO', 0)
                                           ->orderBy('INDICE_TEMA','asc');
    }

    /**
     * @return \App\MaterialDidacticoCADO
     * @description: OBTIENE EL CONTENIDO TEMATICO RELACIONADO CON LA FICHA
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function material_didactico(){
        return $this->hasMany('App\MaterialDidacticoCADO',
            'FK_FICHA_TECNICA')->where('BORRADO', 0);
    }

    /**
     * @return \App\CriterioEvaluacionCADO
     * @description: OBTIENE EL MATERIAL DIDACTICO RELACIONADO CON LA FICHA
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function criterios_evaluacion(){
        return $this->hasMany('App\CriterioEvaluacionCADO',
            'FK_FICHA_TECNICA')->where('BORRADO', 0);
    }

    /**
     * @return \App\CompetenciaCADO
     * @description: OBTIENE LAS COMPETENCIAS RELACIONADAS CON LA FICHA
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 10/4/2020
     */
    public function competencias(){
        return $this->hasMany('App\CompetenciaCADO',
            'FK_FICHA_TECNICA')->where('BORRADO', 0);
    }

    /**
     * @return \App\FuenteInformacionCADO
     * @description: OBTIENE LAS FUENTES DE INFORMACION RELACIONADAS CON LA FICHA
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 10/4/2020
     */
    public function fuentes_informacion(){
        return $this->hasMany('App\FuenteInformacionCADO',
            'FK_FICHA_TECNICA')->where('BORRADO', 0);
    }
}
