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

<div id="encabezado">
<br><center>
<table width="90%" border="0">
<tr><td align="center">

</td><td align="center">
<img src="img/knotes.png" height="20px">
</td><td align="center">

</td></tr></table>
</div>

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal('modal')">&times;</span>
    <h2>Renombra nota</h2>
    <?php
    //   $_SESSION["we"]=$_GET["we"];
    //   echo $_GET["we"];
    //   echo "<br><br>";
    ?>
        <form action="subida.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" id="nuevonombres" accept=".zip">
        <br><br>
        <input type="submit" value="Subir Archivo">


    <!-- <form action="cambianombre.php" method="post">
      <input type="text" name="nuevonombre" id="nuevonombres" placeholder="Renombra la nota" value="<?php echo $_SESSION["we"]; ?>" autocomplete="off">
      <br><br>
      <input type="submit" value="Renombra">
    </form> -->
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

  window.onclick = function(event) {
    var modals = document.getElementsByClassName("modal");
    for (var i = 0; i < modals.length; i++) {
      var modal = modals[i];
      if (event.target == modal) {
        cerrarModal(modal.id); // Cierra la modal si se hace clic fuera de ella
      }
    }
  }
</script>