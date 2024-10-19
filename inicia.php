<?php
session_start();
date_default_timezone_set('Europe/Madrid');
include("estilo.css"); 
include("identifica.php");

// SESION PEGAJOSA
// LA SESION NO SE CIERRA HASTA QUE LO HAGAS DESDE EL MENU DESPLEGABLE
if(isset($_COOKIE['SesionKnotes'])) {
    $kakado=explode(";",$_COOKIE['SesionKnotes']);
    $_SESSION["gusuario"]=$kakado[0];
    $_SESSION["gusuario1"]=base64_decode($kakado[1]);
    $_SESSION["gclave"]=$kakado[2];
    $_SESSION["gclave1"]=$desencriptar($kakado[3]);
    $_SESSION["usuarioZ"]=$_SESSION["gusuario"];
  } else {
  }
// SESION PEGAJOSA
if (!isset($_SESSION["usuarioZ"]) or $_SESSION["usuarioZ"]==""){
    $kakado=explode(";",$_COOKIE['SesionKnotes']);
    $_SESSION["gusuario"]=$kakado[0];
    $_SESSION["gusuario1"]=base64_decode($kakado[1]);
    $_SESSION["gclave"]=$kakado[2];
    $_SESSION["gclave1"]=$desencriptar($kakado[3]);
    $_SESSION["usuarioZ"]=$_SESSION["gusuario"];

    header("Location: salida.php");
 
} 

// A -1 MUESTRA LA NOTA EN MODO VISTA PREVIA
 if ($_SESSION["comoveo"]!=1 and $_SESSION["comoveo"]!=-1) {$_SESSION["comoveo"]=-1;}
 
 if (!file_exists($_SESSION["elusuario"]."/perfil.png")){include("creaperfil.php");}

// GESTION DEL MODO OSCURO
if (isset($_SESSION['oscuro'])) {$_SESSION["oscuro"]=1;}
if (file_exists($_SESSION["usuarioZ"]."/cambios.ubi")){
$ar=fopen($_SESSION["usuarioZ"]."/cambios.ubi","r") or die("No se pudo abrir 1");
$linea=explode(";",fgets($ar));
$_SESSION["oscuro"]=$linea[1];
fclose($ar);
}
if ($_SESSION["oscuro"]==0) {$_SESSION["oscuro"]=1;}
if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}

?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>


<!-- ASPECTO DEL MENU SUPERIOR -->
<style>
.dropdown-menu {
    height: 0;
    width: 190px;
    position: fixed;
    top: 55;
    left: 5;
    background-color: #c7dceb;
    overflow: hidden;
    transition: height 0.2s;
    z-index: 999; 
    border-radius: 10px;

}

.dropdown-menu.active {
    height: 365px; 
}

.dropdown-menu ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    font-size: 15px;

}

.dropdown-menu ul li {
    padding: 2px;
}

.dropdown-menu ul li a {
    text-decoration: none;
    color: black;
    display: block;
    padding-top: 3px;
    padding-bottom: 3px;
}

.dropdown-menu ul li a:hover {
    background-color: #FFFCFC;
    padding-top: 3px;
    padding-bottom: 3px;

}

.toggle-menu {
    position: fixed;
    top: 2px;
    left: 0px;
    border: none;
    cursor: pointer;
    z-index: 999;
    border-radius: 5px;
    background-color: transparent;

}

.toggle-menu:focus {
    outline: none;
}



.has-submenu {  position: relative;
}

.submenu {  display: none;
  position: absolute;
  top: 100%;  
  left: 40;
  background-color: #c7dceb;
  padding: 5px;
  border-radius: 5px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.8); 

}

.has-submenu:hover .submenu {  display: block;
}

</style>

<!-- VERIFICA LOS CAMBIOS REALIZADOS EN LA NOTA. TAMBIEN, SI HAY NOTAS ENVIADAS O POR RECIBIR
 HAY QUE TENER CUIDADO SI AÑADES CODIGO ANTES DE ESTE SCRIPT PORQUE PUEDE DEJAR DE FUNCIONAR -->
