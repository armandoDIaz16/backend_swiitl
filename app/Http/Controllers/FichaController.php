<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\DB;
use DateTime;

class FichaController extends Controller
{
    public function descargarFicha($id)
    {
        $fk_aspirante = DB::table('CATR_ASPIRANTE')->where('FK_PADRE', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('users')
        ->select(
            DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
            'CATR_CARRERA.NOMBRE as NOMBRE_CARRERA',
            'CATR_CARRERA.CAMPUS',
            'CATR_ASPIRANTE.FOLIO_CENEVAL',
            'users.name as NOMBRE',
            'users.PRIMER_APELLIDO',
            DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
            'CAT_TURNO.DIA',
            'CAT_TURNO.DIA as NOMBRE_DIA',
            'CAT_TURNO.HORA',
            'CATR_EDIFICIO.NOMBRE as NOMBRE_EDIFICIO',
            'CATR_EDIFICIO.PREFIJO',
            'CAT_CAMPUS.NOMBRE as NOMBRE_CAMPUS',
            'CATR_ESPACIO.NOMBRE as NOMBRE_ESPACIO',
            'CATR_ASPIRANTE.FECHA_MODIFICACION',
        )
        ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CATR_CARRERA', 'CATR_CARRERA.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CATR_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->join('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')
        ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
        ->where([
            ['users.PK_USUARIO', '=', $id],
            ['CATR_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
        ])
        ->get();
        $fecha=$aspirante[0]->FECHA_MODIFICACION;
        $aspirante[0]->FECHA_MODIFICACION = substr($fecha, 8, 2)."/" .substr($fecha, 5, 2). "/".substr($fecha, 0, 4);

        
        $dayofweek = date('w', strtotime($aspirante[0]->NOMBRE_DIA));
        switch ($dayofweek){
                case 0: $dayofweek ="Domingo"; break; 
                case 1: $dayofweek ="Lunes"; break; 
                case 2: $dayofweek ="Martes"; break; 
                case 3: $dayofweek ="Miercoles"; break; 
                case 4: $dayofweek ="Jueves"; break; 
                case 5: $dayofweek ="Viernes"; break; 
                case 6: $dayofweek ="Sabado"; break; 
        }

        $aspirante[0]->NOMBRE_DIA = $dayofweek;

        $dia=$aspirante[0]->DIA;        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $fecha = DateTime::createFromFormat('!m', substr($dia, 5, 2));
        $mes = strftime("%B", $fecha->getTimestamp()); // marzo
        $aspirante[0]->DIA = substr($dia, 8, 2). " de " . $mes . " del " . substr($dia, 0, 4);
        $aspirante[0]->HORA = date("g:i a",strtotime($aspirante[0]->HORA));


        $pdf = Facade::loadView('ficha', ['ASPIRANTE' => $aspirante]);
        return $pdf->download('Ficha '.$aspirante[0]->PREFICHA.'.pdf');      
        
    }
}
