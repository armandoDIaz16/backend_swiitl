<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformacionActaCalificacion extends Model
{
    protected $table = 'CAT_CARTA_CALIFICACION_RESIDENCIA';
    public $timestamps = false;
    protected $primaryKey = 'PK_CARTA_CALIFICACION_RESIDENCIA';
    protected $fillable = ['FOLIO_ASIGNADO','FECHA','NUMERO_CONTROL'];

    public function LetraPeriodo() {
       $mes = date('n');

       if($mes <= 6){
           $Letra = 'F';
       }
       else{
           $Letra = 'A';
       }
       return $Letra;
    }
}
