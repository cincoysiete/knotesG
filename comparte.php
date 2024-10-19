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

<?php
$contenido = file_get_contents($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);

?>

<script>
// if(navigator.share) {
    // let buttonShare = document.getElementById("button-share");
    // buttonShare.addEventListener("click", (e) => {
      e.preventDefault();
      const URL = this.href;
      navigator.share({
        title: "Compartir",
        text: "<?php echo $contenido; ?>",
        url: URL
      })
      return false;
    // });
// } else {
// }
</script>