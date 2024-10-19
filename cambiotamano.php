<?php
session_start();
include("identifica.php");
$_SESSION["tamanotxt"]=$_POST["tamano"]."px";

$keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
$tamanotxt=explode(";",$keike);

$nuevotxt=$tamanotxt[0].";".$tamanotxt[1].";".$_SESSION["tamanotxt"];
file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",$nuevotxt);
?>

<script>window.history.go(-2)</script>