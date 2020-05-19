@foreach($ASPIRANTE as $ASPIRANTE)
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>FICHA {{$ASPIRANTE->PREFICHA}}</title>
    <style type="text/css"></style>
</head>

<body>

    <div style="margin-left: .5cm; margin-right: .5cm; padding-top: -1.5cm; font-size: 0.7em;">
        <div align="center">
            {{-- producción: public/img/banner_2020.png --}}
            {{-- local:      img/banner_2020.png --}}
            <img src="public/img/banner_2020.png">
        </div>

        <div align="center">
            <b>
                FORMALIZACIÓN DE FICHA
                <br>
                NÚMERO DE "MATRICULA": {{$ASPIRANTE->PREFICHA}}
            </b>
        </div>

        <div>
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
                <td width="6%">Firma:</td>
                <td width="50%">
                    <hr size="2" style="color: black">
                </td>
            </tr>
        </table>


        <div>
            <ul>
                <li>
                    Examen CENEVAL.
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
                    {{$ASPIRANTE->MENSAJE}}
                </li>
                <li>
                    Es indispensable que te presentes con tu ficha de admisión,
                    pase de ingreso al examen
                    y una identificación con fotografía (INE, Pasaporte, Credencial de la escuela).
                </li>
                {{--<li>
                    Examen de ingles.
                    Deberas presentarte en el {{$ASPIRANTE->NOMBRE_EDIFICIO_INGLES}} (Edificio {{$ASPIRANTE->PREFIJO_INGLES}})
                    del Instituto Tecnológico de León Campus {{$ASPIRANTE->NOMBRE_CAMPUS_INGLES}},
                    en el espacio "{{$ASPIRANTE->NOMBRE_ESPACIO_INGLES}}-{{$ASPIRANTE->IDENTIFICADOR_INGLES}}",
                    el día {{$ASPIRANTE->NOMBRE_DIA_INGLES}} {{$ASPIRANTE->DIA_INGLES}} a las {{$ASPIRANTE->HORA_INGLES}}.
                </li>--}}
            </ul>
        </div>
        Fecha de formalización de ficha: {{$ASPIRANTE->FECHA_MODIFICACION}}.
        <br><br>
        <hr>

        <div align="center">
            <img src="public/img/banner_2020.png">
        </div>


        <div align="center" class="titulo">
            <b>

                FORMALIZACIÓN DE FICHA
                <br>
                NÚMERO DE "MATRICULA": {{$ASPIRANTE->PREFICHA}}
            </b>
        </div>


        <div>
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
                <td width="6%">Firma:</td>
                <td width="50%">
                    <hr size="2" style="color: black">
                </td>
            </tr>
        </table>



        <div>
            <ul>
                <li>
                    Examen CENEVAL.
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
                    {{$ASPIRANTE->MENSAJE}}
                </li>
                <li>
                    Es indispensable que te presentes con tu ficha de admisión,
                    pase de ingreso al examen
                    y una identificación con fotografía (INE, Pasaporte, Credencial de la escuela).
                </li>
                {{--<li>
                    Examen de ingles.
                    Deberas presentarte en el {{$ASPIRANTE->NOMBRE_EDIFICIO_INGLES}} (Edificio {{$ASPIRANTE->PREFIJO_INGLES}})
                    del Instituto Tecnológico de León Campus {{$ASPIRANTE->NOMBRE_CAMPUS_INGLES}},
                    en el espacio "{{$ASPIRANTE->NOMBRE_ESPACIO_INGLES}}-{{$ASPIRANTE->IDENTIFICADOR_INGLES}}",
                    el día {{$ASPIRANTE->NOMBRE_DIA_INGLES}} {{$ASPIRANTE->DIA_INGLES}} a las {{$ASPIRANTE->HORA_INGLES}}.
                </li>--}}
            </ul>
        </div>
        Fecha de formalización de ficha: {{$ASPIRANTE->FECHA_MODIFICACION}}.
    </div>

</body>

</html>
@endforeach
