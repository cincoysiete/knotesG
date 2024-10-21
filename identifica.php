<?php
include("variablesZ.php");
include($retroZ."encriptado.php");

// SESION PEGAJOSA. LA SESION NO SE CIERRA HASTA QUE LO HAGAS DESDE EL MENU DESPLEGABLE
$sipaso="no";
if (!isset($_SESSION["gusuario"])){
     ?>
<script>window.location.href = 'index.php';</script>
<?php 

}
if ($_SESSION["gusuario"]==base64_encode($_SESSION["gusuario1"]) and $_SESSION["gclave"]==$encriptar($_SESSION["gclave1"])){$sipaso="si";} 

if (isset($_COOKIE['SesionKnotes']) or $sipaso=="si"){

} else {
     ?>
     <script>window.location.href = 'index.php';</script>
     <?php 
     }

?>
