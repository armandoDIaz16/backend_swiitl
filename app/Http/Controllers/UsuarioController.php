<?php

namespace App\Http\Controllers;

use App\Helpers\EncriptarUsuario;
use App\User;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Usuario::get();
        echo json_encode($usuario);
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
    public function prueba()
    {
        $usuarios = User::select('PK_USUARIO', 'FECHA_REGISTRO')->whereRaw('PK_ENCRIPTADA IS NULL')->get();
        foreach ($usuarios as $usuario) {
            User::where('PK_USUARIO', $usuario->PK_USUARIO)->update(['PK_ENCRIPTADA' => EncriptarUsuario::getPkEncriptada($usuario->PK_USUARIO,$usuario->FECHA_REGISTRO)]);
        }
    }
    public function prueba2()
    {
        return User::select('PK_USUARIO','FECHA_REGISTRO','PK_ENCRIPTADA')->whereRaw('PK_ENCRIPTADA IS NULL')->get();
    }
}
