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

// Ejemplo de almacenamiento en un archivo
$cadena = implode(';', $windowInfo);
$tempo=explode(".",$_SESSION["nombreArchivoMarkdown"]);
$filename = $tempo[0].".ubi";
file_put_contents($filename, $cadena);
?>
<script>window.history.go(-1)</script>
