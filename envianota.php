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

// SI EXISTE LA CUENTA COMPARTE NOTA PARA COLABORAR
$pitofla = base64_encode(strtolower($_POST["quecuenta"]));
if (is_dir($pitofla)){
    $arx=fopen(base64_encode(strtolower($_POST["quecuenta"]))."/mensaje.ubi","a") or die("Problemas en la creacion ");
    fputs($arx,$_POST["quenota"].";".strtolower($_POST["quecuenta"]).";".base64_decode($_SESSION["usuarioZ"]).PHP_EOL);
    fclose($arx);

    // AVISA DE QUE LE COMPARTES UNA NOTA
    $enlace=explode(".",$_POST["quenota"]);
    $para = trim(strtolower($_POST["quecuenta"]));
    $asunto = base64_decode($_SESSION["usuarioZ"])." comparte ".$enlace[0]." contigo";
    $mensaje = "Hola, ".base64_decode($_SESSION["usuarioZ"])." te invita a colaborar en la nota ".$enlace[0];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "Reply-To: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    mail($para, $asunto, $mensaje, $headers);

    // TE DEJA EMAIL DE QUE LE COMPARTES UNA NOTA
    $enlace=explode(".",$_POST["quenota"]);
    $para = base64_decode($_SESSION["usuarioZ"]);
    $asunto = trim(strtolower($_POST["quecuenta"]))." -> ".$enlace[0];
    $mensaje = "Hola, hascompartido ".$enlace[0]." con ".trim(strtolower($_POST["quecuenta"]));
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "Reply-To: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    mail($para, $asunto, $mensaje, $headers);

    ?><script>window.history.go(-2)</script><?php
} else {
// SI NO EXISTE LA CUENTA, LE ENVIA UN EMAIL PARA QUE SE DE DE ALTA Y COMPARTE LA NOTA
    $enlace=base64_encode($_POST["quenota"].";".strtolower($_POST["quecuenta"]).";".base64_decode($_SESSION["usuarioZ"]));
    $para = trim(strtolower($_POST["quecuenta"]));
    $asunto = base64_decode($_SESSION["usuarioZ"])." comparte nota contigo";

    $mensaje = "Hola, ".base64_decode($_SESSION["usuarioZ"])." te invita a colaborar en una nota compartida. <br><br>Si aceptas, toca el enlace de abajo, crearás tu cuenta en kNotes con tu email: ".strtolower($_POST["quecuenta"]).", recibirás un email con tus credenciales de acceso y podrás acceder a la nota. Gracias<br><br>".'<a href='.$_SESSION["sitio"].'creacuenta.php?kn='.$enlace.'">Aceptar nota</a>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "Reply-To: ".trim(base64_decode($_SESSION["usuarioZ"]))."\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    mail($para, $asunto, $mensaje, $headers);

// if (mail($para, $asunto, $mensaje, $headers)){
// echo "Enviado";
// echo "<br>";
// echo "REMITE: ".base64_decode($_SESSION["usuarioZ"]);
// echo "<br>";
// echo "DESTINO: ".$para;
// echo "<br>";
// echo $_POST["quecuenta"];
// echo "<br>";
// echo $mensaje;
// echo "<br>";
// echo "<br>";
// echo "<br>";

//     } else {
// echo "Error";
//     }

// echo $enlace;
}

?>

<script>window.history.go(-2)</script>