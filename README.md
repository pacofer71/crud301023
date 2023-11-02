## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
### General Info
***
Crud de ejemplo con imagenes usando PDO. Se generan datos de ejemplo con FAKER. Se guarda conf en .env. 
## Technologies
***
Lenguajes y librerías usadas en este proyecto:
* [PHP] (https://www.php.net): Version 8.0+ 
* [Apache2] (https://httpd.apache.org/): Versión 2.4
* [MariaDb] (https://mariadb.org/): Versión 11.0.2
* [Composer] (https://getcomposer.org/): Version 2.5.8
* [Faker] (https://packagist.org/packages/fakerphp/faker)
* [Dotenv] (https://packagist.org/packages/vlucas/phpdotenv)
* [faker-images] (https://packagist.org/packages/mmo/faker-images)
* [Tailwind] (https://tailwindcss.com/)
* [Fontawesome] (https://fontawesome.com/)
* [SweetAlert2] (https://sweetalert2.github.io/)
## Installation
***
Guía de instalación. 
```
$ git clone https://github.com/pacofer71/crud301023.git
$ cd ../path/to/the/dir
$ crea tu base de datos y la tabla de articulos en ella (cod en la carpeta de sql)
$ rename env.example a .env con tus parámetros de instalación.
$ ejecuta composer update
```