<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Perfil Personal de Ingreso</title>
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
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />

<!-- FIJAR FOOTER -->
<sethtmlpagefooter name="MyFooter1" value="on" />

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
    <p class="p1 bold" align="center">PERFIL PERSONAL DE INGRESO</p>
    <table width="100%" border="1" cellpadding="7px" cellspacing="0" bordercolor="#000000">
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">INFORMACIÓN GENERAL</p>
            </td>
        </tr>
        <tr>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">NOMBRE DEL TUTOR: <u>{{$data['tutor']}}</u></p>
            </td>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">
                    PERIODO: <u>{{$data['periodo']}}</u>
                </p>
                <p class="bold">
                    FECHA DE CONSULTA: <u>{{date('j-m-Y')}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">DATOS DE LA/EL ESTUDIANTE</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="bold">NOMBRE: <u>{{$data['alumno']}}</u></p>
                <p class="bold">NO.CONTROL: <u>{{$data['numero_control']}}</u></p>
                <p class="bold">SEMESTRE: <u>{{$data['semestre']}}</u></p>
            </td>
            <td colspan="2">
                <p class="bold">CARRERA: {{$data['carrera']}}</p>
                <p class="bold">GRUPO: {{$data['grupo']}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">
                    INFORMACIÓN DE CONTACTO EN CASO DE EMERGENCIA:
                </p>
            </td>
            <td colspan="3">
                <p class="bold">
                    Nombre (Parentesco/Relación): <u>{{$data['nombre_contacto']}} ({{$data['parentesco_contacto']}})</u>
                </p>
                <p class="bold">
                    Tel./Cel: <u>{{$data['telefono_contacto']}}</u>, Correo electrónico: <u>{{$data['correo_contacto']}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">INDICADORES DE ÁREAS DE OPORTUNIDAD Y/O FORTALEZAS</p>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <p class="bold">Datos Personales</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Fecha de nacimiento:</b> <u>{{$data['fecha_nacimiento']}} ({{$data['edad']}} años)</u>
                    <br>
                    <b>Edo. Civil:</b> <u>{{$data['estado_civil']}}</u>
                    <br>
                    <b>Colonia donde vive:</b> <u>{{$data['condicion_socioeconomica']['colonia']}}</u>
                    <br>
                    <b>Correo electrónico:</b> <u>{{$data['correo']}}</u>
                    <br>
                    <b>Celular:</b> <u>{{$data['telefono_movil']}}</u>
                    <br>
                    <b>Tel. fijo:</b> <u>{{$data['telefono_fijo']}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Académica</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Tipo de escuela:</b> <u>{{$data['condicion_academica']['tipo_escuela']}}</u>
                    <br>
                    <b>Modalidad:</b> <u>{{$data['condicion_academica']['modalidad']}}</u>
                    <br>
                    <b>Área/especialidad de preparatoria:</b> <u>{{$data['condicion_academica']['especialidad']}}</u>
                    <br>
                    <b>Promedio de preparatoria:</b> <u>{{$data['condicion_academica']['promedio']}}</u>
                    <br>
                    <b>Materias con dificultad:</b> <u>{{$data['condicion_academica']['materias_dificultad']}}</u>
                    <br>
                    <b>Tecnológico de León fue primera opción:</b> <u>{{$data['condicion_academica']['itl_primera_opcion']}}</u>
                    <br>
                    <b>La carrera fue su primera opción:</b> <u>{{$data['condicion_academica']['carrera_primera_opcion']}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Socioeconómica</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Nivel Socioeconómico:</b> <u>{{$data['condicion_socioeconomica']['nivel_socioeconomico']}}</u>
                    <!-- explicación del nivel____________ -->
                    <br>
                    <b>¿Con quién vive?</b> <u>{{$data['condicion_socioeconomica']['con_quien_vive']}}</u>
                    <br>
                    <b>¿Trabaja?</b> <u>{{$data['condicion_socioeconomica']['trabaja']}}</u>
                    <br>
                    <b>¿Quién aporta $ para sus estudios?</b> <u>{{$data['condicion_socioeconomica']['aporte_dinero']}}</u>
                    <br>
                    <b>Escolaridad del padre:</b> <u>{{$data['condicion_socioeconomica']['escolaridad_padre']}}</u>
                    <br>
                    <b>Escolaridad de la madre:</b> <u>{{$data['condicion_socioeconomica']['escolaridad_madre']}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Familiar</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Tipo de familia:</b> <u>{{$data['condicion_familiar']['tipo_familia']}}</u>
                    <br>
                    <b>No. de hermanos:</b> <u>{{$data['condicion_familiar']['numero_hermanos']}}</u>
                    <br>
                    <b>Lugar entre hermanos:</b> <u>{{$data['condicion_familiar']['lugar_entre_hermanos']}}</u>
                    <br>
                    <b>Condición familiar en aspectos excelentes:</b> <u>{{$data['condicion_familiar']['aspectos_excelentes']}}</u>
                    <br>
                    <b>Condición familiar en aspectos deficientes:</b> <u>{{$data['condicion_familiar']['aspectos_deficientes']}}</u>
                </p>

                <br>

                <p class="bold">FACE 20 ESP</p>
                <p>
                    <br>
                    <b>Nivel de cohesión:</b> <u>{{$data['condicion_familiar']['nivel_cohesion']}}</u>
                    <br>
                    <b>Tipo de familia por cohesión:</b> <u>{{$data['condicion_familiar']['familia_cohesion']}}</u>
                    <br>
                    <b>Expliación:</b> <u>{{$data['condicion_familiar']['explicacion_cohesion']}}</u>
                    <br>
                    <br>
                    <b>Nivel de adaptabilidad:</b> <u>{{$data['condicion_familiar']['nivel_adaptabilidad']}}</u>
                    <br>
                    <b>Tipo de familia por adaptabilidad:</b> <u>{{$data['condicion_familiar']['familia_adaptabilidad']}}</u>
                    <br>
                    <b>Expliación:</b> <u>{{$data['condicion_familiar']['explicacion_adaptabilidad']}}</u>
                    <br>
                    <br>
                    <b>Nivel de funcionamiento:</b> <u>{{$data['condicion_familiar']['nivel_funcionamiento']}}</u>
                    <br>
                    <b>Expliación:</b> <u>{{$data['condicion_familiar']['explicacion_funcionamiento']}}</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Pasatiempos</p>
            </td>
            <td colspan="3">
                <p>
                    <b>Actividades que más realiza en su tiempo libre:</b>
                    <ol>
                        <li>{{ $data['pasatiempos']['mas_realiza_1']}}</li>
                        <li>{{ $data['pasatiempos']['mas_realiza_2']}}</li>
                        <li>{{ $data['pasatiempos']['mas_realiza_3']}}</li>
                    </ol>
                    <b>Actividades que menos hace en su tiempo libre:</b>
                    <ol>
                        <li>{{ $data['pasatiempos']['menos_realiza_3']}}</li>
                        <li>{{ $data['pasatiempos']['menos_realiza_2']}}</li>
                        <li>{{ $data['pasatiempos']['menos_realiza_1']}}</li>
                    </ol>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Salud</p>
            </td>
            <td colspan="3">
                <p>
                    <b>En general ¿Cómo calificas tu salud física?</b> <u>{{ $data['salud']['estado_salud']}}</u>
                    <br>
                    {{--Mencionar 1-4, 6, 7, 8, 11, 12 sólo si su respuesta es SÍ
                    <br>--}}
                    <b>Evaluación de habilidades:</b>
                    <ul>
                        @foreach($data['salud']['habilidades'] as $habilidad)
                            <li>
                                {{$habilidad['PLANTEAMIENTO']}}
                                <br>
                                <u>{{$habilidad['RESPUESTA']}}</u>
                            </li>
                        @endforeach
                    </ul>
                    <br>
                    <b>La mayor parte del tiempo me siento:</b> <u>{{ $data['salud']['estado_animo']}}</u>
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
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
