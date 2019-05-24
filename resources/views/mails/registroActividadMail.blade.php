<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<div style="font-family: 'Arial Black', Gadget, sans-serif; padding: 5px; border-left-style: solid; border-left-color: #41AFC2" >
    <p><h3>{{ $name }}, te has sido registrado en la actividad: </h3> </p>
    <div style="padding-left: 20px;">
    <p>{{ $name_act }}</p>
    <p>{{ $fecha }}</p>
    <p>{{ $lugar }} - {{ $hora }}</p>
    </div>
    <hr/>
    <p> <b>Descarga el codigo qr que viene adjunto, ya que sera tu pase para el evento</b> </p>
</div>
</html>