<script>
function verificarModificacionArchivos() {
    // Obtener la URL de los archivos de cambios
    var usuarioZ = "<?php echo $_SESSION['usuarioZ']; ?>";
    var urlArchivoCambios = usuarioZ + '/cambios.ubi';
    var urlArchivoRecibidos = usuarioZ + '/recibidos.ubi';
    var urlArchivoEnviados = usuarioZ + '/enviados.ubi';
    
    // Obtener la última fecha conocida de localStorage para los tres archivos
    var ultimaFechaConocidaCambios = localStorage.getItem('ultimaFechaConocidaCambios');
    var ultimaFechaConocidaRecibidos = localStorage.getItem('ultimaFechaConocidaRecibidos');
    var ultimaFechaConocidaEnviados = localStorage.getItem('ultimaFechaConocidaEnviados');
    
    // Función para comprobar la modificación de un archivo
    function comprobarModificacion(urlArchivo, ultimaFechaConocida, claveLocalStorage) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlArchivo); // Usamos HEAD para obtener solo los encabezados de la respuesta

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var nuevaFecha = xhr.getResponseHeader('Last-Modified');
                    
                    // Si la fecha de última modificación es diferente de la fecha conocida previamente
                    if (nuevaFecha !== ultimaFechaConocida) {
                        // Actualizar la fecha conocida
                        localStorage.setItem(claveLocalStorage, nuevaFecha);
                        
                        // Recargar la página si alguno de los archivos ha cambiado
                        window.location.reload();
                    }
                }
            }
        };

        xhr.send();
    }

    // Comprobar los tres archivos periódicamente
    function verificarArchivos() {
        comprobarModificacion(urlArchivoCambios, ultimaFechaConocidaCambios, 'ultimaFechaConocidaCambios');
        comprobarModificacion(urlArchivoRecibidos, ultimaFechaConocidaRecibidos, 'ultimaFechaConocidaRecibidos');
        comprobarModificacion(urlArchivoEnviados, ultimaFechaConocidaEnviados, 'ultimaFechaConocidaEnviados');
    }

    // Llamar a la función cada cierto tiempo para comprobar modificaciones
    setInterval(verificarArchivos, 10000);
}

// Llamar a la función cuando el documento esté listo
document.addEventListener('DOMContentLoaded', verificarModificacionArchivos);
</script>


<!-- BOTON CREAR NUEVA NOTA -->
<a id="verBoton1" href="crea.php" onclick="abrirModal('modal1')" title="Crear nueva nota"><img class="semi-transparent" src="img/agregar.png" width="70px"></a>

<?php if (filesize($_SESSION["usuarioZ"]."/mensaje.ubi")>10){?>
<a id="verBoton6" href="colaboras.php" onclick="abrirModal('modal1')" title="Aceptar colaboración en una nota"><img class="circulo" src="img/idea.gif" width="70px"></a>
<?php } ?>

<!-- ENCABEZADO DE LA APP -->
<div id="encabezado">
<center>
<table width="99%" border="0">
<tr><td align="left" width="20%">

<?php if (!isset($_SESSION["usuarioZ"]) or $_SESSION["usuarioZ"]==""){ ?>
<button class="toggle-menu"><img src="img/menu.png" width="30px"></button>
<?php } else { ?>
<button class="toggle-menu"><img src="<?php echo $_SESSION["usuarioZ"]."/perfil.png?lkj=0" ?>" width="40px"></button>
<?php } ?>

</td><td align="center" width="50%">
</td><td align="right">
<img src="img/knotes.png" height="20px"><br>
<?php echo '<font size="1px" color="black">'.base64_decode($_SESSION["usuarioZ"])."</font>"; ?>
</td></tr></table>
</div>


<!-- PANTALLA DE TRABAJO -->
<br>
<br>
<br>
<div id="contenido">   
<?php


// VALORES PARA MODIFICAR EL MENU DESPLEGABLE. RELACIONADOS CON EL ASPECTO CLARO/OSCURO Y CON LA DESCARGA DE LAS NOTAS EN .zip
if ($_SESSION["oscuro"]==1){$quemodo="oscuro";} else {$quemodo="claro";}
?>

