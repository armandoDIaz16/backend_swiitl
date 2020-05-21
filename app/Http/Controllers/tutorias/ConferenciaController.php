<?php

namespace App\Http\Controllers\tutorias;

use App\Conferencia;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ConferenciaController
 * @package App\Http\Controllers\tutorias
 */
class ConferenciaController extends Controller
{
    /**
     * @return object
     */
    public function index() {
        $conferencias = Conferencia::where('BORRADO', Constantes::BORRADO_NO)->get();

        return ResponseHTTP::response_ok($conferencias);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $conferencia = new Conferencia;

        $conferencia->TEMA = $request->tema;
        $conferencia->FECHA = $request->fecha;
        $conferencia->LUGAR = $request->lugar;
        $conferencia->DESCRIPCION = $request->descripcion;
        $conferencia->NOMBRE_EXPOSITOR = $request->nombre_expositor;

        return ($conferencia->save())
            ? ResponseHTTP::response_ok($conferencia)
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
        $conferencia = Conferencia::find($id);

        return ($conferencia)
            ? ResponseHTTP::response_ok($conferencia)
            : ResponseHTTP::response_error();
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
        $conferencia = Conferencia::find($id);
        if ($conferencia) {
            $conferencia->TEMA = $request->tema;
            $conferencia->FECHA = $request->fecha;
            $conferencia->LUGAR = $request->lugar;
            $conferencia->DESCRIPCION = $request->descripcion;
            $conferencia->NOMBRE_EXPOSITOR = $request->nombre_expositor;

            return ($conferencia->save())
                ? ResponseHTTP::response_ok($conferencia)
                : ResponseHTTP::response_error();
        } else {
            return ResponseHTTP::response_error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $conferencia = Conferencia::find($id);
        if ($conferencia) {
            $conferencia->BORRADO = Constantes::BORRADO_SI;
            $conferencia->ESTADO = Constantes::ESTADO_INACTIVO;

            // quitar invitacion a la conferencia
            /*$invitados_conferencia =*/

            // quitar a todos los invitados a la conferencia

            return ($conferencia->save())
                ? ResponseHTTP::response_ok($conferencia)
                : ResponseHTTP::response_error();
        } else {
            return ResponseHTTP::response_error();
        }
    }
}
