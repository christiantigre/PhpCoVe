<?php
date_default_timezone_set("America/Guayaquil");
//setlocale(LC_MONETARY, 'en_US');

$idtran_cab = $_GET['numtrs'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//    $this->SetMargins(20, 80);
    $this->SetFont('Arial','BU',10);//15
//    $this->Cell(0, 10, 'ORDEN DE VENTA', 0, 1, 'C');
//    $this->Ln(10);
}
function Footer(){
//    $this->fecha = date("d-m-Y");    
    $this->SetY(-1);
    $this->SetFont('Arial','I',2);//8
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$costo1 = $valor;
$costo2 = $costo1;


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
//
$c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
$consulta = "SELECT SUM(tran_cre_interes) as intereses FROM `tran_cre` WHERE idtran_cre_cab='".$idtran_cab."'";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $intereses = $row['intereses'];
    }
}

while ($rowdet = mysqli_fetch_array($resdet)) {
    if(($rowdet[1])=='CREDITO'){
        $valinteres = (($rowdet[4])*(($rowdet[6])/100))*(($rowdet[7])/30);
        $meses = (($rowdet[7])/30);
    }elseif(($rowdet[1])=='ADICIONAL'){
        $valinteres = $intereses;
    }else{
        $valinteres = 0;
        $meses = 0;
    }
}

include_once '../../class/trandetalle.php';
$objdetalle = new Trandetalle();
$objdetalle->imprimir_det($idtran_cab);
$resdet_1 = $detalle;

//$row = mysqli_fetch_array($resdet);
//$valor_trs = $row['tran_det_monto'];

