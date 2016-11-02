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
              <?php echo "<a title='volver al entorno de mantenimiento'  href='administrador.php'><img id='home' alt='mantenimiento.php' src='vista/imatges/inicio.png'></a>";?>   
    </header>
    <div id="contenedor">
        
        
<?php
       
session_start();
 
 
    if(!isset($_SESSION['pwd']))
    {
        echo "No tienes permitido entrar aquí si no eres Administrador";
        echo "<br><a href='index.php'>Volver</a>";
        $_SESSION=[];
        session_destroy();
      
    }

       
   if(isset($_SESSION['pwd']))
   {
        echo "<div id='menuman'>";
         echo "<div class='bMan'><a  title='Aquí puedes añadir una película' href='anyadirpeli.php'>Nueva Película</a>";
        echo "</div>";
        
       echo "<div class='bMan'> <a href='categorias.php'  title='Aquí podrás añadir o eliminar categorías'>Categorias</a>";
        echo "</div>";
        
        
         echo "<div class='bMan'><a href='criticos.php'  title='Aquí puedes ver las críticas de los diferentes autores y borrarlas una a una, o eliminar de la base de datos todo lo relacionado con ese autor'>Críticos</a>";
        echo "</div>";
        
        echo "</div>";
         try{
            $con = new PDO('mysql:host=localhost;dbname=cinemania', "root"); 
        }catch(PDOException $e){
            echo "<div class='error'>".$e->getMessage()."</div>"; 
            die();
        }
       
          if(isset($_GET['ncategorias'])) 
        {    
             if($_GET["ncategorias"]!=null)
                {     
                $sql = "INSERT INTO `categorias` (`id`, `nombre`) VALUES (NULL, '".$_GET["ncategorias"]."');";

                  $res=$con->exec($sql); 

        
                }
          }
     
       $sql="SELECT categorias.nombre,categorias.id from categorias WHERE categorias.id NOT IN (select DISTINCT categorias.id from categorias,cinemania where cinemania.categoria_id=categorias.id)";
         $res=$con->query($sql); 
        
    
         if (isset($_GET['borrar_categoria']))
        {
            // borra categoria
             
             
             $sel = "SELECT nombre FROM categorias WHERE categorias.id =".$_GET['borrar_categoria']."";
          $res = $con->query($sel);
             
              foreach($res as $fila)
              {
              
               $_GET['borrar_categoria']=$fila['nombre'];
      
             
            echo "<h2>Borrar categoria ".$_GET['borrar_categoria']."</h2><div id='confirmacion'><p>Esta acción borrará la categoría <span>".$_GET['borrar_categoria']." </span>. Estás seguro?";
            echo "<form method='get' action='categorias.php'>";
            echo "<input type='radio' name='confirmar' value='si'>Sí<br>";
            echo "<input type='radio' name='confirmar' value='no' checked>No<br>";
            echo '<input type="text" style="visibility:hidden;width:0" name="borrar_categoria" value="'.$_GET['borrar_categoria'].'">';
            echo "<p><input type='submit' value='confirmar'></p>";
           
            echo "</form>";
            echo "</div>";
        }
         }
            
        if(isset($_GET["confirmar"]))
        {
            
            if($_GET["confirmar"]=="si")
            {
                $sql = "delete from categorias where nombre='".$_GET['borrar_categoria']."';";

              $res=$con->exec($sql); 
              header ("Location:categorias.php");
          
            }
            if($_GET["confirmar"]=="no")
            header ("Location:categorias.php");
        }
         
       ?>
        
    <table>
        
        <tr><td colspan="2">   
        <form method="get" action="categorias.php">
         
        
            <label>Nueva Categoria</label>
            <input type="text" name="ncategorias">
            <button type="submit">Crear Categoria</button>
           
            
        </form>
            </td>    
        </tr>
        <tr>
        <th colspan="2">Llista de categoria sin peliculas</th>
        </tr>
        <tr>
        <th>Categoria</th><th>Eliminar</th>
        </tr>
            <?php
        foreach($res as $fila)
            {
            ?>
            
                
                <tr>
                    <td><?php echo $fila['nombre'];?></td>
                <td><a href="categorias.php?borrar_categoria=<?php echo $fila['id']; ?>"><img src="imatges/eliminar.png" width="10" height="10" alt='eliminar'>  </a></td>
                  </tr>
                
        

            <?php
            }
       
       // formulario para crear catergorias 
       
         ?>
     
        <?php
        echo "</table>";
       
       
        // lista de categrias con pelis
       
        $sql="SELECT categorias.nombre, count(*) as numPeliCategoria,categorias.id from categorias,cinemania WHERE cinemania.categoria_id=categorias.id GROUP by categorias.nombre";
         $res=$con->query($sql);
       echo "<table>";
       echo "<tr><th>Categorias</th><th>Numero de Peliculas de la Categoria</th> </tr>";
         foreach($res as $fila)
         {
             ?>
             <tr>
                    <td><a href="categorias.php?categoriaPelis=<?php echo $fila['id']; ?>"><?php echo $fila['nombre'];?></a></td>
                <td><a href="categorias.php?categoriaPelis=<?php echo $fila['id']; ?>"> <?php echo $fila['numPeliCategoria'] ?></a></td>
                  </tr>
        <?php
         }
       
        
       
       if (isset($_GET["categoriaPelis"]))
       {
        echo "</table><table>";   
           // lista de peliculas de la categoria 
            $sql="SELECT categorias.id,categorias.nombre,avg(criticas.nota) as nota_media,cinemania.id as idpeli,cinemania.foto,cinemania.titulo, cinemania.anyo FROM cinemania left join criticas on(cinemania.id=criticas.id_pelicula),categorias where cinemania.categoria_id=categorias.id and categorias.id=".$_GET["categoriaPelis"]." group by cinemania.id;";
        
              $res=$con->query($sql);
                $res=$res->fetchAll();
                   
           echo "<tr><td colspan='5'><h2>".$res[0]["nombre"]."</h2></td></tr>";
           
       
                foreach ($res as $fila)
                {
                    

               
                


                    $nota_media=$fila['nota_media'];
                    $nota_media=floatval($nota_media);
                    $nota_media=round($nota_media,2);
                    echo "<tr><td><img alt='Carátula del film' src='${fila['foto']}'></td><td>".$fila["titulo"]."</td><td>".$fila["anyo"]."</td><td>".$fila["nombre"]."</td><td class='notamedia'>".$nota_media."</td></tr>";
                }
           ?>
            
        <?php
        
        }
       
       
       
       }
       
  
   
?>
         </table>
    </div>   
</body>
</html>
       