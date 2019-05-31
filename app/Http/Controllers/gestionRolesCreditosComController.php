<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;


class gestionRolesCreditosComController extends Controller
{
    public function getUsuarioByCurp($curp) {
        $usuario = DB::table('users')
                ->select('PK_USUARIO','PRIMER_APELLIDO','SEGUNDO_APELLIDO','name')
                ->where('CURP','=',$curp)
                ->get();
        
                $response = Response::json($usuario);
                return $response;

    }

    public function setRolComite( $pk_usuario ){
        $rol = DB::table('PER_CATR_ROL')
            ->select('PK_ROL')
            ->where('NOMBRE','=','Comite academico')
            ->get()->first();

        DB::table('PER_TR_ROL_USUARIO')
            ->insert(['FK_ROL' => $rol->PK_ROL,
                      'FK_USUARIO' => $pk_usuario]);
    }

    public function setRolJefeCarr( $pk_usuario ){
        $rol = DB::table('PER_CATR_ROL')
            ->select('PK_ROL')
            ->where('NOMBRE','=','Jefe de carrera')
            ->get()->first();

        DB::table('PER_TR_ROL_USUARIO')
            ->insert(['FK_ROL' => $rol->PK_ROL,
                      'FK_USUARIO' => $pk_usuario]);
    }

    public function setRolRespAct( $pk_usuario ){
        $rol = DB::table('PER_CATR_ROL')
            ->select('PK_ROL')
            ->where('NOMBRE','=','Responsable de actividad')
            ->get()->first();

        DB::table('PER_TR_ROL_USUARIO')
            ->insert(['FK_ROL' => $rol->PK_ROL,
                      'FK_USUARIO' => $pk_usuario]);
    }

    public function setRolTutoescolares( $pk_usuario ){
        $sistema = DB::table('PER_CAT_SISTEMA')
            ->select('PK_SISTEMA')
            ->where('NOMBRE','=','Creditos')
            ->get()->first();

        $rol = DB::table('PER_CATR_ROL')
            ->select('PK_ROL')
            ->where('NOMBRE','=','Tutorias-extraescolares')
            ->where('FK_SISTEMA','=',$sistema->PK_SISTEMA)
            ->get()->first();

        DB::table('PER_TR_ROL_USUARIO')
            ->insert(['FK_ROL' => $rol->PK_ROL,
                      'FK_USUARIO' => $pk_usuario]);
    }
}

