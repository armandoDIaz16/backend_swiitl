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
                <p>
                    <b>Tipo de preparatoria:</b>
                    @foreach($academico->tipo_escuela['RESPUESTAS'] as $tipo_escuela)
                        <br>
                        <u>{{$tipo_escuela['RESPUESTA']}} -
                            {{number_format($tipo_escuela['CANTIDAD']*100 / $academico->tipo_escuela['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>

                <p>
                    <b>Área:</b>
                    <br>
                    <u>{{$academico->especialidad['ABIERTAS']}}</u>,
                </p>
                <p>
                    <b>Promedio de calificación de preparatoria:</b>
                    @foreach($academico->promedio['RESPUESTAS'] as $promedio)
                        <br>
                        <u>{{$promedio['RESPUESTA']}} -
                            {{number_format($promedio['CANTIDAD']*100 / $academico->promedio['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>Materias difíciles:</b>
                    <u>{{$academico->materias_dificultad['ABIERTAS']}}</u>,
                </p>
                <p>
                    <b>ITL como primera opción:</b>
                    @foreach($academico->itl_primera_opcion['RESPUESTAS'] as $itl)
                        <br>
                        <u>{{$itl['RESPUESTA']}} -
                            {{number_format($itl['CANTIDAD']*100 / $academico->itl_primera_opcion['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>Carrera actual como primera opción:</b>
                    @foreach($academico->carrera_primera_opcion['RESPUESTAS'] as $carrera)
                        <br>
                        <u>{{$carrera['RESPUESTA']}} -
                            {{number_format($carrera['CANTIDAD']*100 / $academico->carrera_primera_opcion['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Socioeconómica</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                <p>
                    <b>Nivel Socioeconómico:</b>
                    <br>
                    @foreach($socioeconomico->niveles as $nivel)
                        <u>{{$nivel->NIVEL}} - {{$nivel->PROMEDIO}}%</u>,
                    @endforeach
                </p>
                <p>
                    <b>¿Con quién vive?</b>
                    @foreach($socioeconomico->quien_vive['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $socioeconomico->quien_vive['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>¿Trabaja?</b>
                    @foreach($socioeconomico->trabaja['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $socioeconomico->trabaja['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>¿Quién aporta $ para sus estudios?</b>
                    @foreach($socioeconomico->aporta_dinero['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $socioeconomico->aporta_dinero['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>Escolaridad del padre</b>
                    @foreach($socioeconomico->escolaridad_padre['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $socioeconomico->escolaridad_padre['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
                <p>
                    <b>Escolaridad de la madre</b>
                    @foreach($socioeconomico->escolaridad_madre['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $socioeconomico->escolaridad_madre['SUMA_TOTAL'], 1)}}%</u>
                    @endforeach
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Familiar</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                <p>
                    <b>Tipo de familia</b>
                    @foreach($familiar->tipo_familia['RESPUESTAS'] as $item)
                        <br>
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $familiar->tipo_familia['SUMA_TOTAL'], 1)}}%</u>
                        <br>
                    @endforeach
                </p>
                <p>
                    <br>
                    <b>Condición familiar en aspectos excelentes</b>
                    <br>
                    @foreach($familiar->aspectos_excelentes as $aspecto)
                        @if($aspecto['PROMEDIO'] > 0)
                            - <u>{{$aspecto['PLANTEAMIENTO']}} - {{number_format($aspecto['PROMEDIO'], 1)}}</u>
                            <br>
                        @endif
                    @endforeach

                    <br>
                    <b>Condición familiar en aspectos deficientes</b>
                    <br>
                    @foreach($familiar->aspectos_deficientes as $aspecto)
                        @if($aspecto['PROMEDIO'] > 0)
                            - <u>{{$aspecto['PLANTEAMIENTO']}} - {{number_format($aspecto['PROMEDIO'], 1)}}</u>
                            <br>
                        @endif
                    @endforeach
                </p>
                <br>
                <p class="bold">
                    FACE 20 ESP
                </p>
                <p>
                    <br>
                    <b>Nivel de cohesión:</b>
                    <u>{{$familiar->nivel_cohesion->NIVEL}} - {{$familiar->nivel_cohesion->PROMEDIO}}%</u>
                    <br>
                    <b>Tipo de familia por cohesión:</b>
                    <u>{{$familiar->tipo_familia_cohesion}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$familiar->explicacion_cohesion}}</u>
                    <br>
                    <br>
                    <b>Nivel de adaptabilidad:</b>
                    <u>{{$familiar->nivel_adaptabilidad->NIVEL}} - {{$familiar->nivel_adaptabilidad->PROMEDIO}}%</u>
                    <br>
                    <b>Tipo de familia por adaptabilidad:</b>
                    <u>{{$familiar->tipo_familia_adaptabilidad}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$familiar->explicacion_adaptabilidad}}</u>
                    <br>
                    <br>
                    <b>Nivel de funcionamiento:</b>
                    <u>{{$familiar->funcionamiento_nivel}}</u>
                    <br>
                    <b>Explicación:</b>
                    <u>{{$familiar->funcionamiento_descripcion}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Pasatiempos</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Mencionar las actividades que más realiza en su tiempo libre:</b>
                <ol>
                    <li>{{$pasatiempos->mas_1->RESPUESTA}}</li>
                    <li>{{$pasatiempos->mas_2->RESPUESTA}}</li>
                    <li>{{$pasatiempos->mas_3->RESPUESTA}}</li>
                </ol>

                <b>Mencionar las actividades que menos hace en su tiempo libre:</b>
                <ol>
                    <li>{{$pasatiempos->menos_1->RESPUESTA}}</li>
                    <li>{{$pasatiempos->menos_2->RESPUESTA}}</li>
                    <li>{{$pasatiempos->menos_3->RESPUESTA}}</li>
                </ol>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Salud</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de</p>
                <p>
                    En general ¿Cómo calificas tu salud física?
                    <br>
                    @foreach($salud->estado_salud['RESPUESTAS'] as $item)
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $salud->estado_salud['SUMA_TOTAL'], 1)}}%</u>
                        <br>
                    @endforeach
                    <br>
                    @foreach($salud->respuestas as $pregunta)
                        @foreach($pregunta['RESPUESTAS'] as $respuesta)
                            @if($respuesta['RESPUESTA'] == 'SÍ')
                                <u>{{$pregunta['PLANTEAMIENTO']}} -
                                    {{number_format($respuesta['CANTIDAD']*100 / $pregunta['SUMA_TOTAL'], 1)}}%</u>
                                <br>
                            @endif
                        @endforeach
                    @endforeach
                </p>
                <p>
                    <br>
                    <b>Evaluación de habilidades:</b>
                    <br>
                    @foreach($salud->habilidades as $pregunta)
                        {{$pregunta['PLANTEAMIENTO']}}:
                        <br>
                        @foreach($pregunta['RESPUESTAS'] as $respuesta)
                            @if($respuesta['RESPUESTA'] == 'Excelente' || $respuesta['RESPUESTA'] == 'Mala')
                                <u>
                                    {{$respuesta['RESPUESTA']}}:
                                    {{number_format($respuesta['CANTIDAD']*100 / $pregunta['SUMA_TOTAL'], 1)}}%,
                                </u>
                            @endif
                        @endforeach
                        <br>
                    @endforeach
                </p>
                <p>
                    <br>
                    <b>La mayor parte del tiempo me siento:</b>
                    <br>
                    @foreach($salud->estado_animo['RESPUESTAS'] as $item)
                        <u>{{$item['RESPUESTA']}} -
                            {{number_format($item['CANTIDAD']*100 / $salud->estado_animo['SUMA_TOTAL'], 1)}}%</u>
                        <br>
                    @endforeach
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Hábitos de estudio</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Puntos fuertes.</b>
                {{--<ol>
                    @foreach($data['habitos_estudio']['puntos_fuertes'] as $punto_fuerte)
                        <li>{{$punto_fuerte}}</li>
                    @endforeach
                </ol>--}}
                <br>
                <b>Puntos débiles.</b>
                {{--<ol>
                    @foreach($data['habitos_estudio']['puntos_debiles'] as $punto_debil)
                        <li>{{$punto_debil}}</li>
                    @endforeach
                </ol>--}}
                </p>
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
