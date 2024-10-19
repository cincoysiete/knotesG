<?php
session_start();
include("identifica.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jacquard+24+Charted&family=Jersey+15&family=Jersey+20+Charted&family=Lora:ital,wght@0,400..700;1,400..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<!-- <link rel="icon" type="image/png" href="img/favicon.png" /> -->

<?php
include("estilo.css"); 
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
date_default_timezone_set('Europe/Madrid');

if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}
include('Mobile_Detect.php');
include('variablesZ.php');

$_SESSION["movilZ"]=0;
$detect = new Mobile_Detect();
if ($detect->isMobile()) {$_SESSION["movilZ"]=-1;}
if ($detect->isTablet()) {$_SESSION["movilZ"]=1;}

$titlo=explode("/",base64_decode($_GET["mtk"]));
$titul1=explode(".",$titlo[1]);
$titul=$titul1[0];
$_SESSION["titul"]=$titul;
$_SESSION["titlo"]=$titlo[0];

// BLOQUEO DE NOTA. BLOQUEO DE LA NOTA POR EL PRIMERO QUE LA ABRE
$kakeo=explode(".",base64_decode($_GET["mtk"]));
if (file_exists($kakeo[0].".prt")){$candado="si";} else {$candado="no";}
// echo $candado."<br>".$_SESSION["titlo"]." = ".$_SESSION["usuarioZ"]."<br>".$kakeo[0].".prt"."<br>";

$file=$_SESSION["titlo"]."/".$_SESSION["titul"].".blq";
if ($_COOKIE["sueltanota"]!=$file){
if (!file_exists($file) and !is_file($file)){
    file_put_contents($file,base64_decode($_SESSION["usuarioZ"]));
}
}

$user=file_get_contents($file);
if ($candado!="si"){
if (rtrim($user)==rtrim(base64_decode($_SESSION["usuarioZ"]))){
    $escribo="si";
    echo '<a href="sueltanota.php"><img src="img/verde.png" width="15px" title="Toca para desbloquear la nota"></a>'."<font size='1px'> ".$user."</font>";
} else {
    $escribo="no";
    echo '<img src="img/rojo.png" width="15px" title="La nota está bloqueada por otra persona">'."<font size='1px'> ".$user."</font>";
    $_SESSION["comoveo"]=-1;
}
} else {
    if ($_SESSION["titlo"]==$_SESSION["usuarioZ"]){
        $escribo="si";
        echo '<img src="img/verde.png" width="15px" title="La nota está protegida por ti">'."<font size='1px'> ".$user."</font>";
        // echo '<a href="sueltanota.php"><img src="img/verde.png" width="15px" title="Toca para desbloquear la nota"></a>'."<font size='1px'> ".$user."</font>";
    } else {
        $escribo="no";
        echo '<img src="img/rojo.png" width="15px" title="La nota está protegida por su autor">'."<font size='1px'> ".$user."</font>";
        $_SESSION["comoveo"]=-1;
    }
       
}



// if ($candado=="si" and $_SESSION["titlo"]==$_SESSION["usuarioZ"]){
//     $escribo="si";
//     echo '<img src="img/verde.png" width="15px" title="La nota está protegida">'."<font size='1px'> ".$user."</font>";
// }
// else {
//     $escribo="no";
//     echo '<img src="img/rojo.png" width="15px">'."<font size='1px'> ".$user."</font>";
//     $_SESSION["comoveo"]=-1;
  
// }

// } else {

//     $escribo="no";
//     echo '<img src="img/rojo.png" width="15px">'."<font size='1px'> ".$user."</font>";
//     $_SESSION["comoveo"]=-1;
// }

// echo "<br>".base64_decode($_SESSION["titlo"])." = ".base64_decode($_SESSION["usuarioZ"]);

?>

<!-- SI TU NOTA ESTA BLOQUEADA PARA ESCRIBIR, SE ACTUALIZA CADA 10 SEGUNDOS -->
<script type="text/javascript">
        // Pasar la variable PHP a JavaScript
        var escribo = "<?php echo $escribo; ?>";
        
        // Verificar si escribo es igual a 'no'
        if (escribo === 'no') {
            setTimeout(function() {
                location.reload();
            }, 10000);
        }
    </script>


