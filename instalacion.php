<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>crear bd Contactos</title>
        <link href="estilos.css" rel="stylesheet">
       
    </head>
    <body>
        <h1>INSTALACION</h1>
        
        <?php
        
          try
            {
                $conexion = new PDO('mysql:host=localhost', "root");
            }
          catch(PDOException $e)
            {
                echo "Error:".$e->getMessage(); 
                die();
            }
        
        // borramos la base de datos antes que nada para no tener que borrarla en myadmin
        
        
          $sql="drop database if exists cinemania;";
          $res=$conexion->exec($sql);
          
        
        // creamos la base de datos cinemania
        
          $sql="create database cinemania;";
          $res=$conexion->exec($sql); //exec nos devuelve el número de filas afectadas o "false" (o "0") si no ha podido crear la BD
          if($res===FALSE)
              {
                  echo "<p>No se ha podido crear la base de datos</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Base de Datos creada</p>";
              }
          
          // nos conectamos a la base de datos que hemos creado
        
          $sql="use cinemania;";
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>No se ha podido crear la base de datos</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Conectados a 'cinemania'</p>";
              }
        
        
         //creamos tabla categorias
        
          $sql=<<<sql
create table categorias(
	id int primary key auto_increment,
    nombre varchar(20) not null unique
	
	
);
sql;
       $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>No se ha podido crear la tabla categorias</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Tabla categorias creada!!!</p>";
              }
         
        
       //insertamos en categorias
        
         $sql=<<<sql
          
INSERT INTO `categorias` (`id`, `nombre`) VALUES (NULL, 'Sci-Fi'),(NULL, 'Acción'),(NULL, 'Animación'),(NULL, 'Aventuras'),(NULL, 'Terror'),(NULL, 'Comedia'),(NULL, 'Drama'),(NULL, 'Romantica'),(NULL, 'Musical'),(NULL, 'Western');
sql;
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>Error al añadir datos en categorias</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Se han añadido $res filas en la tabla categorias</p>";
              } 
           
        
        // creamos tabla cinemania
        
           $sql=<<<sql
create table cinemania(
	id int primary key auto_increment,
	titulo varchar(40) not null unique,
    anyo int,
    categoria_id int,
    director varchar (40),
    sinopsis text not null,
    affinity varchar (60),
    foto varchar(140),
    foreign key (categoria_id) references categorias(id) ON DELETE SET NULL ON UPDATE CASCADE
);
sql;
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>No se ha podido crear la tabla cinemania</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Tabla contactos creada!!!</p>";
              }
        
        
        // creamos tabla criticas
        
        
          $sql=<<<sql
create table criticas(
	id int primary key auto_increment,
	autor varchar (40),
    id_pelicula int,
    texto text not null,
    nota int,
	foreign key (id_pelicula) references cinemania(id) ON DELETE CASCADE ON UPDATE CASCADE
	
);
sql;
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>No se ha podido crear la tabla criticas</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Tabla criticas creada!!!</p>";
              }
   
        
     
        
         
          
        
        
        // insertamos datos cinemania
        
           
          $sql=<<<sql
          
