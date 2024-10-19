<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>

<?php
// RECUPERAR NOTA
$_SESSION["we"]=base64_decode($_GET["we"]);
copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd",$_SESSION["usuarioZ"]."/".$_SESSION["we"].".md");
copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xubi",$_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi");

unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xubi");

?>
<script>window.history.go(-1)</script>
