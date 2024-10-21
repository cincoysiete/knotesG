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
<title><?php echo $crearZ; ?></title>

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
$elcodigo=$_POST["codigo"];
$elusuario=$_POST["elusuario"];
if ($_GET["kn"]!=""){
  $_SESSION["codigoAleatorio"]="0000";
  $elcodigo="0000";
  $kaka=explode(";",base64_decode($_GET["kn"]));
  $elusuario=$kaka[1];
}
// SI ESCRIBES EL EMAIL Y EL CODIGO
if (isset($elusuario) && isset($elcodigo) && trim($_SESSION["codigoAleatorio"])==trim(strtoupper($elcodigo))) {
  // ESTAS DOS LINEAS DEBEN ESTAR EN ESTE ORDEN YA QUE encriptado.php UTILIZA LA VARIABLE $_SESSION["gusuario1"]
  $_SESSION["gusuario1"]=$elusuario;
  include($retroZ."encriptado.php");
  // -----------------------------------------------------------------------------------------

// LA CUENTA QUE INTENTAS CREAR YA EXISTE
// $pitofla=$encriptar(preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION["gusuario1"]));
$pitofla = base64_encode($_SESSION["gusuario1"]);

if (is_dir($pitofla)){
      echo '<center><div class="marco">';
      echo '<form method="POST" action="">';
      echo 'Hemos comprobado que tu cuenta ya existe. Si necesitas recuperar tu contraseña vuelve al formulario de inicio.';
      echo "<br>";
      echo "<br>";
      echo '<center><a href="index.php"><font color="black">Acceder a formulario de inicio</font></a></center>';  
      exit();
      exit();     
}

// LA CUENTA QUE INTENTAS CREAR NO EXISTE
  $_SESSION["email"]=$elusuario;
  $_SESSION["gpassword"]=$_POST["gpassword"];
  
  // COMPRUEBA QUE EL USUARIO ES UN EMAIL
  if (strpos($elusuario,"@")==false){header("Location: creacuenta.php");}

  // COMPRUEBA QUE HAS ESCRITO CORRECTAMENTE EL CODIGO DE CONTROL
  if (trim($_SESSION["codigoAleatorio"])!=trim(strtoupper($elcodigo))){header("Location: creacuenta.php");}

  // COMPRUEBA QUE HAS ESCRITO EL EMAIL Y EL CODIGO DE CONTROL
  if (trim($elusuario)=="" or trim($elcodigo)==""){header("location: creacuenta.php");}
  
  // GENERA UNA CLAVE AUTOMATICA
  $numeroAleatorio = rand(1000, 9999);
  $credencial=base64_encode($_SESSION["gusuario1"]).';'.$encriptar($numeroAleatorio);
  
  // CREAMOS CARPETA DE USUARIO CON NOMBRE ENCRIPTADO Y ARCHIVO CON CREDENCIALES ENCRIPTADAS DENTRO
 
  $_SESSION["elusuario"] = preg_replace('/[^a-zA-Z0-9_-]/', '', $elusuario);
  $_SESSION["elusuario"] = base64_encode($_SESSION["gusuario1"]);

  mkdir($_SESSION["elusuario"]);
  mkdir($_SESSION["elusuario"]."/upload");
  // mkdir($_SESSION["elusuario"]."/descarga");
  // copy("notas/Como funciona kNotes.md",$_SESSION["elusuario"]."/Como funciona kNotes.md");
  // copy("notas/Como funciona kNotes.ubi",$_SESSION["elusuario"]."/Como funciona kNotes.ubi");

  // copy("notas/colabora.ubi",$_SESSION["elusuario"]."/colabora.ubi");
  // copy("notas/colaborado.ubi",$_SESSION["elusuario"]."/colaborado.ubi");
  copy("notas/enviados.ubi",$_SESSION["elusuario"]."/enviados.ubi");

  copy("notas/mensaje.ubi",$_SESSION["elusuario"]."/mensaje.ubi");
  file_put_contents($_SESSION["elusuario"]."/mensaje.ubi",$kaka[0].";".$kaka[1].";".$kaka[2]);

  copy("notas/recibidos.ubi",$_SESSION["elusuario"]."/recibidos.ubi");
  copy("notas/cambios.ubi",$_SESSION["elusuario"]."/cambios.ubi");
  copy("notas/colabora.ubi",$_SESSION["elusuario"]."/colabora.ubi");
  copy("notas/colaborado.ubi",$_SESSION["elusuario"]."/colaborado.ubi");

  copy("notas/markdown.png",$_SESSION["elusuario"]."/upload/markdown.png");
  copy("notas/arial.ttf",$_SESSION["elusuario"]."/arial.ttf");
  
  $arx=fopen($_SESSION["elusuario"]."/.admin.ubi","w") or die("Problemas en la creacion 1");
  fputs($arx,$encriptar($credencial));
  fclose($arx);
  
  include("creaperfil.php");

  // ENVIAMOS EMAIL CON CREDENCIALES
  $para = $_SESSION["email"];
  $asunto = "Has creado tu cuenta en ";
  $mensaje = "Hola, estas son las credenciales para acceder a tu cuenta:\n\n"."URL: ".$_SESSION["sitio"]." \n"."Usuario: ".$_SESSION["email"]."\n"."Clave: ".$numeroAleatorio."\n\n"."Saludos";
  
  $headers = "From: ".$_SESSION["emailZ"]."\r\n";
  $headers .= "Reply-To: ".$_SESSION["emailZ"]."\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();
  mail($para, $asunto, $mensaje, $headers);

  // MUESTRA MENSAJE EN PANTALLA COMUNICANDO QUE HEMOS ENVIADO EMAIL CON CREDENCIALES Y QUE LA CUENTA HA SIDO CREADA
  echo '<center><div class="marco">';
  echo '<form method="POST" action="">';
  echo 'Tu cuenta ha sido creada correctamente. <br>Acabamos de enviarte un email con las credenciales de acceso.';
  echo "<br>";
  echo "<br>";
  echo '<center><a href="index.php"><font color="black">Acceder a mi cuenta</font></a></center>';

  include("creaperfil.php");

exit();
exit();
  
} else {

// GENERA EL CODIGO DE CONTROL PARA EVITAR ROBOTS EN EL FORMULARIO
$letra1 = chr(rand(65, 90));
$letra2 = chr(rand(65, 90));
$letra3 = chr(rand(65, 90));
$letra4 = chr(rand(65, 90));
$_SESSION["codigoAleatorio"] = $letra1 . $letra2 . $letra3 . $letra4;
?>
<center>
<div class="contenedor">
<form method="POST" action="creacuenta.php" style="max-width:250px;margin:auto">

<div class="title"><h2><?php echo $crearZ; ?></h2></div>
      <div class="input-container">
    <i class="fa fa-user icon"></i>
    <input class="input-field" type="text" placeholder="Email" name="elusuario">
  </div>

  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" type="text" placeholder="<?php echo "Escribe estas letras: ".$_SESSION["codigoAleatorio"]; ?>" name="codigo">
  </div>

  <input class="submit" type="submit"  value="<?php echo $crearZ; ?>">
  <a href="index.php"><br><center><span class="textopequenoZ">Volver</span></center></a>

</form>

</div>
</center>

<?php } ?>
