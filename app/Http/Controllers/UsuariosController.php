<?php

namespace App\Http\Controllers;

use App\AreaAcademica;
use App\AreaAcademicaCarrera;
use App\Carrera;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\ModelViews\ViewUsuarios;
use Illuminate\Support\Facades\DB;
use App\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsuariosController
 * @package App\Http\Controllers
 */
class UsuariosController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = ViewUsuarios::where('BORRADO', Constantes::BORRADO_NO);

        /* INICIO FILTROS QUERY PARAMS */
        if ($request->tipo_usuario) {
            $query->where('TIPO_USUARIO', $request->tipo_usuario);
        }

        if ($request->numero_control) {
            $query->where('NUMERO_CONTROL', $request->numero_control);
        }

        if ($request->carrera && $request->tipo_usuario != 1) {
            $carrera = Carrera::find($request->carrera);
            $carrera_area = AreaAcademicaCarrera::where('FK_CARRERA', $carrera->PK_CARRERA)->first();
            $query->where('FK_AREA_ACADEMICA', $carrera_area->FK_AREA_ACADEMICA);
        }
        /* FIN FILTROS QUERY PARAMS */

        $usuarios = $query->get();

        return ResponseHTTP::response_ok($usuarios);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function alumno(Request $request)
    {
        // TODO AGREGAR TUTOR ASIGNADO
        $query = ViewUsuarios::where('BORRADO', Constantes::BORRADO_NO);

        /* INICIO FILTROS QUERY PARAMS */
        if ($request->tipo_usuario) {
            $query->where('TIPO_USUARIO', Constantes::USUARIO_ALUMNO);
        }

        if ($request->numero_control) {
            $query->where('NUMERO_CONTROL', $request->numero_control);
        }

        if ($request->carrera) {
            $query->where('FK_CARRERA', $request->carrera);
        }
        /* FIN FILTROS QUERY PARAMS */

        $usuarios = $query->get();

        return ResponseHTTP::response_ok($usuarios);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifica_correo_usuario(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);
        if ($usuario) {
            $usuario->CORREO1 = $request->correo;
            $usuario->save();

            return response()->json(true, Response::HTTP_ACCEPTED);
        }

        return response()->json(
            ['error' => 'Error al actualizar correo'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscar_usuarios(Request $request)
    {
        $usuarios_query = DB::table('CAT_USUARIO AS CU')
            ->select('CU.*', 'CA.NOMBRE AS AREA_ACADEMICA', 'CR.NOMBRE AS CARRERA',
                DB::raw('(SELECT CONCAT(CU.NOMBRE, \' \', CU.PRIMER_APELLIDO, \' \', CU.SEGUNDO_APELLIDO) FROM CAT_USUARIO AS CU WHERE CU.PK_USUARIO = GRT.FK_USUARIO) AS NOMBRE_TUTOR'))
            ->leftJoin('CAT_AREA_ACADEMICA AS CA', 'CU.FK_AREA_ACADEMICA', '=', 'CA.PK_AREA_ACADEMICA') // Para obtener AREA_ACADEMICA desde la FK
            ->leftJoin('CAT_CARRERA AS CR', 'CU.FK_CARRERA', '=', 'CR.PK_CARRERA')                      // Para obtener NOMBRE de la carrera desde la FK
            ->leftJoin('TR_GRUPO_TUTORIA_DETALLE AS GRTD', 'CU.PK_USUARIO', '=', 'GRTD.FK_USUARIO')     // Obtener el grupo del estudiante
            ->leftJoin('TR_GRUPO_TUTORIA AS GRT', 'GRTD.FK_GRUPO', '=', 'GRT.PK_GRUPO_TUTORIA')         // Obtener la FK del tutor
            ->where('CU.ESTADO', 2)
            ->where('CU.BORRADO', 0)
            ->whereRaw('CU.TIPO_USUARIO != 3');
        if ($request->tipo_usuario != 0) {
            $usuarios_query->where('TIPO_USUARIO', $request->tipo_usuario);
        }
        if (trim($request->numero_control)) {
            $usuarios_query->whereRaw("NUMERO_CONTROL LIKE '%$request->numero_control%'");
        }
        if (trim($request->nombre)) {
            $usuarios_query->whereRaw(
                "CONCAT(CU.NOMBRE, ' ', CU.PRIMER_APELLIDO, ' ', CU.SEGUNDO_APELLIDO) LIKE '%$request->nombre%'"
            );
        }

        $usuarios_query->orderBy('TIPO_USUARIO', 'DESC');
        $usuarios_query->orderBy('NUMERO_CONTROL', 'ASC');
        $usuarios_query->limit(50);

        return response()->json($usuarios_query->get(), Response::HTTP_ACCEPTED);
    }
}
