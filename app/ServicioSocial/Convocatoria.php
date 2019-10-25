<?php

namespace App\ServicioSocial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Convocatoria extends Model
{
    protected $fillable = [
        'NO_CONTROL_CONV',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    protected $primaryKey = 'PK_CONVOCATORIA';

    public $timestamps = false;

    protected $table = 'CAT_CONVOCATORIA';

    public function datoConvocatorias(){
        return $this-> hasMany(DatoConvocatoria::Class,'FK_CONVOCATOTIA','PK_CONVOCATORIA');
    }

    public function getDataConvocatoria($id){
        return DB::SELECT('SELECT C.NO_CONTROL_CONV,DC.PERIODO,
        DATENAME(year,CONVERT(VARCHAR(10), C.FECHA_REGISTRO, 111)) AS FCY,
        DATEPART(month,CONVERT(VARCHAR(10), C.FECHA_REGISTRO, 111)) AS FCM,
        DATENAME(day,CONVERT(VARCHAR(10), C.FECHA_REGISTRO, 111))  AS FCD,
        DATEPART(month, DC.FECHA_CONVOCATORIA) AS MES,
        DATENAME(day, DC.FECHA_CONVOCATORIA) AS DIANu,
        DATENAME(weekday, DC.FECHA_CONVOCATORIA) AS DIANo,
        DATENAME(year, DC.FECHA_CONVOCATORIA) AS ANIO, DC.TURNO, TE.NOMBRE AS NOMBRE_ESPACIO, E.NOMBRE AS NOMBRE_LUGAR, DC.HORARIO_CONVOCATORIA AS HORARIO FROM CAT_CONVOCATORIA C
        JOIN CATR_DATO_CONVOCATORIA DC ON DC.FK_CONVOCATORIA = C.PK_CONVOCATORIA
        JOIN CATR_ESPACIO E ON E.PK_ESPACIO = DC.FK_ESPACIO_CONVOCATORIA
        JOIN CAT_TIPO_ESPACIO TE ON TE.PK_TIPO_ESPACIO = E.FK_TIPO_ESPACIO
        WHERE C.PK_CONVOCATORIA = :id',['id'=> $id]);
    }

    public function mesMx($n){
        switch($n){
            case '1' : return 'Enero';break;
            case '2' : return 'Febrero';break;
            case '3' : return 'Marzo';break;
            case '4' : return 'Abril';break;
            case '5' : return 'Mayo';break;
            case '6' : return 'Junio';break;
            case '7' : return 'Julio';break;
            case '8' : return 'Agosto';break;
            case '9' : return 'Septiembre';break;
            case '10': return 'Octubre';break;
            case '11': return 'Noviembre';break;
            case '12': return 'Diciembre';break;

        }
    }
    public function diaMx($d){
        switch($d){
            case 'Monday': return "Lunes"; break;
            case 'Tuesday': return "Martes"; break;
            case 'Wednesday': return "Miercoles"; break;
            case 'Thursday': return "Jueves"; break;
            case 'Friday': return "Viernes"; break;
            case 'Saturday': return "Sabado"; break;
            case 'Sunday': return "Domingo"; break;


        }
    }
    public function perName($per){
        if ($per=='ENE-JUN'){
            return array('Enero','Junio');
        }
        else{
            return array('Julio','Diciembre');
        } 
    }

}
