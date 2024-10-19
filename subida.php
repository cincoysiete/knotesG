<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
// Ruta de la carpeta donde se descomprimirá el archivo
$rutaDestino = $_SESSION["usuarioZ"]."/";

// Verificar si se ha enviado un archivo
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtener la información del archivo
    $nombreArchivo = $_FILES['archivo']['name'];
    $rutaTemporal = $_FILES['archivo']['tmp_name'];

    // Verificar que el archivo sea un archivo ZIP
    $tipoArchivo = mime_content_type($rutaTemporal);
    if ($tipoArchivo === 'application/zip') {
        // Mover el archivo a la carpeta destino
        $rutaDestinoCompleta = $rutaDestino . $nombreArchivo;
        move_uploaded_file($rutaTemporal, $rutaDestinoCompleta);

        // Descomprimir el archivo ZIP en la carpeta destino
        $zip = new ZipArchive();
        if ($zip->open($rutaDestinoCompleta) === TRUE) {
            $zip->extractTo($rutaDestino);
            $zip->close();
            // echo "El archivo se ha subido y descomprimido correctamente.";
            unlink($rutaDestinoCompleta);
   
        } else {
            // echo "Error al descomprimir el archivo.";
        }
    } else {
        // echo "Por favor, sube un archivo ZIP.";
    }
} else {
    // echo "No se ha seleccionado ningún archivo o ha ocurrido un error durante la subida.";
}
?>

<script>window.history.go(-2)</script>