<!-- MENU SUPERIOR -->
<nav class="dropdown-menu">
    <ul>
        <li><a href="crea.php"> <img src="img/nuevo.png" width="11px"> Crear nota</a></li>
        <li><a href="busca.php"> <img src="img/buscar.png" width="11px"> Buscar</a></li>
        <li><a href="muestrapapelera.php"> <img src="img/archivo.png" width="11px"> Ver archivadas</a></li>
        <li><a href="comprime.php"> <img src="img/descargando.png" width="11px"> Descargar notas</a></li>
        <li><a href=""></a></li>
        <li><a href=""></a></li>

        <li class="has-submenu"> <a href="#"> <img src="img/usuario.png" width="11px"> Personalizar</a>
        <ul class="submenu">  
        <li><a href="oscuro.php">   <img src="img/cambiar.png" width="11px"> Modo <?php echo $quemodo; ?></a></li>
        <li><a href="tamanotxt.php">   <img src="img/editar.png" width="11px"> Fuente <?php echo $_SESSION["tamanotxt"]; ?></a></li>
        <li><a href="miperfil.php">   <img src="img/usuario.png" width="11px"> Imagen perfil</a></li>
        <li><a href="clavecambia.php">   <img src="img/bloqueado.png" width="11px"> Cambiar clave   </a></li>
        </ul>
    </li>

        <li><a href=""></a></li>
        <li><a href="md.php"> <img src="img/informacion.png" width="11px"> Ayuda</a></li>
        <li><a href="salida.php"> <img src="img/salida.png" width="11px"> Cerrar</a></li>
        
        <?php 
        if (file_exists("img/logo.png")){
        echo '<br><br><br><a href="" target="_new">   <img src="img/logo.png" width="90px"></a>';
        }
        ?>
      </ul>
</nav>


<?php


// MUESTRA LOS ARCHIVOS DE NOTAS EN CUADRICULA DE DOS COLUMNAS
function listarArchivos($path, $cuantosarchivos, $archives) {
  $dir = opendir($path);
  $cuenteo = 0;
  sort($archives);
  $columnas = 900; 
  $contador_columna = 0;

  echo '<div class="grid-container">';

  while ($cuenteo < $cuantosarchivos) {
      $kikio0 = explode("/", $archives[$cuenteo]);
      $kikio1 = explode(".", $kikio0[0]);
      $popup_id = uniqid();
      $esio=explode(".",$kikio0[0]);
      
$kaka=$archives[$cuenteo];
$tempo=explode(".",$kaka);

$fecha_creacion = filectime($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);
$tamaño_archivo = filesize($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);

// RECUPERA POSICION Y TAMAÑO DE LA NOTA
if (file_exists($_SESSION["usuarioZ"]."/".$tempo[0].".ubi")){
$ar=fopen($_SESSION["usuarioZ"]."/".$tempo[0].".ubi","r") or die("No se pudo abrir 2");
$linea=explode(";",fgets($ar));
$leftPosition=$linea[0];
$topPosition=$linea[1];
$width=$linea[2];
$height=$linea[3];
$_SESSION["estrella"]=$linea[4];
fclose($ar);
}

echo '<div class="grid-item">';
?>


<!-- MUESTRA CADA NOTA CON LAS FUNCIONES DE ELIMINAR Y RENOMBRAR -->
<div class="tabla">
  <div class="fila">
    <div class="celda">
      <a href="elimina.php?we=<?php echo base64_encode($esio[0]); ?>" title="Enviar al archivo"><img class="imagen-gris" src="img/archivo1.png" width="30"></a>
    </div>

    <div class="celda"><a href="envia.php?we=<?php echo base64_encode($esio[0]); ?>" title="Enviar la nota a otro usuario para colaboración"><img class="imagen-gris" src="img/colaborar.png" width="30"></a>
    </div>

    <div class="celda"><a href="renombra.php?we=<?php echo base64_encode($esio[0]); ?>" title="Cambiar nombre a la nota"><img class="imagen-gris" src="img/rebautizar.png" width="30"></a></div>
  </div>
</div>

<div class="tabla">
  <div class="fila">
  <div class="celda">
    
</div>
  <div class="celda">
<?php 
if ($tamaño_archivo==0){$icono="img/vacia.png";} else {$icono="img/carpeti.png";} ?>
    <a href="#" title="Abrir la nota" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$archives[$cuenteo])."&mtt=si"; ?>', '<?php echo $popup_id; ?>', 'width=<?php echo rtrim($width); ?>,height=<?php echo rtrim($height); ?>,left=<?php echo rtrim($leftPosition); ?>,top=<?php echo rtrim($topPosition); ?>,menubar=no').focus(); return false;"><img src="<?php echo $icono; ?>" alt="Imagen de enlace" width="50" ></a>


</div>

  <div class="celda">

  </div>

  </div>
</div>

<div class="tabla">
  <div class="fila">

    <div class="celda">
    </div>

  </div>
</div>
<a href="#" title="Abrir la nota" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$archives[$cuenteo]); ?>', '<?php echo $popup_id; ?>', 'width=<?php echo rtrim($width); ?>,height=<?php echo rtrim($height); ?>,left=<?php echo rtrim($leftPosition); ?>,top=<?php echo rtrim($topPosition); ?>,menubar=no').focus(); return false;" >
<?php echo $esio[0]; ?></a>

