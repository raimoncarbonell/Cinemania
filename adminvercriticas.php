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
    <?php echo "<a title='volver al entorno de mantenimiento' href='administrador.php'><img id='home' alt='incio'  src='vista/imatges/inicio.png'></a>";?></header>

<body>
    <div id="contenedor">

<?php
session_start();

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
    
    
    
    try
                    {
                        $conexion = new PDO('mysql:host=localhost;dbname=cinemania', "root");
                    }
                catch(PDOException $e)
                    {
                        echo "Error:".$e->getMessage(); 
                        die();
                    }
    if(isset($_GET["id_pelicula"]))
       {
            
             $sql="SELECT criticas.id, criticas.autor, criticas.texto,criticas.nota,cinemania.titulo from criticas,cinemania WHERE cinemania.id=criticas.id_pelicula and cinemania.id=".$_GET['id_pelicula'].";";
            
             $res=$conexion->query($sql);
            $res=$res->fetchAll();
        
        
            $sql2="select cinemania.titulo, cinemania.id from cinemania where cinemania.id=".$_GET['id_pelicula'].";";
                $res2=$conexion->query($sql2);
        
        foreach($res2 as $fila)
        {
                
                echo " <h2>Críticas de ${fila['titulo']}</h2> ";
        }
        
        echo"<table id='tablacriticas'><tr><th>Autor</th><th class='textocritica'>Texto</th><th>Nota</th><th>Eliminar</th><th>Modificar</th></tr>";
        if (count($res)>0)
        {    
            foreach($res as $fila)
            {
                echo"<tr><td><a title='Ver las críticas de este autor' href='criticos.php?autor=".$fila["autor"]."'>${fila['autor']}</a></td><td class='textocritica'>${fila['texto']}</td><td>${fila['nota']}</td><td><a href='adminvercriticas.php?id_borrar=".$fila['id']."' ><img src=imatges/eliminar.png alt='eliminar' ></a></td><td><a href='adminvercriticas.php?id_modificar=".$fila['id']."' ><img src=imatges/modificar.png alt='modificar' ></a></td></tr>";
             }
        }
        if (count($res)===0) echo "<tr><th colspan=5>No hay críticas para esta película. Quieres ser el primero?</th></tr>";
        
       
        
        echo '<tr><td colspan=5><button id="cargarform" onclick="cargarform()" >Añadir Crítica</button></td></tr><tr><td colspan=5><div id="formescondido">
                            <form method="get" action="adminvercriticas.php">
                            <input type="hidden" name="idpelis" value="'.$_GET['id_pelicula'].'">
                            <label>Nombre: </label><input type="text" name="autor"><br>
                            <label>Crítica: </label><textarea rows="15" cols="80" name="nuevotexto" id="mytextarea" placeholder="arrastra esquina inferior derecha para cambiar tamaño"></textarea>
                            <label>Nota: </label>
                            <select name="nota"> 
                               <option value="0">0</option>
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                               <option value="5">5</option>
                               <option value="6">6</option>
                               <option value="7">7</option>
                               <option value="8">8</option>
                               <option value="9">9</option>
                               <option value="10">10</option>
                             </select>
                             <p><input type="submit" value="confirmar"></p>
                             </form>
                             </div></td></table>';
        
    }
    
   if(isset ( $_GET['id_borrar']))
    {
        
        // borar la critica
       
 
  $sql2="select cinemania.id from cinemania,criticas where cinemania.id=criticas.id_pelicula and criticas.id=".$_GET['id_borrar'].";";
       $res2=$conexion->query($sql2);
       $res2=$res2->fetch();

     $sql = "delete from criticas where id='".$_GET['id_borrar']."';";

              $res=$conexion->exec($sql); 
       
      
           header ("Location:adminvercriticas.php?id_pelicula=".$res2['id']);
        
    
       
    } 
    
    
     if(isset ( $_GET['nuevotexto']))
    {
        
     
       
 
 

     $sql = "INSERT INTO `criticas` (`id`, `autor`, `id_pelicula`, `texto`, `nota`) VALUES (NULL, '".$_GET['autor']."', '".$_GET['idpelis']."', '".$_GET['nuevotexto']."', '".$_GET['nota']."');";

              $res=$conexion->exec($sql); 
       
      
         //foreach($res2 as $fila)
           // {
           header ("Location:adminvercriticas.php?id_pelicula=".$_GET['idpelis']);
        
    
       
    } 
   
    
    
        
    if(isset ( $_GET['id_modificar']))
    {
        
   
        
          
            $sql="select cinemania.titulo,criticas.autor,criticas.nota,criticas.texto from cinemania,criticas where cinemania.id=criticas.id_pelicula and criticas.id=".$_GET['id_modificar'].";";
        
        $res=$conexion->query($sql);
        
               
                 foreach($res as $fila)
        {
               echo "<h2>Modificar critica de ".$fila["autor"]."   ( ".$fila["titulo"]." ) </h2><form id='formmodificar' method='get' action='adminvercriticas.php' >";
              
                echo "<input type='text'  style='visibility:hidden; width:0' name='id' value='".$_GET['id_modificar']."'><br>";
                
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
        echo "<br><label>Texto</label><textarea id='mytextarea' rows='8' cols='60' name='modtexto'> ${fila['texto']}</textarea><br>"; 
        echo "<input type='submit' value='Modificar Critica'>";
        echo "</form>";
        
         }}
        
        if(isset($_GET['modtexto']))
        {
           
        $sql2="select cinemania.id from cinemania,criticas where cinemania.id=criticas.id_pelicula and criticas.id=".$_GET['id'].";";
       $res2=$conexion->query($sql2);
       $res2=$res2->fetch();
            

    $sql= "UPDATE criticas SET autor= '".$_GET["autor"]."', texto= '".$_GET["modtexto"]."', nota = ".$_GET['nota']." WHERE criticas.id =".$_GET["id"].";";
  
             $res=$conexion->exec($sql); 
            echo $sql;
            echo $sql2;
      
         //foreach($res2 as $fila)
           // {
           header ("Location:adminvercriticas.php?id_pelicula=".$res2['id']);
        
        }
    // fin de modificar
                 
           

  

        
    }
    
        
   
    


?>
        </div>
          <script>
            var i=0;
            function cargarform()
            {
                i+=1;
                var x=document.getElementById("formescondido");
                if(i%2!==0) x.style.display="inline";
                else x.style.display="none";
            }
        </script>
    </body>
</html>