
<html>
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
    @foreach($ASPIRANTE as $ASPIRANTE)
<body>
<div class="imagen">
    <img src="images/arriba.jpg" width="100%" height="25%" style="margin-top: 140px">
</div>
<div align="center" class="titulo">
    <b>
        FORMALIZACIÓN DE FICHA
        <br>
        NUMERO DE "MATRICULA": {{$ASPIRANTE->PREFICHA}}
    </b>
</div>

<div class="datos_registro">
    Tus datos de registro son:
    <br>
    <ul>
        <li>Institución: Instituto Tecnológico de León</li>
        <li>Carrera: {{$ASPIRANTE->NOMBRE_CARRERA}} - Campus {{$ASPIRANTE->CAMPUS}}</li>
        <li>Matrícula: {{$ASPIRANTE->PREFICHA}}</li>
        <li>Folio de CENEVAL: {{$ASPIRANTE->FOLIO_CENEVAL}}</li>
    </ul>
</div>


<table width="100%">
    <tr>
        <td width="8%">Nombre:</td>
        <td width="50%">{{$ASPIRANTE->NOMBRE}} {{$ASPIRANTE->PRIMER_APELLIDO}} {{$ASPIRANTE->SEGUNDO_APELLIDO}}</td>
        <td width="6%">Fima:_____________________________________________</td>
        <td width="50%"><hr size="2" style="color: black"></td>
    </tr>
</table>
<div class="nota">
    <ul>
        <li>
            Examen de CENEVAL {{$ASPIRANTE->DIA}} a las {{$ASPIRANTE->HORA}}.
            <ul>
                <li>
                    Descarga tu guía para el examen CENEVAL, desde esta liga:
                    <a href="https://www.itleon.edu.mx/admision/docs/Guia_EXANI_II.pdf">
                        https://www.itleon.edu.mx/admision/docs/Guia_EXANI_II.pdf
                    </a>
                </li>
                <li>
                    Estudiar temas de las páginas 17 a la 22,
                    página 27 sección 7 (física)
                    página 29 sección 10 (inglés)
                    página 30 sección 11 (lenguaje escrito)
                    y página 31 sección 13 (matemáticas).
                </li>
                <li>
                    Es necesario presentarse con lápiz del número 2,
                    calculadora no científica,
                    goma, sacapuntas
                    y se recomienda traer una botella de agua.
                </li>
            </ul>
        </li>
        <li>
            Debes presentarte en el {{$ASPIRANTE->NOMBRE_EDIFICIO}} (Edificio {{$ASPIRANTE->PREFIJO}})
            del Instituto Tecnológico de León Campus {{$ASPIRANTE->NOMBRE_CAMPUS}},
            en el espacio "{{$ASPIRANTE->NOMBRE_ESPACIO}}",
            el día {{$ASPIRANTE->NOMBRE_DIA}} {{$ASPIRANTE->DIA}} a las {{$ASPIRANTE->HORA}}.
        </li>
        <li>
            Es indispensable que te presentes con tu ficha de admisión,
            pase de ingreso al examen
            y una identificación con fotografía (INE, Pasaporte, Credencial de la escuela).
        </li>
    </ul>
</div>
Fecha de formalización de ficha: {{$ASPIRANTE->FECHA_MODIFICACION}}.
<br>
<br>

<hr>

<div>
    <img src="images/arriba.jpg" width="100%" height="25%">
</div>
<div align="center" class="titulo">
    <b>

        FORMALIZACIÓN DE FICHA
        <br>
        NUMERO DE "MATRICULA": {{$ASPIRANTE->PREFICHA}}
    </b>
</div>

<div class="datos_registro">
    Tus datos de registro son:
    <br>
    <ul>
        <li>Institución: Instituto Tecnológico de León</li>
        <li>Carrera: {{$ASPIRANTE->NOMBRE_CARRERA}} - Campus {{$ASPIRANTE->CAMPUS}}</li>
        <li>Matrícula: {{$ASPIRANTE->PREFICHA}}</li>
        <li>Folio de CENEVAL: {{$ASPIRANTE->FOLIO_CENEVAL}}</li>
    </ul>
</div>


<table width="100%">
    <tr>
        <td width="8%">Nombre:</td>
        <td width="50%">{{$ASPIRANTE->NOMBRE}} {{$ASPIRANTE->PRIMER_APELLIDO}} {{$ASPIRANTE->SEGUNDO_APELLIDO}}</td>
        <td width="6%">Fima:_____________________________________________</td>
        <td width="50%"><hr size="2" style="color: black"></td>
    </tr>
</table>
<div class="nota">
    <ul>
        <li>
            Examen de CENEVAL {{$ASPIRANTE->DIA}} a las {{$ASPIRANTE->HORA}}.
            <ul>
                <li>
                    Descarga tu guía para el examen CENEVAL, desde esta liga:
                    <a href="https://www.itleon.edu.mx/admision/docs/Guia_EXANI_II.pdf">
                        https://www.itleon.edu.mx/admision/docs/Guia_EXANI_II.pdf
                    </a>
                </li>
                <li>
                    Estudiar temas de las páginas 17 a la 22,
                    página 27 sección 7 (física)
                    página 29 sección 10 (inglés)
                    página 30 sección 11 (lenguaje escrito)
                    y página 31 sección 13 (matemáticas).
                </li>
                <li>
                    Es necesario presentarse con lápiz del número 2,
                    calculadora no científica,
                    goma, sacapuntas
                    y se recomienda traer una botella de agua.
                </li>
            </ul>
        </li>
        <li>
            Debes presentarte en el {{$ASPIRANTE->NOMBRE_EDIFICIO}} (Edificio {{$ASPIRANTE->PREFIJO}})
            del Instituto Tecnológico de León Campus {{$ASPIRANTE->NOMBRE_CAMPUS}},
            en el espacio "{{$ASPIRANTE->NOMBRE_ESPACIO}}",
            el día {{$ASPIRANTE->NOMBRE_DIA}} {{$ASPIRANTE->DIA}} a las {{$ASPIRANTE->HORA}}.
        </li>
        <li>
            Es indispensable que te presentes con tu ficha de admisión,
            pase de ingreso al examen
            y una identificación con fotografía (INE, Pasaporte, Credencial de la escuela).
        </li>
    </ul>
</div>
Fecha de formalización de ficha: {{$ASPIRANTE->FECHA_MODIFICACION}}.
</body>
@endforeach
<style type="text/css">
    @page{
        margin-bottom: 10px;
    }
    .imagen{
        margin-top: -160px;
    }
    body {
        font-family: Montserrat;
        font-size: 0.7em;
    }
</style>
</html>