INSERT INTO `cinemania` (`id`, `titulo`, `anyo`,`categoria_id`, `director`, `sinopsis`, `affinity`, `foto`) VALUES (NULL, 'HER', '2013',1, 'Spike Jonze', 'En un futuro cercano, Theodore, un hombre solitario a punto de divorciarse que trabaja en una empresa como escritor de cartas para terceras personas, compra un día un nuevo sistema operativo basado en el modelo de Inteligencia Artificial, diseñado para satisfacer todas las necesidades del usuario. Para su sorpresa, se crea una relación romántica entre él y Samantha, la voz femenina de ese sistema operativo.', 'https://www.filmaffinity.com/es/film889720.html', 'vista/imatges/her.jpg'),(NULL, 'Cabaret','1972',9,'Bob Fosse','Berlín anyos 30. El partido nazi domina una ciudad donde el amor, el baile y la música se mezclan en la animada vida nocturna del Kit Kat Club. Un refugio mágico donde la joven Sally Bowles y un divertido maestro de ceremonias hacen olvidar las tristezas de la vida','http://www.filmaffinity.com/es/film307971.html','vista/imatges/cabaret.jpg'),(NULL, 'Rocky IV','1985',4,'Sylvester Stallone','Nuevas aventuras tanto personales como deportivas del boxeador Rocky Balboa, que en esta ocasión debe enfrentarse a un duro y frío boxeador soviético, llamado Ivan Drago','http://www.filmaffinity.com/es/film404346.html','vista/imatges/rocky_iv.jpg'),(NULL, 'SAW','2004',5,'James Wan','Adam se despierta encadenado a un tubo oxidado dentro de una decrépita cámara subterránea. A su lado, hay otra persona encadenada, el Dr. Lawrence Gordon. Entre ellos hay un hombre muerto. Ninguno de los dos sabe por qué está allí, pero tienen un casette con instrucciones para que el Dr. Gordon mate a Adam en un plazo de ocho horas. Recordando una investigación de asesinato llevada a cabo por un detective llamado Tapp, Gordon descubre que él y Adam son victimas de un psicópata conocido como Jigsaw. Sólo disponen de unas horas para desenredar el complicado rompecabezas en el que están inmersos','http://www.filmaffinity.com/es/film988480.html', 'vista/imatges/saw.jpg'),(NULL, 'Pulp Fiction','1994',2,'Quentin Tarantino','Jules y Vincent, dos asesinos a sueldo con no demasiadas luces, trabajan para el gángster Marsellus Wallace. Vincent le confiesa a Jules que Marsellus le ha pedido que cuide de Mia, su atractiva mujer. Jules le recomienda prudencia porque es muy peligroso sobrepasarse con la novia del jefe. Cuando llega la hora de trabajar, ambos deben ponerse "manos a la obra". Su misión: recuperar un misterioso maletín','http://www.filmaffinity.com/es/film160882.html', 'vista/imatges/pulp_fiction.jpg'),(NULL, 'Frozen','2013',3,'Chris Buck, Jennifer Lee','Cuando una profecía condena a un reino a vivir un invierno eterno, la joven Anna, el temerario montañero Kristoff y el reno Sven emprenden un viaje épico en busca de Elsa, hermana de Anna y Reina de las Nieves, para poner fin al gélido hechizo. Adaptación libre del cuento "La reina de las nieves"','http://www.filmaffinity.com/es/film926588.html', 'vista/imatges/frozen.jpg'),(NULL, 'Airbag','1997',6,'Juanma Bajo Ulloa','Juantxo pertenece a la alta sociedad; tiene dinero, una carrera universitaria acabada con 30 años, un magnífico trabajo de abogado y una novia guapa y rica, pero es un auténtico pardillo. Mientras celebra su despedida de soltero junto a dos mejores amigos en un prostíbulo, Juantxo pierde su anillo de compromiso. Será el inicio de una accidentada aventura en la que los tres se cruzarán con cargamentos de cocaína y mafiosos, a la búsqueda de la joya en un trepidante viaje lleno de vicio, corrupción y delirio','http://www.filmaffinity.com/es/film843800.html', 'vista/imatges/airbag.jpg'),(NULL, 'La lista de Schindler','1993',7,'Steven Spielberg','Segunda Guerra Mundial (1939-1945). Oskar Schindler (Liam Neeson), un hombre de enorme astucia y talento para las relaciones públicas, organiza un ambicioso plan para ganarse la simpatía de los nazis. Después de la invasión de Polonia por los alemanes (1939), consigue, gracias a sus relaciones con los nazis, la propiedad de una fábrica de Cracovia. Allí emplea a cientos de operarios judíos, cuya explotación le hace prosperar rápidamente. Su gerente (Ben Kingsley), también judío, es el verdadero director en la sombra, pues Schindler carece completamente de conocimientos para dirigir una empresa','https://www.filmaffinity.com/es/film656153.html', 'vista/imatges/schindler.jpg'),(NULL, 'El diario de Noa','2004',8,'Nick Cassavetes','En una residencia de ancianos, un hombre (James Garner) lee a una mujer (Gena Rowlands) una historia de amor escrita en su viejo cuaderno de notas. Es la historia de Noah Calhoun (Ryan Gosling) y Allie Nelson (Rachel McAdams), dos jóvenes adolescentes de Carolina del Norte que, a pesar de vivir en dos ambientes sociales muy diferentes, se enamoraron profundamente y pasaron juntos un verano inolvidable, antes de ser separados, primero por sus padres, y más tarde por la guerra','https://www.filmaffinity.com/es/film738597.html', 'vista/imatges/diariodenoah.jpeg'),(NULL, 'Sin perdón','1992',10,'Clint Eastwood','William Munny (Clint Eastwood) es un pistolero retirado, viudo y padre de familia, que tiene dificultades económicas para sacar adelante a su hijos. Su única salida es hacer un último trabajo. En compañía de un viejo colega (Morgan Freeman) y de un joven inexperto (Jaimz Woolvett), Munny tendrá que matar a dos hombres que cortaron la cara a una prostituta','https://www.filmaffinity.com/es/film262344.html', 'vista/imatges/sinperdon.jpg'),(NULL, 'Avatar','2009',1,'James Cameron','Año 2154. Jake Sully (Sam Worthington), un ex-marine condenado a vivir en una silla de ruedas, sigue siendo, a pesar de ello, un auténtico guerrero. Precisamente por ello ha sido designado para ir a Pandora, donde algunas empresas están extrayendo un mineral extraño que podría resolver la crisis energética de la Tierra. Para contrarrestar la toxicidad de la atmósfera de Pandora, se ha creado el programa Avatar, gracias al cual los seres humanos mantienen sus conciencias unidas a un avatar: un cuerpo biológico controlado de forma remota que puede sobrevivir en el aire letal. Esos cuerpos han sido creados con ADN humano, mezclado con ADN de los nativos de Pandora, los Na-vi. Convertido en avatar, Jake puede caminar otra vez. Su misión consiste en infiltrarse entre los Na-vi, que se han convertido en el mayor obstáculo para la extracción del mineral. Pero cuando Neytiri, una bella Na-vi (Zoe Saldana), salva la vida de Jake, todo cambia: Jake, tras superar ciertas pruebas, es admitido en su clan. Mientras tanto, los hombres esperan los resultados de la misión de Jake','http://www.filmaffinity.com/es/film495280.html', 'vista/imatges/avatar.jpg');
sql;
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>Error al añadir datos en cinemania</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Se han añadido $res filas en la tabla cinemania</p>";
              } 
        
        // insertamos en criticas
        
        
         $sql=<<<sql
          
