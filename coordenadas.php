<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 

// Decodificación del JSON recibido
$data = json_decode(file_get_contents('php://input'), true);

// Extracción de datos de la ventana
$windowInfo = [
  'left' => $data['left'],
  'top' => $data['top'],
  'width' => $data['width'],
  'height' => $data['height']
];

$cadena = implode(';', $windowInfo);
$tempo=explode(".",$_SESSION["nombreArchivoMarkdown"]);

$filename = $tempo[0].".ubi";
$cadeno=file_get_contents($filename);
$cadenu=explode(";",$cadeno);
$cadena=$cadena.";".$cadenu[4];

file_put_contents($filename, $cadena);
if ($_SESSION["tamanotxt"]==""){$_SESSION["tamanotxt"]="14px";}
file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",date("Y-d-m H:i:s").";".$_SESSION["oscuro"].";".$_SESSION["tamanotxt"]);
?>
<script>window.history.go(-1)</script>