<title><?php echo $titul; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">


<!-- RECUADRO PARA ARRASTRAR ARCHIVOS A LA NOTA -->
<style>
#drop-area {
  border: 2px dashed #78b9eb;
  padding: 2px;
  width: 20%;
  height: 50px;
  text-align: center;
  position: fixed; 
  bottom: 10px; 
  right: 10px; 
  z-index: 999; 
  background-image: url('img/subida.png');
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}

#file-input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}
</style>

<style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* #editordata { */
            /* width: 100%;
            box-sizing: border-box;
            padding: 5px 5px 5px 5px; */
        /* } */

        .previa {
            width: 90%;
            box-sizing: border-box;
            padding: 3px 3px 3px 3px;
            line-height: 1.4;
            letter-spacing: 0.04em; 
            font-size: <?php echo $_SESSION["tamanotxt"]; ?>;
            padding-bottom: 60px;
        }

        </style>

<!-- MODAL PARA MOSTRAR EMOJIS -->
<style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 80%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .emoji {
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
            line-height: 1.5em; 

        }

    </style>


<script>
// MANTIENE EL FOCO EN LA NOTAS TRAS ACTUALIZAR
window.addEventListener('DOMContentLoaded', (event) => {
    var textarea = document.getElementById('editordata');
    textarea.focus();
    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
});

// ENVIAR COORDENADAS DE LA VENTANA
function sendWindowInfo() {
  var windowInfo = {
        left: window.screenLeft,
        top: window.screenTop,
        width: window.innerWidth,
        height: window.innerHeight
    };
    
    const json = JSON.stringify(windowInfo);
    const url = 'coordenadas.php'; 
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: json
    };

    fetch(url, options)
        .then(response => response.json())
        .then(data => console.log('Datos de la ventana enviados:', data))
        .catch(error => console.error('Error al enviar datos de la ventana:', error));

}
</script>



<!-- The Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="emojiContainer">
        <?php 
        include("emojis.ubi");
        include("emojis2.ubi");
        include("emojis4.ubi");
        include("emojis1.ubi");
         ?>
    </div>
  </div>
</div>



<?php

// ELIMINA MARCAS DE MARKDOWN Y DEJA EL TEXTO PLANO
function eliminarMarkdown($texto) {
    // Elimina los encabezados
    $texto = preg_replace('/^(#{1,6})\s+(.*)/m', '$2', $texto);

    // Elimina los enlaces y deja solo el texto del enlace
    $texto = preg_replace('/\[([^\[]+)\]\(([^)]+)\)/', '$1', $texto);

    // Elimina el formato en negrita y cursiva
    $texto = preg_replace('/(\*\*|__)(.*?)\1/', '$2', $texto); // negrita
    $texto = preg_replace('/(\*|_)(.*?)\1/', '$2', $texto);    // cursiva

    // Elimina el formato de código en línea y bloques de código
    $texto = preg_replace('/`([^`]+)`/', '$1', $texto);         // código en línea
    $texto = preg_replace('/```([^`]+)```/s', '$1', $texto);    // bloques de código

    // Elimina las listas (tanto ordenadas como desordenadas)
    $texto = preg_replace('/^\s*([-*+]|\d+\.)\s+/', '', $texto);

    // Elimina las imágenes y deja solo el texto alternativo
    $texto = preg_replace('/!\[([^\[]*)\]\(([^)]+)\)/', '$1', $texto);

    // Elimina las citas
    $texto = preg_replace('/^>\s+/', '', $texto);

    // Elimina los saltos de línea adicionales
    $texto = preg_replace('/\n{2,}/', "\n", $texto);

    return $texto;
}

$nombreArchivoMarkdown = base64_decode($_GET["mtk"]);

