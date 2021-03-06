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
            height: 35px;
            /* Set the fixed height of the footer here */
            line-height: 35px;
            /* Vertically center the text there */
            background-color: #1A5276;
        }

        .footer2 {
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 35px;
            /* Set the fixed height of the footer here */
            line-height: 35px;
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
                    <img src="public/img/banner-tecnmleon.jpeg" width="300px">
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
                    {{$ASPIRANTE->CONCEPTO}}
                </td>
            </tr>
            <tr>
                <td>Fecha l??mite de pago</td>
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
                    <font size=1>N??mero de Referencia</font>
                    <br>
                    <font size=6>{{$ASPIRANTE->REFERENCIA}}</font>
                </td>
                <td>
                    <img src="public/img/bancomer.png" width="140px">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <font size=6>Si la vigencia de la referencia a expirado, descarga una nueva desde la plataforma <a target="blank" href="http://tecvirtual.itleon.edu.mx/"><u>http://tecvirtual.itleon.edu.mx/</u></a></font>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <footer class="footer">
            <font size=6>Ubicaci??n</font>
            <br>
            <font color="white" size=5>Av Tecnol??gico S/N Fracc. Industrial Juli??n de Obreg??n</font>
            <br>
            <font color="white" size=5>Le??n, Gto. M??xico</font>
            <br>
            <font size=6>Contacto:</font>
            <br>
            <font color="white" size=5>aspirantes@leon.tecnm.mx</font>
            <br>
            <font size=6>Tel??fono directo</font>
            <br>
            <font color="white" size=5>(477) 7105-203</font>
        </footer>
        <footer class="footer2">
            <font color="white" size=5>Copyright &copy; TecNM - Sistema de admisi??n</font>
        </footer>
    </div>
</body>

</html>
@endforeach
