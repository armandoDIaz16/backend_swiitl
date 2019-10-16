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

        p > *, p{
            font-size: .8em;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- INICIO ESTILOS ENCABEZADO -->
<htmlpageheader name="MyHeader1">
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

<div style="padding-top: 80px; page-break: auto;">
    <p align="center"><b>PERFIL PERSONAL DE INGRESO</b></p>
    <table width="100%" border="1" cellpadding="7px" cellspacing="0" bordercolor="#000000">
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">INFORMACIÓN GENERAL</p>
            </td>
        </tr>
        <tr>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">NOMBRE DEL TUTOR:</p>
            </td>
            <td valign="middle" align="left" colspan="2">
                <p class="bold">
                    PERIODO: <u>{{\App\Helpers\Constantes::get_periodo_texto()}}</u>
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
            <td>
                <p class="bold">NOMBRE:</p>
            </td>
            <td colspan="3">
                <p class="bold">SEMESTRE:__ CARRERA:__ GRUPO:__ No.CONTROL:__</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">
                    INFORMACIÓN DE CONTACTO EN CASO DE EMERGENCIA:
                </p>
            </td>
            <td colspan="3">
                <p>
                    Nombre: Parentesco/Relación:
                </p>
                <p>
                    Tel./Cel. Correo electrónico
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
                    Fecha de nacimiento__ Edad__ Edo. Civil_________ Colonia donde vive__
                </p>
                <p>
                    Correo electrónico_____________________________
                </p>
                <p>
                    Celular_____ Tel.fijo_____
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Académica</p>
            </td>
            <td colspan="3">
                <p>
                    Tipo de escuela___ Modalidad_________ Área/especialidad de prepa___
                </p>
                <p>
                    Promedio de preparatoria_____ Materias con dificultad____ _____ _____
                </p>
                <p>
                    Tecnológico de León fue primera opción: <u>si</u> <u>no</u>
                    La carrera fue su primera opción <u>sí</u> <u>no</u>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Socioeconómica</p>
            </td>
            <td colspan="3">
                <p>
                    Nivel Socioeconómico_____ explicación del nivel____________
                </p>
                <p>
                    ¿Con quién vive?_____ ¿Trabaja? sí no ¿Quién aporta $ para sus estudios?_____
                </p>
                <p>
                    Escolaridad del padre_________ Escolaridad de la madre_________
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Familiar</p>
            </td>
            <td colspan="3">
                <p>
                    Tipo de familia_________ No. de hermanos_________ Lugar entre hermanos_________
                </p>
                <p>
                    Condición familiar en aspectos excelentes_____ _____ _____ _____
                </p>
                <p>
                    Condición familiar en aspectos deficientes____ _____ _____ _____
                </p>

                <br>
                <p class="bold">FACE 20 ESP</p>

                <p>
                    Nivel de cohesión_____ Tipo de familia por cohesión_____ y expliación_____
                </p>
                <p>
                    Nivel de adaptabilidad_____ &nbsp; Tipo de familia por adaptabilidad_____ y expliación_____
                </p>
                <p>
                    Nivel de funcionamiento_____ y expliación_____
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <b class="bold">Pasatiempos</b>
            </td>
            <td colspan="3">
                <p>
                    Mencionar las actividades que más realiza en su tiempo libre (las que número como 1,2,3)
                </p>
                <p>
                    Mencionar las actividades que menos hace en su tiempo libre (las que número como 13, 14, 15)
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Salud</p>
            </td>
            <td colspan="3">
                <p>
                    En general ¿Cómo calificas tu salud física?_____
                </p>
                <p>
                    Mencionar 1-4, 6, 7, 8, 11, 12 sólo si su respuesta es SÍ
                </p>
                <p>
                    Evaluación de habilidades: Mencionar 16-28 sólo si su respuesta es "Mala" Y "Excelente"
                </p>
                <p>
                    La mayor parte del tiempo me siento: Triste &nbsp; Alegre &nbsp; Ansioso &nbsp; Tranquilo
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Hábitos de estudio</p>
            </td>
            <td colspan="3">
                <p>
                    Mencionar puntos fuertes. Son aquellos aspectos con puntuación igual o mayor a 70
                </p>
                <p>
                    Mencionar puntos débiles. Son aquellos aspectos con puntuación menor a 70
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
