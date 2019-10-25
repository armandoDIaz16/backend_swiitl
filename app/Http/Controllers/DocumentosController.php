<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Helpers\Base64ToFileReplace;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarDocumento(Request $request, $PK_PERIODO)
    {
        try {
            $aspirante = DB::table('CAT_USUARIO AS CU')
                ->select('RUTA')
                ->join('CAT_ASPIRANTE AS CA', 'CU.PK_USUARIO', '=', 'CA.FK_PADRE')
                ->join('CAT_USUARIO_CARPETA AS CUC', 'CU.PK_USUARIO', '=', 'CUC.FK_USUARIO')
                ->where([
                    ['FK_PERIODO', $PK_PERIODO],
                    ['PK_ENCRIPTADA', $request->PK_ENCRIPTADA]
                ])
                ->get();
            if (isset($aspirante[0])) {
                //error_log(print_r('44'.$aspirante, true));
                $ruta = $aspirante[0]->RUTA;
            } else {
                $aspirante = DB::table('CAT_USUARIO AS CU')
                    ->select('CC.NOMBRE', 'FECHA_INICIO', 'PK_USUARIO')
                    ->join('CAT_ASPIRANTE AS CA', 'CU.PK_USUARIO', '=', 'CA.FK_PADRE')
                    ->join('TR_CARRERA_CAMPUS AS TCC', 'CA.FK_CARRERA_1', '=', 'TCC.PK_CARRERA_CAMPUS')
                    ->join('CAT_CARRERA AS CC', 'TCC.FK_CARRERA', '=', 'CC.PK_CARRERA')
                    ->join('CAT_PERIODO_PREFICHAS AS CPP', 'CA.FK_PERIODO', '=', 'CPP.PK_PERIODO_PREFICHAS')
                    ->where([
                        ['PK_PERIODO_PREFICHAS', $PK_PERIODO],
                        ['PK_ENCRIPTADA', $request->PK_ENCRIPTADA]
                    ])
                    ->get();
                //error_log(print_r('44'.$aspirante, true));
                $fecha = strtotime($aspirante[0]->FECHA_INICIO);
                $mes = date("m", $fecha);
                $anio = date("Y", $fecha);
                if ($mes > 6) {
                    $periodo = ($anio + 1) . '_Enero_Julio';
                } else {
                    $periodo =  $anio . '_Agosto_Diciembre';
                }
                $ruta = $request->Sistema . '/' . $periodo . '/' . strtr($aspirante[0]->NOMBRE, " ", "_") . '/' . $request->PK_ENCRIPTADA;
                DB::table('CAT_USUARIO_CARPETA')->insert(['RUTA' => $ruta, 'FK_USUARIO' => $aspirante[0]->PK_USUARIO]);
                //DB::table('CAT_USUARIO_CARPETA')->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)->update(['TIPO_APLICUCION' => $request->TIPO_APLICUCION]);
            }


            //error_log(print_r(strtr($aspirante[0]->NOMBRE, " ", "_"), true));

            // create new workbook
            $archivo = new Base64ToFileReplace();
            $archivo->guardarArchivo($ruta, $request->Nombre, $request->Extencion, $request->Archivo);
            //$ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            //$file = fopen($ruta, "r");
            return response()->json("Se registro correctamente");
        } catch (Exception $e) {
            //return response()->json("El archivo no es una imagen");
        }
    }
    public function obtenerDocumento(Request $request)
    {
        $aspirante = DB::table('CAT_USUARIO_CARPETA')
            ->select('RUTA')
            ->where('FK_USUARIO', $request->PK_USUARIO)
            ->get();

        if (isset($aspirante[0])) {
            // Ruta del directorio donde están los archivos
            $path = "files/" . $aspirante[0]->RUTA . "/";

            // Arreglo con todos los nombres de los archivos
            $files = array_diff(scandir('public/'.$path), array('.', '..'));
            //Luego recorres el arreglo y le haces un simple explode a cada elemento

            // Obtienes tu variable mediante GET

            if ($request->ARCHIVO == 1) {
                $code = 'Identificacion';
            }

            foreach ($files as $file) {
                // Divides en dos el nombre de tu archivo utilizando el .
                $data          = explode(".", $file);
                // Nombre del archivo
                $fileName      = $data[0];
                // Extensión del archivo
                $fileExtension = $data[1];

                if ($code == $fileName) {
                    $ruta = $path . $fileName . '.' . $fileExtension;
                    // Realizamos un break para que el ciclo se interrumpa
                    return response()->json($ruta);
                }
            }
        }
    }
}