INSERT INTO `criticas` (`id`, `autor`, `id_pelicula`, `texto`, `nota`) VALUES (NULL, 'Luis Martínez', '1', '"Hipnótica radiografía del amor en tiempos cibernéticos. (...) una de las cintas más originales y brillantes del año.', '8'),(NULL, 'Francesc', '2', 'Uno de los mejores musicales de la historia, que extrae su fuerza de una dirección vibrante, unos diálogos con chispa, un mensaje previsible pero bien enmarcado en la historia, y unos estupendos intérpretes. Además, claro, de unos números musicales sencillamente soberbios, a los acordes de una banda sonora inolvidable.', '7'),(NULL, 'Francesc', '3', 'Stallone, intentando "actualizar" la serie, decide buscar el contrincante de Balboa en tierras comunistas para enfrentarle con un luchador ruso entrenado para ser implacable, insensible e indoloro. Más de lo mismo con un toque patriótico.', '10'),(NULL, 'Francesc', '4', 'Wan es un listo con todas las letras. Los giros de la trama son tan originales como tarados y el seguidor de este tipo de productos se va a reír de asuntos que no tienen la más mínima gracia. Sin embargo, Saw contiene errores (...) cuando saca la acción al exterior del cuarto de baño decae muchos enteros.', '8'),(NULL, 'Francesc', '5', 'Tras firmar con "Reservoir Dogs" (1992) una de las más geniales óperas primas jamás realizadas, Quentin Tarantino confirma su talento único en esta brillantísima película de acción, con diálogos y toques de comedia delirantes ("Soy el Sr. Lobo, resuelvo problemas") al lado de escenas que rayan lo desagradable por su violencia y crudeza. Maravillosamente filmada, de nuevo sorprende su estructura narrativa en un desborde de creatividad estética y guiños cinéfilos de enorme impacto en crítica y público. Un póster perfecto, el misterioso maletín como MacGuffin, una banda sonora impecablemente elegida, un comienzo en una (otra) cafetería inolvidable, John Travolta bailando... Son innumerables los hallazgos de esta sinfonía audiovisual pop que reinventa (o se inventa) una fusión de códigos y géneros para alumbrar todo un clásico del cine moderno.', '10'),(NULL, 'Francesc', '6', '"Una lección magistral de traición creativa que, he aquí lo importante, se convierte, también, en una gran película y un espectacular acto de autoafirmación. (...)"', '9'),(NULL, 'Raimon', '7', 'Comedieta que abusa de lo efectista y, sobre todo, de lo chabacano, y acumula tanto desmadre y diversión como ausencia de rigor y de imaginación (...) innegable talento visual y narrativo de Bajo Ulloa al servicio de la nada (...) Chiste tras chiste se agota la gracia', '6'),(NULL, 'Raimon', '8', 'Seguramente consciente del enorme reto que suponía poner su arte y su nombre para contar la "Shoah", una historia tan sensible para los judíos, Spielberg exprimió su talento para estremecer al mundo con su desgarrador y magistral relato de las víctimas del holocausto nazi. Asombrosamente contada, "La lista de Schindler" es una poderosa y compleja narración que desarma al espectador ante la visión de una angustia casi inaguantable, no exenta de una visión esperanzadora del hombre. Su gran mérito no fue el unánime reconocimiento de la crítica, ni tan siquiera sus 7 Oscars incontestables. El gran legado, el impagable logro del inteligente realizador americano con esta impresionante película fue su merecidísimo éxito de taquilla, fue usar su fama de director "comercial" para recordar a las generaciones que no vivieron la Segunda Guerra Mundial que tal barbaridad existió.', '10'),(NULL, 'Raimon', '9', 'The Notebook (El diario de Noa) no es una obra redonda, pero es una garantía para cualquier adolescente que busque una recomendación fuera del proselitismo cinéfilo. Promocionarla es infalible, y ahí están los encargados de los videoclubs para darme la razón. Contada con ritmo de forma notable, y tocando las fibras justas en el momento adecuado, es difícil resistirse a los encantos de este drama romántico juvenil, por previsible que parezca. Lo acaramelado de la historia queda eclipsado por una ambientación ídílica y envolvente, marco propicio para un tierno relato que adquiere una inusitada potencia por sus interpretaciones principales, delicadas y convincentes. De Garner y Rowlands poco hay que destacar, dado su historial. Pero son los jóvenes los que se comen la pantalla. McAdams está arrebatadora, tan radiante como natural, y Gosling es el gran descubrimiento. Atractivo, seguro, enamorado. Un galán con las dotes interpretativas de Edward Norton. Lo dicho, querido amigo: pregunta a la chica que te gusta si ha visto "El diario de Noa". Si te dice que no, eres un tipo afortunado. Siempre que tengas a mano un DVD y un salón en penumbra, claro. Pero ten cuidado: puede que en la escena cumbre, justo cuando tengas a tu amada en su punto más vulnerable, te veas sorprendido tratando de esconder una lagrimilla cayendo por tu mejilla. Avisado quedas.', '8'),(NULL, 'Raimon', '10', 'Eastwood vuelve a homenajear (ya lo hizo en "El jinete pálido") al género que lo hizo famoso, ahora en decadencia, con otro deslumbrante relato sobre la dignidad de unos perdedores a la intemperie del otoño. Sombría, sucia, fascinante, plena de fuerza y rebosante de amargura. Las dos palabras que mejor definen "Sin perdón" no son western crepuscular. Son obra maestra.', '10'),(NULL, 'Raimon', '11', 'El espectáculo se despliega durante 160 minutos, pero la emoción de estar viendo la esperadísima “Avatar” (o “James Cameron y sus aliens, el regreso”) apenas alcanza una hora. Es lo que tardas en acostumbrarte a la maravilla visual, para comenzar a darte cuenta de que, mientras estabas ascendiendo a la cumbre del 3D, el guión cayó precipicio abajo, para hundirse en la sima del convencionalismo y los lugares comunes del cine más comercial.', '8');
sql;
        
          $res=$conexion->exec($sql); 
          if($res===FALSE)
              {
                  echo "<p>Error al añadir datos en criticas</p>";
                  echo "<p>".$conexion->errorInfo()[2]."</p>";
              }
          else
              {
                  echo "<p>Se han añadido $res filas en la tabla críticas</p>";
              } 
        
        
      
        
        ?>
    </body>
</html>