include_once '../../class/trancredito.php';
$objcredito = new Trancredito();
$objcredito->imprimir_cred($idtran_cab);
$rescred = $credito;

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
$ciudad_prt = 'Cuenca';
$dia = date("d", strtotime($fecha_trs));
$mes = date("n", strtotime($fecha_trs));
include_once '../../class/calendario.php';
$objcal = new Calendario();
$mes = $objcal->mes_act($mes);
$anio = date('Y');
$ansec = '00'.date('y');

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetMargins(20, 5, 5);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);//10
$pdf->cell(0, 5, 'EGRESO #: '.$ansec.$secu_trs, 0, 1, 'R');
//$pdf->cell(0, 5, $ansec.$secu_trs, 0, 1, 'R');
$pdf->Ln(20);//20
$pdf->SetFont('Arial','BU', 10);//10
$pdf->Cell(0,10,\utf8_decode('EGRESO DE VEHÍCULO'),0,1,'C');
$pdf->SetFont('Times', 'B', 8);//10
$pdf->Cell(30, 5, \utf8_decode('VEHICULO QUE EGRESA'), 0, 1, 'L');
$pdf->Rect(20, 45, 180, 20);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('MARCA'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(45, 5, \utf8_decode($marca_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('COLOR'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(40, 5, \utf8_decode($color_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('CHASIS'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(40, 5, \utf8_decode($chasis_trs), 0, 1, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('MODELO'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(45, 5, \utf8_decode($modelo_trs), 0, 0, 'L');
$pdf->Cell(30, 5, \utf8_decode(''), 0, 0, 'L');
$pdf->Cell(30, 5, \utf8_decode(''), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('MOTOR'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(40, 5, \utf8_decode($motor_trs), 0, 1, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(32, 5, \utf8_decode('MATRICULADO EN'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(33, 5, \utf8_decode($mat_en_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(30, 5, \utf8_decode('POR EL AÑO'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(30, 5, \utf8_decode($mat_anio_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('TIPO'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(40, 5, \utf8_decode($tipo_trs), 0, 1, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(35, 5, \utf8_decode('KILOMETRAJE'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(30, 5, \utf8_decode($km_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(30, 5, \utf8_decode('AÑO'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(30, 5, \utf8_decode($anio_trs), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(20, 5, \utf8_decode('PLACAS'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(40, 5, \utf8_decode($placa_trs), 0, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'DETALLES DE LA TRANSACCION', 0, 1, 'C');
$pdf->Rect(20, 75, 180, 49);
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(5, \utf8_decode('Lugar y fecha: CUENCA, '.$dia.' DE '.$mes.' DE '.$anio.''));
$pdf->Ln(5);
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(0, 5, \utf8_decode('Datos del Comitente'), 0, 1, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(15, 5, \utf8_decode('Nombre:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(95, 5, \utf8_decode($comitente), 0, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(13, 5, \utf8_decode('Cédula: '), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(20, 5, $ced_comt, 0, 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(13, 5, 'Ciudad: ', 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->MultiCell(25, 5, \utf8_decode($ciudad_prt), 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(25, 5, \utf8_decode('Dirección Casa:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->MultiCell(160, 5, \utf8_decode($dire_casa_trs), 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30, 5, \utf8_decode('Dirección Oficina:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->MultiCell(160, 5, \utf8_decode($dire_tra_trs), 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(20, 5, \utf8_decode('Teléfonos:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(15, 5, $tel_fijos_trs.' - '.$tel_cel_trs, 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(0, 5, \utf8_decode('Referencia'), 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30, 5, \utf8_decode('Nombre:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(30, 5, \utf8_decode($referencia_trs), 0, 1, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30, 5, \utf8_decode('Teléfonos:'), 0, 0, 'L');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(30, 5, $tel_ref_trs, 0, 1, 'L');
//$pdf->Ln(5);
$pdf->MultiCell(180, 5, \utf8_decode('El Sr(a). '.$comitente.' acuerda la siguiente forma de pago por la compra '
        . 'del vehículo antes detallado por el valor de $ '.number_format(($costo1+$valinteres), 2).' (DOLARES AMERICANOS). Desglosado de la siguiente manera:'),1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Times', 'BU', 9);
$pdf->Cell(30, 5, \utf8_decode('Precio de vehículo:'), 0, 0, 'C');
$pdf->SetFont('Times', '', 9);
$pdf->Cell(30, 5, \utf8_decode('Valor vehículo'), 0, 0, 'R');
$pdf->Cell(30, 5, \utf8_decode('Seguro'), 0, 0, 'R');
$pdf->Cell(30,5 , \utf8_decode('Gastos'), 0, 0, 'R');
$pdf->Cell(30, 5, \utf8_decode('Total'), 0, 1, 'R');
$pdf->Cell(30, 5, '', 0, 0, 'C');
$pdf->Cell(30, 5, number_format($precio_trs, 2), 0, 0, 'R');
$pdf->Cell(30, 5, number_format($seguro_trs, 2), 0, 0, 'R');
$gastos_trs = $valinteres;
$pdf->Cell(30, 5, number_format($gastos_trs, 2), 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$costo1 = $costo1 + $valinteres;
$pdf->Cell(30, 5, number_format($costo1, 2), 0, 1, 'R');
$pdf->Cell(0, 0, '_____________________________________________________________________________________________________', 0, 1,'C');
$pdf->ln(5);
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(30, 5, \utf8_decode('Forma de Pago:'), 0, 1, 'L');
while ($rowdet_1 = mysqli_fetch_array($resdet_1)) {
    $pdf->SetFont('Times', '', 9);
    if(($rowdet_1[1])=='CREDITO'){
        $pdf->Cell(30, 5, '', 0, 0, 'C');
        $pdf->Cell(30, 5, ($rowdet_1[1]), 0, 0, 'R');
        
        $pdf->Cell(30, 5, number_format((($rowdet_1[4])+$valinteres), 2), 0, 0, 'R');
//        $valinteres = (($rowdet1[4])*(($rowdet1[6])/100))*(($rowdet1[7])/30);
//        $meses = (($rowdet1[7])/30);
        $pdf->Cell(20, 5, 'Plazo ' . $meses . ' meses', 0, 1, 'L');
    }else{
        $pdf->Cell(30, 5, '', 0, 0, 'C');
        if(($rowdet_1[2])=='VEHICULO'){
            $forma = ($rowdet_1[2]);
        }else{
            $forma = ($rowdet_1[1]);
        }
        $pdf->Cell(30, 5, $forma, 0, 0, 'R');
        $pdf->Cell(30, 5, number_format($rowdet_1[4], 2), 0, 1, 'R');
    }
}
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30, 5, '', 0, 0, 'C');
$pdf->Cell(30, 5, 'TOTAL', 0, 0, 'R');
//$pdf->SetFont('Times', 'B', 10);
$costo2 = $costo2 + $valinteres;
$pdf->Cell(30, 5, number_format($costo2, 2), 0, 1, 'R');

$pdf->Cell(0, 0, '_____________________________________________________________________________________________________', 0, 1,'C');
$pdf->ln(5);

$pdf->SetFont('Times', 'BU', 10);//10
$pdf->Cell(0, 5, \utf8_decode('CREDITO'), 0, 1, 'L');
$pdf->SetFont('Times', 'U', 8);//10
$pdf->cell(35, 5, '', 0, 0 );
$pdf->cell(20, 4, 'CUOTA', 0, 0, 'R');
$pdf->cell(20, 4, 'VALOR', 0, 0, 'R');
$pdf->cell(38, 4, 'FECHA DE PAGO', 0, 1, 'R');
$pdf->SetFont('Arial', '', 7.5);
while ($rowcre = mysqli_fetch_array($rescred)) {
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(35, 4, '', 0, 0, '');
    if(substr($rowcre[1], 0, 2) == '99'){
        $dato = 'ADICIONAL';
    }else{
        $dato = $rowcre[1];
    }
    $pdf->Cell(20, 4, ($dato), 0, 0, 'R');
    $pdf->Cell(20, 4, number_format(($rowcre[4]), 2), 0, 0, 'R');
//    $pdf->Cell(20, 4, ($rowcre[3]), 0, 0, 'R');
    $pdf->Cell(30, 4, ($rowcre[2]), 0, 1, 'R');
//    $pdf->Cell(10, 4, ($row[6]), 1, 0, 'R');
//    $pdf->Cell(15, 4, ($row[7]), 1, 0, 'R');
//    switch ($rowcre[8]) {
//        case 0:
//            $valor = 'PENDIENTE';
//            break;
//        case 1:
//            $valor = 'PAGADO';
//            break;
//        default:
//            break;
//    }
//    $pdf->Cell(30, 4, ($valor), 0, 1, '');
}
$pdf->SetAutoPageBreak(1, 50);
$pdf->Ln(5);//5
$pdf->SetFont('Times', 'B', 8);
$pdf->MultiCell(180, 4, \utf8_decode('Yo, '.$comitente.', declaro recibir el vehículo cuyas características corresponden a las antes '
        . 'anotadas, con pleno conocimiento de causa y a entera satisfacción, es decir que lo adquiero en el estado en que '
        . 'se encuentra, por lo cual renuncio a cualquier reclamo posterior con relación a su estado mecánico a partir de la '
        . 'presente fecha.'), 1, 'J');
$pdf->ln(1);//5
$pdf->Write(5, \utf8_decode('Acepto el precio y las condiciones de pago antes descritas.'));
$pdf->Ln(17);//20-30
$pdf->SetFont('Times', 'B', 8);//10
$pdf->Cell(0, 2, \utf8_decode(''.$comitente.''), 10, 1, 'C');
//$pdf->AddPage();
$pdf->Output();
