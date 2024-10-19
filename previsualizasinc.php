<?php
session_start();
include("identifica.php"); 
include("estilo.css"); 
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
date_default_timezone_set('Europe/Madrid');

if ($_SESSION["oscuro"]==-1) {include("modooscuro.php");} else {include("modoclaro.php");}

$titlo=explode("/",base64_decode($_GET["mtk"]));
$titul1=explode(".",$titlo[1]);
$titul=$titul1[0];
?>

<title><?php echo $titul; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta charset="utf-8">
<!-- <link rel="stylesheet" href="styles.css?v=1.1"> -->

<!-- TIPO DE LETRA DE GOOGLE FONTS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jacquard+24+Charted&family=Jersey+15&family=Jersey+20+Charted&family=Lora:ital,wght@0,400..700;1,400..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

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
  background-image: url('subida.png');
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


<?php
$nombreArchivoMarkdown = base64_decode($_GET["mtk"]);

// GUARDA AUTOMATICAMENTE EL CONTENIDO DEL EDITOR
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     if (isset($_POST['editornota'])) {
    //         $contenidoMarkdown = $_POST['editornota'];
    //         file_put_contents($nombreArchivoMarkdown, $contenidoMarkdown);
    //     }
    // }

// MOSTRAR CONTENIDO COMO MARKDOWN
require 'Parsedown.php'; 
if (file_exists($nombreArchivoMarkdown)) {
        $contenidoMarkdown = file_get_contents($nombreArchivoMarkdown);
        $parsedown = new Parsedown();
        $contenidoHTML = $parsedown->text(strip_tags($contenidoMarkdown));
    } else {
        $contenidoHTML = '';
    }
    $_SESSION["nombreArchivoMarkdown"]=$nombreArchivoMarkdown;
    $_SESSION["contenidoHTML"]=$contenidoHTML;
    ?>

<!-- CADA VEZ QUE TOCAS EN LA NOTA SE CARGA EL CONTENIDO POR SI EN OTRA INSTANCIA DE ESTA SE HAN HECHO CAMBIOS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Llama a cargarContenido() cuando el documento está listo
        cargarContenido();

        // Adjunta el evento input al textarea para guardar cambios
        $('#editordata').on('input', guardarCambios);

        // Adjunta el evento click al textarea para cargar contenido
        $('#editordata').on('click', cargarContenido);
    });

    function cargarContenido() {
        $.ajax({
            url: '<?php echo $nombreArchivoMarkdown; ?>', 
            dataType: 'text',
            success: function(data) {
                $('#editordata').val(data);
            }
        });
    }
</script>

<!-- GUARDA EL CONTENIDO DE LA NOTA -->
<script>
        function guardarCambios(event) {
            event.preventDefault(); // Evita el envío del formulario por defecto
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
        }

</script>

<script>
function verificarModificacionArchivo() {
    // Obtener la URL del archivo de cambios
    var urlArchivo = '<?php echo $nombreArchivoMarkdown; ?>';
    
    // Obtener la última fecha conocida de localStorage
    var ultimaFechaConocida = localStorage.getItem('ultimaFechaConocida');
    
    // Función para comprobar la modificación del archivo
    function comprobarModificacion() {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlArchivo); // Usamos HEAD en lugar de GET para obtener solo los encabezados de la respuesta

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var nuevaFecha = xhr.getResponseHeader('Last-Modified');
                    
                    // Si la fecha de última modificación es diferente de la fecha conocida previamente
                    if (nuevaFecha !== ultimaFechaConocida) {
                        // Actualizar la fecha conocida
                        ultimaFechaConocida = nuevaFecha;
                        localStorage.setItem('ultimaFechaConocida', nuevaFecha); // Guardar en localStorage
                        
                        // Actualizar la página
                        window.location.reload(true);
                    }
                }
            }
        };

        xhr.send();
    }

// Llamar a la función cada cierto tiempo para comprobar modificaciones
    // setInterval(comprobarModificacion, 3000);
}

// Llamar a la función cuando el documento esté listo
// document.addEventListener('DOMContentLoaded', verificarModificacionArchivo);



var temporizadorInactividad;

function iniciarTemporizador() {
    // Reiniciar el temporizador si ya está en marcha
    detenerTemporizador();

    // Iniciar el temporizador de inactividad
    temporizadorInactividad = setTimeout(function() {
        comprobarModificacion();
    }, 3000); // 5000 milisegundos = 5 segundos
}

function detenerTemporizador() {
    // Detener el temporizador si está en marcha
    if (temporizadorInactividad) {
        clearTimeout(temporizadorInactividad);
        temporizadorInactividad = null;
    }
}

document.getElementById('editordata').addEventListener('input', function() {
    iniciarTemporizador();
});

// Llamar a la función al cargar el documento para iniciar el temporizador
document.addEventListener('DOMContentLoaded', iniciarTemporizador);

</script>

