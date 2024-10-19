<?php
session_start();
include("identifica.php"); 

unlink($_SESSION["usuarioZ"].'/perfil.png');
include("creaperfil.php");

?>
<script>window.history.go(-2)</script>
