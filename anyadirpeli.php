<!doctype html>
<html lang="es">
    <head>
       <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
          <script>
          tinymce.init({
            selector: '#mytextarea',
              menubar:false,
              plugins: 'lists advlist autolink charmap code textcolor colorpicker emoticons media image paste searchreplace table fullscreen',
              toolbar: "undo redo paste copy searchreplace fullscreen | styleselect bold italic forecolor backcolor | code charmap emoticons media image table",
              image_dimensions: false,
              media_dimensions: false
             
          });
        </script>
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
              <?php echo "<a title='volver al entorno de mantenimiento' href='administrador.php'><img id='home'  alt='inicio' src='vista/imatges/inicio.png'></a>";?>   
    </header>
    <div id="contenedor">
        
<?php
session_start();
$f=""; 
if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{
        echo "<div id='menuman'>";
         echo "<div class='bMan'><a  title='Aquí puedes añadir una película' href='anyadirpeli.php'>Nueva Película</a>";
        echo "</div>";
        
       echo "<div class='bMan'> <a href='categorias.php'  title='Aquí podrás añadir o eliminar categorías'>Categorias</a>";
        echo "</div>";
        
        
         echo "<div class='bMan'><a href='criticos.php'  title='Aquí puedes ver las críticas de los diferentes autores y borrarlas una a una, o eliminar de la base de datos todo lo relacionado con ese autor'>Críticos</a>";
        echo "</div>";
        
        echo "</div>";    
        echo "<h2>Añadir Película</h2>";
          try
                {
                        $con= new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }
    
            echo "<form id='formmodificar' method='post' action='anyadirpeli.php' enctype='multipart/form-data'>";
            echo "<br>";
            echo "<br>";
            echo "<label>Titulo</label><br><input type='text' name='titulo'><br>";
            echo "<label>Año </label><br><input type='number' name='anyo'><br>";
    
    echo "<label>Genero</label><br><br>";
    echo "<select name='categoria'>"; 
             
            $sel = "SELECT * FROM categorias";
        
      
            
        $res = $con->query($sel);
            //print_r($res);
    
    foreach($res as $filac)
        {
        
        
                echo " <option value='${filac['id']}'>${filac['nombre']}</option>";
                
        
        }
     
            echo "</select>";
            
            echo "<br>";
            echo "<label>Director</label><br><input type='text' name='director'><br>";
          echo "<div>";
            echo "<label>Sinopsis</label><br><textarea id='mytextarea' rows='8' cols='10' name='sinopsis'></textarea><br>";
            echo "</div>";

            echo "<label>Affinity</label><input type='text' name='affinity'><br>";
             echo "<label>Foto <br></label>
             
             
             <input type='file' name='foto'><br>";
    
            echo "<label>Fondo (ojo! que sea JPG o JPEG) <br></label>
             
             
             <input type='file' name='fondo'><br>"; 

    
            echo "<p><input type='submit' value='Añadir Pelicula'></p></form>";
            
     
    
     if(isset($_FILES['foto']))
                {
                    
                    $target_path = "vista/imatges/".$_FILES['foto']['name'];
                    $f=$target_path;
                    
                    if(!move_uploaded_file($_FILES['foto']['tmp_name'], $target_path))
                    {
                       
                        echo "";

                    } 
                   
                }
    
    
    if(isset($_FILES['fondo']))
                {
                    
                 $target_path2 = "vista/imatges/".$_FILES['fondo']['name'];
                    
                    
                    
                    if(move_uploaded_file($_FILES['fondo']['tmp_name'], $target_path2))
                    {
                        rename($target_path2,"vista/imatges/".$_POST['titulo']."2.jpg");
                         
                    }
                }
    
    if(count($_POST)>5)
    {
        if($_POST["titulo"]=="") echo "<div class='yaexiste'>Debes ponerle un título a la película</div>";
        if($_POST["anyo"]==0) echo "<div class='yaexiste'>Seguro que el año de estreno de esta película es el mismo del nacimiento de Jesucristo?</div>";
        if($_POST["director"]=="") echo "<div class='yaexiste'>Quién la dirigió, el hombre invisible?</div>";
        if($_POST["sinopsis"]=="") echo "<div class='yaexiste'>Por la sinopsis parece un poco aburrida la peli, no?  PONLE UN ARGUMENTO!!</div>";
        
        
        
        else
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

        //  -----------------------------------------------  //
        
       
        
        
              $sql = "INSERT INTO `cinemania` (`id`, `titulo`, `anyo`, `categoria_id`, `director`, `sinopsis`, `affinity`, `foto`) VALUES (NULL, '".$_POST["titulo"]."', '".$_POST["anyo"]."', ".$_POST["categoria"].", '".$_POST["director"]."', '".$_POST["sinopsis"]."', '".$_POST["affinity"]."', '$f');";

              

              $res=$conexion->exec($sql); 
        
           
              if($res===FALSE)
                  {
                      
                      if($conexion->errorInfo()[2]=="Duplicate entry '".$_POST["titulo"]."' for key 'titulo'")
                          
                          echo "<div id='yaexiste'>Ya existe una película con el título".$_POST["titulo"]."</div>";
                  }
              else
                  {
                      header ("Location:administrador.php");
                 
                  
                  }
        }
        
    }
        
}
       
        
    
?>
    
    </div>        
</body>

</html>