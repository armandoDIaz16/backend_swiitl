<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h4>Bienvenido a la plataforma TecVirtual del Tecnológico Nacional de México en León</h4>
<p>
    Para vincular una nueva contraseña a tu cuenta
    @if(\App\Helpers\Constantes::AMBIENTE)
        <a href="http://tecvirtual.itleon.edu.mx/#/activa-cuenta?token={{$token}}">da clic aquí</a>.
    @elseif
        <a href="http://localhost/#/activa-cuenta?token={{$token}}">da clic aquí</a>.
    @endif
    <br><br>
    O copia y pega el siguiente enlace en una ventana nueva del navegador:
    <br>

    @if(\App\Helpers\Constantes::AMBIENTE)
        http://tecvirtual.itleon.edu.mx/#/activa-cuenta?token={{$token}}
    @elseif
        http://localhost/#/activa-cuenta?token={{$token}}
    @endif

    <br><br><br>
    Posteriormente captura el código: <b><u>{{$clave}}</u></b> y escribe una nueva contraseña.
    <br><br><br>
</p>
<br>
</body>
</html>
