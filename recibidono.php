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
<a id="verBoton8" href="javascript:window.history.go(-1)" title="Volver a notas"><img src="img/volver.png" width="70px"></a>

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

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal('modal')">&times;</span>
    <h2>Abandonar colaboración</h2>
    <?php
$_SESSION["we"]=$_GET["we"];
$kaka=explode(";",$_SESSION["we"]);
$keke=explode(".",$kaka[0]);
// echo $_GET["we"];
// echo "<br><br>";

?>
  <form action="quitarecibidono.php" method="post">
    <?php
echo "Vas a dejar de colaborar con <b>".$kaka[2]."</b> en su nota <b>".$keke[0]."</b><br><br>";
    ?>
  <input type="submit" value="Abandonar colaboración">
</form>

  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
  abrirModal('modal');
});

function abrirModal(idModal) {
  var modal = document.getElementById(idModal);
  modal.style.display = "block";
}

function cerrarModal(idModal) {
  var modal = document.getElementById(idModal);
  modal.style.display = "none";
  history.back(); // Retrocede en el historial del navegador
}

// window.onclick = function(event) {
//   var modals = document.getElementsByClassName("modal");
//   for (var i = 0; i < modals.length; i++) {
//     var modal = modals[i];
//     if (event.target == modal) {
//       cerrarModal(modal.id); // Cierra la modal si se hace clic fuera de ella
//     }
//   }
// }


</script>

<!-- <script>window.history.go(-1)</script> -->
