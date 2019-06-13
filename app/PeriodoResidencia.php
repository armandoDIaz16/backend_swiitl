<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\CreditosSiia;

class PeriodoResidencia extends Model
{
    protected $table = 'CAT_PERIODO_RESIDENCIA';
    public $timestamps = false;
    protected $primaryKey = 'PK_PERIODO';
    protected $fillable = ['FK_AREA_ACADEMICA','ID_PROCESO','FECHA_INICIO','FECHA_FIN','PERIODO'];

    public function FIniA($area, $proceso){
        $areaa = DB::select('SELECT CATR_CARRERA.FK_AREA_ACADEMICA
                                    FROM CATR_CARRERA
                                    JOIN CATR_ALUMNO ON CATR_CARRERA.PK_CARRERA = CATR_ALUMNO.CLAVE_CARRERA
                                    JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
                                    WHERE users.PK_USUARIO = :id',['id'=>$area]);

        $areaa1 = json_decode(json_encode($areaa),true);
        $areaa2 = array_pop($areaa1);
        $areaa3 = array_pop($areaa2);

        $periodo = new CreditosSiia();
        $periodoactual = $periodo->periodo();

        $Fecha = DB::select('SELECT FECHA_INICIO
                                    FROM CAT_PERIODO_RESIDENCIA
                                    WHERE ID_PROCESO = :proceso
                                    AND PERIODO = :periodo
                                    AND (FK_AREA_ACADEMICA = :area OR FK_AREA_ACADEMICA = 5)',['proceso'=>$proceso,'area'=>$areaa3,'periodo'=>$periodoactual]);
        $Fecha1 = json_decode(json_encode($Fecha),true);
        $Fecha2 = array_pop($Fecha1);
        $Fecha3 = array_pop($Fecha2);
        return $Fecha3;
    }

    public function FFinA($area, $proceso){
        $areaa = DB::select('SELECT CATR_CARRERA.FK_AREA_ACADEMICA
                                    FROM CATR_CARRERA
                                    JOIN CATR_ALUMNO ON CATR_CARRERA.PK_CARRERA = CATR_ALUMNO.CLAVE_CARRERA
                                    JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
                                    WHERE users.PK_USUARIO = :id',['id'=>$area]);

        $areaa1 = json_decode(json_encode($areaa),true);
        $areaa2 = array_pop($areaa1);
        $areaa3 = array_pop($areaa2);

        $periodo = new CreditosSiia();
        $periodoactual = $periodo->periodo();

        $Fecha = DB::select('SELECT FECHA_FIN
                                    FROM CAT_PERIODO_RESIDENCIA
                                    WHERE ID_PROCESO = :proceso
                                    AND PERIODO = :periodo
                                    AND (FK_AREA_ACADEMICA = :area OR FK_AREA_ACADEMICA = 5)',['proceso'=>$proceso,'area'=>$areaa3,'periodo'=>$periodoactual]);
        $Fecha1 = json_decode(json_encode($Fecha),true);
        $Fecha2 = array_pop($Fecha1);
        $Fecha3 = array_pop($Fecha2);
        return $Fecha3;
    }

    public function FIniD($area, $proceso){
        $areaa = DB::select('SELECT CATR_DOCENTE.ID_AREA_ACADEMICA
                                    FROM CATR_DOCENTE
                                    JOIN users ON CATR_DOCENTE.ID_PADRE = users.PK_USUARIO
                                    WHERE PK_USUARIO = :id',['id'=>$area]);

        $areaa1 = json_decode(json_encode($areaa),true);
        $areaa2 = array_pop($areaa1);
        $areaa3 = array_pop($areaa2);

        $periodo = new CreditosSiia();
        $periodoactual = $periodo->periodo();

        $Fecha = DB::select('SELECT FECHA_INICIO
                                    FROM CAT_PERIODO_RESIDENCIA
                                    WHERE ID_PROCESO = :proceso
                                    AND PERIODO = :periodo
                                    AND (FK_AREA_ACADEMICA = :area OR FK_AREA_ACADEMICA = 5)',['proceso'=>$proceso,'area'=>$areaa3,'periodo'=>$periodoactual]);
        $Fecha1 = json_decode(json_encode($Fecha),true);
        $Fecha2 = array_pop($Fecha1);
        $Fecha3 = array_pop($Fecha2);
        return $Fecha3;
    }

    public function FFinD($area, $proceso){
        $areaa = DB::select('SELECT CATR_DOCENTE.ID_AREA_ACADEMICA
                                    FROM CATR_DOCENTE
                                    JOIN users ON CATR_DOCENTE.ID_PADRE = users.PK_USUARIO
                                    WHERE PK_USUARIO = :id',['id'=>$area]);

        $areaa1 = json_decode(json_encode($areaa),true);
        $areaa2 = array_pop($areaa1);
        $areaa3 = array_pop($areaa2);

        $periodo = new CreditosSiia();
        $periodoactual = $periodo->periodo();

        $Fecha = DB::select('SELECT FECHA_FIN
                                    FROM CAT_PERIODO_RESIDENCIA
                                    WHERE ID_PROCESO = :proceso
                                    AND PERIODO = :periodo
                                    AND (FK_AREA_ACADEMICA = :area OR FK_AREA_ACADEMICA = 5)',['proceso'=>$proceso,'area'=>$areaa3,'periodo'=>$periodoactual]);
        $Fecha1 = json_decode(json_encode($Fecha),true);
        $Fecha2 = array_pop($Fecha1);
        $Fecha3 = array_pop($Fecha2);
        return $Fecha3;
    }
}
