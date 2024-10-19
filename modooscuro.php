<?php
// session_start();
include("identifica.php");
$keike=file_get_contents($_SESSION["usuarioZ"]."/cambios.ubi");
$tamanotxt=explode(";",$keike);
$_SESSION["tamanotxt"]=$tamanotxt[2];
?>
<style>
body {
    background-color: #1f1f1f;
    color: #cacaca;
    font-size: 16px;
    line-height: 1.3em; 
    letter-spacing: 0.03em; 
}

.oscuro {
  background-color: #1f1f1f;
  color: #cacaca; 
  font-size: <?php echo $_SESSION["tamanotxt"]; ?>;
  }

  a:link {
    text-decoration: none;
  color: #cacaca;
  }
  a:visited {
    text-decoration: none;
  color: #cacaca;
  }
  a:hover {
    text-decoration: none;
  color: #cacaca;
  }
  a:active {
    text-decoration: none;
  color: #cacaca;
  }
  
  </style>
