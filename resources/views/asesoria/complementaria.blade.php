@foreach($DATA as $DATA)
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>FICHA  </title>
    <style type="text/css"></style>
</head>
<body>

<div style="margin-left: .5cm; margin-right: .5cm; padding-top: -1cm; font-size: 0.7em;">
<div align="center">
    <img src="img/banner.jpg">
</div>
<br>
<br>
<div align="center" class="negrita">
    <b>
    CONSTANCIA DE CUMPLIMIENTO DE ACTIVIDAD COMPLEMENTARIA
    </b>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="negrita">
<b>{{$DATA->DESTINATARIO}}<b>
<br>
<b>JEFE DEL DEPTO. DE SERVICIOS ESCOLARES<b>
<br>
<b>PRESENTE<b>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="negrita">
La que suscribe <b>{{$DATA->SUSCRIBE}}</b>, por este medio hace de su conocimiento que el (la) estudiante <b>{{$DATA->ESTUDIANTE}}</b>, 
con número de control <b>{{$DATA->CONTROL}}</b> de la carrera de <b>{{$DATA->CARRERA}}</b>, ha cumplido su actividad complementaria <b>{{$DATA->ACTIVIDAD}}</b>
 con nivel de desempeño <b>{{$DATA->DESEMPENO}}</b> y un valor numérico de <b>{{$DATA->VALOR}}</b>, durante el periodo <b>{{$DATA->PERIODO}}</b> con valor de 1 crédito.
</div>
<br>
<br>
<br>
<br>
<div class="negrita">
Se extiende la presente en la ciudad de León, Guanajuato a los <b>{{$DATA->EXTIENDE}}</b>.
</div>
<br>
<br>
<br>
<br>
<div class="negrita">
<b>A T E N T A M E N T E
<br>
Excelencia en Educación Tecnológica®
<br>
Ciencia Tecnología y Libertad<b> 
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="negrita">
<table width="100%">
  <tr>
    <th width="50%">{{$DATA->NOMBRE1}}</th>
    <th width="50%">{{$DATA->NOMBRE2}}</th>
  </tr>
  <tr>
  <th width="50%">{{$DATA->CARGO1}}</th>
    <th width="50%">{{$DATA->CARGO2}}</th>
  </tr>
</table>
</div>
</body>
<style>
    .negrita{
        font-size:14;
    }
    .normal{
        font-size:12;
    }
</style>
</html>
@endforeach