-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2021 a las 07:01:06
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Base de datos: 'parkour'
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'equipo'
--

CREATE TABLE equipo (
  id_equipo bigint(20) PRIMARY KEY AUTO_INCREMENT,
  nombre_equipo varchar(150) NOT NULL,
  lugar_equipo varchar(250) NOT NULL,
  paginaweb_equipo varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

--
-- Volcado de datos para la tabla 'equipo'
--

INSERT INTO equipo (nombre_equipo, lugar_equipo, paginaweb_equipo) VALUES
('Programacion en desarrollo web','Neuquén','http://localhost/pwa/parkour/'),
('Escuela integral de parkour', 'Ciudad Autónoma de Buenos Aires', 'https://parkourintegral.com/'),
('Club Andino Villa La Angostura', 'Villa la angostura', 'https://www.facebook.com/watch/Club-Andino-Villa-La-Angostura-134010936629558/'),
('Tempest Academy', 'California', 'https://www.tempestacademy.com/'),
('Redbull', 'Austria', 'https://www.redbull.com/'),
('JLM Urban Sport', 'Reino Unido', 'https://parkouragency.co.uk/'),
('Storror', 'Reino Unido', 'https://www.storror.com/');
-- --------------------------------------------------------
CREATE TABLE pais (
  id_pais bigint(20) PRIMARY KEY AUTO_INCREMENT,
  nombre_pais varchar(100) NOT NULL
)ENGINE=InnoDB DEFAULT charset=UTF8;

INSERT INTO pais (nombre_pais)VALUES
('Argentina'),
('Bolivia'),
('Chile'),
('Colombia'),
('Ecuador'),
('Paraguay'),
('Uzbekistán'),
('Australia'),
('Gran Bretaña'),
('Polonia'),
('Grecia'),
('Letonia'),
('Ucrania'),
('Inglaterra'),
('Reino Unido'),
('Estados Unidos'),
('Alemania');

CREATE TABLE provincia (
  id_provincia bigint(20) PRIMARY KEY AUTO_INCREMENT,
  id_pais bigint(20) NOT NULL,
  nombre_provincia varchar(100) NOT NULL,
  FOREIGN KEY(id_pais) REFERENCES pais(id_pais) ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT charset=UTF8;

INSERT INTO provincia(id_pais,nombre_provincia)VALUES
('1','Buenos Aires'),
('1','Misiones'),
('1','La Pampa'),
('1','Tierra Del Fuego'),
('1','Chaco'),
('1','Santa Fe'),
('1','Cordoba'),
('1','Entre Rríos'),
('1','Chubut'),
('1','Rio Negro'),
('1','Mendoza'),
('1','Salta'),
('1','Tucuman'),
('1','Corrientes'),
('1','Neuquén'),
('1','Jujuy'),
('1','San Luis'),
('1','San Juan'),
('1','Santa Cruz'),
('1','La Rioja'),
('1','Catamarca'),
('1','Formosa'),
('1','Santiago Del Estero'),
('2','Dto. Beni'),
('2','Dto. Chuquisaca'),
('2','Dto Cochabamba'),
('2','Dto. La Paz'),
('2','Dto. Oruro'),
('2','Dto. Pando'),
('2','Dto. Potosí'),
('2','Dto. Santa Cruz'),
('2','Dto. Tarija'),
('3','Region de Arica y Parinacota'),
('3','Region de Tarapacá'),
('3','Region de Antogafasta'),
('3','Region de Atacama'),
('3','Region de Valparaíso'),
('3','Region Metropolitana de Santiago'),
('3','Region del Libertador OHiggins'),
('3','Region del Maule'),
('3','Region de Ñuble'),
('3','Region del Biobio'),
('3','Region de La Araucanía'),
('3','Region de Los Ríos'),
('3','Region de Los Lagos'),
('3','Region de Aysén del Gral Ibañez del Campo'),
('3','Region de Magallanes y de la Antártica Chilena'),
('4','Amazonas'),
('4','Antioquía'),
('4','Arauca'),
('4','Atlántico'),
('4','Bolívar'),
('4','Boyacá'),
('4','Caldas'),
('4','Casanare'),
('4','Cauca'),
('4','Cesar'),
('4','Chocó'),
('4','Córdoba'),
('4','Cundinamarca'),
('4','Guainía'),
('4','Guaviare'),
('4','Huila'),
('4','La Guajira'),
('4','Magdalena'),
('4','Meta'),
('4','Nariño'),
('4','Norte de Santander'),
('4','Putumayo'),
('4','Quindío'),
('4','Risaralda'),
('4','San Andrés y Providencia'),
('4','Santander'),
('4','Sucre'),
('4','Tolima'),
('4','Valle del Cauca'),
('4','Vaupés'),
('4','Vichada'),
('5','Esmeralda'),
('5','Manabí'),
('5','Los Ríos'),
('5','Santa Elena'),
('5','Guayas'),
('5','Santo Domingod de los Tsáchilas'),
('5','El Oro'),
('6','Alto Paraguay'),
('6','Alto Paraná'),
('6','Amambay'),
('6','Boquerón'),
('6','Caaguazú'),
('6','Caazapá'),
('6','Canindeyú'),
('6','Central'),
('6','Concepción'),
('6','Cordillera'),
('6','Guairá'),
('6','Itapúa'),
('6','Misiones'),
('6','Ñeembucú'),
('6','Paraguarí'),
('6','Presidente Haris'),
('6','San Pedro'),
('7','Uzbekistán'),
('8','Australia'),
('9','Gran Bretaña'),
('10','Polonia'),
('11','Grecia'),
('12','Letonia'),
('13','Ucrania'),
('14','Inglaterra'),
('15','Reino Unido'),
('16','Estados Unidos'),
('17','Alemania');
--
-- Estructura de tabla para la tabla 'traceur'
--

CREATE TABLE traceur (
  id_traceur bigint(20) PRIMARY KEY AUTO_INCREMENT,
  id_grupo bigint(20) NOT NULL,
  id_pais bigint(20) NOT NULL,
  nombre_traceur varchar(150) NOT NULL,
  apellido_traceur varchar(150) NOT NULL,
  fechanacimiento_traceur date NOT NULL,
  biografia_traceur text NOT NULL,
  FOREIGN KEY (id_grupo) REFERENCES equipo(id_equipo) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (id_pais) REFERENCES pais(id_pais) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

--
-- Volcado de datos para la tabla 'traceur'
--

INSERT INTO traceur (id_grupo, id_pais,nombre_traceur, apellido_traceur, fechanacimiento_traceur, biografia_traceur) VALUES
(1, 1, 'admin','admin','0000-00-00','Estudiante de TUDW'),
(4, 7, 'Erik', 'Mukhametshin', '1990-04-02', 'Freerunner profesional, atleta de parkour y doble que es conocido por publicar una variedad de su trabajo en sus más de 330.000 seguidores en Instagram y más de 60.000 suscriptores en YouTube. Comenzó a entrenar en Judo a los 3 años. Luego comenzó a entrenar en parkour y continuó sobresaliendo. Después de ver la película YAMAKASI, decidió seguir una carrera como corredor libre.'),
(5, 8, 'Tommaso', 'Di Dominic', '1992-05-14', 'Frecuentemente muestra sus habilidades como corredor libre en Instagram, donde ha conseguido más de 1.3 millones de seguidores. Antes de ser corredor libre, estaba involucrado en el ballet y en el patinaje artístico. Trabajó como recolector de basura antes de cumplir su sueño de convertirse en atleta profesional.'),
(6, 9, 'Joseph', 'Henderson', '1996-01-01', 'Uno de los corredores libres más rápidos del mundo. Conocido como \"el campeón del pueblo\" del parkour. Estrellas, modelos y actos en campañas publicitarias para clientes de alto perfil como Just Eat, Abbott y BBC One. Ganador del Campeonato de Parkour de Velocidad de América del Norte de 2016. Podio colocado en múltiples competiciones de prestigio a nivel mundial. Realizado en festivales y eventos corporativos en vivo en todo el Reino Unido y en todo el mundo.'),
(5, 10,'Krystian', 'Kowalewski', '1998-08-25', '¡Hola! Mi nombre es Krystian Kowalewski de Nidzica en Polonia. Nací el 25/08/1998. Mi aventura con Parkour y Freerunning comenzó en octubre de 2011. Al principio, comencé a entrenar solo en el campo o en un pueblo cercano. En 2014, fui a mis primeras competencias BC3RUN CHALLENGE 2 y gané el premio al mejor junior;) en noviembre de 2014 fui invitado a Gdansk KS Movement Academy como invitado especial. En 2015 obtuve el 2do lugar en BC3RUN CHALLENGE 3: D'),
(4, 11,'Dimitris', 'Kyrsanidis', '1995-05-27', 'Corredor de estilo libre profesional y atleta de parkour con victorias en el Red Bull Art of Motion del 2014 y del 2015. Obtuvo un patrocinio con Red Bull y Tempest. Previo a eso fue patrocinado por Krap y fue un embajador para Team JiYo. Comenzó a entrenar como corredor de estilo libre desde el 2007 cuando tenía 12 años.'),
(5, 12,'Pavel', 'Petkuns', '1992-09-29', 'Artista dew parkour conocido por su trabajo como uno de los atletas patrocinados por Red Bull en su deporte. Se convirtió en la primera persona en ganar tres campeonatos consecutivos Art of Motion Freerunning de Red Bull. En el proceso de convertirse en el primer campeón en tres oportunidades de Art of Motion, también se convirtió en el primer atleta de habla rusa en ganar la competencia.'),
(5, 13,'Alexander', 'Titarenko', '1994-07-05', '-Me puse en camino con la esperanza de pasar la clasificación y, de repente, todo el mundo me felicitó por conseguir la victoria general-, dice Titarenko sobre ese logro que acapara los titulares. Su estilo confiado y exuberante ha seguido sirviéndole bien desde esa gran victoria, con Titarenko impresionando en las competiciones de parkour en todo el mundo. Esté atento a que gane más elogios muy pronto, y mírelo haciendo lo suyo en la ciudad ucraniana de Chernivtsi aquí mismo.'),
(7, 14,'Callum', 'Powell', '1991-08-08', 'Atleta inglés de parkour que saltó a la fama publicando videos y contenido de parkour en su cuenta de Instagram callumstorror. Ha conseguido más de 240.000 seguidores en la plataforma para compartir fotos y videos. En 2016 se incorporó al equipo de parkour profesional ETRE-FORT. También ha sido miembro de StorrorBlog.'),
(4, 16,'Nate', 'Weston', '1999-06-11', '¡Hola, mi nombre es Nate! Tengo 22 años y soy un atleta profesional de parkour con base en Missoula MT. Estoy dentro con el grupo tempest y el joven mas popular en free running y parkour'),
(2, 8,'Brodie', 'Pawson', '1994-08-16', 'Atleta profesional de parkour que compitió en la temporada inaugural de Australian Ninja Warrior junto a su hermano gemelo  Dylan Pawson. Creció viendo el programa deportivo japonés Sasuke, la serie que inspiró a Australian Ninja Warrior. u cuenta de Instagram homónima está llena de videos de él mismo corriendo libremente. La cuenta obtuvo 480.000 seguidores.'),
(3, 1, 'Joaquin', 'Barbeito', '1993-03-15', 'Joaquin es un residente de villa la angostura hace aproximadamente 4 años, anteriormente de la ciudad de Neuquén en donde realizo sus estudios de profesorado de educación física en ifes, practicante del deporte desde los 13 años y hoy en la actualidad es profesor de la escuela de parkour en el club andino de villa la angostura'),
(2, 1,'Franco', 'Dalesio', '2002-01-20', 'Hola! soy Franco Dalesio y soy freerunner desde los 15 años, me encanta disfrutar de esta deporte y tener la oportunidad de que en Buenos Aires se encuentre un espacio para practicarlo, también como pasa tiempo ando en skate pero ninguno los practico de manera profesional. '),
(2, 1,'Andres', 'Duarte', '1998-08-12', 'Buenas! soy Andres Ezequiel Duarte, practico el parkour como deporte de recreación, soy practicante y entranador en la Escuela Integral de Parkour que se encuentra en Buenos Aires. Te ayudo a entrenar desde los principios de manera presencial o virtual'),
(6, 15,'Damien', 'Walters', '1982-04-06', 'Damien Walters es un famoso gimnasta, que nació el 6 de abril de 1982 en Reino Unido. Ex gimnasta que ganó el Campeonato del Mundo como miembro del equipo británico en 2003. Desde entonces se ha convertido en un actor de acrobacias muy solicitado en películas como Skyfall, así como en un popular freerunner cuyos videos de YouTube han obtenido decenas de millones de visitas. Hizo acrobacias en las películas Kick-Ass y Kingsman: The Secret Service, ambas dirigidas por Matthew Vaughn.'),
(6, 16,'Timothy', 'Shieff', '1988-03-24', 'Timothy Shieff es un freerunner inglés. Ganó el Barclaycard World Freerun Championship en 2009 y participó en el programa de televisión Ultimate Parkour Challenge. Era vegano desde 2012 por motivos éticos y de salud. En 2018, mientras intentaba curar algunos problemas intestinales, comió salmón y huevos crudos, pero dijo que no era algo que volvería a hacer. Como resultado, la empresa de ropa vegana ETHCS lo eliminó de su etiqueta. En abril de 2019, Tim apareció en This Morning de ITV'),
(7, 14,'Max', 'Cave', '1991-12-23', 'Max Cave es una famosa estrella de YouTube. Nació el 23 de diciembre de 1991 y su lugar de nacimiento es Inglaterra. Max también es conocido como el freerunner que fue aclamado en 2016 cuando apareció un video de él saltando la brecha de 25 pies entre dos edificios en Hong Kong.Max es originario de Inglaterra. Jason Paul y él son bien conocidos por ser freerunners'),
(7, 14,'Benj', 'Cave', '1994-02-28', 'Freerunner inglés y atleta de parkour que saltó a la fama al publicar videos de ejecución urbana gratuita en el popular canal de YouTube StorrorBlog. Esta exposición lo llevó a reunir más de 240.000 seguidores en su cuenta de Instagram personal Benj Cave.'),
(6, 14,'Willis', 'Kie', '1988-12-11', 'Comenzó a entrenar como freerunner en el 2008. Luego se convirtió en profesional en el 2010. Después de ganar varias competencias y lanzar varias partes de video, ayudó a cofundar su propia compañía de freerunning que se llama Storm Freerun. Es conocido por ganar varias competencias, incluyendo el primer lugar en el World Aquatic Parkour Masters en China y el Jambo Speed ​​Challenge en Italia.'),
(5, 17,'Paul', 'Jason', '1991-02-18', 'Corredor de estilo libre profesional patrocinado por Red Bull, GoPro y Farang Clothing que pasa su tiempo viajando por el mundo, creando fotos y videos practicando corrida de estilo libre. Creció como un chico normal, explorando su vecindario, leyendo muchos libros, cambiando de deportes rápidamente y con un amor por los videojuegos e Internet. Descubrió la corrida de estilo libre cuando tenía 14 años y se enamoró de ella.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'imagen'
--

CREATE TABLE imagen(
  id_imagen bigint(20) PRIMARY KEY AUTO_INCREMENT,
  id_traceur bigint(20)NOT NULL,
  nombre_imagen varchar(50) NOT NULL,
  ruta_imagen varchar(150) NOT NULL,
  descripcion_imagen varchar(250) NOT NULL,
  nivel_imagen int(1) NOT NULL,
  FOREIGN KEY (id_traceur) REFERENCES traceur(id_traceur) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

--
-- Volcado de datos para la tabla 'imagen'
--

INSERT INTO imagen (id_traceur, nombre_imagen, ruta_imagen, descripcion_imagen, nivel_imagen) VALUES
(8, 'backflip', 'http://localhost/pwa/parkour/galeria/backflip-rio.jpg', 'Es una vuelta hacia atras, logramos altura y giramos el cuerpo hacia atras levantando las rodillas', 3),
(3, 'backflip', 'http://localhost/pwa/parkour/galeria/backflip.jpg', 'Es una vuelta hacia atras, logramos altura y giramos el cuerpo hacia atras levantando las rodillas', 3),
(3, 'pasavalla', 'http://localhost/pwa/parkour/galeria/pasavalla.jpg', 'Cuando nos acercamos al banco para saltar, apoyamos primero la mano habil y levantamos las piernas con la cadera', 1),
(3, 'reverso', 'http://localhost/pwa/parkour/galeria/reverso.jpg', 'El reverso es el principal salto para ir perdiendo el miedo al salto en movimiento, si bien es basico pero su practica nos ayuda a llevarlo a otros saltos en movimientos, conocer el cuerpo en el salto es muy importante', 1),
(1, 'reverso', 'http://localhost/pwa/parkour/galeria/dan.jpg', 'power move dan edwardes es similar al pasavalla, apoyamos la mano y luego damos la espalda consiguiendo altura y damos la espalda', 2),
(1,'perfil', 'http://localhost/pwa/parkour/galeria/danperfil.jpg', 'es la foto de dan edwardes de perfil', 0),
(2, 'double kong', 'http://localhost/pwa/parkour/galeria/doublekong.jpg', 'double kong, es poder realizar en un salto el kong apoyando al principio del banco y luego al final, dando el impulso en el primer kong, estiramos los brazos para realizar el segundo kong y pasamos las piernas entre los brazos', 3),
(6, 'human flag', 'http://localhost/pwa/parkour/galeria/flag.jpg', 'human flag, necesita mucha fuerza de brazos incluyendo el conocimiento de nuestro cuerpo para sostenerlo mientras nos agarramos de un poste y mantenemos el cuerpo de manera lateral', 3),
(6, 'salto brazo', 'http://localhost/pwa/parkour/galeria/saltobrazo.jpg', 'una de las primeras practicas influye la fuerza de los brazo para poder subir a un paredon sin necesidad de salta de manera previa, nos acercamos y enganchamos al paredon y luego subimos, o puede ser que salte de manera previa por la distancia, no po', 2),
(1, 'salto brazo', 'http://localhost/pwa/parkour/galeria/fondo.jpg', 'el salto brazo, es para engancharnos en el paredon al cual vamos a escalar, esta imagen es usada en el fondo de la pagina', 2),
(1, 'historia', 'http://localhost/pwa/parkour/galeria/historia.jpg', 'Esta imagen es utilizada para la descripcion de la historia del parkour, en donde fue basado el parkour', 0),
(12, 'salto recepcion', 'http://localhost/pwa/parkour/galeria/recepcion.jpg', 'siempre que saltamos de una altura no podemos perder de vista la manera en realizar la recepcion, siempre debemos tener cuidado en la manera de caer e ir puliendo la tecnica en cada salto', 1),
(9, 'run', 'http://localhost/pwa/parkour/galeria/run.jpg', 'Despues de los entrenamientos cotidianos podemos mejorar nuestra distancia en cada salto que realizamos, para esto debemos trabajar las piernas y realizarnos pruebas para conocernos', 1),
(9, 'gato', 'http://localhost/pwa/parkour/galeria/gato.jpg', 'es un nombre asociado al kong, puede llegar a haber variedad en los saltos como no, pero \"teoricamente\" son distintos ya que es mas frontan y el kong puede ser mas libre en su salto', 2),
(9, 'libre', 'http://localhost/pwa/parkour/galeria/free.jpg', 'Siempre en un recorrido libre vamos variando no solo con los saltos sino mutamos las maneras de realizarlos o simplemente creamos saltos comodos sin necesidad de cumplir un salto en especifico \"aunque mayormente tienen sus nombre pero no son reconoci', 2),
(10, 'kong', 'http://localhost/pwa/parkour/galeria/kong-largo.jpg', 'este kong es doble tambien pero logra una mayor distancia, no es distinto a otros pero se aprecia la distancia entre bancos y la tecnica se puede apreciar mucho mejor', 3),
(10, 'sideflip', 'http://localhost/pwa/parkour/galeria/sideflip-alto.jpg', 'el sideflip en este caso logre una precision impecable, donde su salto esta en altura y arriba de unos caños finos, la vuelta con caida de precision son caracteristicas que destacan en este caso a Nate Weston', 3),
(5, 'kong', 'http://localhost/pwa/parkour/galeria/kong.jpg', 'el salto kong puede ser utilizado en diversos entornos, no necesariamente debemos conseguir altura para realizarlo, en este caso es entre casas que se utiliza el kong y aun asi es mas dificil si el nivel del piso es inferior al que se venia corriendo', 3),
(7, 'pasavalla', 'http://localhost/pwa/parkour/galeria/pasavallas.jpg', 'el pasavallas es uno de los primeros movimientos en podes aprender, mas basico y mas utilizados para completar un circuito, nos ayuda a recuperar energias por lo simple', 1),
(7, 'precision', 'http://localhost/pwa/parkour/galeria/precision.jpg', 'Para realizar con tranquilidad los circuitos, debemos trabajar mucho en la precision ya que la misma fatiga nos la puede quitar y facilita a lastimarnos por confianza en cansancio, uno de los saltos mas trabajados', 1),
(4, 'rompemuñecas', 'http://localhost/pwa/parkour/galeria/rompe.jpg', 'rompe muñecas, su nombre no es en vano, los malos movimientos o inseguros a realizar el salto nos puede dejar secuelas graves, parece facil pero debemos entrenar las muñecas para esperar el peso de nuestro cuerpo en movimiento', 3),
(11, 'run', 'http://localhost/pwa/parkour/galeria/run-alto.jpg', 'a comparacion del otro run, este es realizado sobre altura, corre una distancia de 50m entre las columnas visibles', 3),
(11, 'saltobrazo', 'http://localhost/pwa/parkour/galeria/saltobrazo-alto.jpg', 'este salto de brazo es desde una larga distancia para poder llegar al paredón y luego ejerce la fuerza necesaria de brazos para subir', 2),
(3, 'sideflip', 'http://localhost/pwa/parkour/galeria/sideflip.jpg', 'Realiza sideflip que es la acrobacia de medialuna con altura, similar a la vuelta frontal pero es una medialuna el cual al mismo tiempo salta la reja y logra buscar precisión en la caída.', 3),
(1, 'siluetas', 'http://localhost/pwa/parkour/galeria/siluetas.jpg', 'son unas simples silutas de parkour', 0),
(1, 'yamakasi', 'http://localhost/pwa/parkour/galeria/yamakasi.jpg', 'es la foto que representa al primer grupo de parkour autollamados \"yamakasi\", ademas se encuentra una pelicula sobre ellos y aun hay grupos que forman parte hoy en dia', 4);

CREATE TABLE suscriptor(
  nombre_suscriptor varchar(50) PRIMARY KEY,
  empresa_suscriptor varchar(100) NOT NULL,
  contra_suscriptor text NOT NULL,
  id_provincia bigint(20) NOT NULL,
  telefono_suscriptor int NOT NULL,
  email_suscriptor text NOT NULL,
  FOREIGN KEY (id_provincia) REFERENCES provincia(id_provincia) ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE comentario(
  id_comentario bigint(20) PRIMARY KEY AUTO_INCREMENT,
  id_suscriptor varchar(50) NOT NULL,
  contenido_comentario text NOT NULL,
  FOREIGN KEY (id_suscriptor) REFERENCES suscriptor(nombre_suscriptor) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;