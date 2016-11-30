<?php
date_default_timezone_set("America/Guayaquil");

$idtran_cab = $_GET['numtrs'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//    $this->SetMargins(20, 10, 15);
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
$costo = (float)$valor;

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

$comitente = $nombre_trs.' '.$apellido_trs;
//$comisionista = 'VLADIMIR FERNANDO ENDERICA IZQUIERDO';
$ced_comt = $cliente_trs;
//$ced_coms = '0102610094';
$ciudad_prt = 'Cuenca';
$dia = date("j", strtotime($fecha_trs));
$mes = date("n", strtotime($fecha_trs));
include_once '../../class/calendario.php';
$objcal = new Calendario();
$mes = $objcal->mes_act($mes);
$anio = date('Y');

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(20, 25, 20);
$pdf->AddPage();
$pdf->Ln(15);
$pdf->SetFont('Times','BU', 13);
$pdf->Cell(0,10,\utf8_decode('RECEPCION DE IMPRONTAS'),0,1,'C');
$pdf->SetFont('Times', 'B', 10);
$pdf->Ln(5);
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($marca_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($modelo_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($anio_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('COLOR'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($color_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($tipo_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($mat_en_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($mat_anio_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($placa_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($motor_trs), 1, 1, 'L');
$pdf->cell(20,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(80, 5, \utf8_decode($chasis_trs), 1, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Times','BU', 10);
$pdf->Cell(0,10,\utf8_decode('IMPRONTAS DEL VEHICULO'),0,1,'C');
$pdf->Ln(60);
$pdf->SetFont('Times','', 10);
$pdf->Write(5, \utf8_decode('El comprador acepta haber revisado las improntas del vehículo '
        . 'a entera satisfacción y comparado fisicamente con el motor y chasis del vehículo.'));
$pdf->Ln(30);
$pdf->SetFont('Times','B', 10);
$pdf->Cell(0, 5, \utf8_decode('COMPRADOR'), 0, 1, 'C');
//$pdf->Cell(0, 5, \utf8_decode(''.$comitente.''), 0, 1, 'C');
$pdf->Output();