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
              <?php echo "<a title='cerrar sesión e ir al índice'  href='salir.php'><img id='home' alt='salir' src='vista/imatges/logout.gif'></a>"; ?>   
    </header>
    <div id="contenedor">
        
        
<?php
      
session_start();
 
    if(isset($_POST["usuario"]))
     {   
        if($_POST['usuario']=="admin" && $_POST['pwd']=="admin" )
        {
          $_SESSION['usuario']=$_POST['usuario'];
         $_SESSION['pwd']=$_POST['pwd'];   
        
        }
    }
        
    
    if(!isset($_SESSION['pwd']))
    {
        echo "<div id='divsinsesion'> <img id='sinsesion' alt='error' src='vista/imatges/prohibido.png'><h3> No tienes permitido entrar aquí si no eres Administrador</h3></div>";
       
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
        
        
         echo "<div class='bMan'><a href='criticos.php' title='Aquí puedes ver las críticas de los diferentes autores y borrarlas una a una, o eliminar de la base de datos todo lo relacionado con ese autor'>Críticos</a>";
        echo "</div>";
        
        echo "</div>";
         try{
            $con = new PDO('mysql:host=localhost;dbname=cinemania', "root"); 
        }catch(PDOException $e){
            echo "<div class='error'>".$e->getMessage()."</div>"; 
            die();
        }
         echo '<form id="busquedapelis" method="get" action="administrador.php">
            
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
            
            
        </form>'; 
       

       
       
       
       if(isset($_GET['cadena']))
       {
          
             $sel = "SELECT categorias.nombre,cinemania.id,cinemania.foto,cinemania.titulo,avg(criticas.nota) as nota_media, cinemania.anyo FROM cinemania left join criticas on(cinemania.id=criticas.id_pelicula),categorias WHERE cinemania.categoria_id=categorias.id and (cinemania.titulo LIKE ('".$_GET['cadena']."%') or cinemania.titulo LIKE ('%".$_GET['cadena']."%') or cinemania.titulo LIKE ('%".$_GET['cadena']."'))  group by cinemania.id order by ".$_GET['order'].";";
           
           
        }
        else if(!isset($_GET['cadena']))
        {
             $sel = "SELECT categorias.nombre,avg(criticas.nota) as nota_media,cinemania.id,cinemania.foto,cinemania.titulo, cinemania.anyo FROM cinemania left join criticas on(cinemania.id=criticas.id_pelicula),categorias where cinemania.categoria_id=categorias.id group by cinemania.id;";
            

        } 
       
  
        $res = $con->query($sel); 
     
        echo "<table>";
        foreach($res as $fila)
        {
          
        
            ?>

            <tr><th><?php echo $fila['titulo'] ?></th>
                <td><?php echo $fila['anyo'] ?> </td>
                <td><a  title="Borrar la película. Te pedirá confirmación" href="borrarpeli.php?titulo=<?php echo urlencode($fila['titulo']); ?>">
                Borrar Película</a></td>
                <td><a  title="Modificar los datos de la película" href="modificarpeli.php?id=<?php echo $fila['id']?>">
                Modificar Película</a></td>
                <td><a  title="Ver las críticas de la película. Podrás añadir críticas" href="adminvercriticas.php?id_pelicula=<?php echo $fila['id']?>"> Ver Criticas</a></td></tr>

     
                

            
<?php
                }

        echo "</table>";
       
        
   }
?>
   </div>
</body>
</html>
       