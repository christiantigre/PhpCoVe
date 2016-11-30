<?php

session_start();
$con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
require('../fpdf/fpdf.php');
$numcre = $_GET['datashowfilepaginastart'];
$numsec = $_GET['datashowfilepaginaend'];

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
$pdf->Cell(100, 8, 'COMPROBANTE DE PAGO', 0);
$pdf->Ln(22);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);



$querytransac = "SELECT * FROM tran_cab where idtran_cab = '" . $numcre . "' ";
$restrs = mysqli_query($con, $querytransac);
while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
    $idtran_cab = $datomarca['idtran_cab'];
    $tran_cab_fecha = $datomarca['tran_cab_fecha'];
    $tran_cab_tipo = $datomarca['tran_cab_tipo'];
    $tran_veh_placas = $datomarca['tran_veh_placas'];
    $tran_cli_ident = $datomarca['tran_cli_ident'];
    $tran_cab_precio = $datomarca['tran_cab_precio'];
    $tran_cab_seguro = $datomarca['tran_cab_seguro'];
    $tran_cab_gastos = $datomarca['tran_cab_gastos'];
}

$queryveh = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.idtran_cab='" . $numcre . "'";
$resveh = mysqli_query($con, $queryveh);
while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
    $tran_veh_placas = $datomarca['idveh_placa'];
    $veh_marca = $datomarca['veh_marca'];
    $veh_modelo = $datomarca['veh_modelo'];
    $veh_tipo_des = $datomarca['veh_tipo_des'];
    $veh_anio = $datomarca['veh_anio'];
    $veh_motor = $datomarca['veh_motor'];
    $veh_chasis = $datomarca['veh_chasis'];
    $veh_km = $datomarca['veh_km'];
    $veh_color1 = $datomarca['veh_color1'];
    $veh_color2 = $datomarca['veh_color2'];
    $veh_mat_lugar = $datomarca['mat_lugar'];
    $veh_mat_anio = $datomarca['veh_mat_anio'];
    $veh_estado = $datomarca['veh_estado'];
}

$querycli = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident and tran_cab.idtran_cab='" . $numcre . "'";
$rescli = mysqli_query($con, $querycli);
while ($datomarca = mysqli_fetch_array($rescli, MYSQLI_BOTH)) {
    $idcli_ident = $datomarca['idcli_ident'];
    $cli_nombre = $datomarca['cli_nombre'];
    $cli_apellido = $datomarca['cli_apellido'];
    $cli_dir_casa = $datomarca['cli_dir_casa'];
    $cli_dir_tra = $datomarca['cli_dir_tra'];
    $cli_tel_fijos = $datomarca['cli_tel_fijos'];
    $cli_tel_cel = $datomarca['cli_tel_cel'];
    $cli_correo = $datomarca['cli_correo'];
    $cli_ciudad = $datomarca['cli_ciudad'];
    $cli_nom_ref = $datomarca['cli_nom_ref'];
    $cli_dir_ref = $datomarca['cli_dir_ref'];
    $cli_tel_ref = $datomarca['cli_tel_ref'];
    $cli_est_civ = $datomarca['cli_est_civ'];
    $cli_conyuge = $datomarca['cli_conyuge'];
}

$querycred ="SELECT * FROM `tran_cre` where idtran_cre_cab='".$numcre."' and tran_cre_sec='".$numsec."'";
$rescred = mysqli_query($con, $querycred);
while ($datocred = mysqli_fetch_array($rescred, MYSQLI_BOTH)) {
    $tran_cre_cab_id = $datocred['idtran_cre_cab'];
    $tran_cre_sec   = $datocred['tran_cre_sec'];
    $tran_cre_fecha_venc= $datocred['tran_cre_fecha_venc'];
    $tran_cre_fecha_pago= $datocred['tran_cre_fecha_pago'];
    $tran_cre_cuota= $datocred['tran_cre_cuota'];
    $tran_cre_interes= $datocred['tran_cre_interes'];
    $tran_cre_monto= $datocred['tran_cre_monto'];
    $tran_cre_sal= $datocred['tran_cre_sal'];
    $tran_cre_estado= $datocred['tran_cre_estado'];
}

$querycont = "SELECT COUNT(idtran_cre_cab) as cont FROM `tran_cre` WHERE idtran_cre_cab='".$numcre."'";
$rescont = mysqli_query($con, $querycont);
while ($datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH)) {
    $cuotas = $datocont['cont'];
}

// Datos Cliente
$pdf->SetFont('Arial', 'B', 12);
$top_datos = 45;
$pdf->SetXY(20, $top_datos);
$pdf->Cell(190, 10, "Cliente:", 0, 2, "J");
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(170, //posición X
        5, //posición Y
        "\n" .
        "Cliente  : " . $cli_nombre . ' ' . $cli_apellido . "\n" .
        utf8_decode("Teléfono : ") . $cli_tel_fijos . ' / ' . $cli_tel_cel . "\n" .
        "Correo   : " . $cli_correo . "\n" .
        utf8_decode("Direción   : " . $cli_dir_casa), 0, "J", // texto justificado
        false);


//Datos del vehiculo
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(125, $top_datos);
$pdf->Cell(190, 10, "Vehiculo:", 0, 2, "J");
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(
        45, //posición X
        5, //posicion Y
        utf8_decode("Placa : " . $tran_veh_placas) . "\n" .
        "Modelo: " . $veh_modelo . "\n" .
        utf8_decode("Año   : " . $veh_anio) . "\n" .
        "Color : " . $veh_color1 . "\n" .
        "Tipo  : " . $veh_tipo_des, 0, // bordes 0 = no | 1 = si
        "J", // texto justificado
        false);


//DETALLE DE PAGO
$top_detall= 85;
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(50, $top_detall);
$pdf->Cell(10, 10, "Detalle :", 0, 2, "J");
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(
        190, //posición X
        5, //posicion Y
        utf8_decode("Fecha de vencimiento  : " . $tran_cre_fecha_venc) . "\n" .
        "Fecha de pago : " . $tran_cre_fecha_pago. "\n" .
        "Cuota N#   : " . $tran_cre_sec. ' de ' . $cuotas . "\n" .
        "Monto : " . $tran_cre_monto . "\n" .
        "Interes : " . $tran_cre_interes . "\n" .
        "Valor : " . $tran_cre_cuota, 0, // bordes 0 = no | 1 = si
        "J", // texto justificado
        false);




$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, 'VLADIMIR ENDERICA', '', 1, 'L');
$pdf->Cell(250, 5, 'AUTOMOTORES ', '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>