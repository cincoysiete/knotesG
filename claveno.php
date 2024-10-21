<?php 
session_start();
// include("identifica.php");
 
$_SESSION["gusuario"]="";
$_SESSION["gclave"]="";
$_SESSION["gusuario1"]="";
$_SESSION["gclave1"]="";
$_SESSION["sipasaZ"]=0;
$_SESSION["sipasoZ"]=0;
include("variablesZ.php");
include("acceso.css"); 
?>
<html lang="es">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Clave olvidada</title>

<!-- EN CASO DE TOCAR BOTON ATRAS, VUELVE A index.php -->
<script>
    window.onload = function () {
      if (window.history && window.history.pushState) {
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
          history.pushState(null, null, document.URL);
          window.location.href = "index.php";
        });
      }
    };
  </script>
  
<?php
if (isset($_POST["elusuario"]) && $_POST["elusuario"]!="") {
  // ESTAS DOS LINEAS DEBEN ESTAR EN ESTE ORDEN YA QUE encriptado.php UTILIZA LA VARIABLE $_SESSION["gusuario1"]
  $_SESSION["gusuario1"]=$_POST["elusuario"];
  include($retroZ."encriptado.php");
  // -----------------------------------------------------------------------------------------

  // MIRA LAS CREDENCIALES SEGUN EL EMAIL QUE HAYAS ESCRITO
  $clave="";
  $_SESSION["elusuario"] = base64_encode($_POST["elusuario"]);
  $ero=fopen($_SESSION["elusuario"]."/.admin.ubi","r") or die(header("Location: index.php"));
  $lineo=fgets($ero);
  $linea=$desencriptar($lineo);
  $linea=explode(";",$linea);
  if ($linea[0]==$_SESSION["elusuario"]){$clave=trim($desencriptar($linea[1]));}
  fclose($ero);
 
  // SI EXISTE EL USUARIO, LE ENVIA LA CLAVE POR EMAIL
  if ($clave!=""){
  $para = $_POST["elusuario"];
  $asunto = "Recuperación de clave";
  $mensaje = "Hola, estas son las credenciales para acceder a tu cuenta:\n\n"."URL: https://...\n"."Usuario: ".$_POST["elusuario"]."\n"."Clave: ".$clave."\n\n"."Saludos";
  $headers = "From: ".$_SESSION["emailZ"]."\r\n";
  $headers .= "Reply-To: ".$_SESSION["emailZ"]."\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();
  mail($para, $asunto, $mensaje, $headers);

}
  
  echo '<center><div class="contenedor">';
  echo '<form method="POST" action="" >';
  echo 'Acabamos de enviarte un email con las credenciales de acceso.';
  echo "<br>";
  echo "<br>";
  echo '<center><a href="index.php"><font color="black">Acceder a mi cuenta</font></a></center>';
  echo '</div>';
exit();
exit();
  
} else {
  ?>
<center>
<div class="contenedor">
<form method="POST" action="claveno.php" style="max-width:250px;margin:auto">

<div class="title"><h2>Recuperar clave</h2></div>
      <div class="input-container">
    <i class="fa fa-user icon"></i>
    <input class="input-field" type="text" placeholder="Email" name="elusuario">
  </div>

  <input class="submit" type="submit"  value="Recibir clave por email">
  <a href="index.php"><br><center><span class="textopequenoZ">Volver</span></center></a>

</form>

</div>
</center>

<?php } 
header("Location: index.php");
?>
