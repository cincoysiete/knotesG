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
if ($_POST["nuevonombre"]!="" and !file_exists($_SESSION["usuarioZ"]."/".$_POST["nuevonombre"].".md")){

    $larchivo=$_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi";
    $koko=file_get_contents($larchivo);
    $kuku=explode(";",$koko);
    $cadena=$kuku[0].";".$kuku[1].";".$kuku[2].";".$kuku[3].";".-1;
    file_put_contents($larchivo,$cadena);
    

copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md",$_SESSION["usuarioZ"]."/".$_POST["nuevonombre"].".md");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md");

copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi",$_SESSION["usuarioZ"]."/".$_POST["nuevonombre"].".ubi");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi");

}
?>
<script>window.history.go(-2)</script>