<?php
$contenido = file_get_contents($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);
?>

<!-- MUESTRA FECHA DE CREACION DE LA NOTA -->
<?php 
echo '<div class="interlin">'.date("Y-m-d H:i:s", $fecha_creacion).'</div>';
echo '<div class="interlin">'.$tamaño_archivo.' bytes</div>'; 
?>

<div class="tabla">
  <div class="fila">

  <!-- MARCAR NOTA COMO FAVORITA -->
  <div class="celda">
<?php 
if ($_SESSION["estrella"]==1){
    $mencion="img/estrellasi.png"; 
    echo '<button class="boton-transparente"><a href="estrella.php?mtk='.base64_encode($_SESSION["usuarioZ"]."/".$archives[$cuenteo]).'" title="Desmarcar la nota"><img src="'.$mencion.'" width="30px"></a></button><br>';
    } else {
    $mencion="img/estrellano.png"; 
    echo '<button class="boton-transparente"><a href="estrella.php?mtk='.base64_encode($_SESSION["usuarioZ"]."/".$archives[$cuenteo]).'" title="Marcar la nota como favorita"><img class="imagen-gris" src="'.$mencion.'" width="30px"></a></button><br>';

    } ?>
  </div>    

  <div class="celda">    
  </div>    

  <!-- PROTEGER O NO LA NOTA -->
  <div class="celda">
    <?php
    $kaka=explode(".",$archives[$cuenteo]);
    if (file_exists($_SESSION["usuarioZ"].'/'.$kaka[0].".prt")) {
        echo '<button class="boton-transparente"><a href="protege.php?we=;'.$_SESSION["usuarioZ"].';'.$archives[$cuenteo].' " title="Protege tu nota"><img  src="img/protesi.png" width="30"></a></button>';
     } else {
        echo '<button class="boton-transparente"><a href="protege.php?we=;'.$_SESSION["usuarioZ"].';'.$archives[$cuenteo].' " title="Protege tu nota"><img class="imagen-gris" src="img/proteno.png" width="30"></a></button>';
     }
    ?>
  </div>    

</div>    
</div>

<?php
      echo '</div>';

      $cuenteo++;
      $contador_columna++;
      if ($contador_columna == $columnas) {
          echo '<div class="clearfix"></div>'; 
          $contador_columna = 0;
      }
  }

  echo '</div>';
}


// MIRA QUE NOTAS ESTAN COMPARTIDAS PARA NO LISTARLAS EN LA ZONA PRINCIPAL
$ero=fopen($_SESSION["usuarioZ"]."/enviados.ubi","r") or die("Error en base de datos");
$_SESSION["compartido"]="";
while (!feof($ero)) {
$linea=explode(";",fgets($ero));
$_SESSION["compartido"]=$_SESSION["compartido"].";".rtrim($linea[0]);
}

// LEE LAS NOTAS DE LA CARPETA DEL USUARIO
$cuantosarchivos = 0;
$archives = array();
$dir = opendir($_SESSION["usuarioZ"]."/");

while ($elemento = readdir($dir)) {
//   if ($elemento != "." && $elemento != ".." && strpos($elemento, ".md")) {
  if ($elemento != "." && $elemento != ".." && strpos($elemento, ".md") && stripos($_SESSION["compartido"],$elemento)==false) {
      if (!is_dir($_SESSION["usuarioZ"]."/".$elemento)) {
          $archives[$cuantosarchivos] = $elemento;
          $cuantosarchivos++;
      }
  }
}


listarArchivos($_SESSION["usuarioZ"],$cuantosarchivos,$archives ); 

?>
</div>


<!-- NOTAS COMPARTIDAS ENTRE CUENTAS -->
<?php

