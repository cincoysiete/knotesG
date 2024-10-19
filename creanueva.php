<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
$nombreArchivo = $_GET["archivo"];
?>
<script>
    // Llamar a la función para abrir la ventana emergente después de que la página se haya cargado completamente
    window.onload = function() {
        abrirVentanaEmergente("<?php echo $nombreArchivo; ?>");
    };

    function abrirVentanaEmergente(nombreArchivo) {
        var url = 'previsualiza.php?mtk=' + nombreArchivo;
        var ancho = 405;
        var altura = 430;
        var left = (screen.width - ancho) / 2;
        var top = (screen.height - altura) / 2;
        var opciones = 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=' + ancho + ', height=' + altura + ', top=' + top + ', left=' + left;
        window.open(url, 'VentanaEmergente', opciones);
    }


</script>

<script>window.history.go(-2)</script>
