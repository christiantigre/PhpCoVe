<?php

session_start();
$conn = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
$c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
require('../fpdf/fpdf.php');
$idhei = $_GET['idhei'];
$sqlmaxid = "SELECT MAX(`iddet_pag`) as id FROM `det_pag`";
$result = mysqli_query($conn, $sqlmaxid) or trigger_error("Query Failed! SQL: $sqlmaxid - Error: " . mysqli_error($conn), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ultimoingreso = $row['id'];
    }
}

$selecdatos = "SELECT * FROM `det_pag` WHERE `iddet_pag`='" . $idhei . "'";
$resultdatos = mysqli_query($conn, $selecdatos) or trigger_error("Query Failed! SQL: $selecdatos - Error: " . mysqli_error($conn), E_USER_ERROR);
if ($resultdatos) {
    while ($rowdata = mysqli_fetch_assoc($resultdatos)) {
        $id = $rowdata['iddet_pag'];
        $list_id = $rowdata['lis_pag_id_pag'];
        $cli_id = $rowdata['cli_datos_idcli_ident'];
        $veh_id = $rowdata['veh_datos_idveh_placa'];
        $fech_reg = $rowdata['fech_reg'];
        $mont = $rowdata['monto'];
        $iva = $rowdata['iva'];
        $subtotal = $rowdata['subtotal'];
        $tranrealiz = $rowdata['tran_realiz'];
        $user = $rowdata['user'];
        $observ = $rowdata['observ'];
        $clien = $rowdata['clien'];
    }
}

//$selectnompag = "select nom_pag from lis_pag where id_pag='" . $list_id . "'";
$selectnompag = "SELECT `nombre_cuenta_plan` as nom_pag FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='". $list_id ."'";
$resultnom_pag = mysqli_query($c, $selectnompag) or trigger_error("Query Failed! SQL: $selectnompag- Error: " . mysqli_error($c), E_USER_ERROR);
if ($resultnom_pag) {
    while ($rownom = mysqli_fetch_assoc($resultnom_pag)) {
        $nom_pag = $rownom['nom_pag'];
    }
}



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../images/logo_pag.png', 10, 3, 190, 20, 'png');
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, utf8_decode('Empresa :' . 'Automotores Vladimir Enderica' . '                    Dirección :' . 'n/n' . '                    Correo :' . 'mail@gmail.com'), '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . '0123456789001' . '                                                 Emitido :' . date("Y-m-d H:i") . '                                    Por :' . $_SESSION['user'], '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'COMPROBANTE', 0);
$pdf->Ln(22);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);



// Datos transaccion
$pdf->SetFont('Arial', 'B', 12);
$top_datos = 45;
$pdf->SetXY(20, $top_datos);
$pdf->Cell(190, 10, "Detalle de Pago", 0, 2, "J");
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(170, //posición X
        5, //posición Y
        "\n" .
        utf8_decode("Por concepto de :  ") . $nom_pag . "\n" .
        utf8_decode("Pago realizado por :  ") . $tranrealiz . "\n" .
        "Subtotal   :  " . $subtotal. "\n" .
        "Iva   :  " . $iva . "\n" .
        "Valor   :  " . $mont . "\n" .
        "Fecha de pago   :  " . $fech_reg . "\n" .
        utf8_decode("Observación   :  " . $observ), 0, "J", // texto justificado
        false);


//Datos del vehiculo
if ($veh_id != '') {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(125, $top_datos);
    $pdf->Cell(190, 10, "Vehiculo:", 0, 2, "J");
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(
            45, //posición X
            5, //posicion Y
            utf8_decode("Placa : " . $veh_id) . "\n" .
            "Pagado a : " . $cli_id, 0, // bordes 0 = no | 1 = si
            "J", // texto justificado
            false);
} else {
    echo '';
}



$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(8);

$pdf->Cell(250, 25, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 4, 'VLADIMIR ENDERICA', '', 1, 'L');
$pdf->Cell(250, 7, 'AUTOMOTORES ', '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>