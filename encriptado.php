<?php
if (isset($_SESSION["gusuario1"])) {$clave  = trim($_SESSION["gusuario1"]);}
$method = 'aes-256-cbc';
// $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
$iv = base64_decode("ZW1wcmVzYXNAYXVsYWludGVncmFsZGVmb3JtYWNpb24uZXM=");
 $encriptar = function ($valor) use ($method, $clave, $iv) {
     return openssl_encrypt ($valor, $method, $clave, false, $iv);
 };
 $desencriptar = function ($valor) use ($method, $clave, $iv) {
     $encrypted_data = base64_decode($valor);
     return openssl_decrypt($valor, $method, $clave, false, $iv);
 };

 ?>
 
