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
              <?php echo "<a title='volver al entorno de mantenimiento'  href='administrador.php'><img id='home' alt='inicio'  src='vista/imatges/inicio.png'></a>";?>   
    </header>
    <div id="contenedor">
        
<?php
        
session_start();
        
        try
        {
            $conexion = new PDO('mysql:host=localhost;dbname=cinemania', "root");
        }
    catch(PDOException $e)
        {
            echo "Error:".$e->getMessage(); 
            die();
        }

if ($_SESSION['usuario']=="admin" && $_SESSION['pwd']=="admin" ) 
{
    if(!isset($_POST['modtexto'])){
    echo "<div id='menuman'>";
         echo "<div class='bMan'><a  title='Aquí puedes añadir una película' href='anyadirpeli.php'>Nueva Película</a>";
        echo "</div>";
        
       echo "<div class='bMan'> <a href='categorias.php'  title='Aquí podrás añadir o eliminar categorías'>Categorias</a>";
        echo "</div>";
        
        
         echo "<div class='bMan'><a href='criticos.php'  title='Aquí puedes ver las críticas de los diferentes autores y borrarlas una a una, o eliminar de la base de datos todo lo relacionado con ese autor'>Críticos</a>";
        echo "</div>";
        
        echo "</div>";
    
     if(!isset($_GET["autor"]) && !isset($_GET["borrartodas"]) && !isset($_GET['id_modificar']) && !isset($_POST["confirmar"]) && !isset($_GET['modtexto']) && !isset($_GET['id_borrar']))
    {    
    echo "<h2>Últimas críticas</h2>";
     }
    
    if(isset($_GET["autor"]))
    {
          echo "<div class='mantenautores'><h2>Críticas de ".$_GET["autor"]."</h2>";
    }
    
    
    
    
    $sql="select  DISTINCT criticas.autor from criticas;";
    $res=$conexion->query($sql);
    
    if(!isset($_GET["borrartodas"]) && !isset ( $_GET['id_modificar']))
    {
    
    echo "<div id='filtroautores'><p class='selectautores'>Autores:</p>";
    echo   '<form id="selectautores" method="get" action="criticos.php">
    <select name="autor">';
    foreach($res as $fila)
    {
        echo '<option value="'.$fila["autor"].'">'.$fila["autor"].'</option>';
     }
    echo '</select>
    <p class="selectautores"><input  type="submit" value="Ver Críticas"></p>
    </form>';
    }
    
     if(!isset($_GET["autor"]) && !isset($_GET["borrartodas"]) && !isset($_GET['id_modificar']) && !isset($_POST["confirmar"]) && !isset($_GET['modtexto']) && !isset($_GET['id_borrar']))
    {    
   
    // ver 10 ultimas criticas 
    $contador=0;
      $sql="select criticas.nota,criticas.autor,criticas.id,criticas.texto,criticas.id_pelicula,cinemania.titulo FROM cinemania join criticas on(cinemania.id=criticas.id_pelicula) ORDER by criticas.id ASC";
    $res=$conexion->query($sql);
     echo "<table id='tablacriticas'><tr><th>Autor</th><th>Película</th><th class='textocritica'>Texto</th><th>Nota</th><th>Eliminar</th><th>Modificar</th></tr>";
     foreach($res as $fila)
       {
         
             if($contador<=9)
             {
                  $contador++;
 
     $autor=urlencode($fila['autor']);
         echo "<tr><th><a title='Críticas del autor' href='criticos.php?autor=".$autor."'>".$fila['autor']."</a></th><th><a title='ir a las críticas de la película' href='adminvercriticas.php?id_pelicula=".$fila['id_pelicula']."'>".$fila["titulo"]."</a></th><td class='textocritica'>".$fila["texto"]."</td><td class='notamedia'>".$fila["nota"]."</td><td><a title='borrar crítica' href='criticos.php?id_borrar=".$fila['id']."' ><img alt='borrar crítica' src=imatges/eliminar.png ></a></td><td><a title='editar crítica' href='criticos.php?id_modificar=".$fila['id']."' ><img  alt='editar crítica' src=imatges/modificar.png ></a></td></tr>";
            
             }
        
        }
    echo "</table>";
    }
    // fin de ultimas criticas 
    
    
    if(isset($_GET["autor"]))
    {
        echo   '<form class="selectautores" method="get" action="criticos.php">
        <input type="text" style="visibility:hidden;width:0" name="borrartodas"><input type="text" style="visibility:hidden;width:0" name="autoring" value="'.$_GET["autor"].'">
        <input id="borrarcritico" type="submit" value="Borrar Crítico"></form></div>';
        
        $sql="select criticas.nota,criticas.autor,criticas.id,criticas.texto,criticas.id_pelicula,cinemania.titulo FROM cinemania join criticas on(cinemania.id=criticas.id_pelicula) WHERE criticas.autor='".$_GET['autor']."';";
        $res=$conexion->query($sql);
        $res=$res->fetchAll();
          echo "<div class='mantenautores'>";
        echo "<table id='tablacriticas'><tr><th>Película</th><th class='textocritica'>Texto</th><th>Nota</th><th>Eliminar</th><th>Modificar</th></tr>";
       foreach($res as $fila)
       {
           
           
           echo "<tr><th><a title='ir a las críticas de la película' href='adminvercriticas.php?id_pelicula=".$fila['id_pelicula']."'>".$fila["titulo"]."</a></th><td class='textocritica'>".$fila["texto"]."</td><td class='notamedia'>".$fila["nota"]."</td><td><a title='borrar crítica' href='criticos.php?id_borrar=".$fila['id']."' ><img alt='borrar crítica' src=imatges/eliminar.png ></a></td><td><a title='editar crítica' href='criticos.php?id_modificar=".$fila['id']."' ><img  alt='editar crítica' src=imatges/modificar.png ></a></td></tr>";
       }
        echo "</table></div>";
        
        
    }
    
    if(isset($_GET["borrartodas"]))
    {
      echo "<h2>Borrado del autor ".$_GET['autoring']."</h2><div id='confirmacion'><p>Esta acción borrará tanto al autor <span>".$_GET['autoring']." </span> como a todas sus críticas. Estás seguro?</p>";
            echo "<form method='post' action='criticos.php'>";
            echo "<input type='radio' name='confirmar' value='si'>Sí<br>";
            echo "<input type='radio' name='confirmar' value='no' checked>No<br>";
            echo '<input type="text" style="visibility:hidden;width:0" name="autoring" value="'.$_GET["autoring"].'">';
            echo "<p><input type='submit' value='confirmar'></p>";
           
            echo "</form>";
            echo "</div>";
        }
            
        if(isset($_POST["confirmar"]))
        {
            if($_POST["confirmar"]==="si")
            {
              $sql = "delete from criticas where autor='".$_POST['autoring']."';";

              $res=$conexion->exec($sql); 
              header ("Location:criticos.php");
          
            }
            if($_POST["confirmar"]==="no")
            header ("Location:criticos.php?autor=".$_POST['autoring']);
            
        }
    
     if(isset ( $_GET['id_borrar']))
    {
        
        // borar la critica
       
 
  $sql2="select cinemania.id, criticas.autor from cinemania,criticas where cinemania.id=criticas.id_pelicula and criticas.id=".$_GET['id_borrar'].";";
       $res2=$conexion->query($sql2);
       $res2=$res2->fetch();

     $sql = "delete from criticas where id='".$_GET['id_borrar']."';";

              $res=$conexion->exec($sql); 
       
      
         //foreach($res2 as $fila)
           // {
           header ("Location:criticos.php?autor=".$res2['autor']);
        
    
       
    } 
    
    
     if(isset ( $_GET['id_modificar']))
    {
        
   
        
          $sql = "select criticas.autor,criticas.nota,criticas.texto,cinemania.titulo from criticas,cinemania where criticas.id_pelicula=cinemania.id and criticas.id=".$_GET['id_modificar'].";";
        
        $res=$conexion->query($sql);
               
                 foreach($res as $fila)
        {
               echo "<h2>Modificar crítica de ".$fila['autor']." ( ".$fila['titulo']." ) </h2><div id='modificarcri'><form method='post' action='criticos.php'>";
              
                echo "<input type='text' style='visibility:hidden;width:0;' name='id' value='".$_GET['id_modificar']."'>";
                
                echo "<label>Autor</label><br><input type='text' name='autor' value='${fila['autor']}'><br>";
                echo "<label>Nota</label> ";
               echo "<select name='nota'>"; 
                $nota=$fila['nota'];
                $nota=intval($nota);               
               for ($i=0;$i<11;$i++)
                {

                    if($i==$nota)
                    {
                    echo " <option value='${fila['nota']}' selected='selected'>${fila['nota']}</option>";

                    }

                    else
                    {
                        echo " <option value=$i>$i</option>";

                    }
                }
     
            echo "</select> <br>";
        echo "<br><label>Texto</label><br><br><br><textarea id='mytextarea' rows='8' cols='60' name='modtexto'> ${fila['texto']}</textarea><br>"; 
        echo "<input type='submit' value='Modificar Critica'></form></div>";
        
         }}
}
        
        if(isset($_POST['modtexto']))
        {
            
        $sql= "UPDATE criticas SET autor= '".$_POST["autor"]."', texto= '".$_POST["modtexto"]."', nota = ".$_POST['nota']." WHERE criticas.id =".$_POST["id"].";";
            
        $res=$conexion->exec($sql);
           
    
       
        
        header("Location:criticos.php?autor=".$_POST['autor']);
            
            
        
        }
    
}

?>
        
    </div>
    </body>
</html>