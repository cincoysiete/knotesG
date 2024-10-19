<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 

// if ($_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
    // Directorio de destino donde se guardará la imagen
    $directorio_destino = $_SESSION["usuarioZ"]."/";

    // Nombre del archivo en el servidor
    $nombre_archivo = basename($_FILES["imagen"]["name"]);

    // Ruta completa del archivo en el servidor
    $ruta_archivo_destino = $directorio_destino . $nombre_archivo;

    // Mover el archivo temporal al directorio de destino
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_archivo_destino)) {
        // echo "El archivo se ha subido correctamente.";
        unlink($_SESSION["usuarioZ"]."/perfil.png");
        copy ($ruta_archivo_destino,$_SESSION["usuarioZ"]."/perfil.png");
        unlink($ruta_archivo_destino);

    } else {
        // echo "Ocurrió un error al subir el archivo.";
    }
// } else {
//     echo "Error al recibir el archivo.";
// }

?>

<script>window.history.go(-2)</script>
