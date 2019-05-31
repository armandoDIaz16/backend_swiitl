<?php

namespace App\Http\Controllers;

use App\PAAE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoAspirantesMail;


class PAAE_Periodo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PK_PAAE_PERIODO = PAAE::select('FECHA_INICIO','FECHA_FIN')->max('PK_PAAE_PERIODO');

        $periodo = PAAE::select('FECHA_INICIO','FECHA_FIN')
        ->where('PK_PAAE_PERIODO',$PK_PAAE_PERIODO)
        ->get()[0];
        
        return [
            array(
            'FECHA_INICIO' => $periodo->FECHA_INICIO,
            'FECHA_FIN' => $periodo->FECHA_FIN,
            'FECHA_ACTUAL' => $this->fechaActual()
            )
        ];
    }

    public function fechaActual(){
        $fechaActual = Date('Y').'-';
        $fechaActual = $fechaActual .Date('m').'-';
        $fechaActual = $fechaActual .Date('d');
        return $fechaActual;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->FK_USUARIO_REGISTRO){
            $periodo = new PAAE();
            $periodo->FECHA_INICIO = $request->FECHA_INICIO;
            $periodo->FECHA_FIN = $request->FECHA_FIN;
            $periodo->FK_USUARIO_REGISTRO = $request->FK_USUARIO_REGISTRO;
            $periodo->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function horario(Request $request){      
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        //print_r($periodo);

        $hora = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
            ->select('Dia','HoraInicial','MinutoInicial','HoraFinal','MinutoFinal')
            ->where([['NumeroControl',$request->control],    
                    ['IdPeriodoEscolar',$periodo],
                    ['Dia',$request->dia]
                    ])   
            ->orderBy('dia')
            ->orderBy('HoraInicial')
            ->get();
         if($hora){
             return $hora;
            //return $hoy;
        /* return response()->json(['data' => $horario], Response::HTTP_OK); */
         }else{
            return $this->failedResponse();
         }
    }

    public function horarioAll(Request $request){      
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        //print_r($periodo);

        $hora = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
            ->select('Dia','HoraInicial','MinutoInicial','HoraFinal','MinutoFinal')
            ->where([['NumeroControl',$request->control],    
                    ['IdPeriodoEscolar',$periodo]
                    ])   
            ->orderBy('dia')
            ->orderBy('HoraInicial')
            ->get();
         if($hora){
             return $hora;
            //return $hoy;
        /* return response()->json(['data' => $horario], Response::HTTP_OK); */
         }else{
            return $this->failedResponse();
         }
    }
    
    public function materia(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month; $materias=[];
        $materia = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
            ->select('Nombre')
            ->distinct()
            ->join('view_reticula', 'view_horarioalumno.clavemateria', '=', 'view_reticula.ClaveMateria')
            ->where([['NumeroControl',$request->control],    
                    ['IdPeriodoEscolar',$periodo]
                    ])
            ->get();            
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function materiAsesor(Request $request){
        $materia = DB::connection('sqlsrv2')
        ->table('view_seguimiento')
            ->select('Nombre')
            ->distinct()
            ->join('view_reticula', 'view_seguimiento.clavemateria', '=', 'view_reticula.ClaveMateria')
            ->where([['NumeroControl',$request->control],    
                    ['IdNivelCurso','CO'],
                    ['Calificacion','>',85],
                    ])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function promedio(Request $request){
        $promedio = DB::connection('sqlsrv2')
        ->table('view_seguimiento')
        ->where([['NumeroControl',$request->control]])
        ->avg('Calificacion');
        if($promedio){
            return $promedio;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function crearSolicitud(Request $request ){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

        DB::table('CATR_USER_ASESORIA_HORARIO')->insert([
            'FK_USUARIO' => $request->id,
            'MATERIA' => $request->materia,
            'DIA' => $request->dia,
            'HORA' => $request->hora,
            'PERIODO' => $periodo,
            'CAMPUS' => $request->campus,
            'STATUS' => 'PENDIENTE'
        ]);

        $asesor = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->select('FK_USUARIO')
        ->where([['MATERIA',$request->materia],    
                ['DIA',$request->dia],
                ['HORA',$request->hora],
                ])
        ->get()->first();        

        $asesor1 = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->select('FK_USUARIO')
        ->where([['MATERIA1',$request->materia],    
                ['DIA',$request->dia],
                ['HORA',$request->hora],
                ])
        ->get()->first();       

        $asesor2 = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->select('FK_USUARIO')
        ->where([['MATERIA2',$request->materia],    
                ['DIA',$request->dia],
                ['HORA',$request->hora],
                ])
        ->get()->first();        

        if($asesor){
            DB::table('CATR_ASESORIA_ACEPTADA')->insert([
                'FK_ASESOR' => $asesor->FK_USUARIO,
                'FK_ALUMNO' => $request->id,
                'MATERIA' => $request->materia,
                'DIA' => $request->dia,
                'HORA' => $request->hora,
                'PERIODO' => $periodo,
                'CAMPUS' => $request->campus,
                'STATUS' => 'ACEPTADO'
            ]);
        }
        if($asesor1){
          
            DB::table('CATR_ASESORIA_ACEPTADA')->insert([
                'FK_ASESOR' => $asesor1->FK_USUARIO,
                'FK_ALUMNO' => $request->id,
                'MATERIA' => $request->materia,
                'DIA' => $request->dia,
                'HORA' => $request->hora,
                'PERIODO' => $periodo,
                'CAMPUS' => $request->campus,
                'STATUS' => 'ACEPTADO'
            ]);
        }
        if($asesor2){
            DB::table('CATR_ASESORIA_ACEPTADA')->insert([
                'FK_ASESOR' => $asesor2->FK_USUARIO,
                'FK_ALUMNO' => $request->id,
                'MATERIA' => $request->materia,
                'DIA' => $request->dia,
                'HORA' => $request->hora,
                'PERIODO' => $periodo,
                'CAMPUS' => $request->campus,
                'STATUS' => 'ACEPTADO'
            ]);
        }

        return response()->json(['data' => true], Response::HTTP_OK);
        
    }

    public function crearSolicitudAsesor(Request $request ){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        DB::table('CATR_ASESOR_ASESORIA_HORARIO')->insert([
            'FK_USUARIO' => $request->id,
            'MATERIA' => $request->materia,
            'MATERIA1' => $request->materia1,
            'MATERIA2' => $request->materia2,
            'DIA' => $request->dia,
            'HORA' => $request->hora,
            'VALIDA' => $request->validar,
            'CAMPUS' => $request->campus,
            'PERIODO' => $periodo,
            'STATUS' => 'PENDIENTE'

        ]);
        return response()->json(['data' => true], Response::HTTP_OK);
        
    }
    //hola
    public function getDatos(Request $request){
        $alumno = DB::table('users')
            ->select('NUMERO_CONTROL', 'PRIMER_APELLIDO', 'SEGUNDO_APELLIDO', 'name', 'CLAVE_CARRERA', 'email', 'TELEFONO_MOVIL','SEMESTRE')
            ->where('PK_USUARIO',$request->id)
            ->get()->first();

        if(!empty($alumno)){
                //return $this->successResponse($alumno);
                $datos_alumno = [
                    'control'           => trim($alumno->NUMERO_CONTROL),
                    'apep'           => trim($alumno->PRIMER_APELLIDO),
                    'apem'           => trim($alumno->SEGUNDO_APELLIDO),
                    'name'           => trim($alumno->name),
                    'carrera'           => trim($alumno->CLAVE_CARRERA),
                    'email'           => trim($alumno->email),
                    'semestre'           => trim($alumno->SEMESTRE),
                    'celular'           => trim($alumno->TELEFONO_MOVIL),
                ];
                return response()->json([$datos_alumno], Response::HTTP_OK);
        }

        return $this->failedResponse();
    }
//fin 

    public function getAsesor(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
            ->select('CATR_ASESOR_ASESORIA_HORARIO.PK_ASESOR_ASESORIA_HORARIO', 
            'users.name', 'users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO', 'users.email', 
            'users.TELEFONO_MOVIL','CATR_ASESOR_ASESORIA_HORARIO.MATERIA',
            'CATR_ASESOR_ASESORIA_HORARIO.MATERIA1','CATR_ASESOR_ASESORIA_HORARIO.MATERIA2'
            ,'CATR_ASESOR_ASESORIA_HORARIO.DIA',
            'CATR_ASESOR_ASESORIA_HORARIO.HORA','CATR_ASESOR_ASESORIA_HORARIO.CAMPUS',
            'CATR_ASESOR_ASESORIA_HORARIO.STATUS','CATR_ASESOR_ASESORIA_HORARIO.PERIODO',
            'users.NUMERO_CONTROL','CATR_ASESOR_ASESORIA_HORARIO.VALIDA')
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO')
            ->where('PERIODO',$periodo)
            ->get();

            if($alumno){
                return $alumno;
            }else{
            return $this->failedResponse();
            }
    }

    public function getAsesorPeriodo(Request $request){
        $alumno = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
            ->select('CATR_ASESOR_ASESORIA_HORARIO.PK_ASESOR_ASESORIA_HORARIO', 
            'users.name', 'users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO', 'users.email', 
            'users.TELEFONO_MOVIL','CATR_ASESOR_ASESORIA_HORARIO.MATERIA',
            'CATR_ASESOR_ASESORIA_HORARIO.MATERIA1','CATR_ASESOR_ASESORIA_HORARIO.MATERIA2'
            ,'CATR_ASESOR_ASESORIA_HORARIO.DIA',
            'CATR_ASESOR_ASESORIA_HORARIO.HORA','CATR_ASESOR_ASESORIA_HORARIO.CAMPUS',
            'CATR_ASESOR_ASESORIA_HORARIO.STATUS','CATR_ASESOR_ASESORIA_HORARIO.PERIODO')
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO')
            ->where('PERIODO',$request->periodo)
            ->get();

            if($alumno){
                return $alumno;
            }else{
            return $this->failedResponse();
            }
    }

    public function getSolicitud(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('CATR_USER_ASESORIA_HORARIO.PK_USER_ASESORIA_HORARIO','users.name',
        'users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO', 'users.email', 'users.TELEFONO_MOVIL',
        'CATR_USER_ASESORIA_HORARIO.MATERIA'
        , 'CATR_USER_ASESORIA_HORARIO.DIA',
        'CATR_USER_ASESORIA_HORARIO.HORA','CATR_USER_ASESORIA_HORARIO.CAMPUS', 'CATR_USER_ASESORIA_HORARIO.STATUS',
        'CATR_USER_ASESORIA_HORARIO.CAMPUS','CATR_USER_ASESORIA_HORARIO.STATUS','CATR_USER_ASESORIA_HORARIO.PERIODO',
        'users.NUMERO_CONTROL')
        ->join('users', 'users.PK_USUARIO', '=', 'CATR_USER_ASESORIA_HORARIO.FK_USUARIO')
        ->where('PERIODO',$periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function getSolicitudPeriodo(Request $request){
        $alumno = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('CATR_USER_ASESORIA_HORARIO.PK_USER_ASESORIA_HORARIO','users.name',
        'users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO', 'users.email', 'users.TELEFONO_MOVIL',
        'CATR_USER_ASESORIA_HORARIO.MATERIA'
        , 'CATR_USER_ASESORIA_HORARIO.DIA',
        'CATR_USER_ASESORIA_HORARIO.HORA','CATR_USER_ASESORIA_HORARIO.CAMPUS', 'CATR_USER_ASESORIA_HORARIO.STATUS',
        'CATR_USER_ASESORIA_HORARIO.CAMPUS','CATR_USER_ASESORIA_HORARIO.STATUS','CATR_USER_ASESORIA_HORARIO.PERIODO')
        ->join('users', 'users.PK_USUARIO', '=', 'CATR_USER_ASESORIA_HORARIO.FK_USUARIO')
        ->where('PERIODO',$request->periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function seguimiento(Request $request){
        $alumno = DB::connection('sqlsrv2')->select('SELECT distinct  a.ClaveMateria,b.Nombre COLLATE Latin1_General_CI_AI AS [Nombre],a.IdNivelCurso,a.Calificacion 
        FROM view_seguimiento a INNER JOIN view_reticula b on a.ClaveMateria = b.ClaveMateria WHERE NumeroControl = :control1',['control1'=>$request->control]);
        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function actualizAsesor(Request $request){
        DB::table('CATR_ASESOR_ASESORIA_HORARIO')
            ->where('PK_ASESOR_ASESORIA_HORARIO', $request->id)
            ->update(['MATERIA' => $request->materia1, 'MATERIA1' => $request->materia2, 'MATERIA2' => $request->materia3,
            'DIA' => $request->dia,'HORA' => $request->hora,'VALIDA' => $request->valida]);
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function actualizaSolicitud(Request $request){
        DB::table('CATR_USER_ASESORIA_HORARIO')
            ->where('PK_USER_ASESORIA_HORARIO', $request->id1)
            ->update(['MATERIA' => $request->materia,'DIA' => $request->dia1,'HORA' => $request->hora1]);
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function borrAsesor(Request $request){
        DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->where('PK_ASESOR_ASESORIA_HORARIO',$request->id)
        ->delete();
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function borraSolicitud(Request $request){
        DB::table('CATR_USER_ASESORIA_HORARIO')
        ->where('PK_USER_ASESORIA_HORARIO',$request->id1)
        ->delete();
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }


    public function allMaterias(){
        $alumno = DB::connection('sqlsrv2')->select('SELECT distinct Nombre COLLATE Latin1_General_CI_AI AS [Nombre] 
        FROM view_reticula');
        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function asignacionIndividual(Request $request){
        $hoy = getdate();$year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        
        $asesor = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->select('VALIDA')
        ->where([['FK_USUARIO',$request->selectasesor]
                ])
        ->get()->first();

        DB::table('CATR_ASESORIA_ACEPTADA')->insert([
            'FK_ASESOR' => $request->selectasesor,
            'FK_ALUMNO' => $request->selectsolicitante,
            'MATERIA' => $request->selectmateria,
            'DIA' => $request->dia,
            'HORA' => $request->hora,
            'PERIODO' => $periodo,
            'CAMPUS' => $request->campus,
            'ESPACIO' => $request->espacio,
            'VALIDA' =>  $asesor->VALIDA,
            'STATUS' => 'ACEPTADO'
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);

    }


    public function claveGrupo(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $clave = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
            ->select('clavegrupo')
            ->distinct()
            ->where([['clavemateria','PDH'],    
                    ['IdPeriodoEscolar','20182']
                    ])
            ->get();
         if($clave){
             return $clave;
         }else{
            return $this->failedResponse();
         }

    }

    public function claveHorario(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $clave = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
            ->select('HoraInicial','MinutoInicial','HoraFinal','MinutoFinal','Dia')
            ->distinct()
            ->where([['clavemateria','PDH'],    
                    ['IdPeriodoEscolar',$periodo],    
                    ['clavegrupo',$request->clavegrupo]
                    ])
            ->get();
         if($clave){
             return $clave;
         }else{
            return $this->failedResponse();
         }

    }

    public function getAsesorAsigna(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
            ->select('users.PK_USUARIO','users.name','users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO','CATR_ASESOR_ASESORIA_HORARIO.VALIDA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO')
            ->where('PERIODO',$periodo)
            ->get();

            if($alumno){
                return $alumno;
            }else{
            return $this->failedResponse();
            }
    }

    public function getSolicitudAsigna(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('users.PK_USUARIO','users.name','users.PRIMER_APELLIDO', 'users.SEGUNDO_APELLIDO')
        ->distinct()
        ->join('users', 'users.PK_USUARIO', '=', 'CATR_USER_ASESORIA_HORARIO.FK_USUARIO')
        ->where('PERIODO',$periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function asignacionGrupal(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;


        $asesor = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
        ->select('VALIDA')
        ->where([['FK_USUARIO',$request->selectasesorgrupo]
                ])
        ->get()->first();

        DB::table('CATR_ASESORIA_GRUPO')->insert([
            'FK_ASESOR' => $request->selectasesorgrupo,
            'CLAVE_GRUPO' => $request->clavegrupo,
            'MATERIA' => $request->selectmateriagrupo,
            'DIA' => $request->diagru,
            'HORA' => $request->horagrupo,
            'PERIODO' => $periodo,
            'CAMPUS' => $request->campusgrupo,
            'ESPACIO' => $request->espaciogrupo,
            'STATUS' => 'ACEPTADO',
            'VALIDA' => $asesor->VALIDA
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);

    }

    public function getAsesoria(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_ASESORIA_ACEPTADA')
        ->select('CATR_ASESORIA_ACEPTADA.PK_ASESORIA_ACEPTADA','CATR_ASESORIA_ACEPTADA.MATERIA','CATR_ASESORIA_ACEPTADA.DIA',
        'CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.CAMPUS',
        'CATR_ASESORIA_ACEPTADA.PERIODO','CATR_ASESORIA_ACEPTADA.FK_ASESOR','CATR_ASESORIA_ACEPTADA.FK_ALUMNO'
        ,'CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.VALIDA')
        ->where('PERIODO',$periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function getAsesoriaPeriodo(Request $request){
        $alumno = DB::table('CATR_ASESORIA_ACEPTADA')
        ->select('CATR_ASESORIA_ACEPTADA.PK_ASESORIA_ACEPTADA','CATR_ASESORIA_ACEPTADA.MATERIA','CATR_ASESORIA_ACEPTADA.DIA',
        'CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.CAMPUS','CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.VALIDA',
        'CATR_ASESORIA_ACEPTADA.PERIODO','CATR_ASESORIA_ACEPTADA.FK_ASESOR','CATR_ASESORIA_ACEPTADA.FK_ALUMNO')
        ->where('PERIODO',$request->periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function getAsesoriaGrupo(){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::table('CATR_ASESORIA_GRUPO')
        ->select('CATR_ASESORIA_GRUPO.PK_ASESORIA_GRUPO','CATR_ASESORIA_GRUPO.MATERIA','CATR_ASESORIA_GRUPO.DIA',
        'CATR_ASESORIA_GRUPO.HORA','CATR_ASESORIA_GRUPO.CAMPUS','CATR_ASESORIA_GRUPO.ESPACIO','CATR_ASESORIA_GRUPO.VALIDA',
        'CATR_ASESORIA_GRUPO.PERIODO','CATR_ASESORIA_GRUPO.FK_ASESOR','CATR_ASESORIA_GRUPO.CLAVE_GRUPO')
        ->where('PERIODO',$periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function getAsesoriaGrupoPeriodo(Request $request){
        $alumno = DB::table('CATR_ASESORIA_GRUPO')
        ->select('CATR_ASESORIA_GRUPO.PK_ASESORIA_GRUPO','CATR_ASESORIA_GRUPO.MATERIA','CATR_ASESORIA_GRUPO.DIA',
        'CATR_ASESORIA_GRUPO.HORA','CATR_ASESORIA_GRUPO.CAMPUS','CATR_ASESORIA_GRUPO.ESPACIO','CATR_ASESORIA_GRUPO.VALIDA',
        'CATR_ASESORIA_GRUPO.PERIODO','CATR_ASESORIA_GRUPO.FK_ASESOR','CATR_ASESORIA_GRUPO.CLAVE_GRUPO')
        ->where('PERIODO',$request->periodo)
        ->get();

        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function actualizAsigInd(Request $request){
        DB::table('CATR_ASESORIA_ACEPTADA')
            ->where('PK_ASESORIA_ACEPTADA', $request->idAsesor)
            ->update(['FK_ASESOR' => $request->asesor, 'FK_ALUMNO' => $request->alumno, 'MATERIA' => $request->materia,
            'DIA' => $request->dia,'HORA' => $request->hora,'VALIDA' => $request->valida,'ESPACIO' => $request->espacio,
            'CAMPUS' => $request->campus]);
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function borrInd(Request $request){
        DB::table('CATR_ASESORIA_ACEPTADA')
        ->where('PK_ASESORIA_ACEPTADA',$request->idAsesor)
        ->delete();
        
        return response()->json(['data' => true], Response::HTTP_OK);
    } 

    public function actualizGrupo(Request $request){
        DB::table('CATR_ASESORIA_GRUPO')
            ->where('PK_ASESORIA_GRUPO', $request->idGrupo)
            ->update(['FK_ASESOR' => $request->asesor1, 'CLAVE_GRUPO' => $request->grupo, 'MATERIA' => $request->materia1,
            'DIA' => $request->dia1,'HORA' => $request->hora1,'VALIDA' => $request->valida1,'ESPACIO' => $request->espacio1,
            'CAMPUS' => $request->campus1]);
        
        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function borrGru(Request $request){
        DB::table('CATR_ASESORIA_GRUPO')
        ->where('PK_ASESORIA_GRUPO',$request->idGrupo)
        ->delete();
        
        return response()->json(['data' => true], Response::HTTP_OK);
    } 

    public function allDocente(){
        $alumno = DB::connection('sqlsrv2')
        ->table('view_docentes')
        ->select('Nombre', 'ApellidoPaterno','ApellidoMaterno')
        ->distinct()        
        ->get();
        if($alumno){
            return $alumno;
        }else{
        return $this->failedResponse();
        }
    }

    public function motivo(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

        $alumno = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('PK_USER_ASESORIA_HORARIO')
        ->distinct()
        ->where([['FK_USUARIO',$request->id],    
                    ['PERIODO',$periodo],    
                    ])        
        ->get()->first();
       // return $alumno->PK_USER_ASESORIA_HORARIO;

        DB::table('TR_ASESORIA_MOTIVO')->insert([
            'FK_MOTIVO' => $request->motivo,
            'FK_SOLICITUD' => $alumno->PK_USER_ASESORIA_HORARIO,
            'FK_USER' => $request->id,
            'TURNO' => $request->turno,
            'MATERIA_APOYO1' => $request->materiasAll,
            'DOCE
            NTE1' => $request->maestro,
            'EDAD' => $request->edad,
            'RESIDENCIA' => $request->residencia,
            'OTRO' => $request->otro,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function compromisoUser(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        DB::table('CATR_CARTA_COMPROMISO_USER')->insert([
            'FK_USER' => $request->id,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function nombreAsesor(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.PK_USUARIO','users.name','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','CATR_ASESORIA_ACEPTADA.MATERIA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->where([['FK_ALUMNO',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function evaluacionSatisfaccion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

   /*      $alumno = DB::table('CATR_ASESORIA_ACEPTADA')
        ->select('FK_ASESOR')
        ->distinct()
        ->where([['FK_ALUMNO',$request->id],    
                    ['PERIODO',$periodo],    
                    ])        
        ->get()->first(); */

        DB::table('TR_EVALUACION_SATISFACCION')->insert([
            'FK_AFIRMACION' => $request->afirmacion,
            'RESPUESTA' => $request->respuesta,
            'FK_USER' => $request->id,
            'FK_ASESOR' => $request->asesorSa,
            'MATERIA' => $request->materiaSa,
            'SESIONES' => $request->sesion,
            'SUGERENCIA' => $request->sugerencia,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function compromisoAsesor(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        DB::table('CATR_CARTA_COMPROMISO_ASESOR')->insert([
            'FK_USER' => $request->id,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function allAsesor(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('CATR_ASESORIA_ACEPTADA.MATERIA')
            ->distinct()
            ->where([['FK_ASESOR',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function crearSesion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

        DB::table('CATR_REPORTE_DE_SESIONES')->insert([
            'FK_ASESOR' => $request->id,
            'MATERIA' => $request->materia,
            'SESION' => $request->sesion,
            'FECHA' => $request->fecha,
            'ASISTENTES' => $request->asistentes,
            'HORAINICIO' => $request->horainicio,
            'HORAFINAL' => $request->horafinal,
            'TEMA' => $request->tema,
            'ACTIVIDADES_OBSERVACIONES' => $request->actividades,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function getAlumnoAsesorado(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.PK_USUARIO','users.name','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ALUMNO')
            ->where([['FK_ASESOR',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function getAlumnoAsesoradoMateria(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.PK_USUARIO','users.name','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.NUMERO_CONTROL','users.CLAVE_CARRERA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ALUMNO')
            ->where([['FK_ASESOR',$request->id],
            ['MATERIA',$request->materialis]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function crearAsistencia(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

        DB::table('CATR_LISTA_DE_ASISTENCIA')->insert([
            'FK_ASESOR' => $request->id,
            'FK_USER' => $request->fk_user,
            'FECHA' => $request->fechalis,
            'ASISTIO' => $request->asistio,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }


    public function getSesion(Request $request){
        $materia = DB::table('CATR_REPORTE_DE_SESIONES')
            ->select('PK_REPORTE_DE_SESIONES','FECHA','TEMA')
            ->distinct()
            /* ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ALUMNO') */
            ->where([['FK_ASESOR',$request->id],
            ['MATERIA',$request->materiafin]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function creaFinal(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;

        DB::table('CATR_REPORTE_FINAL')->insert([
            'FK_ASESOR' => $request->id,
            'MATERIA' => $request->materiafin,
            'FECHA_ENTREGA' => $request->fechafin,
            'FECHA_INICIO' => $request->fechafin1,
            'FECHA_FIN' => $request->fechafin2,
            'LUGAR' => $request->lugar,
            'ASESORADOS' => $request->asesorados,
            'SESIONES' => $request->sesionfin,
            'SUGERENCIAS' => $request->sugerenciafin,
            'PERIODO' => $periodo
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
    }

    public function situacionAcademica(){
       

        $materia = DB::connection('sqlsrv2')
            ->table('view_seguimiento')
            ->select('view_seguimiento.NumeroControl','view_alumnos.Nombre','view_alumnos.ApellidoPaterno','view_alumnos.ApellidoMaterno')
            ->distinct()
            ->join('view_reticula', 'view_reticula.ClaveMateria', '=', 'view_seguimiento.ClaveMateria')
            ->join('view_alumnos', 'view_alumnos.NumeroControl', '=', 'view_seguimiento.NumeroControl')
            ->where([['view_alumnos.Estado','AR'],
            ['IdNivelCurso','CR']])
            ->orWhere([['view_alumnos.Estado','AR'],
            ['IdNivelCurso','CE']])
            ->orWhere([['view_alumnos.Estado','AR'],
            ['IdNivelCurso','CE2"']])
            ->get();
        if($materia){          
             return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function recursando(Request $request){
    $alumno = DB::connection('sqlsrv2')
    ->table('view_seguimiento')
    ->select(
        DB::raw('view_reticula.Nombre COLLATE Latin1_General_CI_AI AS [Nombre]'),
        DB::raw('view_reticula.ClaveMateria')
        )
    ->distinct()
    ->join('view_reticula', 'view_reticula.ClaveMateria', '=', 'view_seguimiento.ClaveMateria')
    ->join('view_alumnos', 'view_alumnos.NumeroControl', '=', 'view_seguimiento.NumeroControl')
    ->where([['view_alumnos.Estado','AR'],
    ['IdNivelCurso','CR'],['view_seguimiento.NumeroControl',$request->selectreprobado]])
    ->orWhere([['view_alumnos.Estado','AR'],
    ['IdNivelCurso','CE'],['view_seguimiento.NumeroControl',$request->selectreprobado]])
    ->orWhere([['view_alumnos.Estado','AR'],
    ['IdNivelCurso','CE2"'],['view_seguimiento.NumeroControl',$request->selectreprobado]])
    ->get();

return $alumno;
    }

    public function materiaRepeticion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $alumno = DB::connection('sqlsrv2')
        ->table('view_horarioalumno')
        ->select(DB::raw('view_reticula.Nombre COLLATE Latin1_General_CI_AI AS [Nombre]'))
        ->distinct()
        ->join('view_reticula', 'view_reticula.ClaveMateria', '=', 'view_horarioalumno.ClaveMateria')
        ->where([['view_horarioalumno.IdPeriodoEscolar',$periodo],
        ['view_reticula.ClaveMateria',$request->clavemateriasituacion],['view_horarioalumno.NumeroControl',$request->selectreprobado]])
        ->get();
        
        if(json_decode($alumno, true)){          
            return $alumno;
       }else{
          return $this->failedResponse();
       }
        }

        public function asignacionSituacion(Request $request){
            $hoy = getdate();$year = $hoy['year'];
            $month = $hoy['mon'];
            if($month <=6){
                $month = 1;       
            }
            if($month > 7){
                $month = 2;
            }
            $periodo = $year.$month;

            $asesor = DB::table('CATR_ASESOR_ASESORIA_HORARIO')
            ->select('VALIDA')
            ->where([['FK_USUARIO',$request->asesorsituacion]
                    ])
            ->get()->first();
            DB::table('CATR_ASESORIA_ACEPTADA_SITUACION')->insert([
                'FK_ASESOR' => $request->asesorsituacion,
                'CONTROL_ALUMNO' => $request->selectreprobado,
                'MATERIA' => $request->clavemateriasituacion,
                'DIA' => $request->diasituacion,
                'HORA' => $request->horasituacion,
                'PERIODO' => $periodo,
                'CAMPUS' => $request->campussituacion,
                'ESPACIO' => $request->espaciosituacion,
                'VALIDA'  => $asesor->VALIDA,
                'STATUS' => 'ACEPTADO'

            ]);
    
            return response()->json(['data' => true], Response::HTTP_OK);
    
        }

        public function enviarCorreos(Request $request)
    {
        Mail::to($request->correos)->send(new CorreoAspirantesMail($request->mensaje, $request->asunto));
    }

    public function AsesorEntregoFinal(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_REPORTE_FINAL')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_REPORTE_FINAL.PERIODO','CATR_ASESOR_ASESORIA_HORARIO.VALIDA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->join('CATR_ASESOR_ASESORIA_HORARIO', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->where([['CATR_REPORTE_FINAL.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function AsesorEntregoFinalPeriodo(Request $request){
        $materia = DB::table('CATR_REPORTE_FINAL')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_REPORTE_FINAL.PERIODO','CATR_ASESOR_ASESORIA_HORARIO.VALIDA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->join('CATR_ASESOR_ASESORIA_HORARIO', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->where([['CATR_REPORTE_FINAL.PERIODO',$request->periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function creaCalificacion(Request $request){
        $hoy = getdate();$year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
/* 
        $asesor = DB::table('CATR_CALIFICACION_PARCIAL')
        ->select('VALIDA')
        ->where([['FK_USUARIO',$request->asesorsituacion]
                ])
        ->get()->first(); */
        DB::table('CATR_CALIFICACION_PARCIAL')->insert([
            'FK_USUARIO' => $request->id,
            'FK_ASESOR' => $request->asesorSa,
            'MATERIA' => $request->materiaSa,
            'AULA' => $request->aula,
            'DIA' => $request->dia,
            'HORA' => $request->hora,
            'UNIDAD' => $request->unidad,
            'CALIFICACION' => $request->calificacionun,
            'OBSERVACIONES' => $request->sugerencia,
            'PERIODO' => $periodo,
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);

    }

    public function allMotivos(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('TR_ASESORIA_MOTIVO')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA',
            'CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE','TR_ASESORIA_MOTIVO.EDAD','users.SEXO','TR_ASESORIA_MOTIVO.RESIDENCIA'
            ,'TR_ASESORIA_MOTIVO.TURNO','users.email', 'TR_ASESORIA_MOTIVO.MATERIA_APOYO1','TR_ASESORIA_MOTIVO.DOCENTE1', 'TR_ASESORIA_MOTIVO.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
            ->join('CAT_MOTIVO_ASESORIA_ACADEMICA', 'CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
            ->where([['TR_ASESORIA_MOTIVO.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allMotivosPeriodo(Request $request){
        $materia = DB::table('TR_ASESORIA_MOTIVO')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA',
            'CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE','TR_ASESORIA_MOTIVO.EDAD','users.SEXO','TR_ASESORIA_MOTIVO.RESIDENCIA'
            ,'TR_ASESORIA_MOTIVO.TURNO','users.email', 'TR_ASESORIA_MOTIVO.MATERIA_APOYO1','TR_ASESORIA_MOTIVO.DOCENTE1', 'TR_ASESORIA_MOTIVO.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
            ->join('CAT_MOTIVO_ASESORIA_ACADEMICA', 'CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
            ->where([['TR_ASESORIA_MOTIVO.PERIODO',$request->periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCompromisoUser(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_CARTA_COMPROMISO_USER')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_CARTA_COMPROMISO_USER.FECHA_REGISTRO','CATR_CARTA_COMPROMISO_USER.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_CARTA_COMPROMISO_USER.FK_USER')
            ->where([['CATR_CARTA_COMPROMISO_USER.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCompromisoUserPeriodo(Request $request){
        $materia = DB::table('CATR_CARTA_COMPROMISO_USER')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_CARTA_COMPROMISO_USER.FECHA_REGISTRO','CATR_CARTA_COMPROMISO_USER.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_CARTA_COMPROMISO_USER.FK_USER')
            ->where([['CATR_CARTA_COMPROMISO_USER.PERIODO',$request->periodo1]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCompromisoAsesor(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_CARTA_COMPROMISO_ASESOR')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_CARTA_COMPROMISO_ASESOR.FECHA_REGISTRO','CATR_CARTA_COMPROMISO_ASESOR.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_CARTA_COMPROMISO_ASESOR.FK_USER')
            ->where([['CATR_CARTA_COMPROMISO_ASESOR.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCompromisoAsesorPeriodo(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_CARTA_COMPROMISO_ASESOR')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_CARTA_COMPROMISO_ASESOR.FECHA_REGISTRO','CATR_CARTA_COMPROMISO_ASESOR.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_CARTA_COMPROMISO_ASESOR.FK_USER')
            ->where([['CATR_CARTA_COMPROMISO_ASESOR.PERIODO',$request->periodo2]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allEvaluacion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('TR_EVALUACION_SATISFACCION')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'TR_EVALUACION_SATISFACCION.RESPUESTA','TR_EVALUACION_SATISFACCION.MATERIA','TR_EVALUACION_SATISFACCION.SESIONES',
            'TR_EVALUACION_SATISFACCION.SUGERENCIA','TR_EVALUACION_SATISFACCION.PERIODO','a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea',
            'CAT_AFIRMACIONES_EVALUACION.NOMBRE')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'TR_EVALUACION_SATISFACCION.FK_USER')
            ->join('users as a', 'a.PK_USUARIO', '=', 'TR_EVALUACION_SATISFACCION.FK_ASESOR')
            ->join('CAT_AFIRMACIONES_EVALUACION', 'CAT_AFIRMACIONES_EVALUACION.PK_AFIRMACIONES_EVALUACION', '=', 'TR_EVALUACION_SATISFACCION.FK_AFIRMACION')
            ->where([['TR_EVALUACION_SATISFACCION.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allEvaluacionPeriodo(Request $request){
        $materia = DB::table('TR_EVALUACION_SATISFACCION')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'TR_EVALUACION_SATISFACCION.RESPUESTA','TR_EVALUACION_SATISFACCION.MATERIA','TR_EVALUACION_SATISFACCION.SESIONES',
            'TR_EVALUACION_SATISFACCION.SUGERENCIA','TR_EVALUACION_SATISFACCION.PERIODO','a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea',
            'CAT_AFIRMACIONES_EVALUACION.NOMBRE')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'TR_EVALUACION_SATISFACCION.FK_USER')
            ->join('users as a', 'a.PK_USUARIO', '=', 'TR_EVALUACION_SATISFACCION.FK_ASESOR')
            ->join('CAT_AFIRMACIONES_EVALUACION', 'CAT_AFIRMACIONES_EVALUACION.PK_AFIRMACIONES_EVALUACION', '=', 'TR_EVALUACION_SATISFACCION.FK_AFIRMACION')
            ->where([['TR_EVALUACION_SATISFACCION.PERIODO',$request->periodo3]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCalificacion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_CALIFICACION_PARCIAL')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_CALIFICACION_PARCIAL.MATERIA','CATR_CALIFICACION_PARCIAL.AULA','CATR_CALIFICACION_PARCIAL.DIA',
            'CATR_CALIFICACION_PARCIAL.HORA','CATR_CALIFICACION_PARCIAL.UNIDAD','CATR_CALIFICACION_PARCIAL.CALIFICACION',
            'CATR_CALIFICACION_PARCIAL.OBSERVACIONES','CATR_CALIFICACION_PARCIAL.PERIODO'
            ,'a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_CALIFICACION_PARCIAL.FK_USUARIO')
            ->join('users as a', 'a.PK_USUARIO', '=', 'CATR_CALIFICACION_PARCIAL.FK_ASESOR')
            ->where([['CATR_CALIFICACION_PARCIAL.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allCalificacionPeriodo(Request $request){
        $materia = DB::table('CATR_CALIFICACION_PARCIAL')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_CALIFICACION_PARCIAL.MATERIA','CATR_CALIFICACION_PARCIAL.AULA','CATR_CALIFICACION_PARCIAL.DIA',
            'CATR_CALIFICACION_PARCIAL.HORA','CATR_CALIFICACION_PARCIAL.UNIDAD','CATR_CALIFICACION_PARCIAL.CALIFICACION',
            'CATR_CALIFICACION_PARCIAL.OBSERVACIONES','CATR_CALIFICACION_PARCIAL.PERIODO'
            ,'a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_CALIFICACION_PARCIAL.FK_USUARIO')
            ->join('users as a', 'a.PK_USUARIO', '=', 'CATR_CALIFICACION_PARCIAL.FK_ASESOR')
            ->where([['CATR_CALIFICACION_PARCIAL.PERIODO',$request->periodo4]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allReporteSesion(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_REPORTE_DE_SESIONES')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_REPORTE_DE_SESIONES.MATERIA','CATR_REPORTE_DE_SESIONES.SESION','CATR_REPORTE_DE_SESIONES.FECHA',
            'CATR_REPORTE_DE_SESIONES.ASISTENTES','CATR_REPORTE_DE_SESIONES.HORAINICIO','CATR_REPORTE_DE_SESIONES.HORAFINAL',
            'CATR_REPORTE_DE_SESIONES.TEMA','CATR_REPORTE_DE_SESIONES.ACTIVIDADES_OBSERVACIONES','CATR_REPORTE_DE_SESIONES.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_REPORTE_DE_SESIONES.FK_ASESOR')
            ->where([['CATR_REPORTE_DE_SESIONES.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allReporteSesionPeriodo(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_REPORTE_DE_SESIONES')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_REPORTE_DE_SESIONES.MATERIA','CATR_REPORTE_DE_SESIONES.SESION','CATR_REPORTE_DE_SESIONES.FECHA',
            'CATR_REPORTE_DE_SESIONES.ASISTENTES','CATR_REPORTE_DE_SESIONES.HORAINICIO','CATR_REPORTE_DE_SESIONES.HORAFINAL',
            'CATR_REPORTE_DE_SESIONES.TEMA','CATR_REPORTE_DE_SESIONES.ACTIVIDADES_OBSERVACIONES','CATR_REPORTE_DE_SESIONES.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_REPORTE_DE_SESIONES.FK_ASESOR')
            ->where([['CATR_REPORTE_DE_SESIONES.PERIODO',$request->periodo5]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allAsistencia(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_LISTA_DE_ASISTENCIA')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_LISTA_DE_ASISTENCIA.FECHA','CATR_LISTA_DE_ASISTENCIA.ASISTIO','CATR_LISTA_DE_ASISTENCIA.PERIODO',
            'a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_LISTA_DE_ASISTENCIA.FK_ASESOR')
            ->join('users as a', 'a.PK_USUARIO', '=', 'CATR_LISTA_DE_ASISTENCIA.FK_USER')
            ->where([['CATR_LISTA_DE_ASISTENCIA.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allAsistenciaPeriodo(Request $request){
        $materia = DB::table('CATR_LISTA_DE_ASISTENCIA')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_LISTA_DE_ASISTENCIA.FECHA','CATR_LISTA_DE_ASISTENCIA.ASISTIO','CATR_LISTA_DE_ASISTENCIA.PERIODO',
            'a.PRIMER_APELLIDO as apellidop','a.SEGUNDO_APELLIDO as apellidom','a.name as namea')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_LISTA_DE_ASISTENCIA.FK_ASESOR')
            ->join('users as a', 'a.PK_USUARIO', '=', 'CATR_LISTA_DE_ASISTENCIA.FK_USER')
            ->where([['CATR_LISTA_DE_ASISTENCIA.PERIODO',$request->periodo6]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allReporteFinal(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_REPORTE_FINAL')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_REPORTE_FINAL.MATERIA','CATR_REPORTE_FINAL.FECHA_ENTREGA','CATR_REPORTE_FINAL.FECHA_INICIO',
            'CATR_REPORTE_FINAL.FECHA_FIN','CATR_REPORTE_FINAL.LUGAR','CATR_REPORTE_FINAL.ASESORADOS',
            'CATR_REPORTE_FINAL.SESIONES','CATR_REPORTE_FINAL.SUGERENCIAS','CATR_REPORTE_FINAL.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->where([['CATR_REPORTE_FINAL.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allReporteFinalPeriodo(Request $request){
        $materia = DB::table('CATR_REPORTE_FINAL')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','u.CLAVE_CARRERA',
            'CATR_REPORTE_FINAL.MATERIA','CATR_REPORTE_FINAL.FECHA_ENTREGA','CATR_REPORTE_FINAL.FECHA_INICIO',
            'CATR_REPORTE_FINAL.FECHA_FIN','CATR_REPORTE_FINAL.LUGAR','CATR_REPORTE_FINAL.ASESORADOS',
            'CATR_REPORTE_FINAL.SESIONES','CATR_REPORTE_FINAL.SUGERENCIAS','CATR_REPORTE_FINAL.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_REPORTE_FINAL.FK_ASESOR')
            ->where([['CATR_REPORTE_FINAL.PERIODO',$request->periodo7]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allSituacionAcademica(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_ASESORIA_ACEPTADA_SITUACION')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name',
            'CATR_ASESORIA_ACEPTADA_SITUACION.CONTROL_ALUMNO','CATR_ASESORIA_ACEPTADA_SITUACION.MATERIA','CATR_ASESORIA_ACEPTADA_SITUACION.DIA',
            'CATR_ASESORIA_ACEPTADA_SITUACION.HORA','CATR_ASESORIA_ACEPTADA_SITUACION.CAMPUS','CATR_ASESORIA_ACEPTADA_SITUACION.ESPACIO',
            'CATR_ASESORIA_ACEPTADA_SITUACION.VALIDA','CATR_ASESORIA_ACEPTADA_SITUACION.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA_SITUACION.FK_ASESOR')
            ->where([['CATR_ASESORIA_ACEPTADA_SITUACION.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function allSituacionAcademicaPeriodo(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA_SITUACION')
            ->select('u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name',
            'CATR_ASESORIA_ACEPTADA_SITUACION.CONTROL_ALUMNO','CATR_ASESORIA_ACEPTADA_SITUACION.MATERIA','CATR_ASESORIA_ACEPTADA_SITUACION.DIA',
            'CATR_ASESORIA_ACEPTADA_SITUACION.HORA','CATR_ASESORIA_ACEPTADA_SITUACION.CAMPUS','CATR_ASESORIA_ACEPTADA_SITUACION.ESPACIO',
            'CATR_ASESORIA_ACEPTADA_SITUACION.VALIDA','CATR_ASESORIA_ACEPTADA_SITUACION.PERIODO')
            ->distinct()
            ->join('users as u', 'u.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA_SITUACION.FK_ASESOR')
            ->where([['CATR_ASESORIA_ACEPTADA_SITUACION.PERIODO',$request->periodo2]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function AsesoresListal(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_ASESORIA_ACEPTADA.MATERIA',
            'CATR_ASESORIA_ACEPTADA.DIA','CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.CAMPUS','CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->join('CATR_ASESOR_ASESORIA_HORARIO', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->where([['CATR_ASESORIA_ACEPTADA.PERIODO',$periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function AsesoresListalPeriodo(Request $request){
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','users.NUMERO_CONTROL','users.CLAVE_CARRERA','CATR_ASESORIA_ACEPTADA.MATERIA',
            'CATR_ASESORIA_ACEPTADA.DIA','CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.CAMPUS','CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.PERIODO')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->join('CATR_ASESOR_ASESORIA_HORARIO', 'CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->where([['CATR_ASESORIA_ACEPTADA.PERIODO',$request->periodo]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function sesionPorAsesor(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_REPORTE_DE_SESIONES')
            ->select('CATR_REPORTE_DE_SESIONES.MATERIA',
            'CATR_REPORTE_DE_SESIONES.SESION','CATR_REPORTE_DE_SESIONES.FECHA','CATR_REPORTE_DE_SESIONES.ASISTENTES','CATR_REPORTE_DE_SESIONES.HORAINICIO','CATR_REPORTE_DE_SESIONES.HORAFINAL',
            'CATR_REPORTE_DE_SESIONES.TEMA','CATR_REPORTE_DE_SESIONES.ACTIVIDADES_OBSERVACIONES')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_REPORTE_DE_SESIONES.FK_ASESOR')
            ->where([['CATR_REPORTE_DE_SESIONES.PERIODO',$periodo],
                    ['CATR_REPORTE_DE_SESIONES.FK_ASESOR',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function correosAlumnos(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.email')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ALUMNO')
            ->where([['CATR_ASESORIA_ACEPTADA.PERIODO',$periodo],
                    ['CATR_ASESORIA_ACEPTADA.FK_ASESOR',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function listaAlumnos(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('CATR_ASESORIA_ACEPTADA.MATERIA','CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.DIA'
            ,'CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.PERIODO',
            'users.NUMERO_CONTROL','users.name','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.email','users.CLAVE_CARRERA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ALUMNO')
            ->where([['CATR_ASESORIA_ACEPTADA.PERIODO',$periodo],
                    ['CATR_ASESORIA_ACEPTADA.FK_ASESOR',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }

    public function correoAsesor(Request $request){
        $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        if($month <=6){
            $month = 1;       
        }
        if($month > 7){
            $month = 2;
        }
        $periodo = $year.$month;
        $materia = DB::table('CATR_ASESORIA_ACEPTADA')
            ->select('users.email','CATR_ASESORIA_ACEPTADA.MATERIA','CATR_ASESORIA_ACEPTADA.ESPACIO','CATR_ASESORIA_ACEPTADA.DIA'
            ,'CATR_ASESORIA_ACEPTADA.HORA','CATR_ASESORIA_ACEPTADA.PERIODO',
            'users.NUMERO_CONTROL','users.name','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.email','users.CLAVE_CARRERA')
            ->distinct()
            ->join('users', 'users.PK_USUARIO', '=', 'CATR_ASESORIA_ACEPTADA.FK_ASESOR')
            ->where([['CATR_ASESORIA_ACEPTADA.PERIODO',$periodo],
                    ['CATR_ASESORIA_ACEPTADA.FK_ALUMNO',$request->id]])
            ->get();
        if($materia){
            return $materia;
        }else{
           return $this->failedResponse();
        }
       
    }
    /*    [PK_ASESORIA_ACEPTADA]
      ,[FK_ASESOR]
      ,[FK_ALUMNO]
      ,[MATERIA]
      ,[DIA]
      ,[HORA]
      ,[PERIODO]
      ,[CAMPUS]
      ,[ESPACIO]
      ,[FECHA_REGISTRO]
      ,[STATUS]
      ,[VALIDA]
  FROM [SWIITL].[dbo].[CATR_ASESORIA_ACEPTADA]*/

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Numero de control no encontrado o estado de alumno no valido'
        ], Response::HTTP_NOT_FOUND);
    }
}
