<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aspirante;
use App\User;
use App\Rol_Usuario;
use App\Generar_Preficha;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\AspirantePasswordMail;
use App\Mail\CorreoAspirantesMail;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;
use PHPExcel;
use PHPExcel_IOFactory;

class AspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return redirect()->action('UserController@profile', [1]);
        //return redirect()->action('AspirantePasswordController@sendEmail', ['email' => $request->email]); 
        $pdo = DB::connection('sqlsrv')->select('EXEC GENERAR_PREFICHA ' . $request->PK_PERIODO . ', '
            . $request->name . ', '
            . $request->PRIMER_APELLIDO . ', '
            . $request->SEGUNDO_APELLIDO . ', '
            . $request->FECHA_NACIMIENTO . ', '
            . $request->SEXO . ', '
            . $request->CURP . ', '
            . $request->FK_ESTADO_CIVIL . ', '
            . $request->CALLE . ', '
            . $request->NUMERO_EXTERIOR . ', '
            . $request->NUMERO_INTERIOR . ', '
            . $request->FK_COLONIA . ', '
            . $request->TELEFONO_CASA . ', '
            . $request->TELEFONO_MOVIL . ', '
            . $request->email . ', '
            . $request->PADRE_TUTOR . ', '
            . $request->MADRE . ', '
            . $request->FK_BACHILLERATO . ', '
            . $request->ESPECIALIDAD . ', '
            . $request->PROMEDIO . ', '
            . $request->NACIONALIDAD . ', '
            . $request->FK_CIUDAD . ', '
            . $request->FK_CARRERA_1 . ', '
            . $request->FK_CARRERA_2 . ', '
            . $request->FK_PROPAGANDA_TECNOLOGICO . ', '
            . $request->FK_UNIVERSIDAD . ', '
            . $request->FK_CARRERA_UNIVERSIDAD . ', '
            . $request->FK_DEPENDENCIA . ', '
            . $request->TRABAJAS_Y_ESTUDIAS . ', '
            . $request->AYUDA_INCAPACIDAD);
        //$pdo = DB::connection('sqlsrv')->select('EXEC GENERAR_PREFICHA 83, Fabricio2, "de la cruz", null, "2019-04-17", 2, 111111111111181127, 2, "lago erie", 117, null, 4, 47728430, null, "142405a70@itleon.edu.mx", "Cruz", null, 4, "Fisico", 10.0, "Africa", null, 2, null, 9, 3, 5, 3, 1, null');

        //return json_encode($pdo[0]->RESPUESTA);

        if (isset($pdo[0]->RESPUESTA)) {
            if ($pdo[0]->RESPUESTA == 3 || $pdo[0]->RESPUESTA == 5) {
                $this->sendEmail(str_replace("'","",$request->email));
                /* $find = array("[","]","\""," ");
                $discapacidades = explode(",", str_replace($find,"",$request->DISCAPASIDADES)); */
                $discapacidades = explode(",", $request->DISCAPASIDADES);

                foreach ($discapacidades as $key => $value) {
                    if (empty($value)) {
                        unset($discapacidades[$key]);
                    }
                }
                if (!empty($discapacidades)) {
                    $datos = null;
                    foreach ($discapacidades as &$valor) {
                        DB::connection('sqlsrv')->select('EXEC INSERTAR_INCAPACIDAD ' . $request->CURP . ', ' . $valor);
                        $datos = $datos . $valor;
                    }
                    return $pdo[0]->RESPUESTA;
                } else {
                    return $pdo[0]->RESPUESTA;
                    //return "No tiene discapacidades";
                }
            }
            return $pdo[0]->RESPUESTA;
        }

        /*

        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'SenderUserName';
        $objDemo->receiver = 'ReceiverUserName';

        Mail::to("eddychavezba@gmail.com")->send(new DemoEmail($objDemo));
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fk_aspirante = Aspirante::where('FK_PADRE', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('users')
            ->select(
                DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CATR_ASPIRANTE.FECHA_REGISTRO',
                'CATR_ASPIRANTE.NUMERO_PREFICHA',
                'CATR_ASPIRANTE.FK_ESTATUS',
                'CAT_ESTATUS_ASPIRANTE.NOMBRE as NOMBRE_ESTATUS',
                'CATR_ASPIRANTE.FOLIO_CENEVAL',
                'users.name',
                'users.PRIMER_APELLIDO',
                DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'users.FECHA_NACIMIENTO',
                'users.SEXO',
                'users.CURP',
                'CAT_ESTADO_CIVIL.NOMBRE as NOMBRE_ESTADO_CIVIL',
                'users.CALLE',
                'TR_COLONIA_CODIGO_POSTAL.FK_NUMERO_CODIGO_POSTAL',
                'users.TELEFONO_CASA',
                'users.TELEFONO_MOVIL',
                'users.email',
                'CATR_CIUDAD.NOMBRE as NOMBRE_CIUDAD',
                'CATR_ASPIRANTE.PROMEDIO',
                'CATR_ASPIRANTE.ESPECIALIDAD',
                'CATR_ASPIRANTE.FK_CARRERA_1',
                'CATR_ASPIRANTE.FK_CARRERA_2'
            )
            ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
            ->join('CAT_ESTADO_CIVIL', 'CAT_ESTADO_CIVIL.PK_ESTADO_CIVIL', '=', 'users.FK_ESTADO_CIVIL')
            ->join('TR_COLONIA_CODIGO_POSTAL', 'TR_COLONIA_CODIGO_POSTAL.FK_COLONIA', '=', 'users.FK_COLONIA')
            ->join('CATR_CODIGO_POSTAL', 'CATR_CODIGO_POSTAL.PK_NUMERO_CODIGO_POSTAL', '=', 'TR_COLONIA_CODIGO_POSTAL.FK_NUMERO_CODIGO_POSTAL')
            ->join('CATR_CIUDAD', 'CATR_CIUDAD.PK_CIUDAD', '=', 'CATR_CODIGO_POSTAL.FK_CIUDAD')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CATR_ASPIRANTE.FK_ESTATUS')
            ->where([
                ['users.PK_USUARIO', '=', $id],
                ['CATR_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        return $aspirante;
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

    public function aspirantes($PK_PERIODO)
    {
        $aspirantes = DB::table('CATR_ASPIRANTE')
            ->select(
                'users.PK_USUARIO',
                DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CATR_ASPIRANTE.NUMERO_PREFICHA',
                'users.CURP',
                'users.name as NOMBRE',
                'users.PRIMER_APELLIDO',
                DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'users.email as CORREO',
                'users.TELEFONO_CASA',
                DB::raw("CASE WHEN users.TELEFONO_MOVIL IS NULL THEN '' ELSE users.TELEFONO_MOVIL END as TELEFONO_MOVIL"),
                'CATR_CARRERA1.NOMBRE as CARRERA1',
                DB::raw("CASE WHEN CATR_CARRERA2.NOMBRE IS NULL THEN '' ELSE CATR_CARRERA2.NOMBRE END as CARRERA2"),
                'CAT_ESTATUS_ASPIRANTE.NOMBRE as ESTATUS',
                'CATR_ASPIRANTE.FECHA_REGISTRO'
            )
            ->join('users', 'users.PK_USUARIO', '=',  'CATR_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CATR_ASPIRANTE.FK_ESTATUS')
            ->join(DB::raw('CATR_CARRERA CATR_CARRERA1'), 'CATR_CARRERA1.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
            ->leftJoin(DB::raw('CATR_CARRERA CATR_CARRERA2'), 'CATR_CARRERA2.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_2')
            ->where('FK_PERIODO', $PK_PERIODO)
            ->get();

        return $aspirantes;
    }

    public function estatusAspirante()
    {
        $estatus = DB::table('CAT_ESTATUS_ASPIRANTE')
            ->select('PK_ESTATUS_ASPIRANTE', 'NOMBRE')
            ->get();
        return $estatus;
    }

    public function graficaEstatus($PK_PERIODO)
    {

        /*         $estatus = DB::table('CATR_ASPIRANTE')
        ->select('CAT_ESTATUS_ASPIRANTE.NOMBRE', DB::raw('COUNT(CATR_ASPIRANTE.FK_ESTATUS)AS CANTIDAD'))
        ->join('CAT_ESTATUS_ASPIRANTE','CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE','=','CATR_ASPIRANTE.FK_ESTATUS')
        ->where('CATR_ASPIRANTE.FK_PERIODO',$PK_PERIODO)
        ->groupBy('CAT_ESTATUS_ASPIRANTE.NOMBRE ')
        ->get(); */

        $estatus = DB::table('CAT_ESTATUS_ASPIRANTE')
            ->select('CAT_ESTATUS_ASPIRANTE.NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'))
            ->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
            ->get();

        return $estatus;
    }

    public function graficaCarreras($PK_PERIODO)
    {
        $carreras = DB::table('CATR_CARRERA')
            ->select('CATR_CARRERA.NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'))
            ->leftJoin(DB::raw('(SELECT FK_CARRERA_1, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_CARRERA_1) x'), 'x.FK_CARRERA_1', '=', 'CATR_CARRERA.PK_CARRERA')
            ->get();
        return $carreras;
    }

    public function graficaCampus($PK_PERIODO)
    {
        $campus = DB::table('CATR_CARRERA')
            ->select('CATR_CARRERA.CAMPUS as NOMBRE', DB::raw('CANTIDAD = SUM(ISNULL(CANTIDAD,0))'))
            ->leftJoin(DB::raw('(SELECT FK_CARRERA_1, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_CARRERA_1) x'), 'x.FK_CARRERA_1', '=', 'CATR_CARRERA.PK_CARRERA')
            ->groupBy('CATR_CARRERA.CAMPUS')
            ->get();
        return $campus;
    }
    public function cargarArchivoBanco(Request $request, $PK_PERIODO)
    {
        $File = $request->file('myfile'); //line 1   
        $res = $this->leerPagos($File, $PK_PERIODO);
        if ($res == 1) {
            $sub_path = 'files'; //line 2
            $real_name = $File->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $File->move($destination_path,  $real_name);  //line 5 
            return response()->json('Se registro correctamente');
        } else if ($res == 2) {
            return response()->json('El archivo no es el correcto');
        }
    }

    private function leerPagos($File, $PK_PERIODO)
    {
        $real_name = $File->getClientOriginalName();
        $contenido = file($File);
        $datos = array();
        if ($contenido != '') {
            foreach ($contenido as $fila) {
                //return substr($fila,0,7);            
                //array_push($datos, $fila);
                if (is_numeric(substr($fila, 0, 7)) &&  substr($fila, 0, 7) != "" && substr($fila, 0, 7) == 1369296 && substr($fila, 37, 5) == '03319') {
                    array_push($datos, [
                        'CLAVE' => substr($fila, 0, 7),
                        'REFERENCIA_BANCO' => substr($fila, 37, 20),
                        'IDCONTROL' => substr($fila, 42, 4),
                        'MONTO' => substr($fila, 114, 4),
                        'TIPO_PAGO' => substr($fila, 164, 3),
                        'FECHA_PAGO' => substr($fila, 130, 10),
                        'FECHA_LIMITE' => substr($fila, 140, 10)
                    ]);
                }
            }
            if ($this->guardarDatosBD($datos, $PK_PERIODO, $real_name) == 1) {
                return 1;
            } else {
                return 2;
            }
            //return $datos;
        }
    }
    private function guardarDatosBD($datos, $PK_PERIODO, $real_name)
    {

        if ($datos) {
            foreach ($datos as $dato) {

                $PK_USUARIO = DB::table('CATR_ASPIRANTE')
                    ->where([
                        ['FK_PERIODO', '=', $PK_PERIODO],
                        ['NUMERO_PREFICHA', '=', $dato['IDCONTROL']],
                        ['FK_ESTATUS', '=', 1]
                    ])
                    ->max('FK_PADRE');

                if ($PK_USUARIO) {

                    DB::table('CATR_REFERENCIA_BANCARIA_USUARIO')->insert(
                        [
                            'FK_USUARIO' => $PK_USUARIO,
                            'REFERENCIA_BANCO' => $dato['REFERENCIA_BANCO'],
                            'MONTO' => $dato['MONTO'],
                            'CONCEPTO' => "Ficha para examen de admisión",
                            'CANTIDAD' => 1,
                            'TIPO_PAGO' => $dato['TIPO_PAGO'],
                            'FECHA_PAGO' => $dato['FECHA_PAGO'],
                            'FECHA_LIMIE' => $dato['FECHA_LIMITE'],
                            'ARCHIVO_REGISTRO' => $real_name
                        ]
                    );

                    DB::table('CATR_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['NUMERO_PREFICHA', '=', $dato['IDCONTROL']],
                            ['FK_ESTATUS', '=', 1]
                        ])
                        ->update(['FK_ESTATUS' => 2]);
                }
            }
            return 1;
        }
    }

    public function aspirantes2(Request $request)
    {
        $aspirantes = DB::table('CATR_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CATR_ASPIRANTE.FECHA_REGISTRO',
                'users.name as NOMBRE',
                'users.PRIMER_APELLIDO',
                DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'users.email as CORREO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.REFERENCIA_BANCO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.TIPO_PAGO'
            )
            ->join('users', 'users.PK_USUARIO', '=',  'CATR_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CATR_ASPIRANTE.FK_ESTATUS')
            ->join(DB::raw('CATR_CARRERA CATR_CARRERA1'), 'CATR_CARRERA1.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
            ->join('CATR_REFERENCIA_BANCARIA_USUARIO', 'CATR_REFERENCIA_BANCARIA_USUARIO.FK_USUARIO', '=',  'users.PK_USUARIO')
            ->leftJoin(DB::raw('CATR_CARRERA CATR_CARRERA2'), 'CATR_CARRERA2.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_2')
            ->where([
                ['FK_PERIODO', '=', $request->PK_PERIODO],
                ['FK_ESTATUS', '=', 2]
            ])
            ->whereBetween('CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO', [$request->FECHA_INICIO, $request->FECHA_FIN])
            ->get();

        return $aspirantes;
    }

    public function aspirantes3($PK_PERIODO)
    {
        $aspirantes = DB::table('CATR_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'users.name as NOMBRE',
                'users.PRIMER_APELLIDO',
                DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                DB::raw('100342 as CLAVE_INSTITUCION'),
                DB::raw('4576 as CLAVE_SEDE'),
                'users.FECHA_NACIMIENTO',
                'users.email as CORREO',
                'CATR_CARRERA.CLAVE_CARRERA'
            )
            ->join('users', 'users.PK_USUARIO', '=',  'CATR_ASPIRANTE.FK_PADRE')
            ->join('CATR_CARRERA', 'CATR_CARRERA.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
            ->where([
                ['FK_PERIODO', '=', $PK_PERIODO],
                ['FK_ESTATUS', '=', 2]
            ])
            ->get();

        return $aspirantes;
    }
    public function cargarArchivoPreRegistroCENEVAL(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $file = $request->file('myfile');
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file)->getSheet(2);

            for ($row = 2; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("B" . $row)->getValue();
                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CATR_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha],
                            ['FK_ESTATUS', '=', 2]
                        ])
                        ->update(['FK_ESTATUS' => 3]);
                } else {
                    break;
                }
            }
            $sub_path = 'files'; //line 2
            $real_name = $file->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $file->move($destination_path,  $real_name);  //line 5 
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }
    public function cargarArchivoRegistroCENEVAL(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $file = $request->file('myfile');
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file)->getSheet(1);


            for ($row = 4; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("F" . $row)->getValue();
                $folioCeneval = $objPHPExcel->getCell("G" . $row)->getValue();

                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    $aspirante = DB::table('CATR_ASPIRANTE')
                        ->select('PREFICHA')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha],
                            ['FK_ESTATUS', '=', 3]
                        ])
                        ->get();
                    if (isset($aspirante[0])){
                    DB::table('CATR_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha],
                            ['FK_ESTATUS', '=', 3]
                        ])
                        ->update([
                            'FOLIO_CENEVAL' => $folioCeneval,
                            'FK_ESTATUS' => 4,
                            'FK_EXAMEN_ADMISION' => $this->asignaExamen()
                        ]);
                }
                } else {
                    break;
                }
            }
            $sub_path = 'files'; //line 2
            $real_name = $file->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $file->move($destination_path,  $real_name);  //line 5 
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }
    private function asignaExamen()
    {
        $bool = false;

        $modelExamen = DB::table('CATR_EXAMEN_ADMISION')
            ->select(
                'FK_ESPACIO'
            )
            ->get();
        //$modelExamen = AExamenAdmision::model()->findAll();
        //$modelTurno = ATurno::model()->findAll();
        $modelTurno = DB::table('CAT_TURNO')
            ->select(
                'PK_TURNO',
                'DIA',
                'HORA'
            )
            ->get();

        $diasSemanaTotal = [];
        $turnosTotal = [];
        $espaciosTotal = [];

        foreach ($modelExamen as $exam) {
            array_push($espaciosTotal, $exam->FK_ESPACIO);
        }

        foreach ($modelTurno as $model) {
            array_push($diasSemanaTotal, $model->DIA);
            array_push($turnosTotal, $model->HORA);
        }

        $turnos = array_unique($turnosTotal);
        $diasSemana = array_unique($diasSemanaTotal);
        $espacios = array_unique($espaciosTotal);

        //Insertar por orden de espacio
/*         foreach ($espacios as $espacio) {
            if (!$bool) {
                foreach ($diasSemana as $dia) {
                    if (!$bool) {
                        foreach ($turnos as $turno) { */

        //Insertar por orden dias                    
        foreach ($diasSemana as $dia) {
            if (!$bool) {
                foreach ($turnos as $turno) {
                    if (!$bool) {
                        foreach ($espacios as $espacio) {
                            if (!$bool) {
                                //$espacioAplicacion = AEspacio::model()->findByAttributes(array('pk_espacio' => $espacio));                              
                                $espacioAplicacion = DB::table('CATR_ESPACIO')
                                    ->select(
                                        'PK_ESPACIO',
                                        'CAPACIDAD'
                                    )
                                    ->where('PK_ESPACIO', $espacio)
                                    ->get();

                                $capacidad = $espacioAplicacion[0]->CAPACIDAD;

                                $modelTurnoDia = DB::table('CAT_TURNO')
                                    ->select(
                                        'PK_TURNO'
                                    )
                                    ->where([
                                        ['DIA', '=', $dia],
                                        ['HORA', '=', $turno]
                                    ])
                                    ->get();

                                if (isset($modelTurnoDia[0])) {
                                    $examen = DB::table('CATR_EXAMEN_ADMISION')
                                        ->select(
                                            'PK_EXAMEN_ADMISION',
                                            'LUGARES_OCUPADOS'
                                        )
                                        ->where([
                                            ['FK_ESPACIO', '=', $espacioAplicacion[0]->PK_ESPACIO],
                                            ['FK_TURNO', '=', $modelTurnoDia[0]->PK_TURNO]
                                        ])
                                        ->get();
                                    if (isset ($examen[0])) {
                                        $ocupados = $examen[0]->LUGARES_OCUPADOS;
                                        if ($capacidad > $ocupados) {
                                            //return $espacioAplicacion[0]->PK_ESPACIO." ".$modelTurnoDia[0]->PK_TURNO;
                                            DB::table('CATR_EXAMEN_ADMISION')
                                                ->where([
                                                    ['FK_ESPACIO', '=', $espacioAplicacion[0]->PK_ESPACIO],
                                                    ['FK_TURNO', '=', $modelTurnoDia[0]->PK_TURNO]
                                                ])
                                                ->update(
                                                    ['LUGARES_OCUPADOS' => $examen[0]->LUGARES_OCUPADOS + 1]
                                                );
                                            //$examen[0]->LUGARES_OCUPADOS = $examen[0]->LUGARES_OCUPADOS+1;
                                            //$examen[0]->saveAttributes(array('lugares_ocupados'));
                                            $bool = true;
                                            return $examen[0]->PK_EXAMEN_ADMISION;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function cargarArchivoAceptados(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $file = $request->file('myfile');
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file)->getSheet(0);

            for ($row = 2; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("I" . $row)->getValue();
                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CATR_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha]//,
                            //['FK_ESTATUS', '=', 4]
                        ])
                        ->update(['FK_ESTATUS' => 5]);
                } else {
                    break;
                }
            }
            $sub_path = 'files'; //line 2
            $real_name = $file->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $file->move($destination_path,  $real_name);  //line 5 
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }

    public function sendEmail($email)
    {
        if (!$this->validateEmail($email)) {
            return $this->failedResponse();
        }
        $this->send($email);
        return $this->successResponse();
    }
    public function send($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new AspirantePasswordMail($token, $email));
    }
    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();
        if ($oldToken) {
            return $oldToken->token;
        }
        $token = str_random(60);
        $this->saveToken($token, $email);
        return $token;
    }
    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }
    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse()
    {
        return response()->json([
            'data' => 'Reset Email is send successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }

    public function modificarAspirante(Request $request)
    {


        $fk_padre = DB::table('users')
            ->where('CURP', $request->CURP)
            ->max('PK_USUARIO');

        $fk_aspirante = DB::table('CATR_ASPIRANTE')
            ->where('FK_PADRE', $fk_padre)
            ->max('PK_ASPIRANTE');

        DB::table('CATR_ASPIRANTE')
            ->where([
                ['FK_PADRE', '=', $fk_padre],
                ['PK_ASPIRANTE', '=', $fk_aspirante]
            ])
            ->update([
                'FK_CARRERA_1' => $request->FK_CARRERA_1,
                'FK_CARRERA_2' => $request->FK_CARRERA_2
            ]);

        DB::table('users')
            ->where('CURP', $request->CURP)
            ->update([
                'TELEFONO_CASA' => $request->TELEFONO_CASA,
                'TELEFONO_MOVIL' => $request->TELEFONO_MOVIL,
                'email' => $request->email
            ]);




        return response()->json('Se modifico correctamente');
    }
    public function enviarCorreos(Request $request)
    {
        Mail::to($request->CORREOS)->send(new CorreoAspirantesMail($request->MENSAJE, $request->ASUNTO));
    }
}
