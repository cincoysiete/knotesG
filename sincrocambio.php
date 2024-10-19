<?php
session_start();
$_SESSION["sincro"]=$_POST["sincro"];

// $keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
// $tamanotxt=explode(";",$keike);

// $nuevotxt=$sincro[0].";".$sincro[1].";".$_SESSION["sincro"];
// file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",$nuevotxt);
?>

<script>window.history.go(-2)</script>