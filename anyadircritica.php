<!doctype html>
<html lang="es">

        <meta charset="utf-8">
        <title>película</title>
        <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
          <script>
        
          tinymce.init({
            selector: '#mytextarea',
              menubar:"edit tools insert",
              plugins: 'lists advlist autolink charmap code textcolor colorpicker emoticons media image paste searchreplace table fullscreen',
              toolbar: "undo redo paste copy searchreplace fullscreen | styleselect bold italic forecolor backcolor | code charmap emoticons media image table"
             
          });
              
        </script>
        <style>
            
                  #info
            {
                
               width: 95%;
                height: 10%; 
                background-color: green;
                margin-top: 10%;
                margin-left: 5%;
            }
            
    </style>        


<?php
session_start();

if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
    
     try
                    {
                        $conexion = new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }
{
        if (isset($_GET["id"]))
        {    

           
            echo "<form method='post' action='anyadircritica.php'>";
             echo "<input type='number' style='visibility:hidden' value=".$_GET['id']." name='id'>";
            echo "<label>Nombre</label><input type='text' name='nombre'><br>";
            echo "<label>Texto Crítica</label><textarea  id='mytextarea' rows='12' cols='50' name='texto'></textarea><br>";
            
    
            echo "   <select name='nota'> 
                    <option value='0'>0</option>
                   <option value='1'>1</option>
                   <option value='2'>2</option>
                   <option value='3'>3</option>
                   <option value='4'>4</option>
                   <option value='5'>5</option>
                   <option value='6'>6</option>
                   <option value='7'>7</option>
                   <option value='8'>8</option>
                   <option value='9'>9</option>
                   <option value='10'>10</option>
                    </select>";
            
            echo "<p><input type='submit' value='añadir critica'></p>";
            echo "</form>";
            
        }
    
    }
     
      if(isset($_POST["texto"]))
      
    {      
    

              $sql = "INSERT INTO `criticas` (`id`, `autor`, `texto`,`id_pelicula`, `nota`) VALUES (NULL, '".$_POST["nombre"]."', '".$_POST["texto"]."', ".$_POST["id"].",".$_POST["nota"].");";

              $res=$conexion->exec($sql); 
        
            print_r($res);
              if($res===FALSE)
                  {
                      echo "<p>Error al añadir la crítica</p>";
                      echo "<p>".$conexion->errorInfo()[2]."</p>";
                  }
            
          $id=$_POST['id'];
          $nombre=$_POST['nombre'];
          $texto=$_POST['texto'];
          $nota=$_POST['nota'];
          
          
          
          header("Location:/Francesc/Practica-2/adminvercriticas.php?id_pelicula=$id&nombre=$nombre&texto=$texto&nota=$nota");
  
        //echo "<div id='info'>Se ha añadido tu comentario</span></div>";
      }
    
     
    
?>