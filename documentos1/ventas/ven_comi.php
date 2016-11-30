<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_REQUEST['numtrs'];
$cliente_comi = $_REQUEST['benef'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//    $this->SetMargins(20, 80);
//    $this->SetFont('Times','BU',15);
//    $this->Cell(0, 10, 'ORDEN DE VENTA', 0, 1, 'C');
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

$comitente = $cliente_comi; //$nombre_trs.' '.$apellido_trs;
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
$pdf->SetMargins(25, 50, 12);
$pdf->AddPage();
$pdf->SetFont('Times','B',14);
$pdf->Cell(0, 10,'CONTRATO DE GESTION DE VENTA', 0, 1, 'C');
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode('Comparecen a la celebración del presente contrato, por una parte el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', por sus propios y personales derechos, y por los que representa de la sociedad '
        . 'conyugal, a quien en adelante y para efectos de este instrumento se le/la denominará simplemente como '
        . 'el "MANDANTE y/o PROPIETARIO"; y por otra, el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', a quién en adelante, y para efectos de este instrumento se le denominará como el "MANDATARIO".'));
$pdf->Ln(7);
$pdf->Write(5, \utf8_decode('Las partes son hábiles para contratar y obligarse, quienes convienen libre y voluntariamente '
        . 'y por los derechos que representan celebrar el presente contrato de Gestión de Venta, al tenor de las siguientes cláusulas:'));
$pdf->Ln(10);
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode('Cláusula Primera: Antecedentes. -'));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('1. El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', es una persona natural la cual mantiene como actividad la venta al por menor, comisión e intermediación de vehículos usados.'));
$pdf->Ln(7);
$pdf->Write(5, \utf8_decode('2. El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', cuenta con la infraestructura necesaria para el cumplimiento de sus fines y para llevar adelante la comercialización '
        . 'de vehículos usados, previa la exhibición y negociación de dichos automotores por los medios legales y necesarios para el efecto.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('3. El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' es propietario de un vehículo de las siguientes características:'));
$pdf->ln(7);
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(50, 5, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($marca_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($modelo_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($anio_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('COLOR 1 / 2'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($color_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($tipo_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($mat_en_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($mat_anio_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($idveh_placa), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($motor_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(50, 5, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(70, 5, \utf8_decode($chasis_trs), 1, 1, 'L');
$pdf->SetFont('Times','',10);
$pdf->ln(5);
$pdf->Write(5, \utf8_decode('3. El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' desea que el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' se encargue de la exhibición y gestión de venta en su nombre y '
        . 'representación del vehículo descrito en el numeral tres de la presente cláusula.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('5. El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', recibe el vehículo usado detallado en la presente cláusula, '
        . 'mismo que es de propiedad de el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' para exhibirlo y encargarse de la gestión de venta.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('6. El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' declara que sobre el vehículo que entrega no pesa ningún '
        . 'gravamen ni impedimentos legales para su comercialización, y que su origen es lícito. '
        . 'No obstante, a ello, se obliga al saneamiento de ley, y en caso de presentarse alguna anomalía, '
        . 'vicios redhibitorios, impuestos, multas o gravámenes se obliga a asumir todos los gastos que '
        . 'sean necesarios para solucionarlos, y será responsable de los daños y perjuicios que pueda '
        . 'ocasionar la no comercialización y/o no cambio de propietario del automotor por cualquier '
        . 'impedimento que limite su dominio.'));
$pdf->addpage();
$pdf->Write(5, \utf8_decode('7. Del avalúo y la revisión mecánica efectuada al vehículo de manera conjunta '
        . 'se determinó que el valor del mismo es US $ '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, number_format($costo, 2));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', valor que aspira recibir el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' por la venta del vehículo antes descrito, '
        . 'por lo que lo entrega para la comercialización al Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode('.'));
$pdf->ln(10);
$pdf->SetFont('Times','B',10);
//$pdf->SetMargins(20, 20, 5);
$pdf->Write(5, \utf8_decode('Cláusula Segunda: Objeto.-'));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('Con estos antecedentes, el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' y el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' convienen en celebrar el presente contrato de gestión de venta, mediante el cual el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' entrega el vehículo al Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' con la finalidad de que éste lo exhiba, '
        . 'negocie y lo comercialice por él a sus clientes al tenor de las cláusulas contenidas en este instrumento.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Por la firma de este contrato, el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' no pierde la calidad de propietario, y se sujeta '
        . 'a las estipulaciones contenidas en el presente contrato.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Las partes aclaran que este contrato es de medio y no de resultados, por lo que el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' actuará con los datos que le han sido proporcionados y el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' nada tendrá que reclamar a el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' por cualquier problema que tenga con el comprador del bien a futuro.'));
$pdf->ln(10);
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode('Cláusula Tercera: Condiciones generales.- '));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('El servicio que prestará el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' en la negociación y comercialización del vehículo de propiedad de el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', consistirá en lo siguiente:'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' recibirá, exhibirá y gestionará la venta en sus patios del vehículo antes descrito, el que no será parte '
        . 'de su patrimonio o inventario pues solo se le ha encomendado su comercialización, para lo cual se compromete a realizar toda '
        . 'actividad y erogación económica necesaria, sin que por razón alguna que no constituya fuerza mayor o caso fortuito pueda dejar '
        . 'de cumplir con este fin.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' se obliga a reconocer todos aquellos gastos en que ha incurrido o incurra el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' y/o luego el comprador del vehículo para la solución de cualquier conflicto o anomalía que se presente y '
        . 'de la que sea legalmente responsable, misma que impida realizar el traspaso y matriculación del vehículo o gastos que sean '
        . 'necesarios para solucionar vicios ocultos que existan o se presenten.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' entregará el original de la matrícula y la revisión vehicular, actualizado al año en que se '
        . 'produce la entrega del mismo.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Será obligación de el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' el pago de cualquier tipo de multas que se hayan impuesto por la Comisión '
        . 'Nacional de Tránsito, Municipios, y/o cualquier otro organismo con competencia para hacerlo. Si el propietario no cubre '
        . 'estos rubros el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' queda facultado para descontar los mismos del pago del valor pactado por las partes.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' autoriza a el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' de ser el caso a negociar el vehículo a plazos, pudiendo recibir a su nombre títulos de '
        . 'crédito y las cauciones necesarias para garantizar el cumplimiento de la obligación.'));
$pdf->AddPage();
$pdf->Write(5, \utf8_decode('El/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', mediante la suscripción del presente contrato, autoriza a el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' a recibir los valores pagados en concepto de la comercialización de su vehículo, por lo cual, '
        . 'cualquier giro bancario, efectivo, o cheque que el cliente que adquiere el vehículo antes descrito realice deberá '
        . 'ser efectuada a la cuenta bancaria que el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' determine.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Una vez comercializado el vehículo el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' se obliga a comparecer ante la Autoridad correspondiente '
        . 'para realizar el reconocimiento de firmas y proporcionar los documentos que habiliten la negociación y obtención del '
        . 'traspaso de dominio.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Caso contrario en cumplimiento de lo dispuesto en el Art. 5 de la Resolución No. NAC-DGERCGC14-00575 '
        . 'emitida por el Servicio de Rentas Internas, el 30 de julio del 2014 el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' otorgará Poder Especial, amplio y suficiente '
        . 'debidamente conferido a favor del Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', para realizar los siguientes actos:'));
$pdf->ln(10);
$pdf->SetLeftMargin(30);
$pdf->Write(5, \utf8_decode('- Realizar todos los trámites necesarios, ante los diferentes organismos de control, para efectuar el traspaso de '
        . 'dominio a favor del comprador del vehículo antes descrito;'));
$pdf->ln(6);
$pdf->Write(5, \utf8_decode('- Recibir a nombre de el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' cualquier documento de crédito y de ser el caso la garantía que avale el cumplimiento '
        . 'de la obligación, en caso de que la venta se hubiere efectuado a plazos;'));
$pdf->ln(6);
$pdf->Write(5, \utf8_decode('- Negociar a nombre del Mandante y endosar por él cualquier documento de crédito y garantías a favor de terceras '
        . 'personas sean estas naturales o jurídicas legalmente capaces.'));
$pdf->ln(6);
$pdf->Write(5, \utf8_decode('- Resciliar el contrato de compraventa del vehículo objeto de este contrato.'));
$pdf->ln(6);
$pdf->Write(6, \utf8_decode('- Recibir a nombre de el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' el comprobante de venta que emita el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' por sus servicios.'));
$pdf->SetLeftMargin(25);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('A la firma del presente instrumento el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' entrega a el/la Señor(a) '));
$pdf->SetFont('Times','B',10); 
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' una suma equivalente al precio fijado en el numeral siete de la cláusula primera '
        . 'como garantía por la tenencia, mantenimiento y buen uso del vehículo de su propiedad mientras permanezca en los patios del Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', una vez perfeccionada la venta del automotor - esto es, una vez se realice el traspaso de dominio del vehículo '
        . 'al nuevo propietario y se verifique la no existencia de multas o impedimentos que permitan dicho traspaso - se descontarán '
        . 'los valores correspondientes a los gastos en los que hubiere incurrido el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' para las reparaciones o adecuaciones del vehículo previo a su venta - lo cual ha sido expresamente aceptado por el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' en párrafos precedentes y el saldo se entregará a el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' o servirá para compensar el valor del depósito previamente recibido.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('En caso de que el Mandante, sus sucesores o cualquier persona en su representación y siempre que justifiquen '
        . 'legalmente tal calidad, desearen por cualquier motivo retirar el vehículo antes descrito de los patios del Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' deberán devolver el valor de la garantía que le fuere entregada por ella comprometiéndose adicionalmente a '
        . 'reconocer el valor de todos los costos y gastos en que ésta hubiere incurrido para ponerlo en condiciones óptimas para su '
        . 'comercialización.'));
$pdf->AddPage();
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode('Cláusula Cuarta: Plazo.-'));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('El presente contrato terminará una vez que el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' realice la comercialización del vehículo entregado - objeto de este contrato -, salvo que por caso fortuito o fuerza mayor el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' no pueda cumplir el fin de este instrumento.'));
$pdf->ln(10);
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode('Cláusula Quinta: Valor del honorario de el Sr. '));
$pdf->Write(5, \utf8_decode($comisionista.'.- '));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' por la prestación de su servicio recibirá la diferencia en más o en menos entre el precio determinado del avalúo y la revisión mecánica '
        . 'establecida en el numeral 7 de la cláusula primera de este instrumento y el precio EFECTIVO de la venta.'));
$pdf->ln(7);
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode('Cláusula Sexta: Responsabilidad'));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('EL/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(', seguirá siendo responsable del vehículo, en su calidad de propietario, hasta el momento de su transferencia.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('El Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' es responsable por la integridad del mismo y por daños que pudieren presentarse a terceros, el Sr. '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' a su voluntad podrá contratar o incluir el vehículo en su póliza de seguro durante el tiempo que estuviere en sus instalaciones por '
        . 'adecuaciones y exhibición hasta su comercialización, sin que esto signifique que el Sr. '));
$pdf->SetFont('Times','B',10); 
$pdf->Write(5, \utf8_decode($comisionista));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' tiene propiedad alguna sobre el mismo.'));
$pdf->ln(10);
$pdf->SetFont('Times','B',10); 
$pdf->Write(5, \utf8_decode('Cláusula Séptima: Ratificación.-'));
$pdf->SetFont('Times','',10);
$pdf->ln(10);
$pdf->Write(5, \utf8_decode('Los contratantes al ratificarse en el contenido del contrato que antecede, manifiestan su conformidad con el mismo. De la misma forma '
        . 'manifiestan su conformidad con el estado actual de funcionamiento del vehículo materia de la negociación el que se entrega y recibe luego de haberlo '
        . 'examinado mecánicamente a su entera satisfacción, por lo que renuncian a cualquier reclamo posterior, a partir de la suscripción del presente contrato y '
        . 'del Acta de Entrega-Recepción de Vehículos Usados que se firma de forma conjunta, salvo aquellos problemas que se evidencien luego por vicios ocultos, '
        . 'gravámenes, daños mecánicos, alteración de números de motor o chasis, origen ilícito del automotor  y cualquier otro que impida u obstaculice el proceso '
        . 'de transferencia o matriculación del vehículo, en cuyo caso el/la Señor(a) '));
$pdf->SetFont('Times','B',10);
$pdf->Write(5, \utf8_decode($comitente));
$pdf->SetFont('Times','',10);
$pdf->Write(5, \utf8_decode(' será responsable por los perjuicios ocasionados.'));
$pdf->ln(7);
$pdf->Write(5, \utf8_decode('Para constancia de lo pactado firman las partes contratantes en: '));
//$pdf->ln(7);
$pdf->SetFont('Times','B',10); 
$pdf->Write(5, \utf8_decode(''.$ciudad_prt.' a, '.$dia.' de '.$mes.' del '.$anio));
$pdf->Ln(40);
$pdf->SetFont('Times','B',8); 
$pdf->Cell(80, 5, \utf8_decode(''.$comitente.''), 0, 0, 'C');
$pdf->Cell(90, 5, \utf8_decode(''.$comisionista.''), 0, 1, 'C');
$pdf->Cell(80, 5, \utf8_decode('MANDANTE / PROPIETARIO'), 0, 0, 'C');
$pdf->Cell(90, 5, \utf8_decode('MANDATARIO'), 0, 1, 'C');
$pdf->Output();
?>