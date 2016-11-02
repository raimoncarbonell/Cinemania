<?php
session_start();

if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{
    
    
        echo "<button><a href='administrador.php'>Volver</a></button>";
    
    try
                    {
                        $conexion = new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }

                $id=$_GET['id'];
             $sql = "select *from criticas where id=$id;";

              $res=$conexion->query($sql); 
                        
            echo "<table border=1><tr><th>autor</th><th>texto</th><th>nota</th><tr>";
    
    
             foreach($res as $fila)
            {
                echo"<tr><td>${fila['autor']}</td><td>${fila['texto']}</td><td>${fila['nota']}</td>";
                ?><td><a href="vercriticas.php?id=<?php echo $fila['id'];?>&">
                Eliminar Critica</a></td></tr>
                 <?php
                 
            }
}           echo "<table>";
    
?>