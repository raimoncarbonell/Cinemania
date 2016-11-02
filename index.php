<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        <title>CINEMANIA-Inicio</title>
        <link rel="stylesheet" type="text/css" href="/Francesc/Practica-2/css/estilos.css">
        <style>
            body
            {
                background-image: url(/Francesc/Practica-2/vista/imatges/CINE2.jpg);
            }          
        </style>        
    </head>
    
    <body>
          
        
        
        <header>
            <H1>CINEMANIA</H1>
            <form method="post" action="administrador.php" id="identificador">
                
                <input type="text" name="usuario" placeholder="usuario">
             
                <input type="password" name="pwd" placeholder="password">
                <button type="submit">Entrar</button><br>
            </form>       
        </header>
    
        <div id="contenedor">
       
  
         <form method="get" action="index.php" id="busquedapelis">
            <label>Búsqueda Película</label>
            <input type="text" name="cadena">
            <label>Ordenar por: </label>
            <select name="order"> 
                <option value="id">Fecha de aparición en Cinemania</option>
                <option value="titulo">Título</option>
                <option value="anyo">Año</option>
                <option value="avg(criticas.nota)">Nota Media</option>                 
            </select>
            <button type="submit">Buscar</button>           
        </form>
        
        <?php
        
        
        if(isset($_GET['cadena']))
        {    
        $sel = "SELECT categorias.nombre,cinemania.id,cinemania.foto,cinemania.titulo,avg(criticas.nota) as nota_media, cinemania.anyo FROM cinemania left join criticas on(cinemania.id=criticas.id_pelicula),categorias WHERE cinemania.categoria_id=categorias.id and (cinemania.titulo LIKE ('".$_GET['cadena']."%') or cinemania.titulo LIKE ('%".$_GET['cadena']."%') or cinemania.titulo LIKE ('%".$_GET['cadena']."'))  group by cinemania.id order by ".$_GET['order'].";";
        }
        else $sel = "SELECT categorias.nombre,avg(criticas.nota) as nota_media,cinemania.id,cinemania.foto,cinemania.titulo, cinemania.anyo FROM cinemania left join criticas on(cinemania.id=criticas.id_pelicula),categorias where cinemania.categoria_id=categorias.id group by cinemania.id;";
        $sel2="select * from categorias;";
        try{
            $con = new PDO('mysql:host=localhost;dbname=cinemania', "root"); 
        }catch(PDOException $e){
            echo "<div class='error'>".$e->getMessage()."</div>"; 
            die();
        }
            
        $res = $con->query($sel); 
        $res2=$con->query($sel2);
        
    
        echo "<nav><ul id='nopeliculas'>";
        foreach ($res2 as $fila)
        {
            echo "<li><a href='controlador.php/publicat?id=".$fila["id"]."'>".$fila["nombre"]."</a></li>";
        }
        echo "</ul></nav>";
        echo "<table>";
        if($res->rowCount()>0)
        {    
        foreach($res as $fila)
        {
            $nota_media=$fila['nota_media'];
            $nota_media=floatval($nota_media);
            $nota_media=round($nota_media,2);
            echo "<tr><td><img class='caratula' alt='Carátula del film' src='${fila['foto']}'></td><td><a href='controlador.php/publicvistapeli?id=".$fila["id"]."'>".$fila["titulo"]."</a></td><td>".$fila["anyo"]."</td><td>".$fila["nombre"]."</td><td class='notamedia'>".$nota_media."</td></tr>";
        }
        
        }
            else echo "<tr><th>No hay películas que cumplan los criterios de búsqueda</th></tr>";
      echo "</table>";
       
        ?>
            
            
      </div>
    </body>
</html>
        
        