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
// AÑADE LINEA CON NOTA Y CUENTA DE ORIGEN EN RECIBIDOS.UBI DEL DESTINATARIO
// $kaka=explode(";",$_POST["quenota"]);
// echo base64_encode($kaka[1])."/recibidos.ubi";
// $arx=fopen(base64_encode($kaka[1])."/recibidos.ubi","a") or die("Problemas en la creacion ");
// fputs($arx,$kaka[0].";".$kaka[2]);
// fclose($arx);

// $arx=fopen(base64_encode($kaka[2])."/enviados.ubi","a") or die("Problemas en la creacion ");
// fputs($arx,$kaka[0].";".$kaka[1]);
// fclose($arx);


// ELIMINA LA LINEA DE DATOS DE MENSAJE.UBI DEL DESTINATARIO
$cadenar = explode(";",$_GET["quenota"]); // Cadena que se desea eliminar
$nombreArchivo = base64_encode($cadenar[1]).'/mensaje.ubi'; 
$cadenaAEliminar=$_GET["quenota"];

// Abrir el archivo en modo lectura
$archivo = fopen($nombreArchivo, 'r');

// Abrir un nuevo archivo temporal en modo escritura
$nuevoArchivo = fopen('temporal.txt', 'w');

// Verificar si el archivo se abrió correctamente
if ($archivo && $nuevoArchivo) {
    // Leer el archivo línea por línea
    while (($linea = fgets($archivo)) !== false) {
        // Verificar si la línea contiene la cadena a eliminar
        if (strpos($linea, $cadenaAEliminar) === false) {
            // Si la línea no contiene la cadena, escribirla en el nuevo archivo
            if (!feof($archivo) || trim($linea) !== '') {
                fwrite($nuevoArchivo, $linea);
            }
        }
    }
    
    // Cerrar los archivos
    fclose($archivo);
    fclose($nuevoArchivo);

    // Renombrar el nuevo archivo al nombre del archivo original
    rename('temporal.txt', $nombreArchivo);

    // echo "Se eliminó la línea que contiene la cadena '$cadenaAEliminar' del archivo '$nombreArchivo'.";
} else {
    // echo "No se pudo abrir el archivo.";
}


?>
<script>
// window.history.go(-1)
// Volver a la página anterior
window.history.back();

// Actualizar la página
location.reload();
</script>
