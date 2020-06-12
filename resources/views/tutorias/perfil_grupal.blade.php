<<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Perfil Grupal de Ingreso</title>
    <style type="text/css">
        table .gris {
            background-color: rgb(178, 179, 179);
        }

        p > *, p {
            font-size: .8em;
        }

        .p1 {
            font-size: 1em;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- INICIO ESTILOS ENCABEZADO -->
<htmlpageheader name="MyHeader1">
</htmlpageheader>
<!-- FIN ESTILOS ENCABEZADO -->

<!-- INICIO ESTILOS FOOTER -->
<htmlpagefooter name="MyFooter1">
    <table width="100%">
        <tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;"></span></td>
            <td width="33%" style="text-align: center; "></td>
            <td width="33%" align="right" style="font-style: italic; font-size: .6em">
                Página {PAGENO} de {nbpg}
            </td>
        </tr>
    </table>
</htmlpagefooter>
<!-- FIN ESTILOS FOOTER -->

<!-- FIJAR ENCABEZADO -->
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>

<!-- FIJAR FOOTER -->
<sethtmlpagefooter name="MyFooter1" value="on"/>

<!-- INICIO CONTENIDO -->
<div>
    <table width="100%">
        <tr>
            <td width="50%" align="left">
                <img src="{{public_path('img/comun/sep_marca_agua.png')}}" alt="">
            </td>
            <td width="50%" align="right">
                <img src="{{public_path('img/comun/tecnm_itl_gris_marca_agua.png')}}" alt="">
            </td>
        </tr>
    </table>
</div>

<div>
    <p class="p1 bold" align="center">PERFIL GRUPAL DE INGRESO</p>
    <table width="100%" border="1" cellpadding="7px" cellspacing="0" bordercolor="#000000">
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">DATOS GENERALES</p>
            </td>
        </tr>
        <tr>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">NOMBRE DEL TUTOR: <u>{{$tutor}}</u></p>
            </td>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">
                    PERIODO: <u>{{$periodo}}</u>
                </p>
                <p class="bold">
                    FECHA DE CONSULTA: <u>{{date('j-m-Y')}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">ASPECTOS ACADÉMICOS</p>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <p class="bold">GRUPO: <u>{{$grupo}}</u></p>
            </td>
            <td width="25%">
                <p class="bold">N° DE ALUMNOS: <u>{{$cantidad_alumnos}}</u></p>
            </td>
            <td width="25%">
                <p class="bold">SEMESTRE: <u>1</u></p>
            </td>
            <td width="25%">
                <p class="bold">CARRERA: <u>{{$carrera}}</u></p>
            </td>
        </tr>
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">
                    INDICADORES DE ÁREAS DE OPORTUNIDAD Y/O FORTALEZAS
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Datos Personales</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                <p>
                    <b>Sexo:</b>
                    <br>
                    @foreach($personales['sexo'] as $item)
                        <u>{{$item->ITEM}} ({{$item->PROMEDIO}}%)</u>,
                    @endforeach
                </p>
                <p>
                    <b>Edad:</b>
                    <br>
                    @foreach($personales['edad'] as $item)
                        @if($item->ITEM == 0)
                            <u>No definido ({{$item->PROMEDIO}}%)</u>,
                        @else
                            <u>{{$item->ITEM}} ({{$item->PROMEDIO}}%)</u>,
                        @endif
                    @endforeach
                </p>
                <p>
                    <b>Edo. Civil: </b>
                    <br>
                    @foreach($personales['estado_civil'] as $item)
                        <u>{{$item->ITEM}} ({{$item->PROMEDIO}}%)</u>,
                    @endforeach
                </p>
                <p>
                    <b>Colonia donde vive:</b>
                    <br>
                    <?php $ind = 0 ?>
                    @foreach($personales['colonia'] as $item)
                        @if($ind == 5)
                            break;
                        @else
                            <u>{{$item->ITEM}} ({{$item->PROMEDIO}}%)</u>,
                            <?php $ind++ ?>
                        @endif
                    @endforeach
                </p>
                <p>
                    <b>Lugar de residencia:</b>
                    <br>
                    @foreach($personales['situacion_residencia'] as $item)
                        <u>{{$item->ITEM}} ({{$item->PROMEDIO}}%)</u>,
                    @endforeach
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Académica</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                {{--<p>
                    <b>Tipo de preparatoria:</b>
                    @foreach($data['academico']['tipo_escuela'] as $tipo_escuela)
                        <br>
                        <u>{{$tipo_escuela->PROMEDIO}}% {{$tipo_escuela->ETIQUETA}}</u>
                    @endforeach
                </p>

                <p>
                    <b>Área:</b>
                    <br>
                    @foreach($data['academico']['areas'] as $area)
                        <u>{{$area->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>Promedio de calificación de preparatoria:</b>
                    @foreach($data['academico']['promedios'] as $promedio)
                        <br>
                        <u>{{$promedio->PROMEDIO}}% {{$promedio->ETIQUETA}}</u>
                    @endforeach
                </p>
                <p>
                    <b>Materias difíciles:</b>
                    @foreach($data['academico']['materias_dificiles'] as $materia_dificil)
                        <br>
                        <u>{{$materia_dificil->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>ITL como primera opción:</b>
                    @foreach($data['academico']['itl_primera_opcion'] as $itl_primera)
                        <br>
                        <u>{{$itl_primera->PROMEDIO}}% {{$itl_primera->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>Carrera actual como primera opción:</b>
                    @foreach($data['academico']['carrera_primera_opcion'] as $carrera_primera)
                        <br>
                        <u>{{$carrera_primera->PROMEDIO}}% {{$carrera_primera->ETIQUETA}}</u>,
                    @endforeach
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Socioeconómica</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                {{--<p>
                    <b>Nivel Socioeconómico:</b> <u>{{$data['socioeconomica']['nivel_socioeconomico']}}</u>
                </p>
                <p>
                    <b>¿Con quién vive?</b>
                    @foreach($data['socioeconomica']['quien_vive'] as $quien_vive)
                        <br>
                        <u>{{$quien_vive->PROMEDIO}}% {{$quien_vive->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>¿Trabaja?</b>
                    @foreach($data['socioeconomica']['trabaja'] as $trabaja)
                        <br>
                        <u>{{$trabaja->PROMEDIO}}% {{$trabaja->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>¿Quién aporta $ para sus estudios?</b>
                    @foreach($data['socioeconomica']['aporta_dinero'] as $aporta_dinero)
                        <br>
                        <u>{{$aporta_dinero->PROMEDIO}}% {{$aporta_dinero->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>Escolaridad del padre</b>
                    @foreach($data['socioeconomica']['escolaridad_padre'] as $escolaridad_padre)
                        <br>
                        <u>{{$escolaridad_padre->PROMEDIO}}% {{$escolaridad_padre->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <b>Escolaridad de la madre</b>
                    @foreach($data['socioeconomica']['escolaridad_madre'] as $escolaridad_madre)
                        <br>
                        <u>{{$escolaridad_madre->PROMEDIO}}% {{$escolaridad_madre->ETIQUETA}}</u>,
                    @endforeach
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Familiar</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de: (dos primeros porcentajes)</p>
                {{--<p>
                    <b>Tipo de familia</b>
                    @foreach($data['familiar']['tipo_familia'] as $tipo_familia)
                        <br>
                        <u>{{$tipo_familia->PROMEDIO}}% {{$tipo_familia->ETIQUETA}}</u>,
                    @endforeach
                </p>
                <p>
                    <br>
                    <b>Condición familiar en aspectos excelentes y deficientes:</b>
                    <br>
                    @foreach($data['familiar']['aspectos'] as $aspectos)
                        - {{$aspectos->PLANTEAMIENTO}}
                        <br>
                        @foreach($aspectos->RESPUESTAS as $aspecto)
                            <u>{{$aspecto->RESPUESTA}}
                                ( {{number_format((($aspecto->CANTIDAD / $data['cantidad_alumnos']) * 100), 0)}}% )</u>,
                        @endforeach
                        <br>
                    @endforeach
                </p>
                <br>
                <p class="bold">
                    FACE 20 ESP
                </p>
                <p>
                    <br>
                    <b>Nivel de cohesión:</b>
                    <u>{{$data['familiar']['cohesion']['nivel']}}</u>
                    <br>
                    <b>Tipo de familia por cohesión:</b>
                    <u>{{$data['familiar']['cohesion']['tipo_familia']}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$data['familiar']['cohesion']['explicacion']}}</u>
                    <br>
                    <br>
                    <b>Nivel de adaptabilidad:</b>
                    <u>{{$data['familiar']['adaptabilidad']['nivel']}}</u>
                    <br>
                    <b>Tipo de familia por adaptabilidad:</b>
                    <u>{{$data['familiar']['adaptabilidad']['tipo_familia']}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$data['familiar']['adaptabilidad']['explicacion']}}</u>
                    <br>
                    <br>
                    <b>Nivel de funcionamiento:</b>
                    <u>{{$data['familiar']['funcionamiento']['nivel']}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$data['familiar']['funcionamiento']['explicacion']}}</u>
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Pasatiempos</p>
            </td>
            <td colspan="3">
                {{--<p>
                    <b>Mencionar las actividades que más realiza en su tiempo libre:</b>
                <ol>
                    <li>{{$data['pasatiempos'][0]->ETIQUETA}}</li>
                    <li>{{$data['pasatiempos'][1]->ETIQUETA}}</li>
                    <li>{{$data['pasatiempos'][2]->ETIQUETA}}</li>
                </ol>

                <b>Mencionar las actividades que menos hace en su tiempo libre:</b>
                <ol>
                    <li>{{$data['pasatiempos'][12]->ETIQUETA}}</li>
                    <li>{{$data['pasatiempos'][13]->ETIQUETA}}</li>
                    <li>{{$data['pasatiempos'][14]->ETIQUETA}}</li>
                </ol>
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Salud</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de</p>
                {{--<p>
                    <b>En general ¿Cómo calificas tu salud física?</b>
                    @foreach($data['salud']['salud_fisica'] as $salud_fisica)
                        <br>
                        <u>{{$salud_fisica->PROMEDIO}}% {{$salud_fisica->ETIQUETA}}</u>,
                    @endforeach
                </p>
                --}}{{--<p>Mencionar 1-4, 6, 7, 8, 11, 12 sólo si su respuesta es SÍ</p>--}}{{--
                <p>
                    <br>
                    <b>Evaluación de habilidades:</b>
                    @foreach($data['salud']['habilidades'] as $pregunta)
                        <br>
                        - {{$pregunta->PLANTEAMIENTO}}
                        <br>
                        @foreach($pregunta->RESPUESTAS as $respuesta)
                            <u>{{$respuesta->RESPUESTA}}
                                ( {{number_format((($respuesta->CANTIDAD / $data['cantidad_alumnos']) * 100), 0)}}%
                                )</u>,
                        @endforeach
                    @endforeach
                </p>
                <p>
                    <br>
                    <b>La mayor parte del tiempo me siento:</b>
                    @foreach($data['salud']['sentimiento'] as $sentimiento)
                        <br>
                        <u>{{$sentimiento->PROMEDIO}}% {{$sentimiento->ETIQUETA}}</u>,
                    @endforeach
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Hábitos de estudio</p>
            </td>
            <td colspan="3">
                {{--<p>
                    <b>Puntos fuertes.</b>
                <ol>
                    @foreach($data['habitos_estudio']['puntos_fuertes'] as $punto_fuerte)
                        <li>{{$punto_fuerte}}</li>
                    @endforeach
                </ol>
                <br>
                <b>Puntos débiles.</b>
                <ol>
                    @foreach($data['habitos_estudio']['puntos_debiles'] as $punto_debil)
                        <li>{{$punto_debil}}</li>
                    @endforeach
                </ol>
                </p>--}}
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">16 PF</p>
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <p class="bold">Resultados Ceneval</p>
            </td>
            <td colspan="3"></td>
        </tr>
    </table>
</div>
<!-- FIN CONTENIDO -->
</body>
</html>