// MOSTRAR CONTENIDO COMO MARKDOWN
require 'ParsedownMy.php'; 
if (file_exists($nombreArchivoMarkdown)) {
        $contenidoMarkdown = file_get_contents($nombreArchivoMarkdown);
        $parsedown = new MyParsedown();
        $contenidoHTML = $parsedown->text(strip_tags($contenidoMarkdown));
    } else {
        $contenidoHTML = '';
    }
    $_SESSION["nombreArchivoMarkdown"]=$nombreArchivoMarkdown;
    $_SESSION["contenidoHTML"]=$contenidoHTML;
    $_SESSION["textoplano"]=eliminarMarkdown($contenidoMarkdown);
    $_SESSION["contenidoMarkdown"]=$contenidoMarkdown;

    ?>

<!-- GUARDA EL CONTENIDO DE LA NOTA -->
<script>
document.getElementById('editordata').addEventListener('input', guardarCambios);
document.getElementById('editordata').addEventListener('paste', guardarCambios);
document.getElementById('editordata').addEventListener('cut', guardarCambios);
document.getElementById('editordata').addEventListener('keydown', guardarCambios);

function guardarCambios(event) {
            event.preventDefault(); 
            var formData = new FormData(document.getElementById('editorForm'));
            // Realizar una solicitud AJAX para guardar los cambios
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'guardar.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Cambios guardados exitosamente.');
                } else {
                    console.error('Error al guardar los cambios.');
                }
            };
            xhr.send(formData);
            obtenerParametroURL(nombre);

            var bloqueo = getCookie('bloqueo');
            if (bloqueo) {navigator.sendBeacon("quitabloqueo.php?mtk=" + encodeURIComponent(bloqueo));}

        }

</script>


