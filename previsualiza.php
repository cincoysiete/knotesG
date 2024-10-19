<?php
session_start();
include("identifica.php"); 

// if ($_SESSION["movilZ"]==1 or $_SESSION["movilZ"]==-1){} else {


// $_SESSION["miventana"]=base64_decode($_GET["mtk"]);
// $koko=file_get_contents($_SESSION["usuarioZ"]."/ventanas.ubi");

// echo $koko;
// echo "<br><br>";
// echo base64_decode($_GET["mtk"]);
// echo $_GET["mtt"];


// if (strpos($koko,base64_decode($_GET["mtk"]))!== false and $_GET["mtt"]!="si"){
//     $keke=str_replace(base64_decode($_GET["mtk"],"",$koko));
//     file_put_contents($_SESSION["usuarioZ"]."/ventanas.ubi",$keke);
//     echo '<script>window.close();</script>';
// } else {
//     $keke=$koko.base64_decode($_GET["mtk"]);
//     file_put_contents($_SESSION["usuarioZ"]."/ventanas.ubi",$keke);
// }


// }

if ($sincronizaZ=="1"){include("previsualizasinc.php");} else {include("previsualizano.php");}

?>
