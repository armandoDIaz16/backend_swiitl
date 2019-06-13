<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseResidenciasController extends Controller
{

    public function index()
    {
        $info = DB::select('SELECT CATR_CALIFICACION_ALUMNO.OBSERVACIONES, 
CATR_CALIFICACION_ALUMNO.TITULACION, 
CATR_CALIFICACION_ALUMNO.CALIFICACION, 
CATR_ALUMNO.NUMERO_CONTROL,
users.name,
users.PRIMER_APELLIDO, 
users.SEGUNDO_APELLIDO, 
(select name from users JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as NOMBREDOCENTE,
(select PRIMER_APELLIDO from users JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as PRIMERADOCENTE,
(select SEGUNDO_APELLIDO from users JOIN CATR_DOCENTE ON users.PK_USUARIO = CATR_DOCENTE.ID_PADRE JOIN CATR_PROYECTO ON CATR_DOCENTE.ID_PADRE = CATR_PROYECTO.FK_DOCENTE WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as SEGUNDOADOCENTE,
(select name from users JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as NOMBREEXTERNO,
(select PRIMER_APELLIDO from users JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as PRIMERAEXTERNO,
(select SEGUNDO_APELLIDO from users JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT WHERE FK_ANTEPROYECTO = FK_ANTEPROYECTO) as SEGUNDOAEXTERNO,
CAT_ANTEPROYECTO_RESIDENCIA.NOMBRE,
CAT_ANTEPROYECTO_RESIDENCIA.EMPRESA,
CAT_CARTA_CALIFICACION_RESIDENCIA.FOLIO_ASIGNADO
FROM CATR_CALIFICACION_ALUMNO
JOIN CATR_ALUMNO ON CATR_CALIFICACION_ALUMNO.FK_ALUMNO = CATR_ALUMNO.ID_PADRE
JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
JOIN CAT_ANTEPROYECTO_RESIDENCIA ON CATR_ALUMNO.ID_PADRE = CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO
JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
JOIN CAT_CARTA_CALIFICACION_RESIDENCIA ON CATR_ALUMNO.NUMERO_CONTROL = CAT_CARTA_CALIFICACION_RESIDENCIA.NUMERO_CONTROL ');
        return $info;
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $final = [];
        $alumno = DB::select('select CATR_ALUMNO.NUMERO_CONTROL, CAT_CARTA_CALIFICACION_RESIDENCIA.FECHA, CATR_CALIFICACION_ALUMNO.CALIFICACION, CAT_CARTA_CALIFICACION_RESIDENCIA.FOLIO_ASIGNADO
                                    FROM CAT_CARTA_CALIFICACION_RESIDENCIA
                                    JOIN CATR_ALUMNO ON CAT_CARTA_CALIFICACION_RESIDENCIA.NUMERO_CONTROL = CATR_ALUMNO.NUMERO_CONTROL
                                    JOIN CATR_CALIFICACION_ALUMNO ON CATR_ALUMNO.ID_PADRE = CATR_CALIFICACION_ALUMNO.FK_ALUMNO
                                    WHERE PERIODO = :periodo', ['periodo' => $actual]);



        foreach ($alumno as $index => $value) {
            $no = $value->NUMERO_CONTROL;
            $nocontrol = DB::connection('sqlsrv2')->select('SELECT
                                                                        view_alumnos.Semestre 
                                                                    from view_horarioalumno 
                                                                    join view_alumnos on view_horarioalumno.NumeroControl = view_alumnos.NumeroControl 
                                                                    where ClaveMateria = :materia 
                                                                    and IdPeriodoEscolar = :periodo 
                                                                    and Dia = :dia
                                                                    and view_alumnos.NumeroControl = :nol',['materia'=>'R1', 'periodo'=>$actual, 'dia'=>'1', 'nol'=>$no]);
            $t = json_decode(json_encode($nocontrol), true);
            $t2 = array_pop($t);
            $t3 = array_pop($t2);
            $value->SEMESTRE = $t3;
            $value->PERIODO = $actual;
        }
        return $alumno;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