<!-- MUESTRA FORMATO TEXTO O VISTA PREVIA MARKDOWN -->
    <form id="editorForm" action="guardar.php" method="POST" onsubmit="guardarCambios(event)">
    
    <!-- CAMBIO MODO EDICION A MODO LECTURA -->
    <?php if ($_SESSION["comoveo"]!=-1){ ?>
        
        <!-- MUESTRA LA NOTA EN MODO EDICION -->
        <!-- LO QUE CONTENGA myDiv ES LO QUE SE COMPARTE -->
    <div id=myDiv >
        <!-- NO SINCRONIZA. SOLO GUARDA LO QUE ESCRIBES -->

<?php 
// BLOQUEO DE NOTA.
if ($escribo=="si"){ ?>
        <textarea id="editordata" class="oscuro" name="editornota" placeholder="Comienza a escribir..." cols="90%" oninput="guardarCambios(event)" ><?php echo $contenidoMarkdown; ?></textarea>
<?php } else { ?>
        <textarea id="editordata" class="oscuro" name="editornota" placeholder="Comienza a escribir..." cols="90%" oninput="guardarCambios(event)" disabled ><?php echo $contenidoMarkdown; ?></textarea>
<?php } ?>

    </div>


<!-- HABILITAMOS LA OPCION DE DESHACER Ctrl z -->
<script>
    const textarea = document.getElementById('editordata');

    // Almacena el historial de cambios
    let history = [];
    let currentIndex = -1;

    // Función para guardar el estado actual
    function saveState() {
        const value = textarea.value;
        // Solo agrega al historial si no es igual al último estado
        if (currentIndex === -1 || history[currentIndex] !== value) {
            history.push(value);
            currentIndex++;
        }
    }

    // Almacena el estado inicial
    saveState();

    // Escucha el evento de entrada
    textarea.addEventListener('input', saveState);

    // Escucha el evento de teclado
    document.addEventListener('keydown', function(event) {
        // Ctrl + Z para deshacer
        if (event.ctrlKey && event.key === 'z') {
            event.preventDefault(); // Evita el comportamiento por defecto

            // Si hay un estado anterior, regresa a él
            if (currentIndex > 0) {
                currentIndex--;
                textarea.value = history[currentIndex];
            }

        }
    }
                guardarCambios(event);
);
</script>



<!-- MUESTRA CODIGOS MARKDOWN AL PULSAR DETERMINADAS TECLAS -->
<script>
// Mapa de combinaciones de teclas y los textos correspondientes
const keyTextMap = {
    'ctrl+shift+f1': { text: "# ", backspace: 0 },
    'ctrl+shift+f2': { text: "## ", backspace: 0 },
    'ctrl+shift+f3': { text: "### ", backspace: 0 },
    'ctrl+shift+f4': { text: "#### ", backspace: 0 },
    'ctrl+shift+n': { text: "****", backspace: 2 },
    'ctrl+shift+i': { text: "**", backspace: 1 },
    'ctrl+shift+u': { text: "~~~~", backspace: 2 },
    'ctrl+shift+l': { text: "- ", backspace: 0 },
    'ctrl+shift+c': { text: " > ", backspace: 0 },
    'ctrl+shift+p': { text: "```\n\n```\n", backspace: 5 },
    'ctrl+shift+t': { text: "|  |  |  |\n|:-|::|-:|\n|  |  |  |\n|  |  |  |\n", backspace: 42 },
    'ctrl+shift+e': { text: "[](https://)", backspace: 11 },
    'ctrl+shift+!': { text: "![](https://)", backspace: 11 },
    'ctrl+shift+w': { text: "[![imagen](img.png) texto ](https://)", backspace: 28 },
    'ctrl+shift+s': { text: "\n---\n", backspace: 0 },
    'ctrl+shift+o': { text: "<!--  -->", backspace: 4 },
    'ctrl+shift+f': { text: '', backspace: 0 }
};

document.addEventListener('keydown', function(event) {
    // Construir la clave a partir de la combinación de teclas presionadas
    let keyCombo = '';
    if (event.ctrlKey) keyCombo += 'ctrl+';
    if (event.altKey) keyCombo += 'alt+';
    if (event.shiftKey) keyCombo += 'shift+';
    keyCombo += event.key.toLowerCase();

    // Evitar afectar la combinación de teclas de Pegar (Ctrl+V) y otras combinaciones estándar
    if (keyCombo === 'ctrl+v' || keyCombo === 'ctrl+c' || keyCombo === 'ctrl+x' || keyCombo === 'ctrl+a') {
        return;
    }

    // Verifica si la combinación de teclas está en el mapa
    if (keyTextMap[keyCombo]) {
        event.preventDefault(); // Evita el comportamiento predeterminado

        // Selecciona el textarea
        var textarea = document.getElementById('editordata');
        // El texto correspondiente a la combinación de teclas
        var { text, backspace } = keyTextMap[keyCombo];

        // Si la combinación es Ctrl+Shift+F, inserta la fecha actual
        if (keyCombo === 'ctrl+shift+f') {
            const now = new Date();
            const dateText = now.toISOString().split('T')[0];  // Formato: YYYY-MM-DD
            text = dateText + ' ';
        }

        // Guarda la posición actual del cursor
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;

        // Inserta el texto en la posición del cursor
        var before = textarea.value.substring(0, start);
        var after = textarea.value.substring(end, textarea.value.length);
        textarea.value = before + text + after;

        // Ajusta la posición del cursor después de la inserción
        var newPosition = start + text.length;
        textarea.selectionStart = textarea.selectionEnd = newPosition;

        // Retrocede el cursor según el valor especificado en el mapa
        textarea.selectionStart = textarea.selectionEnd = newPosition - backspace;

        // Llama a la función guardarCambios
        guardarCambios(event);
    }
});
</script>



<!-- REPITE - O > PARA FACILITAR LA CREACION DE LISTAS Y CITAS Y AÑADE DOS ESPACIOS AL FINAL DE LA LINEA SI NO LOS TIENE-->
<script>
document.getElementById('editordata').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        const textarea = e.target;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const value = textarea.value;
        const before = value.substring(0, start);
        const after = value.substring(end);
        const lines = before.split('\n');
        const currentLine = lines[lines.length - 1].trim();

        // Verifica si la línea actual es un título (comienza con '#')
        if (currentLine.startsWith('#')) {
            e.preventDefault(); // Prevenir comportamiento por defecto
            // Inserta un salto de línea sin espacios extra ni tabulaciones
            textarea.value = before + '\n' + after;
            const newCursorPos = start + 1; // Mover cursor a la nueva línea
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            return;
        }

        // Verifica si la línea actual necesita ser eliminada o formateada
        if (currentLine === '-' || currentLine === '- ' || currentLine === '>' || currentLine === ' >') {
            e.preventDefault(); // Solo prevenir cuando es necesario
            // Eliminar la línea actual
            lines.pop();
            textarea.value = lines.join('\n') + after;
            textarea.setSelectionRange(lines.join('\n').length + 1, lines.join('\n').length + 1);
            return;
        }

        // No duplicar el salto de línea: solo inserta una nueva línea manualmente
        e.preventDefault(); // Evita el comportamiento por defecto

        let newLine = '\n'; // Inserta solo un salto de línea sin añadir espacios extra

        // Si la línea comienza con '- ' o '> ', añade ese formato en la nueva línea
        if (currentLine.startsWith('- ') && currentLine.trim() !== '-') {
            newLine += '- ';
        } else if (currentLine.startsWith('> ') && currentLine.trim() !== '>') {
            newLine += '> ';
        }

        // Inserta el salto de línea manualmente sin los espacios
        textarea.value = before + newLine + after;

        // Coloca el cursor después de la nueva línea
        const newCursorPos = start + newLine.length;
        textarea.setSelectionRange(newCursorPos, newCursorPos);
    }
});


