<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActaResidencias extends Model
{

    public function info($id) {
        $info = DB::select(' DECLARE @alumno int = :alumno
                                   SELECT CAT_ANTEPROYECTO_RESIDENCIA.EMPRESA, CAT_ANTEPROYECTO_RESIDENCIA.NOMBRE, CATR_ALUMNO.NUMERO_CONTROL, 
                                   CAT_USUARIO.NOMBRE AS NOMBREALUMNO, CAT_USUARIO.PRIMER_APELLIDO, CAT_USUARIO.SEGUNDO_APELLIDO, CATR_CARRERA.NOMBRE AS CARRERA, CATR_CALIFICACION_ALUMNO.CALIFICACION, 
                                   CATR_CALIFICACION_ALUMNO.OBSERVACIONES, (select CAT_USUARIO.NOMBRE from CAT_USUARIO join CATR_DOCENTE on CAT_USUARIO.PK_USUARIO = CATR_DOCENTE.ID_PADRE join CATR_PROYECTO on 
                                   CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = @alumno) AS NOMBREMAESTRO, (select CAT_USUARIO.PRIMER_APELLIDO from CAT_USUARIO join CATR_DOCENTE on CAT_USUARIO.PK_USUARIO = CATR_DOCENTE.ID_PADRE join CATR_PROYECTO 
                                    on CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = @alumno) AS PAMAESTRO, (select CAT_USUARIO.SEGUNDO_APELLIDO from CAT_USUARIO join CATR_DOCENTE on CAT_USUARIO.PK_USUARIO = CATR_DOCENTE.ID_PADRE join CATR_PROYECTO 
                                   on CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = @alumno) AS SAMAESTRO, (select CAT_USUARIO.NOMBRE from CAT_USUARIO join CATR_EXTERNO on CAT_USUARIO.PK_USUARIO = CATR_EXTERNO.ID_PADRE join CATR_PROYECTO 
                                   on CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = @alumno) AS NOMBREEXTERNO, (select CAT_USUARIO.PRIMER_APELLIDO from CAT_USUARIO join CATR_EXTERNO on CAT_USUARIO.PK_USUARIO = CATR_EXTERNO.ID_PADRE join CATR_PROYECTO 
                                   on CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = @alumno) AS PAEXTERNO, (select CAT_USUARIO.SEGUNDO_APELLIDO from CAT_USUARIO join CATR_EXTERNO on CAT_USUARIO.PK_USUARIO = CATR_EXTERNO.ID_PADRE join CATR_PROYECTO 
                                   on CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT join CAT_ANTEPROYECTO_RESIDENCIA on CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                   where ALUMNO = 1) AS SAEXTERNO, CAT_CARTA_CALIFICACION_RESIDENCIA.FOLIO_ASIGNADO
                                   FROM
                                   CAT_ANTEPROYECTO_RESIDENCIA
                                   JOIN CATR_ALUMNO ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CATR_ALUMNO.ID_PADRE
                                   JOIN CAT_USUARIO ON CATR_ALUMNO.ID_PADRE = CAT_USUARIO.PK_USUARIO
                                   JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.CLAVE
                                   JOIN CATR_CALIFICACION_ALUMNO ON CATR_ALUMNO.ID_PADRE = CATR_CALIFICACION_ALUMNO.FK_ALUMNO
                                   JOIN CAT_CARTA_CALIFICACION_RESIDENCIA ON CATR_ALUMNO.NUMERO_CONTROL = CAT_CARTA_CALIFICACION_RESIDENCIA.NUMERO_CONTROL
                                   WHERE CATR_ALUMNO.ID_PADRE = @alumno',['alumno'=>$id]);
        return $info;
    }

    public function mes() {
        $mes = date('n');
        $mesLetra =  null;
        switch ($mes){
            case 1:
                $mesLetra = 'ENERO';
                break;
            case 2:
                $mesLetra = 'FEBRERO';
                break;
            case 3:
                $mesLetra = 'MARZO';
                break;
            case 4:
                $mesLetra = 'ABRIL';
                break;
            case 5:
                $mesLetra = 'MAYO';
                break;
            case 6:
                $mesLetra = 'JUNIO';
                break;
            case 7:
                $mesLetra = 'JULIO';
                break;
            case 8:
                $mesLetra = 'AGOSTO';
                break;
            case 9:
                $mesLetra = 'SEPTIEMBRE';
                break;
            case 10:
                $mesLetra = 'OCTUBRE';
                break;
            case 11:
                $mesLetra = 'NOVIEMBRE';
                break;
            case 12:
                $mesLetra = 'DICIEMBRE';
                break;
        }
        return $mesLetra;
    }

    public function periodo() {
        $mes = date('n');
        if ($mes <= 6){
            $periodo = 'ENERO - JUNIO';
        } else{
            $periodo = 'AGOSTO - DICIEMBRE';
        }
        return $periodo;
    }
}
