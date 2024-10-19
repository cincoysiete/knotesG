<?php 
session_start();
include("identifica.php");

// SE ELIMINA LA COOKIE PARA CERRAR LA SESION PEGAJOSA
setcookie('SesionKnotes', "", time() - 3600);

// ELIMINA knotes.zip Y ELIMINA DE upload TODOS LOS ARCHIVOS QUE NO APARECEN EN LAS NOTAS
unlink ($_SESSION["usuarioZ"]."/knotes.zip");
$rutaUpload = $_SESSION["usuarioZ"]."/".'upload/';
$rutaNotas = $_SESSION["usuarioZ"]."/";

// Obtener lista de archivos en la carpeta upload
$archivosUpload = array_diff(scandir($rutaUpload), array('.', '..'));

// Recorrer cada archivo en la carpeta upload
foreach ($archivosUpload as $archivo) {
    $existeEnNotas = false;
    
    // Recorrer cada archivo en la carpeta notas
    foreach (scandir($rutaNotas) as $nota) {
        // Saltar archivos . y ..
        if ($nota != '.' && $nota != '..') {
            // Leer contenido del archivo de notas
            $contenidoNota = file_get_contents($rutaNotas . $nota);
            // Verificar si el nombre del archivo está presente en el contenido de la nota
            if (strpos($contenidoNota, $archivo) !== false) {
                $existeEnNotas = true;
                break; // Se encontró el archivo en una nota, no es necesario seguir buscando
            }
        }
    }

    // Si el archivo no se encuentra en ninguna nota, eliminarlo de la carpeta upload
    if (!$existeEnNotas) {
        unlink($rutaUpload . $archivo);
        // echo "El archivo $archivo ha sido eliminado de la carpeta upload.<br>";
    }
}


// ELIMINA LOS ARCHIVOS DE BLOQUE DE NOTAS .blq
$folder = $_SESSION["usuarioZ"];

// Comprobar si la carpeta existe
// if (!is_dir($folder)) {
//     die("La carpeta especificada no existe.");
// }

// Obtener todos los archivos con extensión .blq en la carpeta
$files = glob($folder . '/*.blq');

// Eliminar cada archivo encontrado si contiene la línea específica
foreach ($files as $file) {
    if (is_file($file)) {
        // Leer el contenido del archivo
        $content = file_get_contents($file);
        
        // Comprobar si el contenido del archivo contiene 'jmolina@gmail.com'
        if (empty($content) || strpos($content, base64_decode($_SESSION["usuarioZ"])) !== false) {
            if (unlink($file)) {
                // echo "Archivo eliminado: $file\n";
            } else {
                // echo "Error al eliminar el archivo: $file\n";
            }
        }
    }
}



unset($_SESSION["gusuario"]);
unset($_SESSION["gclave"]);
unset($_SESSION["gusuario1"]);
unset($_SESSION["gclave1"]);
unset($_SESSION["sipasaZ"]);
unset($_SESSION["sipasoZ"]);
unset($_SESSION["usuarioZ"]); 
unset($_SESSION["fechaZ"]);
unset($_SESSION["ipZ"]);
unset($_SESSION["movilZ"]);
unset($_SESSION["emailZ"]);
setcookie('SesionKnotes',"", time() - 3600, '/');
session_destroy(); 

// header("Location: index.php");

?>
<script>window.location.href = 'index.php';</script>
