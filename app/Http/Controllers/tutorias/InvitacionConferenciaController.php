<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Models\Tutoria\InvitacionConferencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ConferenciaController
 * @package App\Http\Controllers\tutorias
 */
class InvitacionConferenciaController extends Controller
{
    /**
     * @return object
     */
    public function index(Request $request) {
        $invitaciones = InvitacionConferencia::where('TR_INVITACION_CONFERENCIA.ESTADO', Constantes::ESTADO_ACTIVO)
            ->leftJoin('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'FK_CARRERA')
            ->where('FK_JORNADA', $request->pk_conferencia)
            ->get();

        return ResponseHTTP::response_ok($invitaciones);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $invitacion = new InvitacionConferencia;

        $invitacion->FK_JORNADA = $request->pk_conferencia;
        $invitacion->TIPO_INVITACION = $request->tipo_invitacion;
        $invitacion->FECHA_INVITACION = date('Y-m-d');
        if ($request->carrera != -1 && $request->carrera != 0) {
            $invitacion->FK_CARRERA = $request->carrera;
        }
        if ($request->semestre) {
            $invitacion->SEMESTRE = $request->semestre;
        }

        $this->registra_detalle($request->TIPO_INVITACION, $request->carrera, $request->semestre);

        return ($invitacion->save())
            ? ResponseHTTP::response_ok($invitacion)
            : ResponseHTTP::response_error('Error al registrar');
    }

    private function registra_detalle($tipo_invitacion, $carrera, $semestre) {
        // TODO HACER EL DETALLE
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $invitacion = InvitacionConferencia::find($id);

        return ($invitacion)
            ? ResponseHTTP::response_ok($invitacion)
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
        $invitacion = InvitacionConferencia::find($id);
        if ($invitacion) {
            $invitacion->TIPO_INVITACION = $request->tipo_invitacion;
            $invitacion->FECHA_INVITACION = date('Y-m-d');
            if ($request->carrera != -1 && $request->carrera != 0) {
                $invitacion->FK_CARRERA = $request->carrera;
            } else {
                $invitacion->FK_CARRERA = NULL;
            }
            if ($request->semestre) {
                $invitacion->SEMESTRE = $request->semestre;
            } else {
                $invitacion->SEMESTRE = NULL;
            }

            // TODO ELIMINA DETALLE INVITACION

            // REGISTRA DETALLE
            $this->registra_detalle($request->TIPO_INVITACION, $request->carrera, $request->semestre);

            return ($invitacion->save())
                ? ResponseHTTP::response_ok($invitacion)
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
        $invitacion = InvitacionConferencia::find($id);
        if ($invitacion) {
            $invitacion->BORRADO = Constantes::BORRADO_SI;
            $invitacion->ESTADO = Constantes::ESTADO_INACTIVO;

            // TODO ELIMINA DETALLE DE CONFERENCIA

            // TODO ELIMINA PERMISO EN PASE DE LISTA

            return ($invitacion->save())
                ? ResponseHTTP::response_ok($invitacion)
                : ResponseHTTP::response_error();
        } else {
            return ResponseHTTP::response_error();
        }
    }
}
