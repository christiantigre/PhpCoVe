<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_GET['numtrs'];

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
$pdf->AliasNbPages();
$pdf->SetMargins(20, 25, 10);
$pdf->AddPage();
$pdf->Ln(15);
$pdf->SetFont('Arial','BU', 15);
$pdf->Cell(0,10,'DOCUMENTO ACLARATORIO',0,1,'C');
$pdf->SetFont('Times', '', 10);
$pdf->Write(4, \utf8_decode('En la ciudad de Cuenca a, '.$dia.' de '.$mes.' del '.$anio.', suscriben en el presente '
        . 'documento el Sr(a). '.$comitente.' con cédula de Ciudadanía número '.$ced_comt.', quien libre y '
        . 'voluntariamente DECLARA:'));
$pdf->Ln(10);
$pdf->Write(4, \utf8_decode('PRIMERA.- En la presente fecha, el interviniente adquiere del Señor '.$comisionista.' un '
        . 'vehículo que se detalla a continación:'));
$pdf->Ln(5);
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($marca_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($modelo_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($anio_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('COLOR'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($color_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($tipo_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($mat_en_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($mat_anio_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($placa_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($motor_trs), 1, 1, 'C');
$pdf->cell(25, 5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->Cell(60, 5, \utf8_decode($chasis_trs), 1, 1, 'C');
$pdf->Ln(5);
$pdf->Write(5, \utf8_decode('El adquiriente paga la totalidad del vehículo.'));
$pdf->Ln(5);
$pdf->Write(5, \utf8_decode('SEGUNDA.- El Señor '.$comitente.', declara que asume total responsabilidad por '
        . 'cualquier accidente, infracciones, multas y otra situación de orden judicial o extrajudicial que se '
        . 'suscitaren a partir de la presente fecha que el vehículo se encuentra en su poder y a fechas posteriores.'));
$pdf->Ln(10);
$pdf->Write(5, \utf8_decode('TERCERA.- Las partes aseguran estar de acuerdo en la negociación celebrada, así como en el estado '
        . 'actual del funcionamiento del vehículo anteriormente mencionado y que recibe luego de haberlo '
        . 'examinado mecánicamente a su entera satisfacción, renunciando por lo tanto a cualquier reclamo '
        . 'posterior, a partir de firmado el presente contrato.'));
$pdf->Ln(10);
$pdf->Write(5, \utf8_decode('CUARTA.- El Sr(a). '.$comitente.', recibe todos los documentos necesarios '
        . 'para la legalización del vehiculo adquirido'));
$pdf->Ln(10);
$pdf->Write(5, \utf8_decode('Para constancia de lo estipulado, firman las partes contratantes en Cuenca a, '.$dia.' de '.$mes.' de '.$anio.','));
$pdf->Ln(30);
$pdf->Cell(80, 5, \utf8_decode(''.$comitente.''), 0, 0, 'C');
$pdf->Cell(80, 5, \utf8_decode(''.$comisionista.''), 0, 1, 'C');
$pdf->Cell(80, 5, \utf8_decode('COMITENTE'), 0, 0, 'C');
$pdf->Cell(80, 5, \utf8_decode('COMISIONISTA'), 0, 1, 'C');
$pdf->Output();