<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumCADO extends Model
{
    /**
     * @var bool
     */
    protected $with = ['formaciones','experiencias_laborales','productos_academicos','participacion_instructor','experiencia_docente'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CV_PARTICIPANTE';

    /**
     * @var string
     */
    protected $table = 'CAT_CV_PARTICIPANTE_CADO';


    /**
     * @return \App\FormacionCVCADO
     * @description: OBTIENE LOS REGISTROS DE FORMACION RELACIONADOS CON EL CV
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/5/2020
     */
    public function formaciones(){
        return $this->hasMany('App\FormacionCVCADO',
            'FK_CV')->where('BORRADO', 0);
    }
    /**
     * @return \App\ExperienciaLaboralCVCADO
     * @description: OBTIENE LOS REGISTROS DE FORMACION RELACIONADOS CON EL CV
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/5/2020
     */
    public function experiencias_laborales(){
        return $this->hasMany('App\ExperienciaLaboralCVCADO',
            'FK_CV')->where('BORRADO', 0);
    }
    /**
     * @return \App\ProductoAcademicoCVCADO
     * @description: OBTIENE LOS REGISTROS DE PRODUCTOS ACADEMICOS RELACIONADOS CON EL CV
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/5/2020
     */
    public function productos_academicos(){
        return $this->hasMany('App\ProductoAcademicoCVCADO',
            'FK_CV')->where('BORRADO', 0);
    }
    /**
     * @return \App\ParticipacionInstructorCVCADO
     * @description: OBTIENE LOS REGISTROS DE PARTICIPACION RELACIONADOS CON EL CV
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/5/2020
     */
    public function participacion_instructor(){
        return $this->hasMany('App\ParticipacionInstructorCVCADO',
            'FK_CV')->where('BORRADO', 0);
    }
    /**
     * @return \App\ExperienciaDocenteCVCADO
     * @description: OBTIENE LOS REGISTROS DE PARTICIPACION RELACIONADOS CON EL CV
     *               HasMany ES PARA RELACIONES 1 A muchos EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/5/2020
     */
    public function experiencia_docente(){
        return $this->hasMany('App\ExperienciaDocenteCVCADO',
            'FK_CV')->where('BORRADO', 0);
    }


}
