<?php
session_start();
include("identifica.php"); 
// if ($_SESSION["comoveo"]!=1 and $_SESSION["comoveo"]!=-1){$_SESSION["comoveo"]=1;}
$_SESSION["oscuro"]=$_SESSION["oscuro"]*-1;
if ($_SESSION["tamanotxt"]==""){$_SESSION["tamanotxt"]="14px";}
file_put_contents($_SESSION["usuarioZ"]."/cambios.ubi",date("Y-d-m H:i:s").";".$_SESSION["oscuro"].";".$_SESSION["tamanotxt"]);
?>
<script>window.history.go(-1)</script>