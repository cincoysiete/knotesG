<?php 
session_start();
include("identifica.php");

include("variablesZ.php");
include("acceso.css"); 
if ($_SESSION["sipasaZ"]!=$_SESSION["sipasoZ"]){header("Location: index.php");}
?>
<html lang="es">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Cambiar clave</title>

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
if (isset($_POST["cl0"]) && $_POST["cl1"]!="" && $_POST["cl2"]!="") {
  // ESTAS DOS LINEAS DEBEN ESTAR EN ESTE ORDEN YA QUE encriptado.php UTILIZA LA VARIABLE $_SESSION["gusuario1"]
  include($retroZ."encriptado.php");
  // -----------------------------------------------------------------------------------------

  $clave="";
  // $_SESSION["elusuario"] = $encriptar(preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION["gusuario1"]));
  // $_SESSION["elusuario"] = base64_encode($_SESSION["gusuario1"]);

  $ero=fopen($_SESSION["elusuario"]."/.admin.ubi","r") or die("Error");
  $lineo=fgets($ero);
  $linea=$desencriptar($lineo);
  $linea=explode(";",$linea);
  fclose($ero);

  if ($desencriptar($linea[1])==$_POST["cl0"] and $_POST["cl1"]==$_POST["cl2"]){

    $credencial=$linea[0].";".$encriptar(trim($_POST["cl1"]));
    $arx=fopen($_SESSION["elusuario"]."/.admin.ubi","w") or die("Problemas en la creacion ");
    fputs($arx,$encriptar($credencial));
    fclose($arx);
 
    echo '<center><div class="contenedor">';
    echo '<form method="POST" action="" >';
    echo 'Has modificado tu clave de acceso correctamente.';
    echo "<br>";
    echo "<br>";
    echo '<center><a href=""><font color="black">Volver</font></a></center>';
    echo '</div>';
    exit();
    exit();
  }
  
} else {
  ?>
<!-- <center> -->
<div class="contenedor">
<form method="POST" action="clavecambia.php" style="max-width:500px;margin:auto">

<div class="title"><h2>Cambiar clave</h2></div>
    <input type="password" placeholder="Clave actual" name="cl0">
    <input type="password" placeholder="Nueva clave" name="cl1">
    <input type="password" placeholder="Repite nueva clave" name="cl2">

  <input class="submit" type="submit"  value="Cambiar clave">

</form>
 <center><a class="textopequenoZcenter" href="index.php"><br>Volver</a>

</div>


<?php } ?>
