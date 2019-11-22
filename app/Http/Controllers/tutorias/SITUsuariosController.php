<?php

namespace App\Http\Controllers\tutorias;

use App\GrupoTutorias;
use App\Helpers\Constantes;
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

        $rol = Rol::where('ABREVIATURA', 'COORD_TUT')->first();

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

    public function roles_tutorias($pk_usuario) {
        if ($pk_usuario){
            $roles = [
                'administrador'       => false,
                'coord_institucional' => false,

                'coord_departamental' => false,
                'departamentos'       => [],

                'coord_investigacion' => false,

                'tutor'               => false,
                'pk_grupo'            => false
            ];

            // verificar si es administrador
            $rol = Rol::where('ABREVIATURA', 'ADM_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario){
                    $roles['administrador'] = true;
                }
            }

            // verificar si es coordinador institucional
            $rol = Rol::where('ABREVIATURA', 'COORI_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario){
                    $roles['coord_institucional'] = true;
                }
            }

            // verificar si es coordinador departamental
            $rol = Rol::where('ABREVIATURA', 'COORD_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario){
                    $departamentos_array = CoordinadorDepartamentalTutoria::where('FK_USUARIO', $pk_usuario)
                        ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                        ->get();
                    $departamentos_temp = [];

                    foreach ($departamentos_array as $item){
                        $departamentos_temp[] = $item->FK_AREA_ACADEMICA;
                    }

                    $roles['coord_departamental'] = true;
                    $roles['departamentos']       = $departamentos_temp;
                }
            }

            // verificar si es coordinador de investigación educativa
            $rol = Rol::where('ABREVIATURA', 'COORIE_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario){
                    $roles['coord_investigacion'] = true;
                }
            }

            // verificar si es tutor
            $rol = Rol::where('ABREVIATURA', 'TUT_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario){
                    $grupo_tutoria = GrupoTutorias::where('FK_USUARIO', $pk_usuario)
                        ->where('PERIODO', Constantes::get_periodo())
                        ->first();
                    if ($grupo_tutoria) {
                        $roles['pk_grupo'] = $grupo_tutoria->PK_GRUPO_TUTORIA;
                    }

                    $roles['tutor'] = true;
                }
            }

            return $roles;
        } else {
            return null;
        }
    }
}
