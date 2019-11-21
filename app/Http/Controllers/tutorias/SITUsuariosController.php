<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\Constantes;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use App\Rol;
use App\Usuario;
use App\Usuario_Rol;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\CoordinadorDepartamentalTutoria;

/**
 * Class SITUsuariosController
 * @package App\Http\Controllers\tutorias
 */
class SITUsuariosController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_coordinadores_departamentales()
    {
        $sql = "
            SELECT
                CAT_USUARIO.NOMBRE,
                CAT_USUARIO.PRIMER_APELLIDO,
                CAT_USUARIO.SEGUNDO_APELLIDO,
                CAT_USUARIO.CORREO1,
                CAT_USUARIO.CORREO_INSTITUCIONAL,
                CAT_USUARIO.NUMERO_CONTROL,
                CAT_AREA_ACADEMICA.NOMBRE AS AREA_ACADEMICA
            FROM TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
                LEFT JOIN CAT_USUARIO
                    ON TR_COORDINADOR_DEPARTAMENTAL_TUTORIA.FK_USUARIO = CAT_USUARIO.PK_USUARIO
                LEFT JOIN CAT_AREA_ACADEMICA
                    ON TR_COORDINADOR_DEPARTAMENTAL_TUTORIA.FK_AREA_ACADEMICA = CAT_AREA_ACADEMICA.PK_AREA_ACADEMICA
            WHERE
                TR_COORDINADOR_DEPARTAMENTAL_TUTORIA.ESTADO = ". Constantes::ESTADO_ACTIVO . "
            ;
        ";

        $coordinadores = Constantes::procesa_consulta_general($sql);

        return response()->json(
            ['data' => $coordinadores],
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coordinador_departamental(Request $request)
    {
        $usuario = null;
        $coordinador =
            CoordinadorDepartamentalTutoria::where('FK_AREA_ACADEMICA', $request->pk_area_academica)
                ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                ->first();

        if ($coordinador) {
            $usuario =
                Usuario::where('ESTADO', 2)
                    ->where("PK_USUARIO", $coordinador->FK_USUARIO)
                    ->first();
        }

        return response()->json(
            ['data' => $usuario],
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_usuarios_docentes(Request $request)
    {
        $usuarios =
            Usuario::where('ESTADO', 2)
                ->where('TIPO_USUARIO', Constantes::USUARIO_DOCENTE)
                ->whereRaw("CONCAT(NOMBRE, ' ', PRIMER_APELLIDO, ' ', SEGUNDO_APELLIDO) LIKE '%$request->nombre_coordinador%'")
                ->get();

        return response()->json(
            ['data' => $usuarios],
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guarda_coordinador(Request $request) {
        $coord_actual =
            CoordinadorDepartamentalTutoria::where('FK_AREA_ACADEMICA', $request->pk_area_academica)
                ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                ->first();

        $rol = Rol::where('ABREVIATURA', 'COORDEP')->first();

        if($coord_actual) {
            //dar de baja al actual
            $coord_actual->ESTADO = Constantes::ESTADO_INACTIVO;
            $coord_actual->save();

            //quitar rol de coordinador de tutoria
            $usuario_rol = Usuario_Rol::where('FK_USUARIO', $coord_actual->FK_USUARIO)
                ->where('FK_ROL', $rol->PK_ROL)
                ->first();

            if ($usuario_rol) {
                $usuario_rol->delete();
            }
        }

        // registrar al nuevo coordinador
        $coord_nuevo = new CoordinadorDepartamentalTutoria;
        $coord_nuevo->FK_USUARIO        = $request->pk_nuevo_coordinador;
        $coord_nuevo->FK_AREA_ACADEMICA = $request->pk_area_academica;

        if ($coord_nuevo->save()) {
            //asignar rol de coordinador de tutoria
            $nuevo_rol = new Usuario_Rol;
            $nuevo_rol->FK_USUARIO = $request->pk_nuevo_coordinador;
            $nuevo_rol->FK_ROL     = $rol->PK_ROL;
            $nuevo_rol->save();

            return response()->json(
                ['data' => true],
                Response::HTTP_ACCEPTED
            );
        } else {
            return response()->json(
                ['data' => false],
                Response::HTTP_ACCEPTED
            );
        }
    }
}
