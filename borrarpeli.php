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
     <header id="headermanten">
            <H1>CINEMANIA</H1>
              <?php echo "<a title='volver al entorno de mantenimiento' alt='mantenimiento.php' href='administrador.php'><img id='home' alt='mantenimiento.php'  src='vista/imatges/inicio.png'></a>";?>   
    </header>
    <div id="contenedor">
       

<?php
    session_start();

if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{
    
  if(isset($_GET["titulo"]) )
        {    
           
            echo "<h2>Borrado de la película ".$_GET['titulo']."</h2><div id='confirmacion'><p>Seguro que quieres borrar la pelicula <br><span>".$_GET['titulo']." </span>?</p>";
            echo "<form method='post' action='borrarpeli.php'>";
            echo "<input type='radio' name='confirmar' value='si'>Sí<br>";
            echo "<input type='radio' name='confirmar' value='no' checked>No<br>";
            echo '<input type="text" style="visibility:hidden;width:0" name="titulo" value="'.$_GET["titulo"].'">';
            echo "<p><input type='submit' value='confirmar'></p>";
           
            echo "</form>";
            echo "</div>";
        }
            
        if(isset($_POST["confirmar"]))
        {
            if($_POST["confirmar"]==="si")
            {
                try
                    {
                        $conexion = new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }
                
                
              

              $sql = "delete from cinemania where cinemania.titulo='".$_POST["titulo"]."';";

              

              $res=$conexion->exec($sql); 
              if($res===FALSE)
                  {
                      echo "<p>Error al borrar pelicula</p>";
                      echo "<p>".$conexion->errorInfo()[2]."</p>";
                  }
              else
                  {
                      
                  
                  header ("location:administrador.php");
                 
                  
                  }
                
          
             
        }
            
        if($_POST["confirmar"]==="no") header ("location:administrador.php");
            
        else if($_POST["confirmar"]
                !=="no" && $_POST["confirmar"]
                !=="si") header ("location:administrador.php");
        }
        
        
      
        
    

}
?>
           
            </div>  
    
    </body>




</html>