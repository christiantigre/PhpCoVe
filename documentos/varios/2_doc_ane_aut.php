<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_POST['numtrs'];


require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//    $this->SetMargins(20, 50, 15);
//    $this->SetFont('Arial','BU',15);
//    $this->Ln(10);
}
function Footer(){
//    $this->fecha = date("d-m-Y");    
//    $this->SetY(-15);
//    $this->SetFont('Arial','I',8);
}
}

// Creación del objeto de la clase heredada
include_once '../../class/transacc.php';
$objtrs = new Transacc();
$objtrs->imprime_trans($idtran_cab);
//$tran_num = $numtra;
$fecha_trs = $fecha_t;
$idveh_placa = $placa;
$idcli_ident = $cliente;

include_once '../../class/vehiculo.php';
$objveh = new Vehiculo();
$objveh->imprime_veh($idveh_placa);
$marca_trs = $marca;
$modelo_trs = $modelo;
$anio_trs = $anio;
$color_trs = $color_1_2;
$tipo_trs = $tipo;
$mat_en_trs = $mat_en;
$mat_anio_trs = $mat_anio;
$placa_trs = $placa; 
$motor_trs = $motor;
$chasis_trs = $chasis;

include_once '../../class/cliente.php';
$objcli = new Cliente();
$objcli->imprime_cli($idcli_ident);
$cliente_trs = $ident;
$nombre_trs = $nombre;
$apellido_trs = $apellido;
$dire_casa_trs = $dire_casa; 
$dire_tra_trs = $dire_tra;
$tel_fijos_trs = $tel_fijo;
$tel_cel_trs = $tel_cel;
$correo_trs = $correo;
$ciudad_trs = $ciudad;
$referencia_trs = $referencia;
$dir_refe = $dir_refe;
$tel_ref_trs = $tel_ref;
$est_civil_trs = $est_civil;
$conyuge_trs = $conyuge;

$benef_p = $_POST['benef'];

$comitente = $nombre_trs.' '.$apellido_trs;
$comisionista = 'VLADIMIR FERNANDO ENDERICA IZQUIERDO';
$ced_comt = $cliente_trs;
$ced_coms = '0102610094';
$dia = date("d", strtotime($fecha_trs));
$mes = date("n", strtotime($fecha_trs));
include_once '../../class/calendario.php';
$objcal = new Calendario();
$mes = $objcal->mes_act($mes);
$anio = date("Y", strtotime($fecha_trs)); 

$pdf = new PDF('P','mm','A4');
$pdf->SetMargins(20, 25, 10);
$pdf->AddPage();
$pdf->Ln(15);
$pdf->SetFont('Arial','BU', 15);
$pdf->Cell(0,10,'DOCUMENTO ANEXO DE AUTORIZACION',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Times', '', 10);
$pdf->Write(5, \utf8_decode('Yo, '.$comitente.', con cédula de ciudadania '.$ced_comt.' capaz ante la '
        . 'ley, en mi calidad de legitimo propietario del vehiculo de las siguientes características:'));
$pdf->Ln(8);
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->Cell(60, 5, $marca_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->Cell(60, 5, $modelo_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->Cell(60, 5, $anio_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('COLOR'), 1, 0, 'L');
$pdf->Cell(60, 5, $color_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->Cell(60, 5, $tipo_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->Cell(60, 5, $mat_en_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->Cell(60, 5, $mat_anio_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->Cell(60, 5, $placa_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->Cell(60, 5, $motor_trs, 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->Cell(60, 5, $chasis_trs, 1, 1, 'L');
$pdf->Ln(8);
$pdf->Write(5, \utf8_decode('Autorizo , al señor '.$comisionista.' de cédula '.$ced_coms.', en calidad '
        . 'de comisionista, a cobrar el monto producto de la venta del vehículo de mi propiedad anteriormente '
        . 'descrito y a girarlo, depositarlo o transferirlo a '.$benef_p.''));
$pdf->Ln(20);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 5, \utf8_decode(''.$comitente.''), 0, 1, 'C');
$pdf->Output();