<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Reporte PDF Ficha Tecnica</title>
    <style>
        /* Font Definitions */
        *{
         line-height: 200px;
        }
        @font-face
        {font-family:"Cambria Math";
            panose-1:2 4 5 3 5 4 6 3 2 4;}
        @font-face
        {font-family:Calibri;
            panose-1:2 15 5 2 2 2 4 3 2 4;}
        @font-face
        {font-family:"Soberana Titular";
            panose-1:0 0 0 0 0 0 0 0 0 0;}
        @font-face
        {font-family:"Soberana Sans";
            panose-1:0 0 0 0 0 0 0 0 0 0;}
        @font-face
        {font-family:"Segoe UI";
            panose-1:2 11 5 2 4 2 4 2 2 3;}
        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal
        {mso-style-name:"Normal\,Cuerpo";
            margin:0cm;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        p
        {margin-right:0cm;
            margin-left:0cm;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
        {margin-top:0cm;
            margin-right:0cm;
            margin-bottom:0cm;
            margin-left:36.0pt;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
        {margin-top:0cm;
            margin-right:0cm;
            margin-bottom:0cm;
            margin-left:36.0pt;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
        {margin-top:0cm;
            margin-right:0cm;
            margin-bottom:0cm;
            margin-left:36.0pt;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
        {margin-top:0cm;
            margin-right:0cm;
            margin-bottom:0cm;
            margin-left:36.0pt;
            font-size:10.0pt;
            font-family:"Arial",serif;}
        .MsoChpDefault
        {font-family:"Arial",sans-serif;}
        .MsoPapDefault
        {margin-bottom:8.0pt;
            line-height:107%;}
        /* Page Definitions */
        @page WordSection1
        {size:612.0pt 792.0pt;
            margin:60.0pt 36.0pt 36.0pt 36.0pt;}
        div.WordSection1
        {page:WordSection1;}
        /* List Definitions */
        ol
        {margin-bottom:0cm;}
        ul
        {margin-bottom:0cm;}
        -->
        td, th {
            border:1px solid #111111 !important;
        }

        .firma{
            width:156.6pt;
            border-top: 1px solid #000000;
            border-bottom: none;border-left: none;border-right: none;
            padding:0cm 5.4pt 0cm 5.4pt;
            text-align: center !important;
        }
        .texto_gris {
            color:#aaaaaa;
        }
    </style>
</head>
<body style="font-family: Arial;" lang=es-419 link="#0563C1" vlink="#954F72">
    {{-- ********************************************************************************************************* --}}
    {{-- ******************************************* CABECERA **************************************************** --}}
    {{-- ********************************************************************************************************* --}}
    <div class=WordSection1>
        <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><b><span
                lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                FICHA T&Eacute;CNICA DEL SERVICIO DE ACTUALIZACI&Oacute;N PROFESIONAL Y </span></b></p>
        <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><b><span
                lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                FORMACI&Oacute;N DOCENTE</span></b></p>
        <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><b><span
                lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>M00-SC-029-A02</span></b></p>
        <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
     {{-- ********************************************************************************************************* --}}
     {{-- ************************************* DESCRIPCION DEL SERVICIO ****************************************** --}}
     {{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='text-align:justify;line-height:99%;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
                <b>Instituto Tecnol&oacute;gico o Centro o Unidad:</b>
                Instituto Tecnol&oacute;gico de le&oacute;n</span></p>
        <p class=MsoNormal style='line-height:10.0pt;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal style='line-height:99%;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
                <span style='font-weight: bold;'>Nombre del Servicio:</span>
                {{ $curso['NOMBRE_CURSO'] }}</span>
        </p>
        <p class=MsoNormal style='line-height:99%;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>&nbsp;
            </span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif;text-transform: lowercase;'>
            <span style='font-weight: bold;'>Instructor(a):</span>
            @if(is_null( $curso['INSTRUCTORES']))
                No se ha registrado el instructor del curso
            @else
                @for($i=0; $i<count($curso['INSTRUCTORES']); $i++)
                    <span style="text-transform: capitalize">
                        {{ $curso['INSTRUCTORES'][$i]->NOMBRE_INSTRUCTOR}}{{count($curso['INSTRUCTORES']) >1 && $i+1 < count($curso['INSTRUCTORES']) ? ',' : '' }}
                    </span>
                @endfor
            @endif
            </span>
        </p>
        <p style='margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;background:white;punctuation-wrap:simple;
        text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                1)<span style='font:7.0pt "Times New Roman"'>&nbsp;</span></span></b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif;color:black'>
                <b>Introducci&oacute;n:</b>
                @if(is_null(  $ficha['INTRODUCCION'] ) || $ficha['INTRODUCCION'] == '' )
                   <span class="texto_gris" >No se ha registrado la introducción</span>
                @else
                     {{  $ficha['INTRODUCCION'] }}
                @endif
            </span></p>
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;line-height:12.65pt;punctuation-wrap:simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    2)<span style='font:7.0pt "Times New Roman"'>&nbsp;</span></span></b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    <b>Justificaci&oacute;n:</b>
                @if(is_null(  $ficha['JUSTIFICACION'] ) || $ficha['JUSTIFICACION'] == '')
                    <span class="texto_gris" >No se ha registrado la justificación</span>
                @else
                    {{  $ficha['JUSTIFICACION'] }}
                @endif
                </span></p>
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;punctuation-wrap:simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    3)<span  style='font:7.0pt "Times New Roman"'>&nbsp;</span></span></b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    <b>Objetivo General:</b>
                @if(is_null(  $ficha['OBJETIVO_GENERAL'] ) || $ficha['OBJETIVO_GENERAL'] == '')
                    <span class="texto_gris" >No se ha registrado el objetivo general</span>
                @else
                    {{  $ficha['OBJETIVO_GENERAL'] }}
                @endif</span></p>

{{-- ********************************************************************************************************* --}}
{{-- ************************************* INFORMACIÓN DEL SERVICIO ****************************************** --}}
{{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;punctuation-wrap:simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    4)<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></b><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                    Descripci&oacute;n del Servicio: </span></b></p>
        <p class=MsoNormal style='line-height:.05pt;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
        <p class=MsoNormal style='line-height:.05pt;text-autospace:none'><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;line-height:99%;punctuation-wrap:simple;text-autospace:none'><span
            lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
            a.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
            Especificar tipo de servicio:
            @if(is_null($texto_tipo_servicio ) || $texto_tipo_servicio == '')
                <span class="texto_gris" >No se ha registrado el tipo de servicio</span>
            @else
                {{  $texto_tipo_servicio }}
            @endif
            </span></p>
        <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;line-height:99%;punctuation-wrap:simple;text-autospace:none'><span
            lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
            b.<span  style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
            Duraci&oacute;n en horas del curso:
            @if(is_null(  $curso['TOTAL_HORAS'] ) || $curso['TOTAL_HORAS'] == '' )
                <span class="texto_gris" >No se ha registrado el total de horas</span>
            @else
                {{  $curso['TOTAL_HORAS'] }}&nbsp;Horas
            @endif
            </span></p>
        <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX
                                                           style='font-size:10.0pt;font-family:"Arial",sans-serif'>
            c.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
            Contenido tem&aacute;tico del curso</span></p>
 {{-- ********************************************************************************************************* --}}
 {{-- ************************************* CONTENIDO TEMÁTICO ****************************************** --}}
 {{-- ********************************************************************************************************* --}}
        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 style='margin-left:60.0pt;border-collapse:collapse;border:none'>
            <tr>
                <th width=38 valign=top style='width:28.75pt; background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:   simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif'>
                        No.</span></b></p>
                </th>
                <th width=133 valign=top style='width:109.95pt;  background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:   simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif'>
                     Temas / Subtemas<span style='color:black'> </span></span></b></p>
                </th>
                <th width=201 valign=top style='width:150.65pt;  background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:  simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif;color:black'>
                    Tiempo Programado (Hrs) </span></b></p>
                </th>
                <th width=189 valign=top style='width:5.5cm;  background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:    simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif;color:black'>
                    Actividades de aprendizaje </span></b></p>
                </th>
            </tr>
            @if(is_null( $ficha['contenido_tematico']) || count($ficha['contenido_tematico'])<=0)
                <tr>
                    <td class="texto_gris" style='text-align: center;font-size:10.0pt;font-family: "Arial",sans-serif;' colspan="4">
                        No se ha registrado el contenido temático</td>
                </tr>
            @else
                @for($i=0; $i<count($ficha['contenido_tematico']); $i++)
                    <tr>
                        <td width=38 valign=top style='width:28.75pt;text-align:center; padding:0cm 5.4pt 0cm 5.4pt'>
                            <p class=MsoNormal style='punctuation-wrap:simple;  text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family: "Arial",sans-serif'>
                        {{$i+1}}.</span></p>
                        </td>
                        <td width=201 valign=top style='width:150.65pt;text-align:justify; padding:0cm 5.4pt 0cm 5.4pt'>
                            <p class=MsoNormal style='text-align:justify;punctuation-wrap:simple;  text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family: "Arial",sans-serif'>
                            <span>
                                {{$ficha['contenido_tematico'][$i]->NOMBRE_TEMA}}</span>
                                </span></p>
                        </td>
                        <td width=189 valign=top style='width:5.0cm; padding:0cm 5.4pt 0cm 5.4pt;text-align:center;'>
                            <p class=MsoNormal style='text-align:center;punctuation-wrap:simple;    text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:      "Arial",sans-serif'>
                                    <span>
                                {{$ficha['contenido_tematico'][$i]->TIEMPO_TEMA}}&nbsp;hrs</span>
                                </span></p>
                        </td>
                        <td width=189 valign=top style='width:5.0cm; text-align:justify; padding:0cm 5.4pt 0cm 5.4pt'>
                            {{--<p class=MsoNormal style='text-align:justify;punctuation-wrap:simple;    text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:      "Arial",sans-serif'>
                                    <span style='text-align:justify !important;'>
                                {{$ficha['contenido_tematico'][$i]->ACTIVIDAD_APRENDIZAJE}}</span>
                                </span></p>--}}
                            <p>{{$ficha['contenido_tematico'][$i]->ACTIVIDAD_APRENDIZAJE}}</p>
                        </td>
                    </tr>
                @endfor
            @endif

        </table>
{{-- ********************************************************************************************************* --}}
{{-- ************************************* ELEMENTOS DITACTICOS ********************************************** --}}
{{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='margin-left:55.0pt;text-align:justify;punctuation-wrap:
simple;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:
-18.3pt;line-height:99%;punctuation-wrap:simple;text-autospace:none'><span            lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
                d.<span  style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;</span></span><span lang=ES-MX style='font-size:10.0pt;line-height:99%;font-family:"Arial",sans-serif'>
                Elementos did&aacute;cticos para el desarrollo del curso:
                 @if(is_null( $ficha['material_didactico']) || count($ficha['material_didactico'])<=0)
                        No se ha registrado el material didáctico
                @else
                    @for($i=0; $i<count($ficha['material_didactico']); $i++)
                        {{$ficha['material_didactico'][$i]->NOMBRE_MATERIAL}}{{count($ficha['material_didactico']) >1
                            && $i+1 < count($ficha['material_didactico']) ? ',' : '' }}
                    @endfor
                @endif
            </span></p>
        {{-- ********************************************************************************************************* --}}
        {{-- ************************************* CRITERIOS DE EVALIACIÓN ******************************************** --}}
        {{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:
    -18.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                e.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;</span></span>
            <span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                Criterios de evaluaci&oacute;n:</span></p>
       <p class=MsoNormal style='margin-left:61.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
       <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0  style='margin-left:60.0pt;border-collapse:collapse;border:none'>
            <tr>
                <th width=38 valign=top style='width:28.75pt; background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:   simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif'>
                        No.</span></b></p>
                </th>
                <th width=220 valign=top style='width:165.0pt;   background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:  simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif;color:black'>
                         Criterio </span></b></p>
                </th>
                <th width=94 valign=top style='width:70.85pt;  background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:  simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif;color:black'>
                         Valor </span></b></p>
                </th>
                <th width=180 valign=top style='width:155.35pt; background:#D0CECE;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:  simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;      font-family:"Arial",sans-serif;color:black'>
                        Instrumento de evaluaci&oacute;n </span></b></p>
                </th>
            </tr>
           @if(is_null( $ficha['criterios_evaluacion']) || count($ficha['criterios_evaluacion'])<=0)
               <tr>
                   <td class="texto_gris" style='text-align: center;font-size:10.0pt;font-family: "Arial",sans-serif;' colspan="4">
                       No se han registrado los criterios de evaluación</td>
               </tr>
           @else
               @for($i=0; $i<count($ficha['criterios_evaluacion']); $i++)
                   <tr>
                       <td width=38 valign=top style='width:28.75pt;text-align:center; padding:0cm 5.4pt 0cm 5.4pt'>
                           <p class=MsoNormal style='punctuation-wrap:simple;  text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:      "Arial",sans-serif'>
                            {{$i+1}}</span></p>
                       </td>
                       <td width=220 valign=top style='width:165.0pt;text-align:justify; padding:0cm 5.4pt 0cm 5.4pt'>
                           <p class=MsoNormal style='punctuation-wrap:simple;   text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:      "Arial",sans-serif'>
                           {{$ficha['criterios_evaluacion'][$i]->NOMBRE_CRITERIO}}</span></p>
                       </td>
                       <td width=94 valign=top style='width:70.85pt; text-align:center;padding:0cm 5.4pt 0cm 5.4pt'>
                           <p class=MsoNormal style='punctuation-wrap:simple;    text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:     "Arial",sans-serif'>
                           {{$ficha['criterios_evaluacion'][$i]->VALOR_CRITERIO}}%</span></p>
                       </td>
                       <td width=180 valign=top style='width:135.35pt;text-align:justify; padding:0cm 5.4pt 0cm 5.4pt'>
                           <p class=MsoNormal style='punctuation-wrap:simple;    text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:      "Arial",sans-serif'>
                           {{$ficha['criterios_evaluacion'][$i]->INSTRUMENTO_DE_EVALUACION}}</span></p>
                       </td>
                   </tr>
               @endfor
           @endif
        </table>

        <p class=MsoNormal style='margin-left:108.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal style='line-height:12.55pt;text-autospace:none'><span    lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
            {{-- ********************************************************************************************************* --}}
            {{-- ************************************* COMPETENCIAS A DESARROLLAR  ************************************** --}}
            {{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;punctuation-wrap:simple;text-autospace:none'><b><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
               5)<span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span></b><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
               Competencias a desarrollar: </span></b>
        </p>
        @if(is_null( $ficha['competencias']) || count($ficha['competencias'])<=0)
            <p class="MsoNormal texto_gris" style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                <span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;</span></span><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                 No se han registrados las competencias</span>
            </p>
        @else
            {{--@for($i=0; $i<count($ficha['competencias']); $i++)
             <p class=MsoNormal style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
              a.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;</span></span><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                 {{$ficha['competencias'][$i]->TEXTO_COMPETENCIA}}</span>
             </p>
            @endfor--}}
            <ol type="a" style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                @for($i=0; $i<count($ficha['competencias']); $i++)
                        <li>
                            <p class=MsoNormal style='margin-left:32.0pt;text-align:justify;text-indent:-5.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                             <span style='font:7.0pt "Times New Roman"'>&nbsp;</span></span>
                                 <span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                                 {{$ficha['competencias'][$i]->TEXTO_COMPETENCIA}}</span>
                          </p>
                    </li>
                  @endfor
            </ol>
        @endif
        <p class=MsoNormal style='line-height:.05pt;text-autospace:none'><b><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'> </span></i></p>
        <p class=MsoNormal style='line-height:12.55pt;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
            {{-- ********************************************************************************************************* --}}
            {{-- ************************************* FUENTES DE INFORMACIÓN ******************************************** --}}
            {{-- ********************************************************************************************************* --}}
        <p class=MsoNormal style='margin-left:22.0pt;text-align:justify;text-indent:-17.9pt;punctuation-wrap:simple;text-autospace:none'><b><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
              6)<span  style='font:7.0pt "Times New Roman"'>&nbsp; </span></span></b><b><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
              Fuentes de Informaci&oacute;n: </span></b>
        </p>
        @if(is_null( $ficha['fuentes_informacion']) || count($ficha['fuentes_informacion'])<=0)
            <p class="MsoNormal texto_gris" style='margin-left:50.0pt;text-align:justify;text-indent:-18.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                <span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;</span></span><span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                 No se han registrados las fuentes de información</span>
            </p>
        @else
            <ol type="a" style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                @for($i=0; $i<count($ficha['fuentes_informacion']); $i++)
                    <li>
                        <p class=MsoNormal style='margin-left:32.0pt;text-align:justify;text-indent:-5.3pt;punctuation-wrap:simple;text-autospace:none'><span lang=ES-MX  style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                             <span style='font:7.0pt "Times New Roman"'>&nbsp;</span></span>
                            <span  lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>
                                 {{$ficha['fuentes_informacion'][$i]->TEXTO_FUENTE}}</span>
                        </p>
                    </li>
                @endfor
            </ol>
        @endif
        <p class=MsoNormal style='line-height:.1pt;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
        <p class=MsoNormal style='margin-left:36.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></i></p>
        <p class=MsoNormal style='margin-left:36.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></i></p>
        <p class=MsoNormal style='margin-left:36.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></i></p>
        <p class=MsoNormal style='margin-left:36.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></i></p>
        <p class=MsoNormal style='margin-left:36.0pt;text-align:justify;punctuation-wrap:simple;text-autospace:none'><i><span lang=ES-MX style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></i></p>
            {{-- ********************************************************************************************************* --}}
            {{-- ************************************* ESPACIO DE FIRMAS ************************************************* --}}
            {{-- ********************************************************************************************************* --}}
        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='margin-left:36.0pt;border-collapse:collapse;border:none'>
            <tr>
                <td width=213 class='firma'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap: simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;  font-family:"Arial",sans-serif'>
                          Nombre y Firma del Facilitador(a) </span></b></p>
                </td>
                <td width=177 valign=top style='width:132.6pt;padding:0cm 5.4pt 0cm 5.4pt;border:none;'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap:  simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;  font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
                </td>
                <td width=209 class='firma'>
                    <p class=MsoNormal align=center style='text-align:center;punctuation-wrap: simple;text-autospace:none'><b><span lang=ES-MX style='font-size:10.0pt;  font-family:"Arial",sans-serif'>
                         Nombre y Firma del Jefe(a) de Desarrollo Acad&eacute;mico. </span></b></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
        <p class=MsoNormal><span lang=ES-MX style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
    </div>
</body>
</html>
