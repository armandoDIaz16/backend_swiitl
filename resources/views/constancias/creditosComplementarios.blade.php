<?php
use Carbon\Carbon;

$fecha = Carbon::today()->formatLocalized('%d/%B/%Y');
$fecha2 = Carbon::today()->formatLocalized('%d de %B del %Y');

$carrera = DB::connection('sqlsrv2')->table('view_alumnos as va')
                    ->join('view_carreras as vc','va.ClaveCarrera','=','vc.ClaveCarrera')
                    ->select('vc.Nombre as CARRERA')
                    ->where('va.NUMEROCONTROL','=',$DATOS->NUMERO_CONTROL)
                    ->get()->first();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Constancia de acreditacion de actividad complementaria</title>
    <style type="text/css"></style>
</head>
<body>
<?php $ind = 0; ?>
<div style="margin-left: 1cm; margin-right: 1cm; padding-top: 3cm;">
    <p align="right" style="font-size: 0.8em;">
        León, Guanajuato, {{$fecha}}<br>
        <br>MEMORANDUM B7-006-2019
        <br>DEPTO. DE SISTEMAS Y COMPUTACIÓN
    </p>
    <br>
    <div  class="extrabold" style="font-size: 0.9em;">
    <p align="justify"><b>
            MTI. EDGAR MANUEL DELGADO TOLENTINO
            JEFE DEL DEPTO. DE SERVICIOS ESCOLARES
            PRESENTE</b></p>
    </div>
    <div style="font-size: 0.9em; font-family: montserrat;">
    <p align="justify">
        El que suscribe ____________ , por este medio me permito hacer de su conocimiento que el (la) estudiante
        <b>{{$DATOS->PRIMER_APELLIDO}} {{$DATOS->SEGUNDO_APELLIDO}} {{$DATOS->name}}</b> con numero de control <b>{{$DATOS->NUMERO_CONTROL}}</b>
        de la carrera de <b>{{$carrera->CARRERA}}</b> ha cumplido con la actividad complementaria <b>"{{$DATOS->NOMBRE}}"</b>
        con el nivel de desempeño <b>{{$DATOS->CALIFICACION}}</b> durante el periodo escolar <b>{{$DATOS->PERIODO}}</b> con un valor curricular
        de 1 credito.
    </p>
    <br>
    <br>
    <p align="justify">
        Se extiende la presente en la ciudad de Leon, Guanajuato a {{$fecha2}}
    </p>
    </div>
    <br>
    <br>
    <br>
    <div  class="extrabold" style="font-size: 0.9em;">
    <b >A T E N T A M E N T E </b>
    </div>
    <div id="atentamente" style="font-size: 0.8em">
        <i>Excelencia en Educación Tecnológica</i>
    </div>
    <div id="atentamente2" style="font-size: 0.7em">
        <i>Ciencia, Tecnología y Libertad</i>
   </div>
    <br>
 <!--  
    <div  class="extrabold" style="font-size: 0.9em;">
            <p align="left" >
                <b>
                    <br>
                    JEFE
                    DEPTO. SISTEMAS Y COMPUTACIÓN
                </b>
            </p>
    </div>
    <p id="ccp" style="font-size: 0.7em;" > C.p. DEPTO. DE GESTIÓN TECNOLÓGICA Y VINCULACIÓN <br> C.p. ASESOR EXTERNO <br> C.p. ASESOR DOCENTE
    <br> C.p. SERVICIOS ESCOLARES <br> C.p. DIVISIÓN DE ESTUDIOS <br> C.p. ALUMNO <br> C.p. ARCHIVO </p>
</div> -->
<p style="page-break-before: always">
</body>
</html>