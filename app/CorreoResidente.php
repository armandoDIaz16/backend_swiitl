<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CorreoResidente extends Model
{
    public function correo($id) {
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :nom',['nom'=>$id]);
        $area1 = json_decode(json_encode($area), true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);

        $correos = DB::select('SELECT email FROM users JOIN CATR_ALUMNO ON users.PK_USUARIO = CATR_ALUMNO.ID_PADRE
                                      JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.PK_CARRERA
                                      WHERE FK_AREA_ACADEMICA = :aca',['aca'=>$area3]);
        return $correos;
    }
}
