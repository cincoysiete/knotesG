<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
include("variablesZ.php"); 
date_default_timezone_set('Europe/Madrid');

// SUBE EL ARCHIVO ARRASTRADO A upload
$_SESSION["horao"]=$_GET["random_number"];
$target_dir = $_SESSION["usuarioZ"]."/"."upload/";
$target_file = $target_dir . str_replace(" ","_",$_SESSION["horao"].basename($_FILES["file"]["name"]));

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
  echo "El archivo ya existe.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 100000000) {
  echo "El archivo es demasiado grande.";
  $uploadOk = 0;
}

// Allow only certain file formats
// if ($imageFileType != "txt" && $imageFileType != "md") {
//   echo "Solo se permiten archivos de texto.";
//   $uploadOk = 0;
// }

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Error al subir el archivo.";
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "El archivo ". htmlspecialchars(basename($_FILES["file"]["name"])). " ha sido subido.";
  } else {
    echo "Error al subir el archivo.";
  }
}

?>