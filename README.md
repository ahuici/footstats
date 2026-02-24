# github
Acceder al github y realizar un git clone en nuestro ordenador

# footstats
Abre la carpeta del git clone recién realizado y abre una terminal en dicha carpeta, una vez ahi ejecuta el siguiente comando:
docker compose up -d --build

# en docker
correr el docker con la flecha azul y acceder al enlace del puerto 8080. 
IMPORTANTE: ESPERAR 15 SEGUNDOS A QUE ESTÉ TODO CARGADO.

# en la pagina web
botón registrar: Acceder a interfaz de registro de usuario
botón entrar: Acceder a interfaz de inicio de sesión
botón ver estadisticas: Desplaza hacia abajo para ver las estadísticas más relevantes

# usuario ya creado
Acceder a la página principal donde vemos un panel de estadísticas de numerosos jugadores y en la cabecera podemos observar otros botones, entre ellos: 

Ver Jugadores: Accede a la vista actual.
Refrescar BD: Solo visible si se es administrador y actualiza la base de datos que trae desde la API.
Mi perfil: Es un desplegable que nos permite cerrar sesión o editar el perfil del usuario.

# Botón Editar perfil 
Accede al menú de configuración del perfil de usuario, en el cual se puede cambiar todos los datos del usuario a excepción de a contraseña.
En esta vista se pueden apreciar dos botones para guardar o cancelar los cambios

# entrar en mysql 
docker exec -it footstats-db mysql -u root -p
contraseña: rootpass