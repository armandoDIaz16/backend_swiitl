<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Perfil Grupal de Ingreso</title>
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
{{--

<pageheader name="encabezado_reporte"
            content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}"
            content-right="My document" header-style="font-family: serif; font-size: 8pt;
  font-weight: bold; font-style: italic; color: #000000;" />

<pagefooter name="pie_pagina_reporte"
            content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}"
            content-right="My document" footer-style="font-family: serif; font-size: 8pt;
  font-weight: bold; font-style: italic; color: #000000;" />

<setpageheader name="encabezado_reporte" value="on" show-this-page="1" />
<setpagefooter name="pie_pagina_reporte" value="on" />
--}}

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

<!-- INICIO CONTENIDO -->
<div style="padding-top: 80px; page-break: auto;">
    <p align="center"><b>PERFIL GRUPAL DE INGRESO</b></p>
    <table width="100%" border="1" cellpadding="7px" cellspacing="0" bordercolor="#000000" style="page-break-inside: avoid">
        <tr>
            <td class="gris" colspan="4" align="center">
                <p class="bold">DATOS GENERALES</p>
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
                <p class="bold">ASPECTOS ACADÉMICOS</p>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <p class="bold">GRUPO:</p>
            </td>
            <td width="25%">
                <p class="bold">N° DE ALUMNOS:</p>
            </td>
            <td width="25%">
                <p class="bold">SEMESTRE:</p>
            </td>
            <td width="25%">
                <p class="bold">CARRERA:</p>
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
                <p>Sexo: ___ % Hombre - ___ % Mujer &nbsp; Edad ___%</p>
                <p>Edo.Civil:___% Soltero ___% Casado ___%Unión libre</p>
                <p>Colonia donde vive:</p>
                <p>Lugar de residencia: % &nbsp; %</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Académica</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                <p>Tipo de preparatoria_____%Pública. _____%Privada</p>
                <p>Área: ___%Humanidades. ___%CBQ ___%Físico-matemáticas</p>
                <p>Promedio de calificación de preparatoria: ___%90-100 &nbsp; ___%80-89 ___%70-79</p>
                <p>Materias difíciles: ___% Cálculo ___% Química</p>
                <p>ITL como primera opción: ___% sí &nbsp; ___% no</p>
                <p>Carrera actual como primera opción &nbsp; ___% sí &nbsp; ___% no</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Socioeconómica</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de:</p>
                <p>Nivel Socioeconómico: A_____ C+_____ C_____ C-_____ y explicación del nivel____________</p>
                <p>¿Con quién vive?_____ &nbsp; ¿Trabaja? &nbsp; _____% sí &nbsp; _____% no &nbsp; </p>
                <p>¿Quién aporta $ para sus estudios? _____</p>
                <p>Escolaridad del padre_________ &nbsp; Escolaridad de la madre_________</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Condición Familiar</p>
            </td>
            <td colspan="3">
                <p class="bold">Porcentaje grupal de: (dos primeros porcentajes)</p>
                <p>Tipo de familia _____% &nbsp; _____%</p>
                <p>Condición familiar en aspectos excelentes_____ _____ _____ _____</p>
                <p>Condición familiar en aspectos deficientes____ _____ _____ _____</p>
                <p>FACE 20 ESP</p>
                <p>Nivel de cohesión_____ &nbsp; Tipo de familia por cohesión_____ y expliación_____</p>
                <p>Nivel de adaptabilidad_____ &nbsp; Tipo de familia por adaptabilidad_____ y expliación_____</p>
                <p>Nivel de funcionamiento_____ y expliación_____</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Pasatiempos</p>
            </td>
            <td colspan="3">
                <p>
                    Mencionar las actividades que más realiza en su tiempo libre: ___%(las que número como
                    1,2,3)
                </p>
                <p>
                    Mencionar las actividades que menos hace en su tiempo libre: ___% (las que número como 13, 14,15)
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold">Salud</p>
            </td>
            <td colspan="3">
                <p class="bold">Retomar % como grupo y mencionar información</p>
                <p>En general ¿Cómo calificas tu salud física?_____</p>
                <p>Mencionar 1-4, 6, 7, 8, 11, 12 sólo si su respuesta es SÍ</p>
                <p>Evaluación de habilidades: Mencionar 16-28 sólo si su respuesta es "Mala" Y "Excelente"</p>
                <p>La mayor parte del tiempo me siento: Triste &nbsp; Alegre &nbsp; Ansioso &nbsp; Tranquilo</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bold" b>Hábitos de estudio</pb>
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
