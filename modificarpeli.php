<!doctype html>
<html lang="es">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>película</title>
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#mytextarea'
        , menubar: "edit tools insert"
        , plugins: 'lists advlist autolink charmap code textcolor colorpicker emoticons media image paste searchreplace table fullscreen'
        , toolbar: "undo redo paste copy searchreplace fullscreen | styleselect bold italic forecolor backcolor | code charmap emoticons media image table"
    });
</script>
<link rel="stylesheet" type="text/css" href="/Francesc/Practica-2/css/estilos.css">
<style>
    body
    {
        background-image: url(/Francesc/Practica-2/vista/imatges/CINE2.jpg);
    }          
</style>  
    
<header id="headermanten">
    <H1>CINEMANIA</H1> 
    <?php echo "<a title='volver al entorno de mantenimiento'  href='administrador.php'><img id='home'  alt='mantenimiento.php' src='vista/imatges/inicio.png'></a>";?></header>

<body>
    <div id="contenedor">
    <?php
session_start();
?>
        <?php
  
if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{      
    echo "<div id='menuman'>";
         echo "<div class='bMan'><a title='Aquí puedes añadir una película' href='anyadirpeli.php'>Nueva Película</a>";
        echo "</div>";
        
       echo "<div class='bMan'> <a href='categorias.php'  title='Aquí podrás añadir o eliminar categorías'>Categorias</a>";
        echo "</div>";
        
        
         echo "<div class='bMan'><a href='criticos.php'  title='Aquí puedes ver las críticas de los diferentes autores y borrarlas una a una, o eliminar de la base de datos todo lo relacionado con ese autor'>Críticos</a>";
        echo "</div>";
        
        echo "</div>";
       try
                                    {
                                        $con= new PDO('mysql:host=localhost;dbname=cinemania', "root");
                                    }
                                catch(PDOException $e)
                                    {
                                        echo "Error:".$e->getMessage(); 
                                        die();
                                    }

     if(isset($_GET['id']))
       {
             $sel = "SELECT * FROM cinemania WHERE cinemania.id =".$_GET['id']."";
          $res = $con->query($sel);
      
      
       
        foreach($res as $fila)
        {
        
        echo "<h2>Modificar Pelicula ${fila['titulo']}</h2>";
            echo "<form id='formmodificar' method='post' action='modificarpeli.php' enctype='multipart/form-data'>";
            echo "<input type='number' style='visibility:hidden' name='id' value='${fila['id']}'><br>";
            echo "<label>Titulo </label> <br><input type='text' name='titulo' value='${fila['titulo']}'><br>";
            echo "<label>Año</label><br><input type='number' name='anyo' value='${fila['anyo']}'><br>";
            
      
     echo "<label>Genero</label><br>";
            echo "<select name='categoria'>"; 
            $sel = "SELECT * FROM categorias";
        
      
            
        $res = $con->query($sel);
        
    
    foreach($res as $filac)
        {
        
        if($filac['id']==$fila['categoria_id'])
        {
            
                  echo " <option value='${filac['id']}' selected='selected'>${filac['nombre']}</option>";
        }
        else
        {
                echo " <option value='${filac['id']}'>${filac['nombre']}</option>";
                
    }
    }
     
            echo "</select><br>";
            
            
           echo "<label>Director</label><br><input type='text' name='director' value='${fila['director']}'><br>";
            echo "<label>Sinopsis</label><br><textarea id='mytextarea' rows='8' cols='60' name='sinopsis' > ${fila['sinopsis']}</textarea><br>";
            echo "<label>Affinity</label><br><input type='text' name='affinity' value='${fila['affinity']}'><br>";
             echo "<label>Foto</label><br><img alt='Carátula del film'  class='imgmodpeli' src='${fila['foto']}'><br><input type='file' name='foto' ><br>";
            
    
            echo "<p><input type='submit' value='modificar'></p>";
         
             
            echo "</form>";
              
        }  
    
     }
    
    if(isset($_POST['id']))
    {
   
  
        $sql = "select id from cinemania where cinemania.titulo='".$_POST["titulo"]."';";

                              $res=$con->query($sql); 
                           
                        
                            $id=$_POST["id"];
                    
        
            if($_FILES['foto']['size']!=0)
                    
                    {    
                
                
                echo  $sql = "select foto from cinemania where cinemania.titulo='".$_POST["titulo"]."';";

              

              $res=$con->query($sql); 
             foreach($res as $fila)
                {
                    $foto=$fila['foto'];
                }
                unlink($foto);
         
         
                    $target_path = "imatges/".$_FILES['foto']['name'];
                    $f=$target_path;
                    
                    if(!move_uploaded_file($_FILES['foto']['tmp_name'], $target_path))
                    {
                       
                        echo "Error al subir la foto";

                    } 
                
    
            
                     $sql= "UPDATE cinemania SET titulo = '".$_POST["titulo"]."', anyo = '".$_POST["anyo"]."', categoria_id = ".$_POST["categoria"].", director = '".$_POST["director"]."', sinopsis = '".$_POST["sinopsis"]."', affinity = '".$_POST["affinity"]."', foto = '".$f."' WHERE cinemania.id =".$id.";";


                    }     
        
        else
        {
            
            $sql= "UPDATE cinemania SET titulo = '".$_POST["titulo"]."', anyo = '".$_POST["anyo"]."', categoria_id = ".$_POST["categoria"].", director = '".$_POST["director"]."', sinopsis = '".$_POST["sinopsis"]."', affinity = '".$_POST["affinity"]."' WHERE cinemania.id =".$id.";";
        }
            $res=$con->exec($sql); 
        
        $_SESSION["titulo"]=$_POST["titulo"];
        
        header ("location:administrador.php?modicar_peli=".$_SESSION['titulo']."");

    }
}
        
          
        ?>
        </div>
</body>

</html>