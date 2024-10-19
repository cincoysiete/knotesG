<?php
session_start();
include("identifica.php"); 

// ELIMINA LA REFERENCIA A LA NOTA EN RECIBIDOS
$cadenar = explode(";",$_SESSION["we"]);
$nombreArchivo = base64_encode($cadenar[1]).'/recibidos.ubi'; 
$cadenaAEliminar=$cadenar[0].";".$cadenar[2];

$kaka="";
$ero = fopen($nombreArchivo, 'r');
while (!feof($ero)) {
    $linea=fgets($ero);
    if (rtrim($linea)!=rtrim($cadenaAEliminar) and $linea!=""){$kaka=$kaka.$linea;}
}
fclose($ero);
file_put_contents($nombreArchivo,$kaka);    



// ELIMINA LA REFERENCIA A LA NOTA EN ENVIADOS
$nombreArchivo = base64_encode($cadenar[2]).'/enviados.ubi'; 
$cadenaAEliminar=$cadenar[0].";".$cadenar[1];

$kaka="";
$ero = fopen($nombreArchivo, 'r');
while (!feof($ero)) {
    $linea=fgets($ero);
    if (rtrim($linea)!=rtrim($cadenaAEliminar) and $linea!=""){$kaka=$kaka.$linea;}
}
fclose($ero);
file_put_contents($nombreArchivo,$kaka);    

?>
<script>window.history.go(-2)</script>


