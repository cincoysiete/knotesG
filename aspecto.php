<?php
session_start();
include("identifica.php"); 

$_SESSION["comoveo"]=$_SESSION["comoveo"]*-1;

?>

<script>
// window.history.go(-1)
// Volver a la página anterior
window.history.back(-1);

// Actualizar la página
location.reload();
</script>

<!-- <script>window.history.go(-1)</script> -->