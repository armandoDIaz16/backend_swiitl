<!DOCTYPE html>
@inject('pdfData', ' App\ServicioSocial\Convocatoria')
@php
    $per = $pdfData->perName($datosC[0]->PERIODO);
@endphp
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Convocatoria</title>
    <style type="text/css"></style>
</head>

<body style="margin:10%;font-family: Arial, Helvetica, sans-serif;" >

    <div style="text-align:center; ">
        <h4 style="text-decoration: underline;text-align:center"><mark>Curso de Inducción de Servicio Social.</mark></h4>
    </div>
    <div style="font-weight: bold;" >
        <p>
            El Instituto Tecnológico de León, a travéz del Departamento de Gestion Tecnológica y Vinculación, y la oficina de
             Servicio Social y Desarrollo Comunitario:
        </p>
        <p style="text-align: center">
            <mark>C O N V O C A N</mark>
        </p>
        <p>
            A las alumnas y alumnos (que inicien con número de control {{ $datosC[0]->NO_CONTROL_CONV }}), proximos a realizar su <i style="text-decoration: underline">SERVICIO 
            SOCIAL</i>  para el periodo de {{ $per[0] }} del presente año a {{ $per[1] }} de {{ $datosC[0]->FCY }}, al "Cuerso de Inducción" (requisito obligatorio) 
            para poder relaizar la solicitud de prestación; que se llevará a cabo en la siguiente fecha:
        </p>

    </div>

        <div >
            <table class="" style="border-collapse:collapse; width:100%; font-weight: bold; " >
                <thead>
                <tr >
                    <td style="border:1px solid black;text-align:center;text-decoration: underline" scope="col">FECHA</td>
                    <td style="border:1px solid black;text-align:center;text-decoration: underline" scope="col">LUGAR</td>
                    <td style="border:1px solid black;text-align:center;text-decoration: underline" scope="col">HORARIO</td>
                </tr>
                </thead>
                @foreach($datosC as $dato)
                <tbody style="text-align:center">
                    <tr>
                    
                        <td style="border:1px solid black;margin-left:10px"> {{ strtoupper($pdfData->diaMx($dato->DIANo))}} {{ strtoupper($dato->DIANu)}} DE {{strtoupper($pdfData->mesMx($dato->MES))}} {{strtoupper($dato->ANIO)}} (TURNO {{strtoupper($dato->TURNO)}}) </td>
                        <td style="border:1px solid black;margin-left:10px"> {{ strtoupper($dato->NOMBRE_ESPACIO)}} {{ strtoupper($dato->NOMBRE_LUGAR)}} </td>
                        <td style="border:1px solid black;margin-left:10px"> {{ strtoupper($dato->HORARIO)}} HRS.</td>
                        
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div><br>

    <div style="margin-left:40px;">
        <div style=" font-weight: bold;"> 
            <p>
                Para mayores informes: Lic. Miguel Angel Ortiz Gaucin  Jefe de la Oficina de Servicio Social y Desarrollo <br>
                Comunitario, (Campus I) correo: <a style="text-decoration: underline">serviciosocial@itleon.edu.mx</a> , teléfono 7.10.52.00 ext. 1500. 
            </p>
            <p style="text-align:center">
                <i>¡Esperamos tu puntual asistencia!</i>
            </p>
        </div>
        <div>
            <p style="
            position: absolute; 
            text-align: left; 
            font-weight: bold;">
            {{ $datosC[0]->FCD }} de {{ $pdfData->mesMx($datosC[0]->FCM) }} de {{$datosC[0]->FCY }}
            </p>
            <p style="
            position: absolute; 
            text-align: right;
            font-weight: 600; " > <i>GT-F-08</i> </p>
        </div>
    </div>


</body>


</html>