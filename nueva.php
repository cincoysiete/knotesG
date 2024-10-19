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
$nombre=$_SESSION["usuarioZ"]."/".$_POST["campoTexto"].".md";
if (file_exists($nombre)){} else {
file_put_contents($nombre, "");
$nombra=str_replace(".md",".ubi",$nombre);
file_put_contents($nombra,"0;0;400;500;-1");
// echo '<script>window.location.href = "creanueva.php?archivo=' . urlencode($nombre) . '";</script>';

}
?>

<script>
        // Función para ejecutar al salir de la página
        window.addEventListener('beforeunload', function(event) {
            // Código que deseas ejecutar
            window.open('kaka.php?mtk=<?php echo $_SESSION["usuarioZ"]."/"; ?><?php echo $archives[$cuenteo]; ?>', '<?php echo $popup_id; ?>', 'width=<?php echo rtrim($width); ?>,height=<?php echo rtrim($height); ?>,left=<?php echo rtrim($leftPosition); ?>,top=<?php echo rtrim($topPosition); ?>,menubar=no').focus();
        });
    </script>


<script>window.history.go(-2)</script>

