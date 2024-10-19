<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editornota']) && isset($_POST['nombreArchivoMarkdown'])) {
        $nombreArchivoMarkdown = $_POST['nombreArchivoMarkdown'];
        $contenidoMarkdown = $_POST['editornota'];

        $kaka=explode("/",$_SESSION["nombreArchivoMarkdown"]);
        
        // Guardar el contenido en el archivo especificado
        file_put_contents($_POST['nombreArchivoMarkdown'], $_POST['editornota']);
        file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",date("Y-d-m H:i:s").";".$_SESSION["oscuro"]);
        if ($_SESSION["tamanotxt"]==""){$_SESSION["tamanotxt"]="14px";}
        file_put_contents($kaka[0]."/cambios.ubi",date("Y-d-m H:i:s").";".$_SESSION["oscuro"].";".$_SESSION["tamanotxt"]);

    } else {
        // echo 'Error: Datos faltantes.';
    }
} else {
    // echo 'Error: Método de solicitud incorrecto.';
}
?>

