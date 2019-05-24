<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConvenioContrato extends Model
{
    public function Informacion($id){
        $empresa = DB::select('select * from CAT_INFO_EMPRESA where PK_INFO_EMPRESA = :pk',['pk'=>$id]);
        return $empresa;
    }

    public function mes() {
        $mes = date('n');
        $mesLetra =  null;
        switch ($mes){
            case 1:
                $mesLetra = 'Enero';
                break;
            case 2:
                $mesLetra = 'Febrero';
                break;
            case 3:
                $mesLetra = 'Marzo';
                break;
            case 4:
                $mesLetra = 'Abril';
                break;
            case 5:
                $mesLetra = 'Mayo';
                break;
            case 6:
                $mesLetra = 'Junio';
                break;
            case 7:
                $mesLetra = 'Julio';
                break;
            case 8:
                $mesLetra = 'Agosto';
                break;
            case 9:
                $mesLetra = 'Septiembre';
                break;
            case 10:
                $mesLetra = 'Octubre';
                break;
            case 11:
                $mesLetra = 'Noviembre';
                break;
            case 12:
                $mesLetra = 'Diciembre';
                break;
        }
        return $mesLetra;
    }

    public function mes2() {
        $mes = date('n');
        $mesLetra =  null;
        switch ($mes){
            case 1:
                $mesLetra = 'ENERO';
                break;
            case 2:
                $mesLetra = 'FEBRERO';
                break;
            case 3:
                $mesLetra = 'MARZO';
                break;
            case 4:
                $mesLetra = 'ABRIL';
                break;
            case 5:
                $mesLetra = 'MAYO';
                break;
            case 6:
                $mesLetra = 'JUNIO';
                break;
            case 7:
                $mesLetra = 'JULIO';
                break;
            case 8:
                $mesLetra = 'AGOSTO';
                break;
            case 9:
                $mesLetra = 'SEPTIEMBRE';
                break;
            case 10:
                $mesLetra = 'OCTUBRE';
                break;
            case 11:
                $mesLetra = 'NOVIEMBRE';
                break;
            case 12:
                $mesLetra = 'DICIEMBRE';
                break;
        }
        return $mesLetra;
    }
}
