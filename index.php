<?php 
session_start();
include("variablesZ.php");
session_set_cookie_params([
  'lifetime' => 0, // La cookie será válida hasta que se cierre el navegador
  'path' => '/', // La cookie será válida en todas las rutas del subdominio
  'domain' => $_SESSION["sitio"], // Limitar la cookie al subdominio
  'secure' => true, // Solo enviar la cookie a través de HTTPS (recomendado si el sitio usa HTTPS)
  'samesite' => 'Lax' // Prevenir algunos tipos de ataques CSRF (ajustar según necesidad)
]);
include("acceso.css"); 
include('Mobile_Detect.php');
include($retroZ."encriptado.php");

// SESION PEGAJOSA
// LA SESION NO SE CIERRA HASTA QUE LO HAGAS DESDE EL MENU DESPLEGABLE
if(isset($_COOKIE['SesionKnotes'])) {
  $kakado=explode(";",$_COOKIE['SesionKnotes']);
  $_SESSION["gusuario"]=$kakado[0];
  $_SESSION["gusuario1"]=base64_decode($kakado[1]);
  $_SESSION["gclave"]=$kakado[2];
  $_SESSION["gclave1"]=$desencriptar($kakado[3]);
  $_SESSION["usuarioZ"]=$_SESSION["gusuario"];
header("Location: inicia.php");
}

// SESION PEGAJOSA
// SI TE SALES POR ERROR, VUELVE A INICIO. SOLO PUEDES SALIR TOCANDO EN CERRAR
if (isset($_SESSION["usuarioZ"]) and $_SESSION["usuarioZ"]!=""){
// LA SESION NO SE CIERRA HASTA QUE LO HAGAS DESDE EL MENU DESPLEGABLE
$lacookie=$_SESSION["gusuario"].";".base64_encode($_SESSION["gusuario1"]).";".$_SESSION["gclave"].";".$encriptar($_SESSION["gclave1"]);
setcookie('SesionKnotes', $lacookie, time() + (10 * 365 * 24 * 60 * 60),"/");

?>  
<script>window.location.href = 'inicia.php';</script>
<?php 
}

$_SESSION["tamtxt"]=12;

$_SESSION["editar"]=-1;
if (isset($imgtabla) and $imgtabla=="si"){$_SESSION["verimagenes"]=1;} else {$_SESSION["verimagenes"]=-1;}

?>
<html lang="es">
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title><?php echo $tituloZ; ?></title>

<div class="background"></div>


<?php

  // SI HEMOS ESCRITO USUARIO Y CONTRASEÑA
if (isset($_POST["gusuario"]) and isset($_POST["gpassword"])) {
// ESTAS DOS LINEAS DEBEN ESTAR EN ESTE ORDEN YA QUE encriptado.php UTILIZA LA VARIABLE $_SESSION["gusuario1"]
  $_SESSION["gusuario1"]=$_POST["gusuario"];
  include($retroZ."encriptado.php");
  // -----------------------------------------------------------------------------------------

  $_SESSION["gclave1"]=$_POST["gpassword"];

// ENCRIPTA EL EMAIL DEL USUARIO
  $_SESSION["elusuario"] = base64_encode($_POST["gusuario"]);

  // SI NO EXISTE LA CUENTA (LA CARPETA) DEL USUARIO VUELVE A index.php
  if (!is_dir($_SESSION["elusuario"])){
    $_POST["gusuario"]="";
    $_POST["gpassword"]="";
    header("Location: index.php");
  }

  // SI EXISTE LA CUENTA COMPRUEBA CREDENCIALES
  $ar=fopen($_SESSION["elusuario"]."/.admin.ubi","r") or die("Error.admin");
    $lineo=fgets($ar);
    $linea=$desencriptar($lineo);
    $kaka=explode(";",$linea);
  
// RECUPERA LAS CREDENCIALES DEL ARCHIVO Admin.ubi
  $_SESSION["gusuario"]=trim($kaka[0]);
  $_SESSION["gclave"]=trim($kaka[1]);
  

  // SI COINCIDEN LA CREDENCIALES ABRE TU SESIÓN PONIENDO $_SESSION["sipasaZ"]=$_SESSION["sipasoZ"] Y ESTABLECIENDO OTRAS VARIALES
  if ($_SESSION["gusuario"]==base64_encode($_SESSION["gusuario1"]) and $_SESSION["gclave"]==$encriptar($_SESSION["gclave1"])) {
   
    $pitofla = base64_encode($_SESSION["gusuario1"]);
    
    $_SESSION["usuarioZ"]=$pitofla;
    $_SESSION["sipasaZ"]=$_SESSION["gclave"]; 
    $_SESSION["sipasoZ"]=$encriptar(trim($_SESSION["gclave1"]));
    $_SESSION["fechaZ"]=date("Y;m;d;H;i");
    $_SESSION["ipZ"]=$_SERVER["REMOTE_ADDR"];
    $_SESSION["movilZ"]=0;
    $detect = new Mobile_Detect();
    if ($detect->isMobile()) {$_SESSION["movilZ"]=-1;}
    if ($detect->isTablet()) {$_SESSION["movilZ"]=1;}

    if ($_SESSION["gusuario"]==base64_encode($_SESSION["gusuario1"]) and $_SESSION["gclave"]==$encriptar($_SESSION["gclave1"])){$sipaso="si";} 

    $keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
    $tamanotxt=explode(";",$keike);
    $_SESSION["tamanotxt"]=$tamanotxt[2];
    if ($_SESSION["tamanotxt"]==""){
      $keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
      $tamanotxt=explode(";",$keike);
      $nuevotxt=$tamanotxt[0].";".$tamanotxt[1].";"."14px";
      file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",$nuevotxt);
    }
       
// SESION PEGAJOSA
// LA SESION NO SE CIERRA HASTA QUE LO HAGAS DESDE EL MENU DESPLEGABLE
$lacookie=$_SESSION["gusuario"].";".base64_encode($_SESSION["gusuario1"]).";".$_SESSION["gclave"].";".$encriptar($_SESSION["gclave1"]);
setcookie('SesionKnotes', $lacookie, time() + (10 * 365 * 24 * 60 * 60),"/");

?>  
<script>window.location.href = 'inicia.php';</script>
<?php 

}
  fclose($ar);

} else {

?>
<center>
  <br><br>
<div class="contenedor">
<form method="POST" action="index.php" style="max-width:250px;margin:auto">
<img src="img/knotes.png" height="30px"><br><br>
      <div class="input-container">
    <input class="input-field" type="text" placeholder="Usuario" name="gusuario">

    <input class="input-field" type="password" placeholder="Clave" name="gpassword">
  </div>
<br>
  <input class="submit" type="submit"  value="<?php echo $accederZ; ?>">
  <br>

<table border="0" align="center" width="80%">
<tr><td width="45%">
<a href="creacuenta.php"><center><font size="1px"><?php echo $crearZ; ?></center></a>
</td><td width="10%">
 
</td><td width="45%">
<a href="claveno.php"><center><font size="1px"><?php echo $olvideZ; ?></center></a>
</td></tr></table>

<?php if (file_exists("img/logo.png")){ ?>
  <a href="" target="blank"><img src="img/logo.png" width="100px" alt=""></a>
<?php } ?>

</form>
</div>
</center>

<?php }

?>
