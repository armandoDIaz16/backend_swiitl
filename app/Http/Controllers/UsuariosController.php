<?php

namespace App\Http\Controllers;

use App\Helpers\UsuariosHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuariosController extends Controller
{
    public function modifica_correo_usuario(Request $request) {
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);
        if ($usuario) {
            $usuario->CORREO1 = $request->correo;
            $usuario->save();

            return response()->json(true,Response::HTTP_ACCEPTED);
        }

        return response()->json(
            ['error' => 'Error al actualizar correo'],
            Response::HTTP_BAD_REQUEST
        );
    }

    public function buscar_usuarios(Request $request) {
        $usuarios_query = Usuario::where('ESTADO', 2)
        ->where('BORRADO', 0)
        ->whereRaw('TIPO_USUARIO != 3');
        if ($request->tipo_usuario != 0) {
            $usuarios_query->where('TIPO_USUARIO', $request->tipo_usuario);
        }
        if (trim($request->numero_control)) {
            $usuarios_query->whereRaw("NUMERO_CONTROL LIKE '%$request->numero_control%'");
        }
        if (trim($request->nombre)) {
            $usuarios_query->whereRaw(
                "CONCAT(NOMBRE, ' ', PRIMER_APELLIDO, ' ', SEGUNDO_APELLIDO) LIKE '%$request->nombre%'"
            );
        }

        $usuarios_query->orderBy('TIPO_USUARIO', 'DESC');
        $usuarios_query->orderBy('NUMERO_CONTROL', 'ASC');
        $usuarios_query->limit(50);

        return response()->json($usuarios_query->get(),Response::HTTP_ACCEPTED);
    }
}