</script>
    <!-- BOTON PARA MOSTRAR NOTA EN MODO LECTURA -->
        <a id="verBoton2" href="aspecto.php" title="Muestra la nota en modo lectura"><img src="img/ver.png" width="40px"></a>

        <!-- BOTON DE COMPARTIR -->
        <?php if ($_SESSION["movilZ"]==1 or $_SESSION["movilZ"]==-1){ ?>
            <a href="#" id="shareButton" title="Compartir nota"><img src="img/compartir.png" width="30px"></a>
            <?php } ?>


        <!-- DESCARGAR NOTA EN PDF -->
        <?php if ($_SESSION["movilZ"]==1 or $_SESSION["movilZ"]==-1){} else { ?>
        
        <a id="verBoton3" href="descargasolo.php" title="Descargar nota"><img src="img/descargar.png" height="30px"></a>

        <a id="openModal" href="#" title="Insertar emojis en la nota"><font color="#8dd1ff"> Emoji</font></a>
        <a href="ayuda.php">       <img src="img/ayuda.png" width="11px"></a>

        <a id="verBoton7" href="#" onclick="sendWindowInfo()" title="Guarda posición y tamaño de la ventana"><img src="img/coordenadas.png" width="30px"></a>
        
        <?php } ?>



        <!-- RECUADRO DE ARRASTRAR Y SOLTAR Y BOTON DE SUBIR -->
        <div id="drop-area" id="verBoton4" ondragover="allowDrop(event)" ondrop="drop(event)" title="Arrastra o selecciona documento para añadir a la nota">
        <input type="file" id="file-input" onchange="handleFile(event)">


    <?php } else { ?> 

        <!-- MUESTRA LA NOTA EN MODO LECTURA -->
        <?php 
        // AJUSTA IMAGENES AL ANCHO DE LA VENTANA
        $contenidoHTML=str_replace('.jpg"','.jpg" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.jpeg"','.jpeg" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.png"','.png" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.gif"','.gif" style="max-width: 112%"',$contenidoHTML);

        $contenidoHTML=str_replace('.JPG"','.JPG" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.JPEG"','.JPEG" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.PNG"','.PNG" style="max-width: 112%"',$contenidoHTML);
        $contenidoHTML=str_replace('.GIF"','.GIF" style="max-width: 112%"',$contenidoHTML);

        echo '<div id=myDiv>';
        echo '<div class="previa">'.$contenidoHTML.'</div>'; 
        echo '</div>';

?> 

        <!-- BOTON PARA VOLVER A MODO EDICION -->
        <a id="verBoton2" href="aspecto.php" title="Muestra la nota en modo edición"><img src="img/ojo.png" width="40px"></a>

        <a id="verBoton3" href="apdf.php" title="Descargar en formato PDF"><img src="img/pdf.png" height="30px"></a>
        <?php if ($_SESSION["movilZ"]==1 or $_SESSION["movilZ"]==-1){ ?>
        <!-- BOTON DE COMPARTIR -->
        <!-- <a href="#" id="shareButton" title="Compartir nota"><img src="img/compartir.png" width="30px"></a> -->
        <?php } else { ?> 

        <a id="verBoton3" href="apdf.php" title="Descargar en formato PDF"><img src="img/pdf.png" height="30px"></a>
            <!-- <a id="verBoton9" href="descargasolo.php" title="Descargar nota"><img src="img/descargar.png" height="30px"></a> -->
            <a id="verBoton7" href="#" onclick="sendWindowInfo()" title="Guarda posición y tamaño de la ventana"><img src="img/coordenadas.png" width="30px"></a>
            <?php } ?>
      
    <?php } ?>
        
        <!-- DESDE AQUI SE GESTIONA EL GUARDADO DE LAS MODIFICACIONES EN LA NOTA -->
        <input type="hidden" name="nombreArchivoMarkdown" value="<?php echo $nombreArchivoMarkdown; ?>">
    </form>

    <?php     
    $tempo=explode(".",$_SESSION["nombreArchivoMarkdown"]);
    $filename = $tempo[0].".ubi";

    ?>
