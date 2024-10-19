<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 


$kaka=explode(";",$_GET["we"]);
$keke=explode(".",$kaka[2]);

// exit($_GET["we"]);
// exit($kaka[1]."/".$keke[0].".prt");
if (file_exists($kaka[1]."/".$keke[0].".prt")){
unlink($kaka[1]."/".$keke[0].".prt");
} else {
file_put_contents($kaka[1]."/".$keke[0].".prt",date("Y-m-d"));
}
?>

<script>window.history.go(-1)</script>