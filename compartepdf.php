<?php
session_start();
include("identifica.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../tcpdf/tcpdf.php');

$kaki=explode(".",$_SESSION["nombreArchivoMarkdown"]);
$nombrepdf=$kaki[0].".pdf";
$_SESSION["mipdf"]=$nombrepdf;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetTitle($nombrepdf);
$pdf->AddPage();
$pdf->setFont('helvetica', '', $_SESSION["tamanotxt"]);
$pdf->writeHTML($_SESSION["contenidoHTML"], true, false, true, false, '');
// $pdf->Output($nombrepdf, 'D');
$pdf->Output($nombrepdf, 'I');

?>
<script>
window.history.back(-1);

// location.reload();
</script>