// MUESTRA NOTAS QUE TE COMPARTEN. RECIBIDAS
if (filesize($_SESSION["usuarioZ"]."/recibidos.ubi")>10){
    echo '<div class="recibidos">';
    echo "<br>";
    echo "<br>RECIBIDAS<br>";
    echo '<div class="grid-container">';

    $ero=fopen($_SESSION["usuarioZ"]."/recibidos.ubi","r") or die("Error en base de datos");
    while (!feof($ero)) {
    $linea=explode(";",fgets($ero));
    $cuenta=rtrim($linea[1]);
    $compartido=rtrim($linea[0]);
    $archivonombre=explode(".",$compartido);

    if (strlen($linea[0])>5){
    echo '<div class="grid-item-recibidas">';
        
 ?>
    <div class="tabla">
    <div class="fila">
    <div class="celda"><a href="recibidono.php?we=<?php echo $compartido.";".base64_decode($_SESSION["usuarioZ"]).";".$cuenta; ?>" title="Dejar de colaborar como invitado en la nota"><img class="imagen-gris" src="img/romper.png" width="30"></a>
    </div>

    <div class="celda">   
    </div>

    <div class="celda">
    </div>
</div>
</div>

<div class="tabla">
<div class="fila">
    <div class="celda">
    <a href="#" title="Abrir la nota para colaborar en ella" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode(base64_encode($cuenta)."/".$compartido); ?>', '<?php echo $popup_id; ?>', 'width=400,height=400,left=50,top=50,menubar=no').focus(); return false;" ><img src="<?php echo base64_encode($cuenta).'/perfil.png?lkj=0'; ?>" alt="Imagen de enlace" width="50" ></a>
    </div>
</div>
</div>

    <a href="#" title="Abrir la nota para colaborar en ella" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode(base64_encode($cuenta)."/".$compartido); ?>', '<?php echo $popup_id; ?>', 'width=400,height=400,left=50,top=50,menubar=no').focus(); return false;" >
    <?php echo $archivonombre[0]."<br>"; ?></a>
    <?php echo '<center><div class="interlin"><div class="suspensivos">'.$cuenta."</div></div></center>"; ?>
    <?php
    $fecha_creacion1 = filectime(base64_encode($cuenta)."/".$compartido);
    $tamaño_archivo1 = filesize(base64_encode($cuenta)."/".$compartido);
    echo '<div class="interlin">'.date("Y-m-d H:i:s", $fecha_creacion1).'</div>';
    echo '<div class="interlin">'.$tamaño_archivo1.' bytes</div>'; 
    echo '</div>';
    ?>

    <?php
    }
}
fclose($ero);
 echo '</div>';
 echo '</div>';

}


