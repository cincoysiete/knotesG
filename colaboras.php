<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
// GESTION DEL MODO OSCURO
if (isset($_SESSION['oscuro'])) {$_SESSION["oscuro"]=1;}
if (file_exists($_SESSION["usuarioZ"]."/cambios.ubi")){
$ar=fopen($_SESSION["usuarioZ"]."/cambios.ubi","r") or die("No se pudo abrir 1");
$linea=explode(";",fgets($ar));
$_SESSION["oscuro"]=$linea[1];
fclose($ar);
}
if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>
<a id="verBoton8" href="javascript:window.history.go(-1)" title="Volver a notas"><img src="img/volver.png" width="70px"></a>

<!-- ENCABEZADO DE LA APP -->
<div id="encabezado">
<center>
<table width="99%" border="0">
<!-- <tr><td align="left" width="20%"> -->
</td><td align="center" width="50%">
  <font size="2px" color="black">Te están invitando a colaborar en alguna nota</font>
</td><td align="right">
<img src="img/knotes.png" height="20px"><br>
<?php echo '<font size="1px" color="black">'.base64_decode($_SESSION["usuarioZ"])."</font>"; ?>
</td></tr></table>
</div>

<div class="recibidos">
<?php
echo '<br><br><br>';
$ero=fopen($_SESSION["usuarioZ"]."/mensaje.ubi","r") or die("Error en base de datos tio");
while (!feof($ero)) {
$linea=fgets($ero);
$kaka=explode(";",$linea);
$keke=explode(".",$kaka[0]);
if ($linea[0]!=""){
    // echo '<a href="aceptonota.php?we='.$linea.'"><font size="2px">Recibir nota '.$keke[0].' de '.$kaka[2].'</font></a><br>';
    echo '<font size="2px">Recibir <b>'.$keke[0].'</b> de <b>'.$kaka[2].'</b></font>   '.'<a href="notaaceptada.php?quenota='.$linea.'"><button class="botonverde">Si</button></a>   <a href="notarechazada.php?quenota='.$linea.'"><button class="botonrojo">No</button></a><br>';
}
}
fclose($ero);
?>
</div>


<!-- <script>window.history.go(-1)</script> -->
