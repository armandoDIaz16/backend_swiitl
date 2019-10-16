<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

use App\User;
use App\ObtenerContrasenia;
use App\Models\General\Sistema;

use App\Helpers\Mailer;
use App\Helpers\UsuariosHelper;

use App\Aspirante;
use App\Helpers\Base64ToFile;
use App\Helpers\EncriptarUsuario;
use App\Helpers\ObtenerCorreo;
use App\Mail\AspirantePasswordMail;
use App\Mail\CorreoAspirantesMail;
use App\Periodo;
use Carbon\Carbon;




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
        //return redirect()->action('AspirantePasswordController@sendEmail', ['CORREO1' => $request->CORREO1]);



        $sql = "EXEC GENERAR_PREFICHA 
            $request->PK_PERIODO,
            $request->NOMBRE,
            $request->PRIMER_APELLIDO,
            $request->SEGUNDO_APELLIDO,
            $request->FECHA_NACIMIENTO,
            $request->SEXO,
            $request->CURP,
            $request->FK_ESTADO_CIVIL,
            $request->CALLE,
            $request->NUMERO_EXTERIOR,
            $request->NUMERO_INTERIOR,
            $request->CP,
            $request->FK_COLONIA,
            $request->TELEFONO_CASA,
            $request->TELEFONO_MOVIL,
            $request->CORREO1,
            $request->PADRE_TUTOR,
            $request->MADRE,
            $request->FK_BACHILLERATO,
            $request->ESPECIALIDAD,
            $request->PROMEDIO,
            $request->NACIONALIDAD,
            $request->FK_CIUDAD,
            $request->FK_CARRERA_1,
            $request->FK_CARRERA_2,
            $request->FK_PROPAGANDA_TECNOLOGICO,
            $request->FK_UNIVERSIDAD,
            $request->FK_CARRERA_UNIVERSIDAD,
            $request->FK_DEPENDENCIA,
            $request->TRABAJAS_Y_ESTUDIAS,
            $request->AYUDA_INCAPACIDAD
        ";


        $pdo = DB::select(DB::raw($sql));
        //$pdo->
        //$pdo = DB::connection('sqlsrv')->select('EXEC GENERAR_PREFICHA 83, Fabricio2, "de la cruz", null, "2019-04-17", 2, 111111111111181127, 2, "lago erie", 117, null, 4, 47728430, null, "142405a70@itleon.edu.mx", "Cruz", null, 4, "Fisico", 10.0, "Africa", null, 2, null, 9, 3, 5, 3, 1, null');

        //return json_encode($pdo[0]->RESPUESTA);

        if (isset($pdo[0]->RESPUESTA)) {
            if ($pdo[0]->RESPUESTA == 3 || $pdo[0]->RESPUESTA == 5) {
                $token = $this->get_datos_token($pdo[0]);
                if (!$this->notifica_usuario(
                    $pdo[0]->CORREO1,
                    $token->TOKEN,
                    $token->CLAVE_ACCESO
                )) {
                    error_log("Error al enviar correo al receptor en activación de cuenta: " . $pdo[0]->CORREO1);
                    error_log("AuthController.php");
                }

                //$this->sendEmail(str_replace("'","",$request->CORREO1));
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
                    return [
                        array('RESPUESTA'  => $pdo[0]->RESPUESTA)
                    ];
                } else {
                    return [array('RESPUESTA'  => $pdo[0]->RESPUESTA)];
                    //return "No tiene discapacidades";
                }
            }
            return [array('RESPUESTA'  => $pdo[0]->RESPUESTA)];
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
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_ASPIRANTE.FECHA_REGISTRO',
                'CAT_ASPIRANTE.NUMERO_PREFICHA',
                'CAT_ASPIRANTE.FK_ESTATUS',
                'CAT_ESTATUS_ASPIRANTE.NOMBRE as NOMBRE_ESTATUS',
                'CAT_ASPIRANTE.FOLIO_CENEVAL',
                'CAT_USUARIO.NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_USUARIO.FECHA_NACIMIENTO',
                'CAT_USUARIO.SEXO',
                'CAT_USUARIO.CURP',
                'CAT_ESTADO_CIVIL.NOMBRE as NOMBRE_ESTADO_CIVIL',
                'CAT_USUARIO.CALLE',
                'CAT_CODIGO_POSTAL.NUMERO',
                'CAT_USUARIO.TELEFONO_CASA',
                'CAT_USUARIO.TELEFONO_MOVIL',
                'CAT_USUARIO.CORREO1',
                'CAT_CIUDAD.NOMBRE as NOMBRE_CIUDAD',
                'CAT_ASPIRANTE.PROMEDIO',
                'CAT_ASPIRANTE.ESPECIALIDAD',
                'CAT_ASPIRANTE.FK_CARRERA_1',
                'CAT_ASPIRANTE.FK_CARRERA_2',
                DB::raw("CAT_CARRERA1.NOMBRE+' CAMPUS ' +CAT_CAMPUS1.NOMBRE as CARRERA1"),
                DB::raw("CASE WHEN CAT_CARRERA2.NOMBRE IS NULL THEN '' ELSE CAT_CARRERA2.NOMBRE+' CAMPUS ' +CAT_CAMPUS2.NOMBRE  END as CARRERA2"),
                'CAT_ASPIRANTE.ICNE',
                'CAT_ASPIRANTE.DDD_MG_MAT',
                //'CAT_ASPIRANTE.ASISTENCIA',
                'CAT_ASPIRANTE.ACEPTADO'
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->join('CAT_ESTADO_CIVIL', 'CAT_ESTADO_CIVIL.PK_ESTADO_CIVIL', '=', 'CAT_USUARIO.FK_ESTADO_CIVIL')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CAT_ASPIRANTE.FK_ESTATUS')

            ->leftjoin('CAT_CODIGO_POSTAL', 'CAT_CODIGO_POSTAL.PK_CODIGO_POSTAL', '=', 'CAT_USUARIO.FK_CODIGO_POSTAL')
            ->leftjoin('CAT_CIUDAD', 'CAT_CIUDAD.PK_CIUDAD', '=', 'CAT_CODIGO_POSTAL.FK_CIUDAD')

            ->join(DB::raw('TR_CARRERA_CAMPUS TR_CARRERA_CAMPUS1'), 'TR_CARRERA_CAMPUS1.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join(DB::raw('CAT_CAMPUS CAT_CAMPUS1'), 'CAT_CAMPUS1.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS1.FK_CAMPUS')
            ->join(DB::raw('CAT_CARRERA CAT_CARRERA1'), 'CAT_CARRERA1.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS1.FK_CARRERA')

            ->leftJoin(DB::raw('TR_CARRERA_CAMPUS TR_CARRERA_CAMPUS2'), 'TR_CARRERA_CAMPUS2.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_2')
            ->leftJoin(DB::raw('CAT_CAMPUS CAT_CAMPUS2'), 'CAT_CAMPUS2.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS2.FK_CAMPUS')
            ->leftJoin(DB::raw('CAT_CARRERA CAT_CARRERA2'), 'CAT_CARRERA2.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS2.FK_CARRERA')

            ->where([
                ['CAT_USUARIO.PK_USUARIO', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        if (isset($aspirante[0])) {
            return $aspirante;
        }
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
        /* $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                'CAT_USUARIO.PK_USUARIO',
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_ASPIRANTE.NUMERO_PREFICHA',
                'CAT_USUARIO.CURP',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_USUARIO.CORREO1 as CORREO',
                'CAT_USUARIO.TELEFONO_CASA',
                DB::raw("CASE WHEN CAT_USUARIO.TELEFONO_MOVIL IS NULL THEN '' ELSE CAT_USUARIO.TELEFONO_MOVIL END as TELEFONO_MOVIL"),
                'CAT_CARRERA1.NOMBRE as CARRERA1',
                DB::raw("CASE WHEN CAT_CARRERA2.NOMBRE IS NULL THEN '' ELSE CAT_CARRERA2.NOMBRE END as CARRERA2"),
                'CAT_ESTATUS_ASPIRANTE.NOMBRE as ESTATUS',
                'CAT_ASPIRANTE.FECHA_REGISTRO'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CAT_ASPIRANTE.FK_ESTATUS')
            ->join(DB::raw('CAT_CARRERA CAT_CARRERA1'), 'CAT_CARRERA1.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->leftJoin(DB::raw('CAT_CARRERA CAT_CARRERA2'), 'CAT_CARRERA2.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_2')
            ->where('FK_PERIODO', $PK_PERIODO)
            ->get(); */


        $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                'CAT_USUARIO.PK_USUARIO',
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_ASPIRANTE.NUMERO_PREFICHA',
                'CAT_USUARIO.CURP',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_USUARIO.CORREO1 as CORREO',
                'CAT_USUARIO.TELEFONO_CASA',
                DB::raw("CASE WHEN CAT_USUARIO.TELEFONO_MOVIL IS NULL THEN '' ELSE CAT_USUARIO.TELEFONO_MOVIL END as TELEFONO_MOVIL"),
                DB::raw("CAT_CARRERA1.NOMBRE+' CAMPUS ' +CAT_CAMPUS1.NOMBRE as CARRERA1"),
                DB::raw("CASE WHEN CAT_CARRERA2.NOMBRE IS NULL THEN '' ELSE CAT_CARRERA2.NOMBRE+' CAMPUS ' +CAT_CAMPUS2.NOMBRE  END as CARRERA2"),
                'CAT_ESTATUS_ASPIRANTE.NOMBRE as ESTATUS',
                'CAT_ASPIRANTE.FECHA_REGISTRO'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CAT_ASPIRANTE.FK_ESTATUS')

            ->join(DB::raw('TR_CARRERA_CAMPUS TR_CARRERA_CAMPUS1'), 'TR_CARRERA_CAMPUS1.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join(DB::raw('CAT_CAMPUS CAT_CAMPUS1'), 'CAT_CAMPUS1.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS1.FK_CAMPUS')
            ->join(DB::raw('CAT_CARRERA CAT_CARRERA1'), 'CAT_CARRERA1.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS1.FK_CARRERA')

            ->leftJoin(DB::raw('TR_CARRERA_CAMPUS TR_CARRERA_CAMPUS2'), 'TR_CARRERA_CAMPUS2.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_2')
            ->leftJoin(DB::raw('CAT_CAMPUS CAT_CAMPUS2'), 'CAT_CAMPUS2.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS2.FK_CAMPUS')
            ->leftJoin(DB::raw('CAT_CARRERA CAT_CARRERA2'), 'CAT_CARRERA2.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS2.FK_CARRERA')
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

        /*         $estatus = DB::table('CAT_ASPIRANTE')
        ->select('CAT_ESTATUS_ASPIRANTE.NOMBRE', DB::raw('COUNT(CAT_ASPIRANTE.FK_ESTATUS)AS CANTIDAD'))
        ->join('CAT_ESTATUS_ASPIRANTE','CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE','=','CAT_ASPIRANTE.FK_ESTATUS')
        ->where('CAT_ASPIRANTE.FK_PERIODO',$PK_PERIODO)
        ->groupBy('CAT_ESTATUS_ASPIRANTE.NOMBRE ')
        ->get(); */

        $estatus = DB::table('CAT_ESTATUS_ASPIRANTE')
            ->select('CAT_ESTATUS_ASPIRANTE.NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'))
            ->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CAT_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
            ->get();

        return $estatus;
    }

    public function graficaCarreras($PK_PERIODO)
    {
        $carreras = DB::table('TR_CARRERA_CAMPUS')
            ->select(DB::raw("CAT_CARRERA.NOMBRE + ' CAMPUS ' + CAT_CAMPUS.NOMBRE as NOMBRE, CANTIDAD = ISNULL(CANTIDAD,0)"))
            ->leftJoin(DB::raw('(SELECT FK_CARRERA_1, CANTIDAD = COUNT(* )  FROM CAT_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_CARRERA_1) x'), 'x.FK_CARRERA_1', '=', 'TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS')
            ->leftJoin('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS.FK_CAMPUS')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
            ->get();
        return $carreras;
    }

    public function graficaCampus($PK_PERIODO)
    {
        $campus = DB::table('TR_CARRERA_CAMPUS')
            ->select('CAT_CAMPUS.NOMBRE as NOMBRE', DB::raw('CANTIDAD = SUM(ISNULL(CANTIDAD,0))'))
            ->leftJoin(DB::raw('(SELECT FK_CARRERA_1, CANTIDAD = COUNT(* )  FROM CAT_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_CARRERA_1) x'), 'x.FK_CARRERA_1', '=', 'TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS')
            ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS.FK_CAMPUS')
            ->groupBy('CAT_CAMPUS.NOMBRE')
            ->get();
        return $campus;
    }

    public function cargarArchivoBanco(Request $request, $PK_PERIODO)
    {
        $archivo = new Base64ToFile();
        $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
        $res = $this->leerPagos($ruta, $PK_PERIODO, $request->Nombre . $request->Extencion);
        if ($res == 1) {
            return response()->json('Se registro correctamente');
        } else if ($res == 2) {
            return response()->json('El archivo no es el correcto');
        }
    }

    private function leerPagos($ruta, $PK_PERIODO, $nombre)
    {
        $File = fopen($ruta, "r");
        $datos = array();
        while (!feof($File)) {
            $fila = fgets($File);
            //return substr($fila,0,7);
            //array_push($datos, $fila);
            if (
                is_numeric(substr($fila, 0, 7)) &&  substr($fila, 0, 7) != "" && substr($fila, 0, 7) == 1369296 && substr($fila, 37, 5) == '03319' ||
                is_numeric(substr($fila, 0, 7)) &&  substr($fila, 0, 7) != "" && substr($fila, 0, 7) == 1369296 && substr($fila, 37, 5) == '03201'
            ) {
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
            //error_log(print_r(substr($fila, 42, 4),true));

            /* if (!$this->guardarDatosBD($datos, $PK_PERIODO, $nombre) == 1) {
                if (isset($datos['IDCONTROL'])) {
                    error_log("AspiranteController (399) ========================== Error al procesar el pago de preficha: " . $datos['IDCONTROL']);
                }
            } */
            //return $datos;
        }
        if ($this->guardarDatosBD($datos, $PK_PERIODO, $nombre)) {
            return 1;
        } else {
            return 2;
        }
    }

    private function guardarDatosBD($datos, $PK_PERIODO, $real_name)
    {

        if ($datos) {
            foreach ($datos as $dato) {

                $PK_USUARIO = DB::table('CAT_ASPIRANTE')
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

                    DB::table('CAT_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['NUMERO_PREFICHA', '=', $dato['IDCONTROL']],
                            ['FK_ESTATUS', '=', 1]
                        ])
                        ->update(['FK_ESTATUS' => 2]);
                }
            }
            return true;
        }
    }

    public function aspirantes2(Request $request)
    {
        /* $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_ASPIRANTE.FECHA_REGISTRO',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_USUARIO.CORREO1 as CORREO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.REFERENCIA_BANCO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.TIPO_PAGO'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CAT_ASPIRANTE.FK_ESTATUS')
            ->join(DB::raw('CAT_CARRERA CAT_CARRERA1'), 'CAT_CARRERA1.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join('CATR_REFERENCIA_BANCARIA_USUARIO', 'CATR_REFERENCIA_BANCARIA_USUARIO.FK_USUARIO', '=',  'CAT_USUARIO.PK_USUARIO')
            ->leftJoin(DB::raw('CAT_CARRERA CAT_CARRERA2'), 'CAT_CARRERA2.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_2')
            ->where([
                ['FK_PERIODO', '=', $request->PK_PERIODO],
                ['FK_ESTATUS', '=', 2]
            ])
            ->whereBetween('CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO', [$request->FECHA_INICIO, $request->FECHA_FIN])
            ->get(); */

        $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_ASPIRANTE.FECHA_REGISTRO',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_USUARIO.CORREO1 as CORREO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.REFERENCIA_BANCO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO',
                'CATR_REFERENCIA_BANCARIA_USUARIO.TIPO_PAGO'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('CAT_ESTATUS_ASPIRANTE', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE', '=', 'CAT_ASPIRANTE.FK_ESTATUS')
            ->join('CATR_REFERENCIA_BANCARIA_USUARIO', 'CATR_REFERENCIA_BANCARIA_USUARIO.FK_USUARIO', '=',  'CAT_USUARIO.PK_USUARIO')
            ->where([
                ['FK_PERIODO', '=', $request->PK_PERIODO] //,
                //['FK_ESTATUS', '=', 2]
            ])
            ->whereBetween('CATR_REFERENCIA_BANCARIA_USUARIO.FECHA_PAGO', [$request->FECHA_INICIO, $request->FECHA_FIN])
            ->get();

        return $aspirantes;
    }

    public function aspirantes3($PK_PERIODO)
    {
        /* $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                DB::raw('100342 as CLAVE_INSTITUCION'),
                DB::raw('4576 as CLAVE_SEDE'),
                'CAT_USUARIO.FECHA_NACIMIENTO',
                'CAT_USUARIO.CORREO as CORREO',
                'CAT_CARRERA.CLAVE_CARRERA'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->where([
                ['FK_PERIODO', '=', $PK_PERIODO],
                ['FK_ESTATUS', '=', 2]
            ])
            ->get(); */

        $aspirantes = DB::table('CAT_ASPIRANTE')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                DB::raw('100342 as CLAVE_INSTITUCION'),
                DB::raw('4576 as CLAVE_SEDE'),
                'CAT_USUARIO.FECHA_NACIMIENTO',
                'CAT_USUARIO.CORREO1 as CORREO',
                'CAT_CARRERA.CLAVE_CARRERA'
            )
            ->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=',  'CAT_ASPIRANTE.FK_PADRE')
            ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
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
            $archivo = new Base64ToFile();
            $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            //$file = fopen($ruta, "r");
            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta)->getSheet(2);

            for ($row = 2; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("B" . $row)->getValue();
                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CAT_ASPIRANTE')
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
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }
    public function cargarArchivoRegistroCENEVAL(Request $request, $PK_PERIODO)
    {
        try {
            $TIPO_APLICACION = DB::table('CAT_PERIODO_PREFICHAS')->select('TIPO_APLICACION')->where('PK_PERIODO_PREFICHAS', $PK_PERIODO)->max('TIPO_APLICACION');
            // create new workbook
            $archivo = new Base64ToFile();
            $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta)->getSheet(1);

            for ($row = 4; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("F" . $row)->getValue();
                $folioCeneval = $objPHPExcel->getCell("G" . $row)->getValue();

                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    $aspirante = DB::table('CAT_ASPIRANTE')
                        ->select('PREFICHA', 'FK_CARRERA_1')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha],
                            ['FK_ESTATUS', '=', 3]
                        ])
                        ->get();
                    if (isset($aspirante[0])) {
                        if ($TIPO_APLICACION == 1) {
                            DB::table('CAT_ASPIRANTE')
                                ->where([
                                    ['FK_PERIODO', '=', $PK_PERIODO],
                                    ['PREFICHA', '=', $preficha],
                                    ['FK_ESTATUS', '=', 3]
                                ])
                                ->update([
                                    'FOLIO_CENEVAL' => $folioCeneval,
                                    'FK_ESTATUS' => 4,
                                    'FECHA_MODIFICACION' => date('Y-m-d H:i:s'),
                                    'FK_EXAMEN_ADMISION' => $this->asignaExamen($PK_PERIODO, $aspirante[0]->FK_CARRERA_1, $TIPO_APLICACION),
                                    'FK_EXAMEN_INGLES' => $this->asignaExamenIngles($PK_PERIODO)
                                ]);
                        } else {
                            DB::table('CAT_ASPIRANTE')
                                ->where([
                                    ['FK_PERIODO', '=', $PK_PERIODO],
                                    ['PREFICHA', '=', $preficha],
                                    ['FK_ESTATUS', '=', 3]
                                ])
                                ->update([
                                    'FOLIO_CENEVAL' => $folioCeneval,
                                    'FK_ESTATUS' => 4,
                                    'FECHA_MODIFICACION' => date('Y-m-d H:i:s'),
                                    'FK_EXAMEN_ADMISION_ESCRITO' => $this->asignaExamen($PK_PERIODO, $aspirante[0]->FK_CARRERA_1, $TIPO_APLICACION),
                                    'FK_EXAMEN_INGLES' => $this->asignaExamenIngles($PK_PERIODO)
                                ]);
                        }
                    }
                } else {
                    break;
                }
            }
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }
    private function asignaExamen($PK_PERIODO, $FK_CARRERA_1, $TIPO_APLICACION)
    {
        $bool = false;

        $diasSemanaTotal = [];
        $turnosTotal = [];
        $espaciosTotal = [];

        if ($TIPO_APLICACION == 1) {
            $modelExamen = DB::table('CATR_EXAMEN_ADMISION')
                ->select('FK_ESPACIO')
                ->where('FK_PERIODO', $PK_PERIODO)
                ->get();

            $modelTurno = DB::table('CAT_TURNO')
                ->select(
                    'PK_TURNO',
                    'DIA',
                    'HORA'
                )
                ->where('FK_PERIODO', $PK_PERIODO)
                ->get();

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
                                        ->where([
                                            ['PK_ESPACIO', $espacio],
                                            ['FK_PERIODO', $PK_PERIODO]
                                        ])
                                        ->get();

                                    $capacidad = $espacioAplicacion[0]->CAPACIDAD;

                                    $modelTurnoDia = DB::table('CAT_TURNO')
                                        ->select(
                                            'PK_TURNO'
                                        )
                                        ->where([
                                            ['DIA', '=', $dia],
                                            ['HORA', '=', $turno],
                                            ['FK_PERIODO', $PK_PERIODO]
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
                                                ['FK_TURNO', '=', $modelTurnoDia[0]->PK_TURNO],
                                                ['FK_PERIODO', $PK_PERIODO]
                                            ])
                                            ->get();
                                        if (isset($examen[0])) {
                                            $ocupados = $examen[0]->LUGARES_OCUPADOS;
                                            if ($capacidad > $ocupados) {
                                                //return $espacioAplicacion[0]->PK_ESPACIO." ".$modelTurnoDia[0]->PK_TURNO;
                                                DB::table('CATR_EXAMEN_ADMISION')
                                                    ->where([
                                                        ['FK_ESPACIO', '=', $espacioAplicacion[0]->PK_ESPACIO],
                                                        ['FK_TURNO', '=', $modelTurnoDia[0]->PK_TURNO],
                                                        ['FK_PERIODO', $PK_PERIODO]
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
        } else {
            $modelExamen = DB::table('CATR_EXAMEN_ADMISION_ESCRITO')
                ->select('FK_EDIFICIO')
                ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CATR_EXAMEN_ADMISION_ESCRITO.FK_CARRERA')
                ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=',  'CAT_CARRERA.PK_CARRERA')
                ->where([
                    ['FK_PERIODO', $PK_PERIODO],
                    ['PK_CARRERA_CAMPUS', $FK_CARRERA_1]
                ])
                ->get();
            $modelTurno = DB::table('CAT_TURNO_ESCRITO')
                ->select(
                    'PK_TURNO_ESCRITO',
                    'DIA',
                    'HORA'
                )
                ->where('FK_PERIODO', $PK_PERIODO)
                ->get();

            foreach ($modelExamen as $exam) {
                array_push($espaciosTotal, $exam->FK_EDIFICIO);
            }

            foreach ($modelTurno as $model) {
                array_push($diasSemanaTotal, $model->DIA);
                array_push($turnosTotal, $model->HORA);
            }

            $turnos = array_unique($turnosTotal);
            $diasSemana = array_unique($diasSemanaTotal);
            $espacios = array_unique($espaciosTotal);

            //Insertar por orden dias
            foreach ($diasSemana as $dia) {
                if (!$bool) {
                    foreach ($turnos as $turno) {
                        if (!$bool) {
                            foreach ($espacios as $espacio) {
                                if (!$bool) {
                                    //$espacioAplicacion = AEspacio::model()->findByAttributes(array('pk_espacio' => $espacio));
                                    $espacioAplicacion = DB::table('CATR_EDIFICIO')
                                        ->select(
                                            'PK_EDIFICIO',
                                            'CAPACIDAD'
                                        )
                                        ->where('PK_EDIFICIO', $espacio)
                                        ->get();

                                    $capacidad = $espacioAplicacion[0]->CAPACIDAD;

                                    $modelTurnoDia = DB::table('CAT_TURNO_ESCRITO')
                                        ->select(
                                            'PK_TURNO_ESCRITO'
                                        )
                                        ->where([
                                            ['DIA', '=', $dia],
                                            ['HORA', '=', $turno],
                                            ['FK_PERIODO', $PK_PERIODO]
                                        ])
                                        ->get();

                                    if (isset($modelTurnoDia[0])) {
                                        $examen = DB::table('CATR_EXAMEN_ADMISION_ESCRITO')
                                            ->select(
                                                'PK_EXAMEN_ADMISION_ESCRITO',
                                                'LUGARES_OCUPADOS'
                                            )
                                            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CATR_EXAMEN_ADMISION_ESCRITO.FK_CARRERA')
                                            ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=',  'CAT_CARRERA.PK_CARRERA')
                                            ->where([
                                                ['FK_EDIFICIO', '=', $espacioAplicacion[0]->PK_EDIFICIO],
                                                ['FK_TURNO_ESCRITO', '=', $modelTurnoDia[0]->PK_TURNO_ESCRITO],
                                                ['FK_PERIODO', $PK_PERIODO],
                                                ['PK_CARRERA_CAMPUS', $FK_CARRERA_1]
                                            ])
                                            ->get();
                                        if (isset($examen[0])) {
                                            $ocupados = $examen[0]->LUGARES_OCUPADOS;
                                            if ($capacidad > $ocupados) {
                                                //return $espacioAplicacion[0]->PK_ESPACIO." ".$modelTurnoDia[0]->PK_TURNO;
                                                DB::table('CATR_EXAMEN_ADMISION_ESCRITO')
                                                    ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CATR_EXAMEN_ADMISION_ESCRITO.FK_CARRERA')
                                                    ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=',  'CAT_CARRERA.PK_CARRERA')
                                                    ->where([
                                                        ['FK_EDIFICIO', '=', $espacioAplicacion[0]->PK_EDIFICIO],
                                                        ['FK_TURNO_ESCRITO', '=', $modelTurnoDia[0]->PK_TURNO_ESCRITO],
                                                        ['FK_PERIODO', $PK_PERIODO],
                                                        ['PK_CARRERA_CAMPUS', $FK_CARRERA_1]
                                                    ])
                                                    ->update(
                                                        ['LUGARES_OCUPADOS' => $examen[0]->LUGARES_OCUPADOS + 1]
                                                    );
                                                //$examen[0]->LUGARES_OCUPADOS = $examen[0]->LUGARES_OCUPADOS+1;
                                                //$examen[0]->saveAttributes(array('lugares_ocupados'));
                                                $bool = true;
                                                return $examen[0]->PK_EXAMEN_ADMISION_ESCRITO;
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
    }

    private function asignaExamenIngles($PK_PERIODO)
    {
        $bool = false;

        $diasSemanaTotal = [];
        $turnosTotal = [];
        $espaciosTotal = [];

        $modelExamen = DB::table('CATR_EXAMEN_ADMISION_INGLES')
            ->select('FK_ESPACIO_INGLES')
            ->where('FK_PERIODO', $PK_PERIODO)
            ->get();

        $modelTurno = DB::table('CAT_TURNO_INGLES')
            ->select(
                'PK_TURNO_INGLES',
                'DIA',
                'HORA'
            )
            ->where('FK_PERIODO', $PK_PERIODO)
            ->get();

        foreach ($modelExamen as $exam) {
            array_push($espaciosTotal, $exam->FK_ESPACIO_INGLES);
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
                                $espacioAplicacion = DB::table('CATR_ESPACIO_INGLES')
                                    ->select(
                                        'PK_ESPACIO_INGLES',
                                        'CAPACIDAD'
                                    )
                                    ->where([
                                        ['PK_ESPACIO_INGLES', $espacio],
                                        ['FK_PERIODO', $PK_PERIODO]
                                    ])
                                    ->get();

                                $capacidad = $espacioAplicacion[0]->CAPACIDAD;

                                $modelTurnoDia = DB::table('CAT_TURNO_INGLES')
                                    ->select(
                                        'PK_TURNO_INGLES'
                                    )
                                    ->where([
                                        ['DIA', '=', $dia],
                                        ['HORA', '=', $turno],
                                        ['FK_PERIODO', $PK_PERIODO]
                                    ])
                                    ->get();

                                if (isset($modelTurnoDia[0])) {
                                    $examen = DB::table('CATR_EXAMEN_ADMISION_INGLES')
                                        ->select(
                                            'PK_EXAMEN_ADMISION_INGLES',
                                            'LUGARES_OCUPADOS'
                                        )
                                        ->where([
                                            ['FK_ESPACIO_INGLES', '=', $espacioAplicacion[0]->PK_ESPACIO_INGLES],
                                            ['FK_TURNO_INGLES', '=', $modelTurnoDia[0]->PK_TURNO_INGLES],
                                            ['FK_PERIODO', $PK_PERIODO]
                                        ])
                                        ->get();
                                    if (isset($examen[0])) {
                                        $ocupados = $examen[0]->LUGARES_OCUPADOS;
                                        if ($capacidad > $ocupados) {
                                            //return $espacioAplicacion[0]->PK_ESPACIO_INGLES." ".$modelTurnoDia[0]->PK_TURNO_INGLES;
                                            DB::table('CATR_EXAMEN_ADMISION_INGLES')
                                                ->where([
                                                    ['FK_ESPACIO_INGLES', '=', $espacioAplicacion[0]->PK_ESPACIO_INGLES],
                                                    ['FK_TURNO_INGLES', '=', $modelTurnoDia[0]->PK_TURNO_INGLES],
                                                    ['FK_PERIODO', $PK_PERIODO]
                                                ])
                                                ->update(
                                                    ['LUGARES_OCUPADOS' => $examen[0]->LUGARES_OCUPADOS + 1]
                                                );
                                            //$examen[0]->LUGARES_OCUPADOS = $examen[0]->LUGARES_OCUPADOS+1;
                                            //$examen[0]->saveAttributes(array('lugares_ocupados'));
                                            $bool = true;
                                            return $examen[0]->PK_EXAMEN_ADMISION_INGLES;
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

    public function cargarArchivoResultados(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $archivo = new Base64ToFile();
            $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta)->getSheet(0);

            for ($row = 2; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("I" . $row)->getValue();
                $ICNE = $objPHPExcel->getCell("FE" . $row)->getValue();
                $DDD_MG_MAT = $objPHPExcel->getCell("FQ" . $row)->getValue();
                if ($preficha) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CAT_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha] //,
                            //['FK_ESTATUS', '=', 4]
                        ])
                        ->update([
                            'ICNE' => $ICNE,
                            'DDD_MG_MAT' => $DDD_MG_MAT
                        ]);
                } else {
                    break;
                }
            }
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }

    public function cargarArchivoAceptados(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $archivo = new Base64ToFile();
            $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta)->getSheet(0);

            for ($row = 2; $row <= $objPHPExcel->getHighestRow(); $row++) {
                $preficha = $objPHPExcel->getCell("I" . $row)->getValue();
                $aceptado = $objPHPExcel->getCell("FU" . $row)->getValue();
                if ($preficha && $aceptado == 1) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CAT_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha] //,
                            //['FK_ESTATUS', '=', 4]
                        ])
                        ->update([
                            'ACEPTADO' => 1
                        ]);
                } else if ($preficha && $aceptado == 2) {
                    /* Actualiza el estatus por preficha */
                    DB::table('CAT_ASPIRANTE')
                        ->where([
                            ['FK_PERIODO', '=', $PK_PERIODO],
                            ['PREFICHA', '=', $preficha] //,
                            //['FK_ESTATUS', '=', 4]
                        ])
                        ->update([
                            'ACEPTADO' => 2
                        ]);
                }
            }
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }

    public function cargarArchivoAsistencia(Request $request, $PK_PERIODO)
    {
        try {
            // create new workbook
            $archivo = new Base64ToFile();
            $ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

            for ($i = 0; $i < $objReader->load($ruta)->getSheetCount(); $i++) {
                $objPHPExcel = $objReader->load($ruta)->getSheet($i);
                for ($row = 3; $row <= $objPHPExcel->getHighestRow(); $row++) {
                    $preficha = $objPHPExcel->getCell("A" . $row)->getValue();
                    $asistencia = $objPHPExcel->getCell("C" . $row)->getValue();
                    if ($preficha && $asistencia == 1) {
                        //error_log(print_r($asistencia, true));
                        //Actualiza el estatus por preficha
                        DB::table('CAT_ASPIRANTE')
                            ->where([
                                ['FK_PERIODO', '=', $PK_PERIODO],
                                ['PREFICHA', '=', $preficha],
                                ['FK_ESTATUS', '=', 4]
                            ])
                            ->update(['FK_ESTATUS' => 5]);
                    }
                }
            }
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            return response()->json("El archivo de carga de ceneval no ha podido ser procesado");
        }
    }

    public function sendEmail($CORREO1)
    {
        if (!$this->validateEmail($CORREO1)) {
            return $this->failedResponse();
        }
        $this->send($CORREO1);
        return $this->successResponse();
    }
    public function send($CORREO1)
    {
        $token = $this->createToken($CORREO1);
        Mail::to($CORREO1)->send(new AspirantePasswordMail($token, $CORREO1));
    }
    public function createToken($CORREO1)
    {
        $oldToken = DB::table('password_resets')->where('CORREO1', $CORREO1)->first();
        if ($oldToken) {
            return $oldToken->token;
        }
        $token = str_random(60);
        $this->saveToken($token, $CORREO1);
        return $token;
    }
    public function saveToken($token, $CORREO1)
    {
        DB::table('password_resets')->insert([
            'CORREO1' => $CORREO1,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
    public function validateEmail($CORREO1)
    {
        return !!User::where('CORREO1', $CORREO1)->first();
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


        $fk_padre = DB::table('CAT_USUARIO')
            ->where('CURP', $request->CURP)
            ->max('PK_USUARIO');

        $fk_aspirante = DB::table('CAT_ASPIRANTE')
            ->where('FK_PADRE', $fk_padre)
            ->max('PK_ASPIRANTE');

        DB::table('CAT_ASPIRANTE')
            ->where([
                ['FK_PADRE', '=', $fk_padre],
                ['PK_ASPIRANTE', '=', $fk_aspirante]
            ])
            ->update([
                'FK_CARRERA_1' => $request->FK_CARRERA_1,
                'FK_CARRERA_2' => $request->FK_CARRERA_2
            ]);

        DB::table('CAT_USUARIO')
            ->where('PK_USUARIO', $request->PK_USUARIO)
            ->update([
                'CURP' => $request->CURP,
                'TELEFONO_CASA' => $request->TELEFONO_CASA,
                'TELEFONO_MOVIL' => $request->TELEFONO_MOVIL,
                'CORREO1' => $request->CORREO1
            ]);




        return response()->json('Se modifico correctamente');
    }
    public function enviarCorreos(Request $request)
    {
        // Mail::to($request->CORREOS)->send(new CorreoAspirantesMail($request->MENSAJE, $request->ASUNTO));
        //error_log(print_r($request, true));

        //enviar correo de notificación
        $mailer = new Mailer(
            array(
                // correo de origen
                //'correo_origen' => $datos_sistema->CORREO1,
                //'password_origen' => $datos_sistema->INDICIO1,

                // datos que se mostrarán del emisor
                // 'correo_emisor' => $datos_sistema->CORREO1,
                'correo_emisor' => 'tecvirtual@itleon.edu.mx',
                'nombre_emisor' => utf8_decode('Tecnológico Nacional de México en León'),

                // array correos receptores
                'correos_receptores' => ($request->CORREOS),

                // asunto del correo
                'asunto' => utf8_decode($request->ASUNTO),

                // cuerpo en HTML del correo
                'cuerpo_html' => view(
                    'mails.correoAspirantes',
                    ['mensaje' => $request->MENSAJE]
                )->render()
            )
        );

        $mailer->send();
    }





    private function get_datos_token($usuario)
    {
        // buscar token activo
        $datos_token = ObtenerContrasenia::where('FK_USUARIO', $usuario->PK_USUARIO)
            ->where('FECHA_GENERACION', '>=', date('Y-m-d 00:00:00'))
            ->where('FECHA_GENERACION', '<=', date('Y-m-d 23:59:59'))
            ->where('ESTADO', 1)
            ->first();

        if (!isset($datos_token->FK_USUARIO)) { // sí no tiene token activo
            // generar token y clave
            $fecha = date('Y-m-d H:i:s');
            $token = UsuariosHelper::get_token_contrasenia($usuario->CURP, $fecha);
            $clave = UsuariosHelper::get_clave_verificacion();

            // registro en tabla de contraseñas
            $datos_token = new ObtenerContrasenia;
            $datos_token->FK_USUARIO = $usuario->PK_USUARIO;
            $datos_token->TOKEN = $token;
            $datos_token->CLAVE_ACCESO = $clave;
            $datos_token->FECHA_GENERACION = $fecha;
            $datos_token->save();
        }

        return $datos_token;
    }

    private function notifica_usuario($correo_receptor, $token, $clave)
    {
        //enviar correo de notificación
        $mailer = new Mailer(
            array(
                // correo de origen
                //'correo_origen' => $datos_sistema->CORREO1,
                //'password_origen' => $datos_sistema->INDICIO1,

                // datos que se mostrarán del emisor
                // 'correo_emisor' => $datos_sistema->CORREO1,
                'correo_emisor' => 'tecvirtual@itleon.edu.mx',
                'nombre_emisor' => utf8_decode('Tecnológico Nacional de México en León'),

                // array correos receptores
                'correos_receptores' => array($correo_receptor),

                // asunto del correo
                'asunto' => utf8_decode('TecVirtual - Activación de cuenta'),

                // cuerpo en HTML del correo
                'cuerpo_html' => view(
                    'mails.activacion_cuenta',
                    ['token' => $token, 'clave' => $clave]
                )->render()
            )
        );

        return $mailer->send();
    }
}
