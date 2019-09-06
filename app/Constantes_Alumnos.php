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

    /* CONSTANTES DE ESTATUS CUENTA DE ALUMNO */
    const ALUMNO_REGISTRADO      = 1;
    const ALUMNO_CUENTA_ACTIVA   = 2;
    const ALUMNO_CUENTA_INACTIVA = 0;

    static function traduce_estatus_cuenta_alumno($estatus){
        switch ($estatus){
            case self::ALUMNO_REGISTRADO:      return 'Alumno registrado';
            case self::ALUMNO_CUENTA_ACTIVA:   return 'Alumno con cuenta activa';
            case self::ALUMNO_CUENTA_INACTIVA: return 'Alumno con cuenta inactiva';
        }
    }
}
