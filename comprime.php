<?php
session_start();
include("identifica.php"); 

function eliminarArchivos($ruta) {
    // Verificar si la ruta es un directorio
    if (!is_dir($ruta)) {
        return false;
    }

    // Obtener la lista de archivos en el directorio
    $items = scandir($ruta);
    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            $rutaCompleta = $ruta . '/' . $item;
            if (is_file($rutaCompleta)) {
                // Si es un archivo, lo eliminamos
                if (strpos($rutaCompleta,".md") or strpos($rutaCompleta,".xmd") or strpos($archivo,".zip")) {unlink($rutaCompleta);}
            }
        }
    }

    return true;
}

function copiarCarpeta($origen, $destino) {
    // Verificar si la carpeta de destino no existe y crearla si es necesario
    // if (!file_exists($destino)) {
    //     mkdir($destino, 0777, true);
    // }

    // Obtener la lista de archivos en la carpeta de origen
    $archivos = scandir($origen);

    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..') {
            $rutaOrigen = $origen . '/' . $archivo;
            $rutaDestino = $destino . '/' . $archivo;

            // Si es una carpeta, llamar recursivamente
            if (is_dir($rutaOrigen) or strpos($rutaOrigen,"/upload")!=0) {
                copiarCarpeta($rutaOrigen, $rutaDestino);
            } else {
                // Copiar el archivo a la carpeta de destino
                if (strpos($archivo,".md") or strpos($archivo,".xmd") or strpos($archivo,".zip")) {
                copy($rutaOrigen, $rutaDestino);
                }
            }
        }
    }
}

copy("notas/notepad.zip",$_SESSION["usuarioZ"]."/"."notepad.zip");

// Ruta de la carpeta que quieres comprimir
$rutaCarpeta = $_SESSION["usuarioZ"];

// COPIAR IMAGENES Y ARCHIVOS .md A descarga
$origen = $_SESSION["usuarioZ"];
$destino = $rutaCarpeta."/upload";
copiarCarpeta($origen, $destino);

// exit();


// Nombre del archivo ZIP resultante
$nombreArchivoZip = $_SESSION["usuarioZ"].'/knotes.zip';

// Eliminar el archivo ZIP después de la descarga
// unlink($nombreArchivoZip);

// Crear un objeto ZipArchive
$zip = new ZipArchive();

// Abrir o crear el archivo ZIP
if ($zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die('Error al crear el archivo ZIP');
}

// Agregar los archivos de la carpeta al archivo ZIP
$rutaCarpeta = $_SESSION["usuarioZ"]."/upload";
agregarArchivos($zip, $rutaCarpeta);

// Cerrar el archivo ZIP
$zip->close();

// ELIMINAR ARCHIVOS .md y .xmd DE upload
$ruta = $_SESSION["usuarioZ"]."/upload";
if (eliminarArchivos($ruta)) {
} else {
}

// exit();

// Ruta al archivo ZIP en el servidor
$file = $_SESSION["usuarioZ"]."/knotes.zip";

// Verifica si el archivo existe
if (file_exists($file)) {
    // Establece las cabeceras HTTP para forzar la descarga del archivo
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Limpia el búfer de salida
    ob_clean();
    flush();
    
    // Lee el archivo y envíalo al navegador
    readfile($file);
    unlink($_SESSION["usuarioZ"].'/knotes.zip');
    exit;
} else {
    // Manejo de errores en caso de que el archivo no exista
    echo 'El archivo no existe.';
}



function agregarArchivos($zip, $ruta) {
    $archivos = glob($ruta . '/*');
    foreach ($archivos as $archivo) {
        
        if (is_dir($archivo)) {
            agregarArchivos($zip, $archivo);
        } else {
            // SOLO DESCARGA NOTAS Y DOCUMENTOS INTERTADOS
            if (strpos($archivo,".ubi")==0 and strpos($archivo,".txt")==0 and strpos($archivo,".ttf")==0){
            // ELIMINA DIRECTORIO EN DOCUMENTOS INSERTADOS EN LAS NOTAS
            $kaka=file_get_contents($archivo);
            $keke=str_replace($_SESSION["usuarioZ"]."/upload"."/","",$kaka);
            file_put_contents($archivo,$keke);
            
            $zip->addFile($archivo, str_replace($ruta . '/', '', $archivo));

        }
        }
    }
}

?>

