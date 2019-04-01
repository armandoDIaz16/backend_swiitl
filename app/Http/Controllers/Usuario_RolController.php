<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = user::where('PK_USUARIO', $id)->select('PK_USUARIO','name')->get()[0];

        $sistemas = DB::table('PER_CAT_SISTEMA')
            ->select('PER_CAT_SISTEMA.PK_SISTEMA', 'PER_CAT_SISTEMA.NOMBRE')
            ->join('PER_CATR_ROL', 'PER_CATR_ROL.FK_SISTEMA', '=', 'PER_CAT_SISTEMA.PK_SISTEMA')
            ->join('PER_TR_ROL_USUARIO', 'PER_TR_ROL_USUARIO.FK_ROL', '=', 'PER_CATR_ROL.PK_ROL')
            ->where('FK_USUARIO', $usuario->PK_USUARIO)
            ->distinct()
            ->get();
            //return $sistemas;

        $array_sistemas = [];
        foreach($sistemas as $sistema){
            $array_sistemas[] = array(
                'PK_SISTEMA' => $sistema->PK_SISTEMA,
                'NOMBRE'     => $sistema->NOMBRE,
                'ROLES'      => $this->get_roles_usuario($usuario->PK_USUARIO,$sistema->PK_SISTEMA)
                //'ROLES'      => $this->get_modulos_usuario($sistema->PK_ROL)
            );
        }


        return [
            array(
            'USUARIO'  => $id,
            'NOMBRE'   => $usuario->name,
            'SISTEMAS' => $array_sistemas
            )
        ];
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
    private function get_roles_usuario($id,$PK_SISTEMA){        
        $usuario = user::where('PK_USUARIO', $id)->select('PK_USUARIO','name')->get()[0];
        $roles = DB::table('PER_TR_ROL_USUARIO')
            ->join('PER_CATR_ROL', 'PER_CATR_ROL.PK_ROL', '=', 'PER_TR_ROL_USUARIO.FK_ROL')
            ->select('PER_CATR_ROL.PK_ROL', 'PER_CATR_ROL.NOMBRE')
            ->where([
                ['FK_USUARIO',$usuario['PK_USUARIO']],
                ['FK_SISTEMA',$PK_SISTEMA]]
                )
            ->get();
            
        $array_roles = array();
        foreach($roles as $rol){

            $modulos = DB::table('PER_TR_ROL_MODULO')
                ->join('PER_CAT_MODULO', 'PER_CAT_MODULO.PK_MODULO', '=', 'PER_TR_ROL_MODULO.FK_MODULO')
                ->select('PER_CAT_MODULO.PK_MODULO', 'PER_CAT_MODULO.NOMBRE')
                ->where('FK_ROL', $rol->PK_ROL)
                ->get();

                $array_modulos = array();
                foreach($modulos as $modulo){
                    $acciones = DB::table('PER_CATR_ACCION')
                    ->join('PER_TR_ROL_MODULO', 'PER_TR_ROL_MODULO.FK_MODULO', '=', 'PER_CATR_ACCION.FK_MODULO')
                    ->select('PER_CATR_ACCION.PK_ACCION', 'PER_CATR_ACCION.NOMBRE')                    
                    ->where([
                        ['FK_ROL',  $rol->PK_ROL],
                        ['PER_CATR_ACCION.FK_MODULO',  $modulo->PK_MODULO]
                    ])
                    ->get();
                    $array_acciones = array();
                    foreach($acciones as $accion){
                        $array_acciones[] = array(
                            'PK_ACCION' => $accion->PK_ACCION,
                            'NOMBRE' => $accion->NOMBRE
                        );
                    }
                    $array_modulos[] = array(
                        'PK_MODULO' => $modulo->PK_MODULO,
                        'NOMBRE' => $modulo->NOMBRE,
                        'ACCIONES'      => $array_acciones
                    );
                }
            $array_roles[] = array(
                'PK_ROL' => $rol->PK_ROL,
                'NOMBRE' => $rol->NOMBRE,            
                'MODULOS'    => $array_modulos
            );
        }
        return $array_roles;
    }
}
