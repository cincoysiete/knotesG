<?php
session_start();
include("identifica.php"); 
// include("estilo.css"); 


// Crear una imagen de 50x50 con fondo transparente
$image = imagecreatetruecolor(51, 51);
imagesavealpha($image, true);
$transparent_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $transparent_color);

// Definir la variable y obtener la primera letra
$variable = strtoupper($_SESSION["gusuario1"]);
$first_letter = substr($variable, 0, 1);

// Generar un color basado en la letra
$hash = crc32($first_letter);
$red = ($hash & 0xFF0000) >> 16;
$green = ($hash & 0x00FF00) >> 8;
$blue = ($hash & 0x0000FF);
$background_color = imagecolorallocate($image, $red, $green, $blue);

// Calcular la luminosidad del color de fondo
$luminosity = 0.299 * $red + 0.587 * $green + 0.114 * $blue;

// Elegir el color de la letra basado en la luminosidad
if ($luminosity > 128) {
    // Fondo claro, letra negra
    $text_color = imagecolorallocate($image, 0, 0, 0);
} else {
    // Fondo oscuro, letra blanca
    $text_color = imagecolorallocate($image, 255, 255, 255);
}

// Calcular la posición para centrar el texto
$font_size = 28; // Ajusta el tamaño de la letra según tu preferencia
$font = $_SESSION["elusuario"] . '/arial.ttf';
$text_box = imagettfbbox($font_size, 0, $font, $first_letter);
$text_width = $text_box[4] - $text_box[6];
$text_height = $text_box[1] - $text_box[7];
$text_x = (imagesx($image) - $text_width) / 2;
$text_y = (imagesy($image) + $text_height) / 2;

// Dibujar el círculo con el color generado
$center_x = 25; // coordenada x del centro del círculo
$center_y = 25; // coordenada y del centro del círculo
$radius = 25; // radio del círculo
imagefilledellipse($image, $center_x, $center_y, $radius * 2, $radius * 2, $background_color);

// Escribir la letra en la imagen
imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font, $first_letter);

// Guardar la imagen en un archivo PNG
imagepng($image, $_SESSION["elusuario"] . '/perfil.png');

// Liberar memoria
imagedestroy($image);


// // Crear una imagen de 50x50 con fondo transparente
// $image = imagecreatetruecolor(51, 51);
// imagesavealpha($image, true);
// $transparent_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
// imagefill($image, 0, 0, $transparent_color);

// // Definir el color de fondo azul
// $background_color = imagecolorallocate($image, 0, 79, 172);

// // Definir la variable y obtener la primera letra
// $variable = strtoupper($_SESSION["gusuario1"]);
// $first_letter = substr($variable, 0, 1);

// // Calcular la posición para centrar el texto
// $font_size = 28; // Ajusta el tamaño de la letra según tu preferencia
// $font = $_SESSION["elusuario"] . '/arial.ttf';
// $text_box = imagettfbbox($font_size, 0, $font, $first_letter);
// $text_width = $text_box[4] - $text_box[6];
// $text_height = $text_box[1] - $text_box[7];
// $text_x = (imagesx($image) - $text_width) / 2;
// $text_y = (imagesy($image) + $text_height) / 2;

// // Dibujar el círculo azul
// $center_x = 25; // coordenada x del centro del círculo
// $center_y = 25; // coordenada y del centro del círculo
// $radius = 25; // radio del círculo
// imagefilledellipse($image, $center_x, $center_y, $radius * 2, $radius * 2, $background_color);

// // Escribir la letra en la imagen
// $text_color = imagecolorallocate($image, 255, 255, 255);
// imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font, $first_letter);

// // Guardar la imagen en un archivo PNG
// imagepng($image, $_SESSION["elusuario"] . '/perfil.png');

// // Liberar memoria
// imagedestroy($image);

?>

