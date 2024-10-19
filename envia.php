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
    <h2>Envía nota para colaborar</h2>
    <?php
    $pela=explode(".",base64_decode($_GET["we"]));
    // echo $pela[1]." - ";
    if ($pela[1]=="md"){$_SESSION["we"]=$pela[0];} else {$_SESSION["we"]=base64_decode($_GET["we"]);}
      
      echo $_SESSION["we"];
      echo "<br><br>";
    ?>
    <form action="envianota.php" method="post">
      <input type="text" name="quecuenta" id="nuevonombres" placeholder="Email" value="" autocomplete="off" maxlength="60">
      <!-- <input type="checkbox" name="invito"> -->
      <input type="hidden" name="quenota" value="<?php echo $_SESSION["we"].".md"; ?>">

      <br><br>
      <input type="submit" value="Enviar">
      <span class="letrilla">Si tu colega no tiene cuenta en kNotes se le invitará a crear una para colaborar en tu nota</span>
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