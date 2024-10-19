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
// ENVIAR A LA PAPELERA
// copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md",$_SESSION["usuarioZ"]."/trash"."/".$_SESSION["we"].".md");
// copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi",$_SESSION["usuarioZ"]."/trash"."/".$_SESSION["we"].".ubi");
// unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md");
// unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi");


// ELIMINAR LA NOTA
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xubi");

?>
<script>window.history.go(-2)</script>