// MUESTRA NOTAS QUE COMPARTES. ENVIADAS
if (filesize($_SESSION["usuarioZ"]."/enviados.ubi")>10){
    echo '<div class="recibidos">';
    echo "<br>ENVIADAS<br>";

    echo '<div class="grid-container">';
    
    $ero=fopen($_SESSION["usuarioZ"]."/enviados.ubi","r") or die("Error en base de datos");
    while (!feof($ero)) {
    $linea=explode(";",fgets($ero));
    $cuenta=rtrim($linea[1]);
    $compartido=rtrim($linea[0]);
    $archivonombre=explode(".",$compartido);
    
    if (strlen($linea[0])>5){
        echo '<div class="grid-item-enviadas">';
        
    ?>
    <div class="tabla">
    <div class="fila">
<div class="celda"><a href="enviadono.php?we=<?php echo $compartido.";".base64_decode($_SESSION["usuarioZ"]).";".$cuenta; ?>" title="Cancelar colaboración en tu nota"><img class="imagen-gris" src="img/romper.png" width="30"></a></div>

    <div class="celda"><a href="envia.php?we=<?php echo base64_encode($compartido); ?>" title="Enviar la nota a otro usuario para colaboración"><img class="imagen-gris" src="img/colaborar.png" width="30"></a>
    </div>

    <div class="celda">
      <!-- <a href="elimina.php?we=<?php echo base64_encode($compartido); ?>" title="Enviar al archivo"><img class="imagen-gris" src="img/archivo1.png" width="30"></a> -->
    </div>
    
    <!-- <div class="celda">
    </div> -->
    
    <!-- <div class="celda">
    </div> -->
    </div>
    </div>
    
    <div class="tabla">
    <div class="fila">
    <div class="celda">
    <a href="#" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$compartido); ?>', '<?php echo $popup_id; ?>', 'width=400,height=400,left=50,top=50,menubar=no').focus(); return false;" ><img class="" src="<?php echo "../".base64_encode($cuenta)."/perfil.png?lkj=0" ?>" alt="Imagen de enlace" width="50" ></a>
    </div>
    </div>
    </div>
    
    <a href="#" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$compartido); ?>', '<?php echo $popup_id; ?>', 'width=400,height=400,left=50,top=50,menubar=no').focus(); return false;" ><?php echo $archivonombre[0]."<br>"; ?></a>
    <?php //echo '<div class="interlin">'.$cuenta."</div>"; ?>
    <?php echo '<center><div class="interlin"><div class="suspensivos">'.$cuenta."</div></div></center>"; ?>
    <?php
    $fecha_creacion1 = filectime($_SESSION["usuarioZ"]."/".$compartido);
    $tamaño_archivo1 = filesize($_SESSION["usuarioZ"]."/".$compartido);
    echo '<div class="interlin">'.date("Y-m-d H:i:s", $fecha_creacion1).'</div>';
    echo '<div class="interlin">'.$tamaño_archivo1.' bytes</div>'; 
    // echo '</div>';
    ?>
    <div class="tabla">
    <div class="fila">
  <!-- PROTEGER O NO LA NOTA -->
  <div class="celda">
    </div>
    <div class="celda">
    </div>
    <div class="celda">
    <?php
    $kaka=explode(".",$compartido);
    if (file_exists($_SESSION["usuarioZ"].'/'.$kaka[0].".prt")) {
        echo '<button class="boton-transparente"><a href="protege.php?we=;'.$_SESSION["usuarioZ"].';'.$compartido.' " title="Protege tu nota"><img  src="img/protesi.png" width="30"></a></button>';
     } else {
        echo '<button class="boton-transparente"><a href="protege.php?we=;'.$_SESSION["usuarioZ"].';'.$compartido.' " title="Protege tu nota"><img class="imagen-gris" src="img/proteno.png" width="30"></a></button>';
     }
    ?>
  </div>    

    </div>
    </div>
    <?php
     echo '</div>';
    }
    }
    fclose($ero);
    echo '</div>';
    echo '</div>';
    
    
    
    }
    echo '</div>';
    echo '<br>';
    ?>



<?php
// SI LA SESION ESTA ABIERTA Y NO HAS CERRADO EL NAVEGADOR O HAS HIBERNADO EL PC inicia.php INCOMPLETO. HAY QUE ACTUALIZAR PARA QUE APAREZCA BIEN
if ($_SESSION["gusuario"]==""){
    ?>
    <script>
    window.location.reload();
    window.location.reload();
    </script>
    <?php
}
?>


<!-- FUNCIONES DEL MENU DESPLEGABLE -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
     const toggleButton = document.querySelector('.toggle-menu');
     const dropdownMenu = document.querySelector('.dropdown-menu');

// Función para cerrar el menú desplegable si está abierto y se hace clic fuera del menú
     function closeMenuOutsideClick(event) {
         const isClickInsideMenu = dropdownMenu.contains(event.target);
         const isClickOnToggleButton = toggleButton.contains(event.target);

         if (!isClickInsideMenu && !isClickOnToggleButton && dropdownMenu.classList.contains('active')) {
             dropdownMenu.classList.remove('active');
         }
     }

// Función para ejecutar el script PHP antes de abrir el menú
     function ejecutarScriptPHP() {
         // Realizar una petición AJAX a la página PHP que contiene el script
         const xhr = new XMLHttpRequest();
         xhr.open('GET', 'comprime0.php', true);

         xhr.onload = function() {
                 // El script PHP se ejecutó correctamente, ahora abrimos el menú
                 dropdownMenu.classList.toggle('active');
         };

         xhr.onerror = function() {
             // Hubo un error en la solicitud AJAX
             console.error('Error en la solicitud AJAX');
         };

         xhr.send();
     }

     // Event listener para el botón de alternar
     toggleButton.addEventListener('click', function() {
         // Antes de abrir el menú, ejecutamos el script PHP
         ejecutarScriptPHP();
     });

     // Event listener para clics en cualquier parte de la página
     document.addEventListener('click', closeMenuOutsideClick);
   });

</script>


<script>
function confirmar()
{
	if(confirm('Vas a dejar de colaborar con <?php echo $cuenta;?> en la nota <?php echo $compartido;?>. \n¿Deseas continuar? '))
		return true;
	else
		return false;
}
</script>


