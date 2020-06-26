<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\Abreviaturas;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Models\Conferencias\CapturistaConferencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ConferenciaController
 * @package App\Http\Controllers\tutorias
 */
class CapturistaConferenciaController extends Controller
{
    /**
     * @return object
     */
    public function index(Request $request) {
        $capturistas = CapturistaConferencia::where('FK_JORNADA', $request->pk_conferencia)
            ->leftJoin('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'FK_USUARIO')
            ->get();

        return ResponseHTTP::response_ok($capturistas);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $capturista = new CapturistaConferencia;

        $capturista->FK_USUARIO = $request->pk_usuario;
        $capturista->FK_JORNADA = $request->pk_conferencia;

        // Agregar rol a usuario
        if (!UsuariosHelper::rol_usuario(
            $capturista->FK_USUARIO,
            Abreviaturas::TUTORIA_ROL_CAPTURISTA,
            TRUE)) {
            error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
            error_log('PK_USUARIO: ' . $request->pk_capturista);
            error_log('ROL: ' . Abreviaturas::TUTORIA_ROL_CAPTURISTA);
        }


        return ($capturista->save())
            ? ResponseHTTP::response_ok($capturista)
            : ResponseHTTP::response_error('Error al registrar');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return ResponseHTTP::response_error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return ResponseHTTP::response_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $capturista = CapturistaConferencia::find($id);
        if ($capturista) {
            // quitar rol a usuario
            if (!UsuariosHelper::rol_usuario(
                $capturista->FK_USUARIO,
                Abreviaturas::TUTORIA_ROL_CAPTURISTA,
                FALSE)) {
                error_log('***** ERROR AL QUITAR ROL A USUARIO *****');
                error_log('PK_USUARIO: ' . $capturista->FK_USAURIO);
                error_log('ROL: ' . Abreviaturas::TUTORIA_ROL_CAPTURISTA);
            }

            return ($capturista->delete())
                ? ResponseHTTP::response_ok([])
                : ResponseHTTP::response_error();
        } else {
            return ResponseHTTP::response_error();
        }
    }
}
