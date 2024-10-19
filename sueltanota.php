<?php
session_start();
include('variablesZ.php');

// ELIMINA EL ARCHIVO DE BLOQUEO Y CREA UNA COOCKIE DE 20 SEGUNDOS PARA DAR TIEMPO A QUE OTRO USUARIO LA BLOQUEE
$file=$_SESSION["titlo"]."/".$_SESSION["titul"].".blq";
    unlink($file);

    // setcookie("sueltanota", 1, time() + 20);
    setcookie("sueltanota", $file, time() + 20);


?>
<script>window.history.go(-1)</script>
