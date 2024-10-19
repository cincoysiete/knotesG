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

<!-- ENCABEZADO DE LA APP -->
<br><br>
<div id="encabezado">
<center>
<table width="99%" border="0">
<tr><td align="left" width="20%">
<!-- <img src="<?php echo $_SESSION["usuarioZ"]."/perfil.png" ?>" width="40px"> -->

</td><td align="left" width="50%"><font size="3px" color="black">Notas archivadas
</td><td align="right">
<img src="img/knotes.png" height="20px"><br>
<?php echo '<font size="1px" color="black">'.base64_decode($_SESSION["usuarioZ"])."</font>"; ?>
</td></tr></table>
</div>
<br>

<!-- PANTALLA DE TRABAJO -->
<div id="contenido">   

<?php
if ($_SESSION["oscuro"]==1){$quemodo="oscuro";} else {$quemodo="claro";}
// echo "<hr>";
// MUESTRA NOTAS ELIMINADAS
function listarPapelera($path, $cuantosarchivos, $archives) {
    $dir = opendir($path);
    $cuenteo = 0;
    sort($archives);
    $columnas = 900; 
    $contador_columna = 0;
  
    echo '<div class="grid-container">';
  
    while ($cuenteo < $cuantosarchivos) {
        $kikio0 = explode("/", $archives[$cuenteo]);
        $kikio1 = explode(".", $kikio0[0]);
        $popup_id = uniqid();
        $esio=explode(".",$kikio0[0]);
        
  $kaka=$archives[$cuenteo];
  $tempo=explode(".",$kaka);
  
  $fecha_creacion = filectime($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);
  $tamaño_archivo = filesize($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);
  
  // RECUPERA POSICION Y TAMAÑO DE LA NOTA
  if (file_exists($_SESSION["usuarioZ"]."/".$tempo[0].".xubi")){
  $ar=fopen($_SESSION["usuarioZ"]."/".$tempo[0].".xubi","r") or die("No se pudo abrir 2");
  $linea=explode(";",fgets($ar));
  $leftPosition=$linea[0];
  $topPosition=$linea[1];
  $width=$linea[2];
  $height=$linea[3];
  $_SESSION["estrella"]=$linea[4];
  // if ($_SESSION["estrella"]!=1 and $_SESSION["estrella"]!=-1){$_SESSION["estrella"]=-1;}
  fclose($ar);
  }
  
  echo '<div class="grid-item">';

  ?>

  
  <!-- MUESTRA CADA NOTA CON LAS FUNCIONES DE ELIMINAR Y RENOMBRAR -->
  <div class="tabla">
    <div class="fila">
      <div class="celda">
        <a href="limpia.php?we=<?php echo base64_encode($esio[0]); ?>" title="Eliminar la nota"><img class="imagen-gris" src="img/cancelar.png" width="30"></a>
      </div>
  
      <div class="celda">
        <a href="" title=""><img class="imagen-gris" src="img/vacio.png" width="30"></a>
      </div>
  
      <div class="celda">
        <a href="recupera.php?we=<?php echo base64_encode($esio[0]); ?>" title="Recuperar nota"><img class="imagen-gris" src="img/recuperar0.png" width="30"></a></div>
    </div>
  </div>
  
  <div class="tabla">
    <div class="fila">
    <div class="celda">
      
  </div>
    <div class="celda">
  <?php 
//   if ($tamaño_archivo==0){$icono="img/vacia.png";} else {$icono="img/favicon.png";} ?>
      <!-- <a href="#" title="Abrir la nota" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/trash"."/".$archives[$cuenteo]); ?>', '<?php echo $popup_id; ?>', 'width=<?php echo rtrim($width); ?>,height=<?php echo rtrim($height); ?>,left=<?php echo rtrim($leftPosition); ?>,top=<?php echo rtrim($topPosition); ?>,menubar=no').focus(); return false;"><img src="<?php echo $icono; ?>" alt="Imagen de enlace" width="50" ></a> -->
  
  
  </div>
  
    <div class="celda">
  
    </div>
  
    </div>
  </div>
  
  <div class="tabla">
    <div class="fila">
  
      <div class="celda">
      </div>
  
    </div>
  </div>
  <a href="#" title="Abrir la nota" onClick="window.open('previsualiza.php?mtk=<?php echo base64_encode($_SESSION["usuarioZ"]."/".$archives[$cuenteo]); ?>', '<?php echo $popup_id; ?>', 'width=<?php echo rtrim($width); ?>,height=<?php echo rtrim($height); ?>,left=<?php echo rtrim($leftPosition); ?>,top=<?php echo rtrim($topPosition); ?>,menubar=no').focus(); return false;" ><?php echo $esio[0]; ?></a>
  
  <?php
  $contenido = file_get_contents($_SESSION["usuarioZ"]."/".$archives[$cuenteo]);
  ?>
  
  <!-- MUESTRA FECHA DE CREACION DE LA NOTA -->
  <?php 
  echo '<div class="interlin">'.date("Y-m-d H:i:s", $fecha_creacion).'</div>';
  echo '<div class="interlin">'.$tamaño_archivo.' bytes</div>'; 
  ?>
  
  <?php 
//   if ($_SESSION["estrella"]==1){
//       $mencion="img/estrellasi.png"; 
//       echo '<button class="boton-transparente"><a href="estrella.php?mtk='.base64_encode($_SESSION["usuarioZ"]."/trash"."/".$archives[$cuenteo]).'" title="Desmarcar la nota"><img src="'.$mencion.'" width="30px"></a></button><br>';
//       } else {
//       $mencion="img/estrellano.png"; 
//       echo '<button class="boton-transparente"><a href="estrella.php?mtk='.base64_encode($_SESSION["usuarioZ"]."/trash"."/".$archives[$cuenteo]).'" title="Marcar la nota como favorita"><img class="imagen-gris" src="'.$mencion.'" width="30px"></a></button><br>';
  
//       } 
      ?>
  
  <?php
        echo '</div>';
  
        $cuenteo++;
        $contador_columna++;
        if ($contador_columna == $columnas) {
            echo '<div class="clearfix"></div>'; 
            $contador_columna = 0;
        }
    }
  
    echo '</div>';
  }
  
  
    // LEE LAS NOTAS DE LA CARPETA DEL USUARIO
  $cuantosarchivos = 0;
  $archives = array();
  $dir = opendir($_SESSION["usuarioZ"]."/");
  
  while ($elemento = readdir($dir)) {
    if ($elemento != "." && $elemento != ".." && strpos($elemento, ".xmd")) {
        if (!is_dir($_SESSION["usuarioZ"]."/".$elemento)) {
            $archives[$cuantosarchivos] = $elemento;
            $cuantosarchivos++;
        }
    }
  }
  
  listarPapelera($_SESSION["usuarioZ"],$cuantosarchivos,$archives ); 

echo "<br>";
?>
