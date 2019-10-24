<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h4>Bienvenido a la plataforma TecVirtual del Tecnológico Nacional de México en León</h4>
    <p>
        Para vincular una nueva contraseña a tu cuenta
        <?php
        if (\App\Helpers\Constantes::AMBIENTE) {
            ?>
            <a href="http://tecvirtual.itleon.edu.mx/#/activa-cuenta?token={{$token}}">da clic aquí</a>.
        <?php
        } else {
            ?>
            <a href="http://localhost/#/activa-cuenta?token={{$token}}">da clic aquí</a>.
        <?php
        }
        ?>

        <br><br><br>
        Posteriormente captura el código: <b><u>{{$clave}}</u></b> y escribe una nueva contraseña.
        <br><br><br>
    </p>
    <br>
</body>

</html>