</div>

<!-- SUBE A upload EL ARCHIVO ARRASTRADO, LO AÑADE A LA NOTA Y LA GUARDA -->
<script>
function handleFile(event) {
    event.preventDefault();
    const file = event.dataTransfer ? event.dataTransfer.files[0] : event.target.files[0];
    const formData = new FormData();
    formData.append('file', file);

    // Generar un número aleatorio de 5 cifras
    const numero_aleatorio = Math.floor(Math.random() * 90000) + 10000;

    // Construir la URL con el número aleatorio como parámetro GET
    const url = `upload.php?random_number=${numero_aleatorio}`;

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        const markdownLink = document.getElementById('editordata');
        const fileNameWithoutSpaces = file.name.replace(/\s+/g, '_'); // Eliminar espacios en el nombre del archivo
        const filePath = '<?php echo $_SESSION["usuarioZ"]."/"; ?>upload/';
        const fileExtension = fileNameWithoutSpaces.split('.').pop().toLowerCase();
        let newLink;

        // Verificar si el archivo es una imagen
        if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
            newLink = `![${numero_aleatorio}${fileNameWithoutSpaces}](${filePath}${numero_aleatorio}${fileNameWithoutSpaces})\n`; // Si es una imagen, agregamos el signo de exclamación !
        } else {
            newLink = `[${numero_aleatorio}${fileNameWithoutSpaces}](${filePath}${numero_aleatorio}${fileNameWithoutSpaces})\n`; // Si no es una imagen, agregamos solo los corchetes []
        }

        // Insertar el nuevo enlace en la posición del cursor
        const startPos = markdownLink.selectionStart;
        const endPos = markdownLink.selectionEnd;
        const textBefore = markdownLink.value.substring(0, startPos);
        const textAfter = markdownLink.value.substring(endPos, markdownLink.value.length);

        markdownLink.value = textBefore + newLink + textAfter;
        markdownLink.selectionStart = markdownLink.selectionEnd = startPos + newLink.length;

        guardarCambios(event); // Guarda los cambios después de agregar el enlace al archivo
    })
    .catch(error => console.error('Error:', error));
}

// Función para agregar ceros a la izquierda si el número es menor que 10
function pad(number) {
    if (number < 10) {
        return '0' + number;
    }
    return '' + number; // Convertimos el número en cadena para asegurar que siempre tenga dos dígitos
}
</script>


<!-- COMPARTE NOTA EN EDICION EN FORMATO TXT. COMPARTE LO QUE HAYA EN myDiv -->
<script>
document.getElementById('shareButton').addEventListener('click', async () => {
  const divContent = document.getElementById('myDiv').textContent;
  try {
    await navigator.share({
      title: '<?php echo $titul; ?>',
      text: divContent,
    });
  } catch(error) {
    console.error('Error compartiendo contenido:', error);
  }
});

</script>

<!-- COMPARTE NOTA PREVISUALIZADA EN FORMATO PDF -->
 <script>
