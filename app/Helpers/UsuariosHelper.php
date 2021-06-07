<?php

namespace App\Helpers;

use App\Rol;
use App\User;
use App\Usuario;
use App\Usuario_Rol;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class UsuariosHelper {

    /**
     * @param $curp
     * @param $fecha
     * @return string
     */
    public static function get_token_contrasenia($curp, $fecha) {
        return Hash::make($curp . $fecha);
    }

    /**
     * @param int $longitud
     * @return bool|string
     */
    public static function get_clave_verificacion($longitud = 6) {
        return substr( md5(microtime()), 1, $longitud);
    }


    /**
     * Función para agrear o quitar el rol a los usaurios
     * @param $pk_usuario      string  primary key del usuario
     * @param $abreviatura_rol string  abreviatura registrada en la base de datos
     * @param $asigna_quita    boolean TRUE = asigna rol, FALSE = quita rol
     */
    public static function rol_usuario($pk_usuario, $abreviatura_rol, $asigna_quita) {
        $usuario = self::get_usuario_pk($pk_usuario);
        if ($usuario) {
            $rol = Rol::where('ABREVIATURA', $abreviatura_rol)->first();
            if ($rol) {
                $rol_usuario = Usuario_Rol::where('FK_USUARIO', $usuario->PK_USUARIO)
                    ->where('FK_ROL', $rol->PK_ROL)
                    ->first();
                if ($asigna_quita) {
                    // asigna rol
                    if ($rol_usuario) {
                        // el rol ya existe en el usuario
                        return true;
                    } else {
                        // registrar rol
                        $rol_nuevo = new Usuario_Rol;
                        $rol_nuevo->FK_ROL = $rol->PK_ROL;
                        $rol_nuevo->FK_USUARIO = $usuario->PK_USUARIO;
                        return $rol_nuevo->save();
                    }
                } else {
                    // quita rol
                    if ($rol_usuario) {
                        // el rol existe, se elimina
                        return $rol_usuario->delete();
                    } else {
                        // no tiene el rol asignado
                        return true;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $numero_control
     * @return |null
     */
    public static function get_usuario_pk($pk_usuario) {
        if ($pk_usuario) {
            $usuario = Usuario::find($pk_usuario);
            if ($usuario) {
                return $usuario;
            }
        }

        return null;
    }

    /**
     * @param $numero_control
     * @return |null
     */
    public static function get_usuario_numero_control($numero_control) {
        if ($numero_control) {
            $usuario = Usuario::where('NUMERO_CONTROL', $numero_control)->first();
            if ($usuario) {
                return $usuario;
            }
        }

        return null;
    }

    /**
     * @param $pk_encriptada
     * @return |null
     */
    public static function get_usuario($pk_encriptada) {
        if ($pk_encriptada) {
            $usuario = Usuario::where('PK_ENCRIPTADA', $pk_encriptada)->first();
            if ($usuario) {
                return $usuario;
            }
        }

        return null;
    }

    /**
     * @param $numero_control Debe ser numero de control, de siia o de ficha
     * @param $tipo_usuario   El tipo de usuario de la base de datos
     * @param $subirectorio   Directorio al que se desea acceder para guardar
     * @return null
     */
    public static function get_url_expediente_usuario($numero_control, $tipo_usuario, $subirectorio) {
        $url = null;

        switch ($tipo_usuario) {
            case 1:
                // el usuario es alumno
                $numero_control = mb_ereg_replace("[a-zA-Z]","", $numero_control);

                $anio =
                    substr(date('Y'), 0,2)
                    .substr($numero_control, 0, 2);

                $url =
                    'usuarios/alumnos/'
                    .$anio.'/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            case 2:
                // el usuario es docente o administrativo
                $numero_control = trim($numero_control);
                $url =
                    'usuarios/empleados/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            case 3:
                // el usuario es aspirante
                $periodo = substr(trim($numero_control), 0, 4);

                $numero_control = mb_ereg_replace("[a-zA-Z]","", $numero_control);

                $anio =
                    substr(date('Y'), 0,2)
                    .substr($numero_control, 0, 2);

                $url =
                    'usuarios/aspirantes'
                    .$anio.'/'
                    .$periodo.'/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            case 4:
                // el usuario es usuario externo
                $numero_control = trim($numero_control);
                $url =
                    'usuarios/empleados/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            default: break;
        }

        // validar si existe la carpeta
        if (!is_dir($url)) {
            // crear directorio
            mkdir($url, 0777, true);
        }

        return $url;
    }
}
