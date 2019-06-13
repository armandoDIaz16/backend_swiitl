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
<div align="right" class="negrita">
León,Gto., {{$DATA->FECHA}}
<br>
OFICIO No. {{$DATA->OFICIO}}
<br>
DEPTO. DE DESARROLLO ACADÉMICO
<br>
<br>
ASUNTO: {{$DATA->ASUNTO}}
</div>
<br>
<br>
<div align="left" class="negrita">
<b>{{$DATA->DIRECTOR}}
<br>
DIRECTOR DEL INSTITUTO TECNOLÓGICO DE LEÓN
<br>
PRESENTE</b>
</div>
<br>
<div align="right" class="negrita">
<b>At´n: {{$DATA->ATENCION}}
<br>
ENCARGADA DEL DEPTO. GESTIÓN
<br>
TECNOLÓGICA Y VINCULACIÓN</b>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="negrita">
 El prestador de Servicio Social: <b>C. {{$DATA->PRESTADOR}}</b> alumno de la carrera de
 <b>{{$DATA->CARRERASER}}</b>, con número de control <b>{{$DATA->CONTROLSER}}</b> en el periodo <b>{{$DATA->PERIODOSER}}</b>,
  en su carácter de <b>{{$DATA->CARACTER}}</b> a acumulando un total de 480 hrs. en el desarrollo del 
 programa denominado:
<br>
<br>
<br>
<b>Asesoría Académica entre Estudiantes</b>
<br>
<br>
<br>
En la ciudad de León, Gto., a los <b>{{$DATA->DIASMES}}</b>, se emite la presente
 Constancia de Terminación de Servicio Social, para los fines que al interesado convengan.
<br>
<br>
<br>
Atentamente
</div>
<br>
<br>
<br>
<br>
<br>
<div class="negrita">
<table width="100%">
  <tr>
    <th width="50%"><hr size="2" style="color: black"></th>
    <th width="50%"><hr size="2" style="color: black"></th>
  </tr>
  <tr>
  <th width="50%">{{$DATA->ATENTAMENTE}}></th>
  <th width="50%">Sello de la Dependencia/Empresa</th>
  </tr>
  <tr>
  <th width="50%">JEFA DEL DEPTO. DESARROLLO ACADÉMICO</th>
  <th width="50%"></th>
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