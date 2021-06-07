<?php

namespace App\Http\Controllers;

use App\CodigoPostal;
use App\Helpers\Base64ToFile;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PerfilController
 * @package App\Http\Controllers
 */
class PerfilController extends Controller
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_perfil(Request $request)
    {
        $perfil = NULL;
        $view = '';
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);

        if (!$usuario) {
            $usuario = Usuario::where('PK_USUARIO', $request->pk_encriptada)->first();
        }

        if ($usuario) {
            if ($usuario->TIPO_USUARIO == Constantes::USUARIO_ALUMNO) {
                //usuario alumno
                $view = 'VW_PERFIL_ALUMNO';
            }

            if ($usuario->TIPO_USUARIO == Constantes::USUARIO_DOCENTE) {
                //usuario docente o administrativo
                $view = 'VW_PERFIL_ALUMNO';
            }

            if ($usuario->TIPO_USUARIO == Constantes::USUARIO_ASPIRANTE) {
                //usuario aspirante
                $view = 'VW_PERFIL_ASPIRANTE';
            }

            if ($usuario->TIPO_USUARIO == Constantes::USUARIO_EXTERNO) {
                //usuario externo
                $view = 'VW_PERFIL_ALUMNO';
            }

            $perfil = DB::table($view)
                ->where('PK_USUARIO', $usuario->PK_USUARIO)
                ->first();
        }

        return ResponseHTTP::response_ok($perfil);
    }

    /**
     *
     */
    public function actualiza_perfil(Request $request)
    {
        $fk_codigo_postal = CodigoPostal::where('NUMERO', $request->CODIGO_POSTAL)->first()->PK_CODIGO_POSTAL;
        $usuario = Usuario::where('PK_USUARIO', $request->PK_USUARIO)->first();

        $usuario->FK_ESTADO_CIVIL = $request->ESTADO_CIVIL;
        $usuario->FK_COLONIA = $request->COLONIA;
        $usuario->FK_CODIGO_POSTAL = $fk_codigo_postal;

        $usuario->FECHA_NACIMIENTO = $request->FECHA_NACIMIENTO;
        $usuario->SEXO = $request->SEXO;
        $usuario->CORREO1 = $request->CORREO1;
        $usuario->CORREO2 = $request->CORREO2;
        $usuario->TELEFONO_CASA = $request->TELEFONO_CASA;
        $usuario->TELEFONO_MOVIL = $request->TELEFONO_MOVIL;
        $usuario->CALLE = $request->CALLE;
        $usuario->NUMERO_EXTERIOR = $request->NUMERO_EXTERIOR;
        $usuario->NUMERO_INTERIOR = $request->NUMERO_INTERIOR;
        $usuario->NOMBRE_CONTACTO = $request->NOMBRE_CONTACTO;
        $usuario->PARENTESCO_CONTACTO = $request->PARENTESCO_CONTACTO;
        $usuario->TELEFONO_CONTACTO = $request->TELEFONO_CONTACTO;
        $usuario->CORREO_CONTACTO = $request->CORREO_CONTACTO;
        $usuario->PERFIL_COMPLETO = 1;

        if ($request->SITUACION_RESIDENCIA) {
            $usuario->FK_SITUACION_RESIDENCIA = $request->SITUACION_RESIDENCIA;
        }
        if ($request->CORREO_INSTITUCIONAL) {
            $usuario->CORREO_INSTITUCIONAL = $request->CORREO_INSTITUCIONAL;
        }
        if ($request->AREA_ACADEMICA) {
            $usuario->FK_AREA_ACADEMICA = $request->AREA_ACADEMICA;
        }

        if ($usuario->save()) {
            return response()->json(true, Response::HTTP_OK);
        } else {
            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }

    public function actualiza_foto_perfil(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario($request->PK_ENCRIPTADA);
        $carpeta = $usuario->NUMERO_CONTROL == '' ? $usuario->PK_USUARIO : $usuario->NUMERO_CONTROL;
        $url = UsuariosHelper::get_url_expediente_usuario(
            $carpeta,
            $usuario->TIPO_USUARIO,
            'perfil'
        );
        $nombre_archivo = md5('perfil_' . $usuario->PK_USUARIO);

        $ruta = Base64ToFile::guarda_archivo($url, $nombre_archivo, $request->EXTENSION, $request->CONTENIDO);

        if ($ruta) {
            $usuario->FOTO_PERFIL = $ruta;
            if ($usuario->save()) {
                return response()->json($ruta, Response::HTTP_OK);
            } else {
                return response()->json(false, Response::HTTP_NOT_FOUND);
            }
        } else {
            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }

    public function get_tipo_usuario(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario_pk($request->pk_usuario);

        if ($usuario) {
            return ResponseHTTP::response_ok($usuario);
        }else {
            return ResponseHTTP::response_error($usuario);
        }
    }
}
