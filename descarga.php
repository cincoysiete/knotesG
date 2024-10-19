<?php
session_start();
include("identifica.php"); 

// Ruta de la carpeta que quieres comprimir
$rutaCarpeta = $_SESSION["usuarioZ"];

// Nombre del archivo ZIP resultante
$nombreArchivoZip = $_SESSION["usuarioZ"].'/knotes.zip';

// Crear un objeto ZipArchive
$zip = new ZipArchive();

// Abrir o crear el archivo ZIP
if ($zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die('Error al crear el archivo ZIP');
}

// Agregar los archivos de la carpeta al archivo ZIP
agregarArchivos($zip, $rutaCarpeta);

// Cerrar el archivo ZIP
$zip->close();

// exit($nombreArchivoZip);

// Descargar el archivo ZIP resultante
// header('Content-Type: application/zip');
// header('Content-Disposition: attachment; filename="' . $nombreArchivoZip . '"');
// header('Content-Length: ' . filesize($nombreArchivoZip));
// readfile($nombreArchivoZip);


// Eliminar el archivo ZIP después de la descarga
// unlink($nombreArchivoZip);

?>
<script>window.history.go(-1)</script>
<?php

// Función recursiva para agregar archivos y carpetas al archivo ZIP
function agregarArchivos($zip, $ruta) {
    $archivos = glob($ruta . '/*');
    foreach ($archivos as $archivo) {
        if (is_dir($archivo)) {
            agregarArchivos($zip, $archivo);
        } else {
            $zip->addFile($archivo, str_replace($ruta . '/', '', $archivo));
        }
    }
}
?>

