<?php
// Recibe el contenido enviado desde JavaScript
$contenidoMarkdown = $_POST['contenido'];

// Guarda el contenido en una sesión o base de datos, o haz lo que necesites con él
$_SESSION['contenidoMarkdown'] = $contenidoMarkdown;
?>
