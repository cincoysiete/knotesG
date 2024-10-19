<?php
session_start();
include("identifica.php"); 
$keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
$visualiza=explode(";",$keike);
$_SESSION["visualiza"]=$visualiza[3];
if ($_SESSION["visualiza"]=="Lectura"){$_SESSION["visualiza"]="Edición";} else {$_SESSION["visualiza"]="Lectura";}
$nuevotxt=$visualiza[0].";".$visualiza[1].";".$visualiza[2].";".$_SESSION["visualiza"];
file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",$nuevotxt);
$_SESSION["comoveo"]=$_SESSION["comoveo"]*-1;

?>
<script>window.history.go(-1)</script>