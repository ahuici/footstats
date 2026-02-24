# QUE ES FOOTSTATS

# COMO INSTALAR EL PROYECTO
1. Acceder al repositorio de github y realizara una copia (git clone) en nuestro ordenador.
2. Abre la carpeta del proyecto y abre una terminal en dicha carpeta
3. Ejecuta el siguiente comando: docker compose up -d --build
4. Ya tenemos el la imagen y el contenedor en el docker.

# COMO ABRIR LA APLICACIÓN
1. Entramos en docker y arrancamos el contenedor
2. Buscamos localhost:8080 en el navegador
3. Esperamos 10-15 segundos a que se arranque la base de datos
4. Ya tenemos la aplicacion funcionando

# INFORMACIÓN IMPORTANTE ACERCA DEL PROYECTO

## Estructura del proyecto
Este proyecto esta levantado en docker y programado en PHP, basandonos en el modelo MVC (Modelo-Vista-Controlador). 

Tenemos un backend/controlador en controladores/controlador_footstats, que es el encargado de manejar toda la lógica de las redirecciones. El acceso a base de datos/modelo esta en modelos/, aqui tenemos los controladores encargados de hacer consultas a las tres tablas de la base de datos (Users, Players y Api_players). Las vistas las tenemos en vistas/, archivos programados en PHP que manejan los datos sacados de la base de datos mediante los modelos.

La base de datos es un MySQL llamada footstats. Tiene tres tablas: Users, Players y Api_players.

## Inicio de sesión y registro de usuarios
La aplicación permite registrarse e iniciar sesion. El registro es manejado mediante el modelo que se encarga de filtrar y sanear todos los datos, despues los guarda en la base de datos. La contraseña se guarda cifrada con un salt. En cuanto al inicio de sesión, manejamos el login con cookies, de forma que podemos restringir a donde puede entrar un usuario logeado y a donde no uno no logeado. Si iniciamos sesion, se crea una cookie. Esta cookie tiene 2 datos en su interior: un numero divisible entre 69 y el ID del usuario logeado. Lo que hacemos con la cookie es juntar estos dos datos y cifrarlos con una clave privada para que nadie que no sea la aplicacion pueda forgar las cookies. Para poder validar las cookies simplemente desciframos con la clave privada y verificamos que el numero divido entre 69 da 0.

## Permisos
En footstats solo el administrador puede actualizar la base de datos. Para hacer esto verificamos que un bit esta activado en la base de datos de usuarios, si es el caso le mostramos la opcion de actualizar bd en la cabecera. Lo que hace esta opcion es llamar a una API externa de jugadores de futbol, de la cual sacaremos todos los jugadores y los guardaremos en la base de datos. Al guardarlos en la base de datos podemos hacer solo una llamada a la API pero mostrar todas las veces que queramos los jugadores.

## Editar informacion del usuario
FALTA POR HACER

# OTRA INFORMACION

## Llamadas API
Usamos una API que permite sacar los jugadores de futbol de ciertos equipos gratis. Tenemos un numero limitado de llamadas a la API, de forma que es mejor no spamear las llamadas. Para conseguir la API_KEY es necesario iniciar sesion en https://www.api-football.com/

## Comando para construir el contenedor de docker
docker compose up -d --build

## Comando para entrar en la base de datos MySQL
docker exec -it footstats-db mysql -u root -p
contraseña: rootpass