<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FichaUnica extends Model
{
    public function jefe($id){
        $area = DB::select('SELECT CAT_AREA_ACADEMICA.NOMBRE 
                                  FROM CAT_AREA_ACADEMICA
                                  JOIN CATR_DOCENTE ON CAT_AREA_ACADEMICA.PK_AREA_ACADEMICA = CATR_DOCENTE.ID_AREA_ACADEMICA
                                  WHERE CATR_DOCENTE.ID_PADRE = :padre',['padre'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);

        switch($area3){
            case "Sistemas y Computación":
                $jefe = 'Guadalupe Efraín Bermúdez';
                break;
            case "Metalmecánica":
                $jefe = 'Francisco Alejandro Ramírez Díaz';
                break;
            case "Ciencias Económico Administrativas":
                $jefe = 'Petra Sandoval Flores';
                break;
            case "Ingeniería Industrial":
                $jefe = 'Eduardo Estrada Palomino';
                break;
        }
        return $jefe;
    }

    public function alumnos($id, $y){
        $maestro = DB::select('SELECT ID_AREA_ACADEMICA
                                      FROM CATR_DOCENTE
                                      WHERE ID_PADRE = :id',['id'=>$id]);
        $maestro1 = json_decode(json_encode($maestro),true);
        $maestro2 = array_pop($maestro1);
        $maestro3 = array_pop($maestro2);

        $alumnos = DB::select('DECLARE @Proyecto int = :proyecto, @Maestro int = :maestro
        SELECT users.name, users.PRIMER_APELLIDO, users.SEGUNDO_APELLIDO, CATR_CARRERA.NOMBRE, CATR_ALUMNO.NUMERO_CONTROL, users.email, CAT_ANTEPROYECTO_RESIDENCIA.NOMBRE AS Proyecto,
CAT_ANTEPROYECTO_RESIDENCIA.Empresa,(SELECT users.name FROM users
JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE
JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE
WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = @Maestro AND CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS NombreDocente,
(SELECT users.PRIMER_APELLIDO FROM users
JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE
JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE
WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = @Maestro AND CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS ApellidoPDocente,
(SELECT users.SEGUNDO_APELLIDO FROM users
JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE
JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE
WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = @Maestro AND CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS ApellidoMDocente,
(SELECT users.email FROM users
JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE
JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE
WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = @Maestro AND CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS CorreoDocente,
(SELECT users.name
FROM users
JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE
JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT
WHERE CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS NombreExterno,
(SELECT users.PRIMER_APELLIDO
FROM users
JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE
JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT
WHERE CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS ApellidoPExterno,
(SELECT users.SEGUNDO_APELLIDO
FROM users
JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE
JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT
WHERE CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS ApellidoMExterno,
(SELECT users.email
FROM users
JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE
JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT
WHERE CATR_PROYECTO.PK_PROYECTO = @Proyecto) AS CorreoExterno
FROM CATR_ALUMNO
JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.PK_CARRERA
JOIN PER_TR_ROL_USUARIO ON CATR_ALUMNO.ID_PADRE = PER_TR_ROL_USUARIO.FK_USUARIO
JOIN CAT_ANTEPROYECTO_RESIDENCIA ON CATR_ALUMNO.ID_PADRE = CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO
JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
JOIN PER_CATR_ROL ON PER_TR_ROL_USUARIO.FK_ROL = PER_CATR_ROL.PK_ROL
WHERE PER_CATR_ROL.NOMBRE = \'Residente\'
AND CATR_CARRERA.FK_AREA_ACADEMICA = @Maestro
AND CATR_PROYECTO.PK_PROYECTO = @Proyecto',['maestro'=>$maestro3,'proyecto'=>$y]);
        return $alumnos;
    }

    public function proyectos($id){
        $maestro = DB::select('SELECT ID_AREA_ACADEMICA
                                      FROM CATR_DOCENTE
                                      WHERE ID_PADRE = :id',['id'=>$id]);
        $maestro1 = json_decode(json_encode($maestro),true);
        $maestro2 = array_pop($maestro1);
        $maestro3 = array_pop($maestro2);

        $proyecto = DB::select('SELECT CATR_PROYECTO.PK_PROYECTO
                                      FROM CATR_PROYECTO
                                      JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                      WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = :id',['id'=> $maestro3]);
        return $proyecto;
    }
    public function mes() {
        $mes = date('n');
        $mesLetra =  null;
        switch ($mes){
            case 1:
                $mesLetra = 'Enero';
                break;
            case 2:
                $mesLetra = 'Febrero';
                break;
            case 3:
                $mesLetra = 'Marzo';
                break;
            case 4:
                $mesLetra = 'Abril';
                break;
            case 5:
                $mesLetra = 'Mayo';
                break;
            case 6:
                $mesLetra = 'Junio';
                break;
            case 7:
                $mesLetra = 'Julio';
                break;
            case 8:
                $mesLetra = 'Agosto';
                break;
            case 9:
                $mesLetra = 'Septiembre';
                break;
            case 10:
                $mesLetra = 'Octubre';
                break;
            case 11:
                $mesLetra = 'Noviembre';
                break;
            case 12:
                $mesLetra = 'Diciembre';
                break;
        }
        return $mesLetra;
    }

    public function periodo(){
        $periodo = '';
        if(Date('m')<=6):
            $periodo = 'Enero - Junio';
        else:
            $periodo = 'Agosto - Diciembre';
        endif;
        return $periodo;
    }

    public function departamento($id){
        $area = DB::select('SELECT CAT_AREA_ACADEMICA.NOMBRE 
                                  FROM CAT_AREA_ACADEMICA
                                  JOIN CATR_DOCENTE ON CAT_AREA_ACADEMICA.PK_AREA_ACADEMICA = CATR_DOCENTE.ID_AREA_ACADEMICA
                                  WHERE CATR_DOCENTE.ID_PADRE = :padre',['padre'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);

        switch($area3){
            case "Sistemas y Computación":
                $departamento = 'SISTEMAS Y COMPUTACIÓN';
                break;
            case "Metalmecánica":
                $departamento = 'METAL MECÁNICA';
                break;
            case "Ciencias Económico Administrativas":
                $departamento = 'CIENCIAS ECONÓMICO ADMINISTRATIVAS';
                break;
            case "Ingeniería Industrial":
                $departamento = 'INGENIERÍA INDUSTRIAL';
                break;
        }
        return $departamento;
    }

}
