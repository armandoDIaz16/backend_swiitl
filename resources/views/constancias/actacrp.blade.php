<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
 <link href="" rel="stylesheet" media="mpdf">
 <title>ACTA DE CALIFICACION DE RESIDENCIA PROFESIONAL</title> 
  <style type="text/css">
    th{
      background: black;
      color: white;
      display: inline;
    }
    h4{
      text-align: right;
    }
    span{
      background: black;
      color: white;
    }
  </style>
</head>
<body>
  <div style="margin-left: 1cm; margin-right: 1cm; padding-top: 1.5cm;">
    <pre>S.E.P             TECNOLÓGICO NACIONAL DE MÉXICO</pre>
     <h4> <span>FOLIO: <?php echo $carta['folio'] ?> </span></h4>
    <p align="center">
      <b>INSTITUTO TECNOLÓGICO DE LEÓN</b><br>
      DEPARTAMENTO DE SERVICIOS ESCOLARES<br>
      <b>ACTA DE CALIFICACIÓN DE RESIDENCIAS</b><br>
    </P>
<div style="font-size: 0.8em;">
   <pre> EMPRESA O INSTITUCIÓN: <b> <?php echo $carta['empresa'] ?> </b> </pre>
   <pre> PROYECTO:              <b> <?php echo $carta['nombre'] ?> </b> </pre>
   <pre> PERIODO DE RESIDENCIA: <b> <?php echo $periodo ?> <?php echo date('Y') ?> </b>  DURACIÓN: <b>5 MESES </b> </pre>
   <pre> ASESOR INTERNO:        <b> <?php echo $carta['pamaestro'] ?> <?php echo $carta['samaestro'] ?> <?php echo $carta['nombremaestro'] ?> </b> </pre>
   <pre> ASESOR EXTERNO:        <b> <?php echo $carta['paexterno'] ?> <?php echo $carta['saexterno'] ?> <?php echo $carta['nombreexterno'] ?> </b> </pre>
</div>
      <table border="1" color="black" style="font-size: 0.8em;">
        <thead>
          <tr>
            <th> NUM </th>
            <th>No. CONTROL</th>
            <th>NOMBRE DEL ALUMNO</th>
            <th>CARRERA</th>
            <th>CALIF</th>
            <th>OBSERVACIONES</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> <?php echo 'hola' ?> </td>
            <td> <?php echo $carta['numero_control'] ?> </td>
            <td> <?php echo $carta['primer_apellido'] ?> <?php echo $carta['segundo_apellido'] ?> <?php echo $carta['nombre_alumno'] ?> </td>
            <td> <?php echo $carta['carrera'] ?> </td>
            <td> <?php echo $carta['calificacion'] ?> </td>
            <td> <?php echo $carta['observaciones'] ?> </td>
          </tr>
        </tbody>
      </table>
      <p style="font-size: 0.6em;">ESCALA DE CALIFICACIÓN DE 0 A 100; LA CALIFICACIÓN MINIMA APROBATORIA ES 70 </p>
      <p style="font-size: 0.6em;">ESTE DOCUMENTO NO ES VALIDO SI LLEVA ENMENDADURAS O RASPADURAS</p>
      <br><br><br><br><br><br><br>
      <table style="font-size: 0.8em;">
        <thead>
          <tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td align="left">LEÓN, GTO. A <?php echo date('d') ?> DE <?php echo $mes ?> DEL <?php echo date('Y') ?></td>
            <td><pre>                          </pre></td>
            <td align="right"><hr size="1px" color="black"><br><?php echo $carta['pamaestro'] ?> <?php echo $carta['samaestro'] ?> <?php echo $carta['nombremaestro'] ?></td>
          </tr>
        </tbody>
      </table>
  </div>
</body>
</html>