<!-- MUESTRA FORMATO TEXTO O VISTA PREVIA MARKDOWN -->
    <form id="editorForm" action="guardar.php" method="POST" onsubmit="guardarCambios(event)">
    
    <!-- CAMBIO MODO EDICION A MODO LECTURA -->
    <?php if ($_SESSION["comoveo"]!=-1){ ?>
        
        <!-- MUESTRA LA NOTA EN MODO EDICION -->
        <!-- LO QUE CONTENGA myDiv ES LO QUE SE COMPARTE -->
        <div id=myDiv >
        
        <!-- SINCRONIZA -->
        <!-- <textarea id="editordata" class="oscuro" name="editornota" placeholder="Comienza a escribir..." cols="100%" onfocus="cargarContenido()" oninput="guardarCambios(event)" ><?php echo $contenidoMarkdown; ?></textarea> -->

        <!-- NO SINCRONIZA. SOLO GUARDA LO QUE ESCRIBES -->
        <textarea id="editordata" class="oscuro" name="editornota" placeholder="Comienza a escribir..." cols="100%" oninput="guardarCambios(event)" ><?php echo $contenidoMarkdown; ?></textarea>

        

        </div>

        <!-- BOTON PARA MOSTRAR NOTA EN MODO LECTURA -->
        <a id="verBoton2" href="aspecto.php" title="Muestra la nota en modo lectura"><img src="ver.png" width="40px"></a>

        <!-- BOTON DE COMPARTIR -->
        <a href="#" id="shareButton"><img src="compartir.png" width="30px"></a>

        <!-- PASAR A PDF -->
        <a id="verBoton3" href="apdf.php"><img src="pdf.png" height="30px"></a>

        <!-- GUARDAR POSICION Y TAMAÑO DE LA VENTANA -->
        <?php if ($_SESSION["movilZ"]==1 or $_SESSION["movilZ"]==-1){} else { ?>
        <a id="verBoton7" href="#" onclick="sendWindowInfo()" title="Guarda posición y tamaño de la ventana"><img src="coordenadas.png" width="30px"></a>
        <?php } ?>

        <!-- RECUADRO DE ARRASTRAR Y SOLTAR Y BOTON DE SUBIR -->
        <div id="drop-area" id="verBoton4" ondragover="allowDrop(event)" ondrop="drop(event)">
        <input type="file" id="file-input" onchange="handleFile(event)">

    <?php } else { ?> 

        <!-- MUESTRA LA NOTA EN MODO LECTURA -->
        <?php 
// AJUSTA IMAGENES AL ANCHO DE LA VENTANA
        $contenidoHTML=str_replace('.jpg"','.jpg" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.jpeg"','.jpeg" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.png"','.png" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.gif"','.gif" style="max-width: 100%"',$contenidoHTML);

        $contenidoHTML=str_replace('.JPG"','.JPG" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.JPEG"','.JPEG" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.PNG"','.PNG" style="max-width: 100%"',$contenidoHTML);
        $contenidoHTML=str_replace('.GIF"','.GIF" style="max-width: 100%"',$contenidoHTML);

        // $contenidoHTML=str_replace("\n","<br>",$contenidoHTML);

        echo '<span class="oscuro">'.$contenidoHTML.'</span>'; 
        // echo '<textarea width="100%"><span class="oscuro">'.$contenidoHTML.'</span></textarea>'; 

?> 

        <!-- BOTON PARA VOLVER A MODO EDICION -->
        <a id="verBoton2" href="aspecto.php" onclick="cargarContenido()" title="Muestra la nota en modo edición"><img src="ojo.png" width="40px"></a>
    <?php } ?>
        
        <!-- DESDE AQUI SE GESTIONA EL GUARDADO DE LAS MODIFICACIONES EN LA NOTA -->
        <input type="hidden" name="nombreArchivoMarkdown" value="<?php echo $nombreArchivoMarkdown; ?>">
    </form>

    <?php     
    $tempo=explode(".",$_SESSION["nombreArchivoMarkdown"]);
    $filename = $tempo[0].".ubi";

    ?>
</div>



<script>
// SUBE A upload EL ARCHIVO ARRASTRADO, LO AÑADE A LA NOTA Y LA GUARDA
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
        const existingText = markdownLink.value;
        
        // Obtener la hora actual
        const now = new Date();
        const hours = pad(now.getHours());
        const minutes = pad(now.getMinutes());
        const seconds = pad(now.getSeconds());

        // Formatear la hora en el formato deseado (HHMMSS)
        // const formattedTime = hours + minutes + seconds;

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

        markdownLink.value = existingText ? `${existingText}\n${newLink}` : newLink;
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

<!-- TAMAÑO DE LA NOTA DENTRO DE LA VENTANA -->
<script>
// Ajustar el tamaño del textarea al cargar la página
// window.addEventListener('DOMContentLoaded', function() {
//     ajustarTextarea();
// });

// Ajustar el tamaño del textarea cuando se redimensiona la ventana
// window.addEventListener('resize', function() {
//     ajustarTextarea();
// });

// Función para ajustar el tamaño del textarea
// function ajustarTextarea() {
//     var textarea = document.getElementById('#editordata');
//     textarea.style.height = (window.innerHeight - 100) + 'px';
// }
</script>

<!-- COMPARTE NOTA. COMPARTE LO QUE HAYA EN myDiv -->
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
