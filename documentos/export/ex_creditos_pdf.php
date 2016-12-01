<?php
date_default_timezone_set("America/Guayaquil");
session_start();

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
    function Header(){
    $this->SetFont('Arial','BU',10);//15
}
function Footer(){
    $this->SetY(-1);
    $this->SetFont('Arial','I',2);//8
}
}
// Creación del objeto de la clase heredada

include_once '../../class/trandetalle.php';
$objdetalle = new Trandetalle();
$objdetalle->imprimir_det_credito();
$resdet_1 = $cred_det;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetMargins(20, 5, 5);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);//10
$cant = mysqli_num_rows($resdet_1);
$pdf->Cell(30, 5, $cant.' '.'CREDITOS GENERADOS', 0, 0, 'R');
$pdf->ln(8);        
$n=1;
while ($rowdet_1 = mysqli_fetch_array($resdet_1)) {
    $id_ref = $rowdet_1['id_ref'];
    include_once '../../class/trandetalle.php';
    $objdetalle = new Trandetalle();
    $objdetalle->ver_detalle($id_ref);
    $resdet_2 = $dtl;
    $mensaje='CREDITO # '.$n.' POR EL VALOR DE '. $rowdet_1['tran_det_monto'].' A '.$rowdet_1['tran_det_plazo'].' DIAS PLAZO CON INTERES DE '.$rowdet_1['tran_det_interes'].'%';
    $pdf->Cell(150, 5, $mensaje.' '.'CREDITOS GENERADOS', 0, 0, 'R');
    $pdf->ln(5);        
$pdf->Cell(20, 5, '#', 0, 0, 'R');
$pdf->Cell(20, 5, 'Fecha', 0, 0, 'R');
$pdf->Cell(20, 5, 'Valor cuota', 0, 0, 'R');
$pdf->Cell(20, 5, 'Interes', 0, 0, 'R');
$pdf->Cell(20, 5, 'Monto', 0, 0, 'R');
$pdf->ln(3);  
    while ($rowdet_2 = mysqli_fetch_array($resdet_2)) {
$pdf->SetFont('Arial', '', 8);//10
$pdf->Cell(20, 5, $rowdet_2[0], 0, 0, 'R');
$pdf->Cell(20, 5, $rowdet_2[1], 0, 0, 'R');
$pdf->Cell(20, 5, $rowdet_2[2], 0, 0, 'R');
$pdf->Cell(20, 5, $rowdet_2[3], 0, 0, 'R');
$pdf->Cell(20, 5, $rowdet_2[4], 0, 0, 'R');
$pdf->ln(3);  
}
    //$consulta = "SELECT * FROM prv_cre where id_ref='".$ref."' ";    
$pdf->ln(8);
$n++;      
}
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30, 5, '', 0, 0, 'C');


$pdf->SetAutoPageBreak(1, 50);
$pdf->Ln(5);//5
$pdf->Output();
