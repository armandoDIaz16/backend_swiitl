<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Espacio extends Model
{
    /* protected $fillable = [
         'PK_ESPACIO',
         'FK_EDIFICIO',
         'FK_TIPO_ESPACIO',
         'NOMBRE',
         'IDENTIFICADOR',
         'CAPACIDAD',
         'FK_USUARIO_REGISTRO',
         'FECHA_REGISTRO',
         'FK_USUARIO_MODIFICACION',
         'FECHA_MODIFICACION',
         'BORRADO'
     ];   */
     protected $table = 'TR_ESPACIO';


    /*
     * SELECT
       PK_ESPACIO,
       TR_ESPACIO.NOMBRE,
       FK_EDIFICIO,
       CONCAT(PREFIJO,IDENTIFICADOR)        AS ESPACIO,
       IDENTIFICADOR,
       SWIITL.dbo.CATR_EDIFICIO.PREFIJO     AS PREFIJO_EDIFICIO,
       SWIITL.dbo.CAT_TIPO_ESPACIO.NOMBRE   AS TIPO_ESPACIO,
       SWIITL.dbo.CATR_CAMPUS.NOMBRE        AS CAMPUS,
       SWIITL.dbo.CATR_TECNM.NOMBRE         AS TECNOLOGICO
FROM
       SWIITL.dbo.TR_ESPACIO
       LEFT JOIN SWIITL.dbo.CAT_TIPO_ESPACIO ON TR_ESPACIO.FK_TIPO_ESPACIO = CAT_TIPO_ESPACIO.PK_TIPO_ESPACIO
       LEFT JOIN SWIITL.dbo.CATR_EDIFICIO    ON TR_ESPACIO.FK_EDIFICIO = CATR_EDIFICIO.PK_EDIFICIO
       LEFT JOIN SWIITL.dbo.CATR_CAMPUS      ON CATR_EDIFICIO.FK_CAMPUS = CATR_CAMPUS.PK_CAMPUS
       LEFT JOIN SWIITL.dbo.CATR_TECNM       ON CATR_CAMPUS.FK_TECNOLOGICO = CATR_TECNM.PK_TECNOLOGICO
WHERE
       SWIITL.dbo.TR_ESPACIO.NOMBRE = 'C1'
;
     */


    public function get_espacio($nombre)
    {
       $pdo = DB::connection('sqlsrv')->select(
           'SELECT
                   PK_ESPACIO,
                   TR_ESPACIO.NOMBRE,
                   FK_EDIFICIO,
                   CONCAT(PREFIJO,IDENTIFICADOR)        AS ESPACIO,
                   IDENTIFICADOR,
                   SWIITL.dbo.CATR_EDIFICIO.PREFIJO     AS PREFIJO_EDIFICIO,
                   SWIITL.dbo.CAT_TIPO_ESPACIO.NOMBRE   AS TIPO_ESPACIO,
                   SWIITL.dbo.CATR_CAMPUS.NOMBRE        AS CAMPUS,
                   SWIITL.dbo.CATR_TECNM.NOMBRE         AS TECNOLOGICO
            FROM
                   SWIITL.dbo.TR_ESPACIO
                   LEFT JOIN SWIITL.dbo.CAT_TIPO_ESPACIO ON TR_ESPACIO.FK_TIPO_ESPACIO = CAT_TIPO_ESPACIO.PK_TIPO_ESPACIO
                   LEFT JOIN SWIITL.dbo.CATR_EDIFICIO    ON TR_ESPACIO.FK_EDIFICIO     = CATR_EDIFICIO.PK_EDIFICIO
                   LEFT JOIN SWIITL.dbo.CATR_CAMPUS      ON CATR_EDIFICIO.FK_CAMPUS    = CATR_CAMPUS.PK_CAMPUS
                   LEFT JOIN SWIITL.dbo.CATR_TECNM       ON CATR_CAMPUS.FK_TECNOLOGICO = CATR_TECNM.PK_TECNOLOGICO
            WHERE
                   SWIITL.dbo.TR_ESPACIO.NOMBRE = :nombre',['nombre' => $nombre]
    );
        return $pdo;
    }
}
