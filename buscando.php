<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
// $_SESSION["comoveo"]=1;
// echo("<meta http-equiv='refresh' content='15'>");
if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}

?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<title>Knotes</title>

<a id="verBoton8" href="javascript:window.history.go(-2)" title="Volver a notas"><img class="semi-transparent" src="img/volver.png" width="70px"></a>

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

<!-- <div id="contenido">    -->

<?php
    // Procesar el formulario cuando se envíe
        // Obtener el texto ingresado por el usuario
        $texto_a_buscar = $_POST['texto_a_buscar'];

        echo "Hemos encontrado <u>".$texto_a_buscar."</u> en estas notas: <br>";
        // Directorio donde se encuentran los archivos .md
        $directorio = $_SESSION["usuarioZ"]."/";

        // Obtener la lista de archivos .md en el directorio
        // $archivos_md = glob($directorio . '*.md');
        $archivos_md = glob($directorio . '*.{md,xmd}', GLOB_BRACE);

        // Iterar sobre cada archivo .md
        foreach ($archivos_md as $archivo) {
            // Leer el contenido del archivo
            $contenido = file_get_contents($archivo);
            
            // Buscar el texto en el contenido del archivo
            if (strpos(strtoupper($contenido), strtoupper($texto_a_buscar)) !== false) {
                // Si se encuentra el texto, mostrar el nombre del archivo

    echo "<br>";
    $larchive=explode("/",$archivo);
    $larchivo=explode(".",$larchive[1]);
    
    ?>

    <a href="#" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$larchive[1]); ?>', '<?php echo $popup_id; ?>', 'width=450,height=500,left=50,top=50,menubar=no').focus(); return false;"><img src="img/favicon.png" alt="Imagen de enlace" width="40" ><?php echo $larchivo[0]; ?></a>


<?php
            }
        }
    ?>