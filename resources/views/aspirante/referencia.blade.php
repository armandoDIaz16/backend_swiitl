@foreach($ASPIRANTE as $ASPIRANTE)
<html>

<head>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
        }

        .footer {
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            /* Set the fixed height of the footer here */
            line-height: 60px;
            /* Vertically center the text there */
            background-color: #1A5276;
        }

        .footer2 {
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            /* Set the fixed height of the footer here */
            line-height: 60px;
            /* Vertically center the text there */
            background-color: #154360;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>REFERENCIA {{$ASPIRANTE->PREFICHA}}</title>
    <style type="text/css"></style>
</head>

<body>

    <div style="margin-left: .5cm; margin-right: .5cm; padding-top: 0cm; font-size: 0.7em;">
        <table>
            <tr>
                <td colspan="2" style="text-align: center">

                    <img src="img/banner-tecnmleon.jpeg" width="300px">

                </td>

            </tr>

            <tr>
                <td>Preficha</td>
                <td>
                    {{$ASPIRANTE->PREFICHA}}
                </td>
            </tr>
            <tr>
                <td>Aspirante</td>
                <td>
                    {{$ASPIRANTE->NOMBRE}}
                </td>
            </tr>
            <tr>
                <td>Concepto de pago</td>
                <td>
                    Solicitud de ficha de pago para examen de admisión.
                </td>
            </tr>
            <tr>
                <td>Fecha límite de pago</td>
                <td>
                    {{$ASPIRANTE->FECHA_LIMITE_PAGO}}</td>
            </tr>
            <tr>
                <td>Importe</td>
                <td>$ {{$ASPIRANTE->MONTO}}.00 M.N.</td>
            </tr>
            <tr>
                <td>Clave CIE</td>
                <td>{{$ASPIRANTE->CLAVE}}</td>
            </tr>
            <tr>
                <td>
                    <font size=6>{{$ASPIRANTE->REFERENCIA}}</font>
                </td>
                <td>
                    <img src="img/bancomer.png" width="140px">
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <footer class="footer">
        <font size=6>Ubicación</font>
            <br>
            <font color="white" size=5>Av Tecnológico S/N Fracc. Industrial Julián de Obregón</font>
            <br>
            <font color="white" size=5>León, Gto. México</font>
            <br>
            <font size=6>Contacto:</font>
            <br>
            <font color="white" size=5>aspirantes@leon.tecnm.mx</font>
            <br>
            <font size=6>Teléfono directo</font>
            <br>
            <font color="white" size=5>(477) 7105-203</font>


        </footer>

        <footer class="footer2">
        <font color="white" size=5>Copyright &copy; TecNM - Sistema de admisión</font>
        </footer>
    </div>
</body>

</html>
@endforeach