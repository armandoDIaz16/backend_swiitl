<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="" rel="stylesheet" media="mpdf">
    <title>Ficha Unica de Asignación</title>
    <style type="text/css"></style>
</head>
<body>
<?php $ind = 0; ?>
<?php foreach ($alumnoss as $array){?>
<div style="margin-left: 1cm; margin-right: 1cm; padding-top: 3cm;">
    <p align="right" style="font-size: 0.8em;">
        León, Guanajuato, <?php echo date('d').'/'.$mes.'/'.date('Y') ?><br>
        <br>MEMORANDUM B7-<?php printf('%03d',$ind+1) ?>-<?php echo date('Y')?>
        <br>ASUNTO: FICHA ÚNICA ASIGNACIÓN
        <br>PERIODO: <?php echo $periodo.' '.date('Y') ?>
        <br>DEPTO. DE <?php echo $departamento ?>
        <br><?php echo $array['Carrera']; ?>
    </p>
    <br>
    <div  class="extrabold" style="font-size: 0.9em;"><b>
            <?php echo $array['PApellido']?> <?php echo $array['SApellido']?> <?php echo $array['Nombre']; ?>(<?php echo $array['Numero']; ?>)<br>
            <?php echo $array['CorreoA'] ?><br>
            PRESENTE</b>
    </div>
    <div style="font-size: 0.9em; font-family: montserrat;">
    <p align="justify">
        POR ESTE CONDUCTO, ME PERMITO COMUNICARLE A USTED, QUE HA SIDO ASIGNADO(A) A LA EMPRESA:
        <p align="center"> <b><?php echo $array['Empresa'] ?></b> </p>
        PARA LA REALIZACIÓN DE SU RESIDENCIA PROFESIONAL, EN EL PROYECTO
        <p align="center"><b><?php echo $array['Proyecto'] ?></b></p>
        Y CUYO ASESOR DOCENTE ES:
        <p align="center"><b><?php echo $array['NombreDocente'] ?> <?php echo $array['ApellidoPDocente'] ?> <?php echo $array['ApellidoMDocente'] ?><br> <?php echo $array['CorreoDocente'] ?></b></p>
        Y COMO ASESOR EXTERNO:
        <p align="center"><b><?php echo $array['NombreExterno']?> <?php echo $array['ApellidoPExterno'] ?> <?php echo $array['ApellidoMExterno'] ?><br> <?php echo $array['CorreoExterno'] ?> </b></p>
        SIN MÁS POR EL MOMENTO, QUEDO DE USTED
    </p>
    </div>
    <br>
    <div  class="extrabold" style="font-size: 0.9em;">
    <b >A T E N T A M E N T E </b>
    </div>
    <div id="atentamente" style="font-size: 0.8em">
        <i>Excelencia en Educación Tecnológica</i>
    </div>
    <div id="atentamente2" style="font-size: 0.7em">
        <i>Ciencia, Tecnología y Libertad</i>
    </div>
    <br>
    <div  class="extrabold" style="font-size: 0.9em;">
            <p align="left" >
                <b>
                    <?php echo $jefe ?>
                    <br>
                    JEFE
                    DEPTO. <?php echo $departamento ?>
                </b>
            </p>
    </div>
    <p id="ccp" style="font-size: 0.7em;" > C.p. DEPTO. DE GESTIÓN TECNOLÓGICA Y VINCULACIÓN <br> C.p. ASESOR EXTERNO <br> C.p. ASESOR DOCENTE
    <br> C.p. SERVICIOS ESCOLARES <br> C.p. DIVISIÓN DE ESTUDIOS <br> C.p. ALUMNO <br> C.p. ARCHIVO </p>
</div>
<?php if($ind != count($alumnoss) - 1){ ?>
<p style="page-break-before: always">
<?php $ind ++; ?>
<?php } ?>
<?php } ?>
</body>
</html>