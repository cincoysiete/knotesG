<?php

// EMAIL DESDE EL QUE SE ENVIAN LOS CORREOS
$_SESSION["emailZ"]="5ysiete@gmail.com";

// DIRECTORIO HACIA ATRAS EN EL QUE SE UBICA encriptado.php
$retroZ="";

// IMAGEN DE FONDO
$imgfondoZ="img/image.jpeg";

// COLOR DE FONDO DEL FORMULARIO
$fondoformuZ="";

// COLOR FONDO BOTON ACCEDER
$fondobotonaccederZ="#004fac";

// COLOR FONDO BOTON CREAR CUENTA
$fondobotoncrearZ="#49A1B2";

// TITULO DEL FORMULARIO EN index.php
$tituloZ="kNotes";

// TEXTO EN EL BOTON DE ACCEDER EN index.php
$accederZ="Acceder";

// TEXTO EN EL BOTON DE CREAR CUENTA EN index.php
$crearZ="Crear cuenta";

// TEXTO EN EL ENLACE DE OLVIDE CLAVE EN index.php
$olvideZ="Olvidé mi clave";



// ************************************************ NO TOCAR *************

// URL DE LA APLICACION
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$directory = dirname($_SERVER['SCRIPT_NAME']);
$currentUrl = $scheme . '://' . $host . $directory;
if (!empty($_SERVER['QUERY_STRING'])) {
    $currentUrl .= '?' . $_SERVER['QUERY_STRING'];
}
$_SESSION["sitio"]=$currentUrl;

// MODIFICA El manifest.json AÑADIENDO URL DE LA APLICACION
$manifestFile = 'manifest.json';
$jsonData = file_get_contents($manifestFile);
$data = json_decode($jsonData, true);
$data['start_url'] = $_SESSION["sitio"]."index.php";
$newJsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($manifestFile, $newJsonData);

// KNOTES. A 1 SINCRONIZA NOTAS SEGUN ESTAS ESCRIBIENDO. 
$sincronizaZ="0";

// $_SESSION["sincrosino"]=4000;

// ***********************************************************************
?>
