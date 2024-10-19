<?php
session_start();
include("identifica.php"); 

$keke=base64_decode($_GET["mtk"]);
$kaka=explode(".",$keke);
$larchivo=$kaka[0].".ubi";


if (file_exists($larchivo)){
    $pelo=file_get_contents($larchivo);
    $pelo1=explode(";",$pelo);
    if ($pelo1[4]==""){$pelo=$pelo1[0].";".$pelo1[1].";".$pelo1[2].";".$pelo1[3].";"."-1"; file_put_contents($larchivo,$pelo);}
} else {
    file_put_contents($larchivo,"0;0;400;500;-1");
}

$koko=file_get_contents($larchivo);
$kuku=explode(";",$koko);
if ($kuku[4]=="" or $kuku[4]==1){$kuku[4]=-1;} else {$kuku[4]=1;}

$_SESSION["estrella"]=$kuku[4];
$cadena=$kuku[0].";".$kuku[1].";".$kuku[2].";".$kuku[3].";".$_SESSION["estrella"];
file_put_contents($larchivo,$cadena);


// CAMBIO DE NOMBRE LA NOTA PRECEDIENDOLA DE UN ESPACIO PARA QUE APAREZCAN EN LA PARTE SUPERIOR DE LAS NOTAS
if ($_SESSION["estrella"]==1){
$nombri=str_replace("/","/".chr(32),$larchivo);
$larchivo=str_replace("/".chr(32),"/",$larchivo);
copy ($larchivo,$nombri);
echo "<br>";
echo "<br>";
if (file_exists($nombri)) {unlink($larchivo);}

$nombro=str_replace(".ubi",".md",$larchivo);
$nombro=str_replace("/","/".chr(32),$nombro);
$larchivo=str_replace(".ubi",".md",$larchivo);
copy ($larchivo,$nombro);
echo "<br>";
echo "<br>";
if (file_exists($nombro)) {unlink($larchivo);}

} else {

$nombro=str_replace("/".chr(32),"/",$larchivo);
copy ($larchivo,$nombro);
echo "<br>";
echo "<br>";
if (file_exists($nombro)) {unlink($larchivo);}

$nombro=str_replace(".ubi",".md",$nombro);
$nombro=str_replace("/".chr(32),"/",$nombro);
$larchivo=str_replace(".ubi",".md",$larchivo);
copy ($larchivo,$nombro);
echo "<br>";
echo "<br>";
if (file_exists($nombro)) {unlink($larchivo);}
}


?>
<script>window.history.go(-1)</script>