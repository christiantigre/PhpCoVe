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
$secu_trs = $sec_trs;
$num_sec = strlen($secu_trs);
switch ($num_sec) {
    case 1:
        $secu_trs = '000'.$secu_trs;
        break;
    case 2:
        $secu_trs = '00'.$secu_trs;
        break;
    case 3:
        $secu_trs = '00'.$secu_trs;
        break;
    default:
        break;
}
$fecha_trs = $fecha_t;
$idveh_placa = $placa;
$idcli_ident = $cliente;
$precio_trs = $precio;
$seguro_trs = $seguro;
$gastos_trs = $gastos;
$costo = $valor;

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
$km_trs = $km;

include_once '../../class/trandetalle.php';
$objdetalle = new Trandetalle();
$objdetalle->imprimir_det($idtran_cab);
$resdet = $detalle;

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
$ciudad_prt = 'CUENCA';
$dia = date("j", strtotime($fecha_trs));
$mes = date("n", strtotime($fecha_trs));
include_once '../../class/calendario.php';
$objcal = new Calendario();
$mes = $objcal->mes_act($mes);
$anio = date('Y');
$ansec = '00'.date('y');

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(20, 15, 10);
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);
$pdf->cell(0, 5, 'INGRESO #: '.$ansec.$secu_trs, 0, 1, 'R');
$pdf->Ln(20);
$pdf->SetFont('','BU');
$pdf->Cell(0,10,'INGRESO DE VEHICULO',0,1,'C');
$pdf->SetFont('', 'B', 9);
$pdf->Cell(30, 5, \utf8_decode('VEHICULO A INGRESAR'), 0, 1, 'L');
$pdf->Rect(20, 55, 180, 20);
$pdf->Cell(20, 5, \utf8_decode('MARCA:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(45, 5, \utf8_decode($marca_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('COLOR:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(40, 5, \utf8_decode($color_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('CHASIS:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(40, 5, \utf8_decode($chasis_trs), 0, 1, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('MODELO:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(45, 5, \utf8_decode($modelo_trs), 0, 0, 'L');
$pdf->Cell(30, 5, \utf8_decode(''), 0, 0, 'L');
$pdf->Cell(30, 5, \utf8_decode(''), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('MOTOR:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(40, 5, \utf8_decode($motor_trs), 0, 1, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(32, 5, \utf8_decode('MATRICULADO EN:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(33, 5, \utf8_decode($mat_en_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('POR EL AÑO:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 5, \utf8_decode($mat_anio_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('TIPO:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(40, 5, \utf8_decode($tipo_trs), 0, 1, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(35, 5, \utf8_decode('KILOMETRAJE:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 5, \utf8_decode($km_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('AÑO:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 5, \utf8_decode($anio_trs), 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('PLACAS:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(40, 5, \utf8_decode($placa_trs), 0, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('', 'B');
$pdf->Cell(0, 5, 'DATOS DEL COMITENTE', 0, 1, 'L');
$pdf->Rect(20, 85, 180, 105);
$pdf->Write(5, \utf8_decode('Lugar y fecha: CUENCA, '.$dia.' DE '.$mes.' DE '.$anio.''));
$pdf->Ln(10);
$pdf->SetFont('', 'BU');
$pdf->Cell(0, 5, \utf8_decode('Datos del Comitente'), 0, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('', 'B');
$pdf->Cell(15, 5, \utf8_decode('Nombre:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(95, 5, $comitente, 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(12, 5, \utf8_decode('Cédula:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(20, 5, $ced_comt, 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(12, 5, \utf8_decode('Ciudad:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->MultiCell(25, 5, $ciudad_trs, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(25, 5, \utf8_decode('Dirección Casa:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->MultiCell(160, 5, $dire_casa_trs, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('Dirección Oficina:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->MultiCell(160, 5, $dire_tra_trs, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(20, 5, \utf8_decode('Teléfonos:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(15, 5, $tel_fijos_trs.' - '.$tel_cel_trs, 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('', 'BU');
$pdf->Cell(0, 5, \utf8_decode('Referencia'), 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('Nombre:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 5, $referencia_trs, 0, 1, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('Teléfonos:'), 0, 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 5, $tel_ref_trs, 0, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('', 'B');
$pdf->MultiCell(180, 5, \utf8_decode('El Sr. '.$comisionista.', en concepto de garantia por el vehiculo '
        . 'ingresado entrega al comitente el valor de $ '.number_format($costo, 2).' (DOLARES AMERICANOS), acordado.  El valor '
        . 'definitivo y la comisión de la liquidación se realizará una vez efectuada la transacción '
        . 'de la venta.'),1, 'J');
$pdf->Ln(5);
$pdf->SetFont('', 'BU'); 
$pdf->Cell(0, 5, \utf8_decode('Forma de Liquidación'), 0, 1, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 5, \utf8_decode('Valor vehículo:'), 0, 0, 'L');
$pdf->Cell(30, 5, number_format($precio_trs, 2), 0, 1, 'R');
$pdf->Cell(30, 5, \utf8_decode('Seguro:'), 0, 0, 'L');
$pdf->Cell(30, 5, number_format($seguro_trs, 2), 0, 1, 'R');
$pdf->Cell(30, 5, \utf8_decode('Total:'), 0, 0, 'L');
$pdf->Cell(30, 5, number_format($gastos_trs, 2), 0, 1, 'R');
$pdf->Ln(4);
$pdf->SetFont('', 'BU');
$pdf->Cell(70, 5, 'FORMA DE PAGO', 0, 1, 'L');
$pdf->SetFont('', 'U');
//    $pdf->Cell(20, 4, ('PAGO'), 1, 0, 'C');
    $pdf->Cell(30, 4, ('PAGO'), 0, 0, 'L');
    $pdf->Cell(25, 4, ('DOCUMENTO'), 0, 0, 'L');
    $pdf->Cell(25, 4, ('VALOR'), 0, 0, 'R');
    $pdf->Cell(20, 4, ('FECHA'), 0, 0, 'C');
//    $pdf->Cell(10, 4, ('%'), 1, 0, 'C');
//    $pdf->Cell(15, 4, ('PLAZO'), 1, 0, 'C');
    $pdf->Cell(55, 4, ('OBSERVACION'), 0, 1, 'R'); 
    $pdf->ln(2);    
while ($row = mysqli_fetch_array($resdet)) {
    $pdf->SetFont('Times', '', 9);
//    $pdf->Cell(40, 4, ($row[1]), 0, 0, '');
    $pdf->Cell(35, 4, ($row[2]), 0, 0, '');
    $pdf->Cell(25, 4, ($row[3]), 0, 0, '');
    $pdf->Cell(20, 4, number_format(($row[4]), 2), 0, 0, 'R');
    $pdf->Cell(20, 4, ($row[5]), 0, 0, 'R');
//    $pdf->Cell(10, 4, ($row[6]), 1, 0, 'R');
//    $pdf->Cell(15, 4, ($row[7]), 1, 0, 'R');
    $pdf->Cell(55, 4, ($row[9]), 0, 1, 'R');
}
$pdf->Cell(0, 5, '', 0, 1, '');
$pdf->SetFont('', 'B', 10);
//$pdf->Write(5, 'Total');
$pdf->Ln(30);
$pdf->Cell(0, 5, \utf8_decode(''.$comitente.''), 0, 1, 'C');
$pdf->Output();