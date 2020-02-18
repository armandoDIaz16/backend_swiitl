## Sistema Integral Tecvirtual Backend

El sistema integral del Tecnológico Nacional de México en León, mejor conocido como 
"[*Tec Virtual*](http://tecvirtual.itleon.edu.mx/#/)", 
incluye la mayoría de los procesos que se llevan a cabo en dicha institución. 
El desarrollo del sistema es la suma de los esfuerzos de estudiantes e ingenieros que trabajan en equipo para hacer 
posible dicho proyecto.

## Índice

* [Instalación](#instalación)
    * [Para Clonar el Proyecto](#para-clonar-el-proyecto)
    * [Crear el Archivo .env](#crear-el-archivo-env)
    * [Crear la Base de Datos](#crear-la-base-de-datos)
* [Uso](#uso)
    * [Configuración de Bibliotecas de Enlace Dinámico (.dll)](#configuración-de-bibliotecas-de-enlace-dinámico-dll)
    * [Compilación del Proyecto](#compilación-del-proyecto)
    * [Verificación de Instalación Correcta](#verificación-de-instalación-correcta)
* [¿Qué Incluye?](#qué-incluye)
* [Preguntas Frecuentes](#preguntas-frecuentes)
* [Versiones](#versiones)
* [Documentación](#documentación)
* [Licencia y Derechos de Autor](#licencia-y-derechos-de-autor)
* [Soporte](#soporte)

## Instalación

Se necesitan descargar e instalar los programas en el siguiente orden:
* [Microsoft ODBC Driver 11 para SQL Server](https://www.apachefriends.org/es/download.html)
* [XAMPP](https://www.apachefriends.org/es/download.html) 7.2.26
* [Composer](https://getcomposer.org/) 1.9.2

### Para Clonar el Proyecto

``` bash
$ git clone http://10.0.6.86/mangel_mx/backend_swiitl.git

# trasladarse a la carpeta de la aplicación
$ cd backend_swiitl

# instalar las dependencias de la aplicación
$ composer install
```

### Crear el Archivo .env

En la ruta *backend_swiitl/* se crea o modifica el archivo **.env** copiando los siguientes campos:  
``` typescript
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:qWo08rKXLPh61jQ+V65pTnm2EvVqc7NaEcLnbb7Lu/0=
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    
    DB_CONNECTION=sqlsrv
    DB_HOST=
    DB_PORT=1433
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    
    DB_CONNECTION_SECOND=sqlsrv
    DB_HOST_SECOND=10.0.6.84
    DB_PORT_SECOND=1433
    DB_DATABASE_SECOND=ITL_SICH
    DB_USERNAME_SECOND=desarrollocc
    DB_PASSWORD_SECOND=DCCitl1824*-?
    
    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=eddychavezba@gmail.com
    MAIL_PASSWORD=cfgtjyhdbppopugw
    MAIL_ENCRYPTION=tls
    
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=mt1
    
    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    
    JWT_SECRET=CDwyZWR5RvWkj97oFPv7mmJbzMS58UTe4AvxWPYu3GhTIP0a7S8tCG6sEyuVbaFT
```
Dependiendo del ambiente en el que se quiera probar el sistema, se cambian los siguientes campos:
<br>

Si es en ambiente local, primero se debe crear la base de datos (ver 
[Crear la base de datos](#crear-la-base-de-datos)). Una vez creada, se utiliza el nombre de 
la base de datos dado y un usuario y contraseña creados por el desarrollador.
``` typescript
    DB_CONNECTION=sqlsrv
    DB_HOST=localhost
    DB_PORT=1433
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
```
 
Si es en ambiente de pruebas, se ponen los siguientes datos:
``` typescript
    DB_CONNECTION=sqlsrv
    DB_HOST=10.0.6.232
    DB_PORT=1433
    DB_DATABASE=TECVIRTUAL
    DB_USERNAME=SA
    DB_PASSWORD=123qweZXC
```

Finalmente, para subir a producción, se hace un pull request a los administradores del proyecto.

### Crear la Base de Datos

Se crea la base de datos con el nombre deseado, después se corren los scripts 
localizados en la ruta *../database/scripts/usuarios/* de la siguiente manera:

1. 01\. esquema inicial.sql
2. 02\. script inicial - sistema.sql
3. 03\. script inicial - _ciudades.sql
4. 03\. script inicial - _codigos postales.sql
5. Después, se deben correr las siguientes líneas:

    ```sql
    ALTER TABLE CAT_COLONIA
   ALTER COLUMN FK_TIPO_ASENTAMIENTO INT NULL;
    ```
6. 03\. script inicial - _colonias.sql
7. 03\. script inicial - codigos postales por colonia.xlsx **<sup>1</sup>**
8. 03\. script inicial - roles y permisos.sql
9. En el archivo 01. esquema cambios.sql se corre cada cambio uno por uno, cambiando los
nombres de los constraints necesarios. Los cambios de las rutas MD5 de la tabla PER_CAT_MODULO y la actualización de 
módulo de grupos a tutor no se corren.
10. 04\. vistas.sql
11. 05\. procedimientos almacenados.sql

**<sup>1</sup>** Dentro del archivo de excel están los registros que se deben correr.

## Uso

### Configuración de Bibliotecas de Enlace Dinámico (.dll)

Para probar los servicios que se vayan desarollando, se deben de configurar las bibliotecas de enlace dinámico 
primero, siguiendo estos pasos:
1. En el panel de control de XAMPP, yendo al servicio de **Apache**, se da clic en la acción de **Config** y 
se elige **PHP (php.ini)**. Esto abrirá un archivo de texto. 
2. Dando CTRL + B en el archivo php.ini, se hacen las siguientes búsquedas:

    ```text
    extension=odbc
    extension=pdo_odbc
    ```
    A estas líneas, se les elimina el punto y coma para descomentarlas. Debajo de la última extensión de esa 
    sección, se agregan las siguientes líneas:
    
    ```text
    ;sqlserver
    extension=php_sqlsrv_72_ts_x64.dll
    extension=php_pdo_sqlsrv_72_ts_x64.dll
    ```
3. Una vez hecho esto, se descargan los drivers en su versión 5.6 de 
[Microsoft para PHP y SQL Server](#https://www.microsoft.com/en-us/download/confirmation.aspx?id=57916).
4. Se colocan en una carpeta de su elección y dentro de ella, se buscan las bibliotecas que se escribieron 
en el archivo **php.ini** y se copian.
5. En la ruta C:/xampp/php/ext/ se pegan las bibliotecas.

Con esto, una vez compilado el proyecto, ya se puede realizar la verificación de instalación correcta.

### Compilación del Proyecto

Para visualizar el proyecto en el localhost:8000 del navegador, se pone el siguiente comando en la terminal:
``` bash
$ php artisan serve
```

### Verificación de Instalación Correcta

Con el servicio de APACHE iniciado en XAMPP, se crea un archivo en la carpeta C:/xampp/htdocs/ con 
extensión .php que contenga lo siguiente:
``` php
<?php
$serverName = "yourServername";
$connectionOptions = array(
    "database" => "yourDatabase",
    "uid" => "yourUsername",
    "pwd" => "yourPassword"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(formatErrors(sqlsrv_errors()));
}

// Select Query
$tsql = "SELECT @@Version AS SQL_VERSION";

// Executes the query
$stmt = sqlsrv_query($conn, $tsql);

// Error handling
if ($stmt === false) {
    die(formatErrors(sqlsrv_errors()));
}
?>

<h1> Results : </h1>

<?php
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo $row['SQL_VERSION'] . PHP_EOL;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

function formatErrors($errors)
{
    // Display errors
    echo "Error information: <br/>";
    foreach ($errors as $error) {
        echo "SQLSTATE: ". $error['SQLSTATE'] . "<br/>";
        echo "Code: ". $error['code'] . "<br/>";
        echo "Message: ". $error['message'] . "<br/>";
    }
}
?>
```
En los campos de *serverName*, *database*, *uid* y *password* se escribe el nombre o dirección ip del servidor que 
se está usando, el nombre de la base de datos, el nombre de usuario y la contraseña de SQL Server, respectivamente.  
Una vez hecho esto, se entra al navegador con dirección a *localhost/**nombre-del-archivo**.php*. Deberá aparecer algo 
parecido al siguiente resultado:
``` text
Microsoft SQL Server 2017 (RTM) - 14.0.1000.169 (X64) Aug 22 2017 17:04:49 Copyright (C) 2017 Microsoft Corporation Express Edition (64-bit) on Windows 10 Pro 10.0 (Build 18363: ) 
```
De caso contrario, revise las [Preguntas Frecuentes](#preguntas-frecuentes).

## ¿Qué Incluye?

Con la descarga del proyecto se obtienen las siguientes carpetas y archivos.

```
backend_swiitl/
├── .../
├── app/
├── .../
├── database
|   ├── ...
|   ├── scripts
|   |   ├── ...
|   |   ├── usuarios
|   ├── ...
├── ...
├── routes
|   ├── api.php
|   ├── ...
├── ...
├── .env.example
├── ...
├── README.md
├── ...
```

## Preguntas Frecuentes

**1. ¿Porqué no aparece el mensaje de "Microsoft SQL Server 2017 (RTM)..." cuando se hace la verificación de la 
instalación?**  
* Si el error comienza cuando se inicia Apache en XAMPP y aparece una ventana con un mensaje como el siguiente:

    ```text
    No se encuentra el punto de entrada del procedimiento ...
    ```
    Se debe verificar que la versión de XAMPP y la versión de las biblioteca de enlace dinámico (archivos .dll 
instalados) sea el mismo. Ejemplo: Si se utiliza XAMPP 7.2.26, se deben de tener las bibliotecas:
    1. php_sqlsrv_72_ts_x64.dll
    2. php_pdo_sqlsrv_72_ts_x64.dll
* Si aún no se han configurado las bibliotecas de enlace dinámico, véase 
[Configuración de Bibliotecas de de Enlace Dinámico (.dll)](#configuración-de-bibliotecas-de-enlace-dinámico-dll).
* Si haciendo lo anterior, aún no se visualiza el mensaje correcto, entonces se entra al **Administrador de 
Configuración de SQL Server** para modificar los **Protocolos de SQLEXRPESS**. En el protocolo TCP/IP, se da 
clic derecho y se va a *Propiedades*. En la pestaña de Direcciones IP, en el apartado de IP1 e IPAll, en el campo 
de *TCP Dynamic Ports* se pone el puerto 1433.

## Versiones

El proyecto se encuentra en la versión 0.4 de desarrollo (Enero 2020).

## Documentación

Se utiliza el framework de PHP, [Laravel](https://laravel.com/docs/6.x) que a su vez utiliza [Composer](https://getcomposer.org/doc/).

## Licencia y Derechos de Autor

Copyright 2020 Tecnológico Nacional de México en León.

## Soporte

Célula de Desarrollo Institucional.  
* Ing. Miguel Angel Peña López :mailbox: mangel.plopez@itleon.edu.mx
* Ing. José María Cruz Parada :mailbox: chema@itleon.edu.mx
