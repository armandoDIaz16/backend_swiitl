<?php

namespace App\Http\Controllers;

use App\CoordinadorDepartamentalTutoria;
use App\GrupoTutorias;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Rol;
use App\User;
use App\Usuario_Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Usuario_RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ResponseHTTP::response_ok([]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ResponseHTTP::response_ok([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ResponseHTTP::response_ok([]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array[]
     */
    public function show($id)
    {
        $usuario = user::where('PK_USUARIO', $id)
            ->select('PK_USUARIO', 'NOMBRE')
            ->first();

        $sistemas = DB::table('PER_CAT_SISTEMA')
            ->select('PER_CAT_SISTEMA.PK_SISTEMA', 'PER_CAT_SISTEMA.NOMBRE')
            ->join('PER_CAT_ROL', 'PER_CAT_ROL.FK_SISTEMA', '=', 'PER_CAT_SISTEMA.PK_SISTEMA')
            ->join('PER_TR_ROL_USUARIO', 'PER_TR_ROL_USUARIO.FK_ROL', '=', 'PER_CAT_ROL.PK_ROL')
            ->where('FK_USUARIO', $usuario->PK_USUARIO)
            ->distinct()
            ->get();
        //return $sistemas;

        $array_sistemas = [];
        foreach ($sistemas as $sistema) {
            $array_sistemas[] = array(
                'PK_SISTEMA' => $sistema->PK_SISTEMA,
                'NOMBRE' => $sistema->NOMBRE,
                'ROLES' => $this->get_roles_usuario($usuario->PK_USUARIO, $sistema->PK_SISTEMA)
                //'ROLES'      => $this->get_modulos_usuario($sistema->PK_ROL)
            );
        }

        $sql = "
        SELECT
            CLAVE_ACCION AS ACCION,
            PER_CAT_ROL.ABREVIATURA AS ROL
        FROM
            PER_CAT_ACCION
                LEFT JOIN PER_TR_PERMISO
                    ON PER_CAT_ACCION.PK_ACCION = PER_TR_PERMISO.FK_ACCION
                LEFT JOIN PER_CAT_ROL
                    ON PER_TR_PERMISO.FK_ROL = PER_CAT_ROL.PK_ROL";
        $acciones = Constantes::procesa_consulta_general($sql);


        return [
            array(
                'USUARIO' => $id,
                'NOMBRE' => $usuario->name,
                'SISTEMAS' => $array_sistemas,
                'ACCIONES' => $acciones,
            )
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function get_roles_usuario($id, $PK_SISTEMA)
    {
        $usuario = user::where('PK_USUARIO', $id)->select('PK_USUARIO', 'NOMBRE')->get()[0];
        $roles = DB::table('PER_TR_ROL_USUARIO')
            ->join('PER_CAT_ROL', 'PER_CAT_ROL.PK_ROL', '=', 'PER_TR_ROL_USUARIO.FK_ROL')
            ->select('PER_CAT_ROL.PK_ROL', 'PER_CAT_ROL.NOMBRE')
            ->where([
                ['FK_USUARIO', $usuario['PK_USUARIO']],
                ['FK_SISTEMA', $PK_SISTEMA],
                ['PER_TR_ROL_USUARIO.BORRADO', 0]
            ])->get();

        $array_roles = array();
        foreach ($roles as $rol) {

            $modulos = DB::table('PER_TR_ROL_MODULO')
                ->join('PER_CAT_MODULO', 'PER_CAT_MODULO.PK_MODULO', '=', 'PER_TR_ROL_MODULO.FK_MODULO')
                ->select('PER_CAT_MODULO.PK_MODULO', 'PER_CAT_MODULO.NOMBRE', 'PER_CAT_MODULO.RUTA_MD5')
                ->where('FK_ROL', $rol->PK_ROL)
                ->where('ES_MENU', 1)
                ->orderBy('ORDEN', 'ASC')
                ->get();

            $array_modulos = array();
            foreach ($modulos as $modulo) {
                $acciones = DB::table('PER_CAT_ACCION')
                    ->join('PER_TR_ROL_MODULO', 'PER_TR_ROL_MODULO.FK_MODULO', '=', 'PER_CAT_ACCION.FK_MODULO')
                    ->select('PER_CAT_ACCION.PK_ACCION', 'PER_CAT_ACCION.NOMBRE')
                    ->where([
                        ['FK_ROL', $rol->PK_ROL],
                        ['PER_CAT_ACCION.FK_MODULO', $modulo->PK_MODULO]
                    ])
                    ->get();
                $array_acciones = array();
                foreach ($acciones as $accion) {
                    $array_acciones[] = array(
                        'PK_ACCION' => $accion->PK_ACCION,
                        'NOMBRE' => $accion->NOMBRE
                    );
                }
                $array_modulos[] = array(
                    'PK_MODULO' => $modulo->PK_MODULO,
                    'NOMBRE' => $modulo->NOMBRE,
                    'RUTA_MD5' => $modulo->RUTA_MD5,
                    'ACCIONES' => $array_acciones
                );
            }
            $array_roles[] = array(
                'PK_ROL' => $rol->PK_ROL,
                'NOMBRE' => $rol->NOMBRE,
                'MODULOS' => $array_modulos
            );
        }
        return $array_roles;
    }

    public function roles_usuario(Request $request)
    {
        $roles = [];
        $usuario = User::where('PK_USUARIO', $request->pk_usuario)->first();
        if ($usuario) {
            $roles['pk_encriptada'] = $usuario->PK_ENCRIPTADA;
            $roles['tipo_usuario'] = $usuario->TIPO_USUARIO;
            $roles['nombre_usuario'] =
                $usuario->NOMBRE
                . ' ' . $usuario->PRIMER_APELLIDO
                . ' ' . $usuario->SEGUNDO_APELLIDO;
            $roles['numero_control'] = $usuario->NUMERO_CONTROL;

            $roles['tutorias'] = $this->get_roles_tutorias($usuario->PK_USUARIO);
        }

        return $roles;
    }

    public function get_roles_tutorias($pk_usuario)
    {
        if ($pk_usuario) {
            $roles = [
                'administrador' => false,
                'coord_institucional' => false,

                'coord_departamental' => false,
                'departamentos' => [],

                'coord_investigacion' => false,

                'tutor' => false,
                'pk_grupo' => false
            ];

            // verificar si es administrador
            $rol = Rol::where('ABREVIATURA', 'ADM_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario) {
                    $roles['administrador'] = true;
                }
            }

            // verificar si es coordinador institucional
            $rol = Rol::where('ABREVIATURA', 'COORI_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario) {
                    $roles['coord_institucional'] = true;
                }
            }

            // verificar si es coordinador departamental
            $rol = Rol::where('ABREVIATURA', 'COORD_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario) {
                    $departamentos_array = CoordinadorDepartamentalTutoria::where('FK_USUARIO', $pk_usuario)
                        ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                        ->get();
                    $departamentos_temp = [];

                    foreach ($departamentos_array as $item) {
                        $departamentos_temp[] = $item->FK_AREA_ACADEMICA;
                    }

                    $roles['coord_departamental'] = true;
                    $roles['departamentos'] = $departamentos_temp;
                }
            }

            // verificar si es coordinador de investigaci??n educativa
            $rol = Rol::where('ABREVIATURA', 'COORIE_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario) {
                    $roles['coord_investigacion'] = true;
                }
            }

            // verificar si es tutor
            $rol = Rol::where('ABREVIATURA', 'TUT_TUT')->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $pk_usuario)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($rol_usuario) {
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
