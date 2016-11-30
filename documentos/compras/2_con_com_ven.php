<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_GET['numtrs'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//
//    $this->SetFont('Arial','BU',15);
//    $this->Ln(10);
}
function Footer(){
//    $this->fecha = date("d-m-Y");    
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$pdf->SetFont('Times','BU', 12);
$pdf->Ln(15);
$pdf->Cell(0, 10, 'CONSTANCIA DE INGRESO', 0, 1, 'C');
//$pdf->Ln(5);
$pdf->SetFont('', '', 9);
$pdf->Write(4, \utf8_decode('Entre los señores '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comisionista));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(', con cédula de ciudadanía '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($ced_coms));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(' por una parte y el Señor(a) '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comitente));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(', con cédula '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($ced_comt));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(' por otra, convienen celebrar el presente contrato contenido en las siguientes cláusulas:'));
$pdf->Ln(6);
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode('PRIMERA.- ANTECEDENTES:'));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(' Por los antecedentes expuestos el Sr(a). '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comitente));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(' otorga poder especial amplio, suficiente e irrevocable a '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comisionista));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(' con fecha para que pueda realizar los siguientes mandatos:'));
$pdf->Ln(6);
$pdf->SetFont('', '');
$pdf->MultiCell(170, 4, \utf8_decode('a) Comparecer a suscribir el contrato de compraventa, compraventa con reserva de dominio, reconocimiento de firma y otro '
        . 'documento que se requiera del vehículo con el comprador final del mismo; b) Recibir el valor de pago del precio del vehículo; c) Recibir anticipos o '
        . 'comprometer el precio en pagos futuros o a través de financiamiento; d) Recibir como parte de pago del precio del vehículo otro u otros vehiculos y '
        . 'comparecer a los actos o contratos que conlleven al perfeccionamiento de dichos actos: e) Realizar todos los trámites y diligencias necesarios ante las '
        . 'autoridades a fin de realizar el traspaso de dominio, matriculación vehicular del vehículo a venderse o, en su defecto, autorizar en el contrato de '
        . 'compraventa a realizar dichos actos al comprador, ya sea en entidades públicas o privadas Municipio, Servicio de Rentas Internas, Agencia Nacional de '
        . 'Tránsito de Cuenca, Agencia Nacional de Tránsito de Quito, Consejo Provincial, Tasa Solidaria, EMOV, Cuenca Aire, Policia y demás Instituciones relacionadas '
        . 'con el Tránsito para loc cual podrá firmar cuanto escrito sea necesario expresando así la voluntad del mandante con el fin de dar cumplimiento a lo que '
        . 'se faculta dentro de este poder; f) Levantar cualquier tipo de gravamen o prohibición del vehículo,  en caso de existir; g) Ofertar el vehículo o exhibirlo '
        . 'por cualquier medio a nivel nacional; h) En general realizar todos los actos tendientes a lograr la venta del vehiculo y poder cumplir de manera idónea con '
        . 'el contrato de prestación de servicios de intermediación y gestión suscrito entre mandante y mandatario; i) Obtener tantas copias certificadas o simples del '
        . 'poder requiera.'), 1, 'J');
$pdf->Ln(4);
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode('SEGUNDA.-'));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode('El Señor '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comitente));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(', da en perpetua enajenación al Señor(a) '));
$pdf->SetFont('', 'B');
$pdf->Write(4, \utf8_decode($comisionista));
$pdf->SetFont('', '');
$pdf->Write(4, \utf8_decode(', un vehículo de las siguientes características:'));
$pdf->Ln(10);
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($marca_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($modelo_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($anio_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('COLOR'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($color_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($tipo_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($mat_en_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($mat_anio_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($placa_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($motor_trs), 1, 1, 'L');
$pdf->cell(25, 4, '', 0, 0, 'C');
$pdf->SetFont('', '');
$pdf->Cell(60, 4, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, \utf8_decode($chasis_trs), 1, 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode('TERCERA.-'));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode('El Señor(a) '));
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode(', acuerda pagar por el vehículo descrito en la cláusula anterior el valor de: $ '));
$pdf->SetFont('', 'B');
$pdf->Write(5, number_format(($costo), 2));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode(' DOLARES AMERICANOS.'));
$pdf->Ln(10);
$pdf->Write(5, \utf8_decode('El valor acordado se cancela de la siguiente manera:'));
$pdf->Ln(10);
$pdf->SetFont('', 'U');
//    $pdf->Cell(20, 4, ('PAGO'), 1, 0, 'C');
    $pdf->Cell(30, 4, ('PAGO'), 0, 0, 'L');
    $pdf->Cell(25, 4, ('DOCUMENTO'), 0, 0, 'L');
    $pdf->Cell(25, 4, ('VALOR'), 0, 0, 'R');
    $pdf->Cell(20, 4, ('FECHA'), 0, 0, 'C');
//    $pdf->Cell(10, 4, ('%'), 1, 0, 'C');
//    $pdf->Cell(15, 4, ('PLAZO'), 1, 0, 'C');
    $pdf->Cell(55, 4, ('OBSERVACION'), 0, 1, 'C');    
while ($row = mysqli_fetch_array($resdet)) {
    $pdf->SetFont('', '');
    $pdf->Cell(35, 4, ($row[2]), 0, 0, '');
    $pdf->Cell(25, 4, ($row[3]), 0, 0, '');
    $pdf->Cell(20, 4, number_format(($row[4]), 2), 0, 0, 'R');
    $pdf->Cell(20, 4, ($row[5]), 0, 0, 'R');
    $pdf->Cell(55, 4, ($row[9]), 0, 1, 'R');
}
$pdf->ln(10);
//$pdf->AddPage();
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode('CUARTA.-'));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode('El señor '));
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode(', declara que sobre el vehículo materia del presente contrato, no pesan gravámenes ni impedimentos para su venta.'));
$pdf->Ln(6);
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode('QUINTA.-'));
$pdf->SetFont('', '');
$pdf->Write(5, \utf8_decode('Las partes aseguran estar de acuerdo en la negociación celebrada, así como en el actual '
        . 'funcionamiento del vehículo anteriormente mencinado y que recibe luego de haberlo examinado '
        . 'mecanicamente a su entera satisfacción, renunciando por lo tanto a cualquier reclamo posterior, a '
        . 'partir de firmado el presente contrato.'));
$pdf->ln(5);
$pdf->SetAutoPageBreak(1, 50);
//$pdf->AddPage();
$pdf->Write(5, \utf8_decode('Para constancia de lo estipulado, firman las partes contratantes en '));
$pdf->SetFont('', 'B');
$pdf->Write(5, \utf8_decode('CUENCA A, '.$dia.' DE '.$mes.' DE '.$anio.'.'));
$pdf->Ln(40);
$pdf->Cell(85, 5, \utf8_decode(''.$comisionista.''), 0, 0, 'C');
$pdf->Cell(85, 5, \utf8_decode(''.$comitente.''), 0, 1, 'C');
$pdf->Cell(85, 5, \utf8_decode('COMISIONISTA'), 0, 0, 'C');
$pdf->Cell(85, 5, \utf8_decode('COMITENTE'), 0, 1, 'C');
$pdf->Output();