document.getElementById('shareBtn').addEventListener('click', async () => {
    const pdfUrl = $_SESSION["mipdf"];  

    try {
        if (navigator.share) {
            await navigator.share({
                title: 'Mi archivo PDF',
                text: 'Aquí tienes un archivo PDF que quiero compartir contigo.',
                url: pdfUrl
            });
            console.log('Archivo compartido exitosamente');
        } else {
            alert('La funcionalidad de compartir no está disponible en este navegador.');
        }
    } catch (error) {
        console.error('Error al compartir:', error);
    }
});

</script>

<script>
        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }
</script>

<!-- GUARDA CAMBIOS EN LA NOTA AL CERRAR LA VENTANA -->
<script>
        // window.addEventListener('unload', function (event) {
        //     guardarCambios();
        // });

        // window.addEventListener('beforeunload', function (e) {
        //     navigator.sendBeacon('desbloquea.php');
        // });

// BLOQUEO DE NOTA.
        let isPageReloading = false;

        // Detectar el recargo de la página
        window.addEventListener('beforeunload', function (e) {
            if (!isPageReloading) {
                navigator.sendBeacon('desbloquea.php');
            }
        });

        // Marcar cuando la página se está recargando
        window.addEventListener('unload', function (e) {
            isPageReloading = true;
        });

        // Detectar el evento de recargar
        window.addEventListener('load', function (e) {
            isPageReloading = false;
        });

</script>




<!-- AJUSTA EL TEXTAREA A LA VENTANA -->
<script>
        function ajustarTextarea() {
            const textarea = document.getElementById('editordata');
            const windowHeight = window.innerHeight;
            textarea.style.height = (windowHeight - 90) + 'px';
        }

        // Ajustar tamaño inicialmente y cuando se cambia el tamaño de la ventana
        window.onload = ajustarTextarea;
        window.onresize = ajustarTextarea;
    </script>


<!-- GESTIONA LA ESCRITURA DE EMOJIS EN LA NOTA -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModal");
    const span = document.getElementsByClassName("close")[0];
    const textarea = document.getElementById("editordata");
    const emojis = document.querySelectorAll('.emoji');

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    emojis.forEach(emoji => {
        emoji.addEventListener('click', () => {
            insertAtCursor(textarea, emoji.textContent);
            modal.style.display = "none";
        });
    });

    function insertAtCursor(textarea, text) {
        const startPos = textarea.selectionStart;
        const endPos = textarea.selectionEnd;
        const beforeValue = textarea.value.substring(0, startPos);
        const afterValue = textarea.value.substring(endPos, textarea.value.length);

        textarea.value = beforeValue + text + afterValue;
        textarea.selectionStart = startPos + text.length;
        textarea.selectionEnd = startPos + text.length;
        textarea.focus();

        guardarCambios(event);

    }
});
</script>


<!-- SI HAY VARIAS INSTANCIAS DE UNA MISMA NOTA ABIERTAS LAS MANTIENE TODAS ACTUALIZADAS -->
<script>
    let intervalId = null;
    let syncEnabled = false; // Variable para controlar el estado de sincronización

    async function fetchFileContent(url) {
      try {
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.text();
      } catch (error) {
        console.error('Fetch error:', error);
        return null;
      }
    }

    function normalizeContent(content) {
      return content.replace(/\s+/g, '').trim();
    }

    function compareContent(textareaContent, fileContent) {
      return normalizeContent(textareaContent) === normalizeContent(fileContent);
    }

    async function checkContent() {
      const textarea = document.getElementById('editordata');
      const fileContent = await fetchFileContent('<?php echo base64_decode($_GET["mtk"]); ?>'); // Replace with the actual file path

      if (fileContent !== null && !compareContent(textarea.value, fileContent)) {
        const cursorPosition = textarea.selectionStart; // Get the cursor position
        textarea.value = fileContent; // Update the textarea with the file content if they are different
        textarea.setSelectionRange(cursorPosition, cursorPosition); // Set the cursor position back
      }
    }

    
    // setInterval(checkContent, 3000);
    // setInterval(checkContent, <?php echo $_SESSION["sincrosino"]; ?>);
    
  </script>

