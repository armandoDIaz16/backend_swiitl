<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ColoniaCodigoPostal extends Model
{
    /* protected $fillable = [
         'FK_COLONIA',
         'FK_NUMERO_CODIGO_POSTAL',
         'FK_USUARIO_REGISTRO',
         'FECHA_REGISTRO',
         'FK_USUARIO_MODIFICACION',
         'FECHA_MODIFICACION',
         'BORRADO'
     ];
     protected $table = 'TR_COLONIA_CODIGO_POSTAL';
    */

    /*
    SELECT
         FK_NUMERO_CODIGO_POSTAL,
         CATR_COLONIA.NOMBRE AS COLONIA,
         CATR_CIUDAD.NOMBRE AS CIUDAD,
         CAT_ENTIDAD_FEDERATIVA.NOMBRE AS ESTADO
    FROM
         SWIITL.dbo.TR_COLONIA_CODIGO_POSTAL
         LEFT JOIN SWIITL.dbo.CATR_COLONIA             ON TR_COLONIA_CODIGO_POSTAL.FK_COLONIA              = CATR_COLONIA.PK_COLONIA
         LEFT JOIN SWIITL.dbo.CATR_CODIGO_POSTAL       ON TR_COLONIA_CODIGO_POSTAL.FK_NUMERO_CODIGO_POSTAL = SWIITL.dbo.CATR_CODIGO_POSTAL.PK_NUMERO_CODIGO_POSTAL
         LEFT JOIN SWIITL.dbo.CATR_CIUDAD              ON CATR_CODIGO_POSTAL.FK_CIUDAD                     = CATR_CIUDAD.PK_CIUDAD
         LEFT JOIN SWIITL.dbo.CAT_ENTIDAD_FEDERATIVA   ON CATR_CIUDAD.FK_ENTIDAD_FEDERATIVA                = CAT_ENTIDAD_FEDERATIVA.PK_ENTIDAD_FEDERATIVA

    WHERE
         FK_NUMERO_CODIGO_POSTAL = 37280
     */


    public function get_colonia_codigo_postal($CP)
    {
        $pdo = DB::connection('sqlsrv')->select(
            'SELECT
                 FK_NUMERO_CODIGO_POSTAL,
                 CATR_COLONIA.NOMBRE AS COLONIA,
                 CATR_CIUDAD.NOMBRE AS CIUDAD,
                 CAT_ENTIDAD_FEDERATIVA.NOMBRE AS ESTADO
            FROM
                 SWIITL.dbo.TR_COLONIA_CODIGO_POSTAL
                 LEFT JOIN SWIITL.dbo.CATR_COLONIA             ON TR_COLONIA_CODIGO_POSTAL.FK_COLONIA              = CATR_COLONIA.PK_COLONIA
                 LEFT JOIN SWIITL.dbo.CATR_CODIGO_POSTAL       ON TR_COLONIA_CODIGO_POSTAL.FK_NUMERO_CODIGO_POSTAL = SWIITL.dbo.CATR_CODIGO_POSTAL.PK_NUMERO_CODIGO_POSTAL
                 LEFT JOIN SWIITL.dbo.CATR_CIUDAD              ON CATR_CODIGO_POSTAL.FK_CIUDAD                     = CATR_CIUDAD.PK_CIUDAD
                 LEFT JOIN SWIITL.dbo.CAT_ENTIDAD_FEDERATIVA   ON CATR_CIUDAD.FK_ENTIDAD_FEDERATIVA                = CAT_ENTIDAD_FEDERATIVA.PK_ENTIDAD_FEDERATIVA
            WHERE
                 FK_NUMERO_CODIGO_POSTAL = :CP',['CP'=>$CP]
        );
        return $pdo;
    }
}
