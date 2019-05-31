<?php

namespace App;

class Constantes_Alumnos{
    /* CONSTANTES DE ESTATUS DE ALUMNO */
    const ALUMNO_BT = 'BT';
    const ALUMNO_BD = 'BD';
    const ALUMNO_AR = 'AR';
    const ALUMNO_EG = 'EG';

    static function traduce_estatus_alumno($estatus){
        switch ($estatus){
            case self::ALUMNO_BT: return 'Baja Temporal';
            case self::ALUMNO_BD: return 'Baja Definitiva';
            case self::ALUMNO_AR: return 'Alumno Regular';
            case self::ALUMNO_EG: return 'Egresado';
        }
    }
}