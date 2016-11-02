<?php
session_start();
$f=""; 
?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Validar Modificar Pelicula</title>
        </head>
    <body>
<?php
  
if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{      
                    try
                    {
                        $con= new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }
    
        
     if(isset($_FILES['foto']))
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
                }
    
    if(count($_POST)>5)
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
        $sql = "select id from cinemania where cinemania.titulo='".$_POST["titulo"]."';";

              

              $res=$conexion->query($sql); 
             foreach($res as $fila)
        {
            $id=$fila['id'];
        }

       //       $sql = "INSERT INTO `cinemania` (`id`, `titulo`, `anyo`, `categoria_id`, `director`, `sinopsis`, `affinity`, `foto`) VALUES (NULL, '".$_POST["titulo"]."', '".$_POST["anyo"]."', ".$_POST["categoria"].", '".$_POST["director"]."', '".$_POST["sinopsis"]."', '".$_POST["affinity"]."', '$f');";

        
        
      echo  $sql= "UPDATE cinemania SET titulo = '".$_POST["titulo"]."', anyo = '".$_POST["anyo"]."', categoria_id = ".$_POST["categoria"].", director = '".$_POST["director"]."', sinopsis = '".$_POST["sinopsis"]."', affinity = '".$_POST["affinity"]."', foto = '$f' WHERE cinemania.id = '$id'";
        

             $res=$conexion->exec($sql); 
        
    }
}
        ?>