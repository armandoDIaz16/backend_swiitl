## Sistema Integral Tecvirtual Backend

El sistema integral del Tecnológico Nacional de México en León, mejor conocido como "[*Tec Virtual*](http://tecvirtual.itleon.edu.mx/#/)", 
incluye la mayoría de los procesos que se llevan a cabo en dicha institución. 
El desarrollo del sistema es la suma de los esfuerzos de estudiantes e ingenieros que trabajan en equipo para hacer posible dicho proyecto.

## Índice

* [Instalación](#instalación)
    * [Para Clonar el Proyecto](#para-clonar-el-proyecto)
    * [Crear el Archivo .env](#crear-el-archivo-env)
    * [Crear la Base de Datos](#crear-la-base-de-datos)
* [Uso](#uso)
* [¿Qué Incluye?](#qué-incluye)
* [Versiones](#versiones)
* [Documentación](#documentación)
* [Licencia y Derechos de Autor](#licencia-y-derechos-de-autor)
* [Soporte](#soporte)

## Instalación

Se necesitan descargar e instalar los programas en el siguiente orden:
* [XAMPP](https://www.apachefriends.org/es/download.html) 7.2.26
* [Composer](https://getcomposer.org/) 1.9.2 

### Para clonar el proyecto
``` bash
$ git clone http://10.0.6.86/mangel_mx/backend_swiitl.git

# trasladarse a la carpeta de la aplicación
$ cd backend_swiitl

# instalar las dependencias de la aplicación
$ composer install
```

### Crear el archivo .env
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

### Crear la base de datos

Se crea la base de datos con el nombre deseado, después se corren los scripts 
localizados en la ruta *../database/scripts/usuarios* de la siguiente manera:

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
nombres de los constraints necesarios. Los cambios de las rutas
10. 04\. vistas.sql
11. 05\. procedimientos almacenados.sql

**<sup>1</sup>** Dentro del archivo de excel están los registros que se deben correr.

## Uso

Para visualizar el proyecto en el localhost:8000 del navegador, se pone el siguiente comando en la terminal:
``` bash
$ php artisan serve
```

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
