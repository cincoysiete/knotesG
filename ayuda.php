<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 

// GESTION DEL MODO OSCURO
if (isset($_SESSION['oscuro'])) {$_SESSION["oscuro"]=1;}
if (file_exists($_SESSION["usuarioZ"]."/cambios.ubi")){
$ar=fopen($_SESSION["usuarioZ"]."/cambios.ubi","r") or die("No se pudo abrir 1");
$linea=explode(";",fgets($ar));
$_SESSION["oscuro"]=$linea[1];
fclose($ar);
}
if ($_SESSION["oscuro"]==0) {$_SESSION["oscuro"]=1;}
if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>
<a id="verBoton8" href="javascript:window.history.go(-1)" title="Volver a notas"><img class="semi-transparent" src="img/volver.png" width="70px"></a>

<style>
/* MODAL */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 50;
    width: 60%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4);
    background-color: #D5D5D5;
    padding: 20px;
    font-size: 14px;

  }
  
  .modal-contenido {
    background-color: #8dd1ff;
    margin: 50px auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    height: 90%;
    border-radius: 10px;
  }
  
  .cerrar {
    /* color: #aaa; */
    color: #1f1f1f;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .cerrar:hover,
  .cerrar:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<!-- ENCABEZADO DE LA APP -->
<div id="encabezado">
<center>
<table width="99%" border="0">
<tr><td align="left" width="20%">
</td><td align="center" width="50%">
</td><td align="right">
<img src="img/knotes.png" height="20px"><br>
<?php echo '<font size="1px" color="black">'.base64_decode($_SESSION["usuarioZ"])."</font>"; ?>
</td></tr></table>
</div>

<div class="contenidomd">   

<!-- MUESTRA LA NOTA EN MODO LECTURA -->
<?php 
require 'Parsedown.php'; 
if (file_exists("notas/ayuda.md")) {
        $contenidoMarkdown = file_get_contents("notas/ayuda.md");
        $parsedown = new Parsedown();
        $contenidoHTML0 = $parsedown->text(strip_tags($contenidoMarkdown));
    } else {
        $contenidoHTML0 = '';
    }

    // AJUSTA IMAGENES AL ANCHO DE LA VENTANA
        $contenidoHTML0=str_replace('.jpg"','.jpg" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.jpeg"','.jpeg" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.png"','.png" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.gif"','.gif" style="max-width: 100%"',$contenidoHTML0);

        $contenidoHTML0=str_replace('.JPG"','.JPG" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.JPEG"','.JPEG" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.PNG"','.PNG" style="max-width: 100%"',$contenidoHTML0);
        $contenidoHTML0=str_replace('.GIF"','.GIF" style="max-width: 100%"',$contenidoHTML0);

        echo "<br><br>";
        echo '<div class="previa">'.$contenidoHTML0.'</div>'; 
        echo "<br><br><br><br>";

?>


</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    abrirModal('modal');
  });

  function abrirModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = "block";

    // Obtener el campo de texto por su ID
    var input = document.getElementById('nuevonombres');
    
    // Obtener la longitud del texto dentro del campo de texto
    var length = input.value.length;
    
    // Mover el cursor al final del texto
    input.setSelectionRange(length, length);
    
    // Establecer el foco en el campo de texto
    input.focus();
    input.select();
  }

  function cerrarModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = "none";
    history.back(); // Retrocede en el historial del navegador
  }

</script>