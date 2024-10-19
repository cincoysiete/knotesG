<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>

<?php
// ENVIAR A LA PAPELERA

// copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md",$_SESSION["usuarioZ"]."/trash"."/".$_SESSION["we"].".md");
// copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi",$_SESSION["usuarioZ"]."/trash"."/".$_SESSION["we"].".ubi");
// unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md");
// unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi");

copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md",$_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd");
copy($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi",$_SESSION["usuarioZ"]."/".$_SESSION["we"].".xubi");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".md");
unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".ubi");


// ELIMINA LA NOTA EN enviados.ubi
$cadenaAEliminar = $_SESSION["we"].".md"; 
$nombreArchivo = $_SESSION["usuarioZ"].'/enviados.ubi'; 

$archivo = fopen($nombreArchivo, 'r');
$nuevoArchivo = fopen('temporal.txt', 'w');
if ($archivo && $nuevoArchivo) {
    while (($linea = fgets($archivo)) !== false) {

        if (strpos($linea, $cadenaAEliminar) === false) {

            if (!feof($archivo) || trim($linea) !== '') {
                fwrite($nuevoArchivo, $linea);
            }
        } else {
            // ELIMINA COLABORACION DEL COLABORADOR (DESTINATARIO)
            $kaka=explode(";",$linea);
            $keke=file_get_contents(base64_encode(trim($kaka[1]))."/recibidos.ubi");
            $lineo=str_replace($kaka[0].";".base64_decode($_SESSION["usuarioZ"]),"",$keke);
            file_put_contents(base64_encode(trim($kaka[1]))."/recibidos.ubi",$lineo);
        }
    }
    fclose($archivo);
    fclose($nuevoArchivo);
    rename('temporal.txt', $nombreArchivo);

    // echo "Se eliminó la línea que contiene la cadena '$cadenaAEliminar' del archivo '$nombreArchivo'.";

if ($_POST["elimini"]==true) {
    unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd");
    unlink($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xubi");
    // exit($_SESSION["usuarioZ"]."/".$_SESSION["we"].".xmd");
}    
    


} else {
    // echo "No se pudo abrir el archivo.";
}


?>
<script>window.history.go(-2)</script>

