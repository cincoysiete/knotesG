<?php
session_start();
include("identifica.php"); 

// $ext=".html";
// $eltexto=$_SESSION["contenidoHTML"];

// $ext=".md";
// $eltexto=$_SESSION["contenidoMarkdown"];

// if ($_SESSION["comoveo"]==-1){$eltexto=$_SESSION["textoplano"]; $ext=".txt";} else {$eltexto=$_SESSION["contenidoMarkdown"]; $ext=".md";}

// $eltexto=$_SESSION["contenidoMarkdown"]; $ext=".txt";
$eltexto=$_SESSION["textoplano"]; $ext=".txt";
$nomarche=explode("/",$_SESSION["nombreArchivoMarkdown"]);
$nomarcho=ltrim($nomarche[1]);
$nomarchi=explode(".",$nomarcho);
file_put_contents($nomarchi[0].$ext,$eltexto);

header('Content-Type: application/txt');
header('Content-Disposition: attachment; filename="' . $nomarchi[0].$ext . '"');
header('Content-Length: ' . filesize($nomarchi[0].$ext));
readfile($nomarchi[0].$ext);

?>


