<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_POST['numtrs'];
$fecha_prd = $_POST['fecha_prenda'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
    $this->SetMargins(20, 10, 15);
    $this->SetFont('Arial','BU',15);
    $this->Ln(10);
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
$fecha_trs = $fecha_prd; //$fecha_t;
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
$ced_conyuge = $cedu_conyuge ;
    
$comitente = $nombre_trs.' '.$apellido_trs;
$comisionista = 'VLADIMIR FERNANDO ENDERICA IZQUIERDO';
$conyuge = $conyuge_trs;
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
$pdf->Cell(0,10,'CONTRATO DE PRENDA INDUSTRIAL ABIERTA',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 10);
$pdf->Write(4, \utf8_decode('En la ciudad de Cuenca a, '.$dia.' de '.$mes.' del '.$anio.' se celebra un contrato de Prenda Industrial Abierta de acuerdo a las '
        . 'cláusulas que constan a continuación:'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('PRIMERA: PARTES QUE INTERVIENEN, Intervienen en la suscripción de este contrato, por una parte el señor '
        . ''.$comisionista.' a quien en lo posterior, podrá denominarse simplemente como acreedor prendario.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('También intervienen los Señores '.$comitente.' y su conyuge '.$conyuge.' quienes '
        . 'constituirán la prenda para garantizar las obligaciones que contraigan o hayan contraido personalmente con el acreedor '
        . 'prendario '.$comisionista.', estos comparecientes podrán llamarse por sus propios nombres '
        . 'o como los deudores prendarios.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('SEGUNDA: ANTECEDENTES.- Los deudores prendarios señores: '.$comitente.' y su conyuge '.$conyuge.' '
        . 'han manifestado al acreedor prendario su deseo de otorgar prenda industrial Abierta sobre el bien, '
        . 'que será posteriormente descrito, para garantizar todas y cada una de las obligaciones, que personalmente adeuden '
        . 'actualmente o en lo posterior al acreedor prendario.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('En consecuencia esta prenda cubre y cubrirá cualquier crédito u obligación que contraen los deudores prendarios, individual '
        . 'o conjuntamente, sea por la suscripción de instrumentos públicos en general, instrumentos privados, letras de cambio, '
        . 'pagares a la orden o cualquier otra clase de títulos ejecutivos o documentos de cartera o comerciales, por obligación '
        . 'directa, aval, endoso o cesión.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('Se aclara que se menciona estos documentos a guisa de ejemplo y que es voluntad de las partes contratantes que esta '
        . 'prenda garantice cualquier obligación que la parte deudora prendaria la mantenga o mantuviera con el deudor prendario.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('La prenda que se constituye cubrirá también los intereses estipulados y en caso de mora, las cosas judiciales, honorarios '
        . 'profesionales y más gastos a los que hubiere lugar para el cobro de lo adecuado.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('TERCERA: PRENDA INDUSTRIAL ABIERTA.- El acreedor prendario ha aceptado la propuesta de los deudores prendarios, '
        . 'para garantizar las obligaciones antes indicadas por los deudores prendarios quienes constituyen Prenda Industrial Abierta a '
        . 'favor del acreedor prendario sobre el vehículo.'));
$pdf->Ln(8);
$pdf->SetFont('Times', '', 8);
$pdf->cell(10, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, \utf8_decode('MARCA:').'  '.$marca_trs, 1, 0, 'L');
$pdf->Cell(70, 5, \utf8_decode('MOTOR:').'  '.$motor_trs, 1, 1, 'L');
$pdf->cell(10, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, \utf8_decode('TIPO:').'  '.$tipo_trs, 1, 0, 'L');
$pdf->Cell(70, 5, \utf8_decode('CHASIS:').'  '.$chasis_trs, 1, 1, 'L');
$pdf->cell(10, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, \utf8_decode('MODELO:').'  '.$modelo_trs, 1, 0, 'L');
$pdf->Cell(70, 5, \utf8_decode('COLOR:').'  '.$color_trs, 1, 1, 'L');
$pdf->cell(10, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, \utf8_decode('MATRICULADO:').'  '.$mat_anio_trs, 1, 0, 'L');
$pdf->Cell(70, 5, \utf8_decode('PLACAS:').'  '.$placa_trs, 1, 1, 'L');
$pdf->cell(10, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, \utf8_decode('AÑO FABRICACION:').'  '.$anio_trs, 1, 0, 'L');
$pdf->Cell(70, 5, \utf8_decode(''), 1, 1, 'L');
$pdf->Ln(8);
$pdf->SetFont('Times', '', 10);
$pdf->Write(4, \utf8_decode('Se acompaña una certificación expedida por el Señor Registrador Mercantil del cantón, que comprueba que el bien que se '
        . 'prenda por este instrumento se encuentra libre de gravamen o limitaciones de dominio.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('El acreedor prendario, en la calidad que comparece, acepta esta prenda por haberse constituido a su favor.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('Este vehículo permanecerá en Cuenca.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('CUARTA: El bien dado en prenda permanecerá en poder de los deudores prendarios, su custodia y cuidado, obligandose '
        . 'éstos a velar por su conservación, para lo cual responderán por toda especie de culpa.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('QUINTA: Los bienes dados en prenda no podrán ser removidos sino con autorización expresa del acreedor prendario. Este '
        . 'tiene el derecho de examinar el bien prendado cuando lo crea conveniente.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('SEXTA: Si los deudores prendarios, tuvieren que realizar actos de conservación del bien dado en prenda, los gastos '
        . 'correspondientes correrán a su cargo.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('SEPTIMA: La restitución del bien prendado solo podrá efectuarse despues de la satisfacción de las deudas '
        . 'pendientes, mediante orden escrita del acreedor prendario.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('OCTAVA: PROHIBICION DE ENAJENAR O GRAVAR.- Los deudores prendarios, constituyen prohibición de enajenar o '
        . 'gravar sobre el bien que, por este instrumento, prenda a favor del acreedor prendario.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('La cuantía por su naturaleza es indeterminada.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('NOVENA: VENCIMIENTO ANTICIPADO DEL PLAZO.- El acreedor prendario podrá declarar el plazo vencido todas y cada '
        . 'una de las obligaciones de los deudores prendarios, para demandarlos, ejecutando esta garantía para el cobro de todas las '
        . 'deudas pendientes, con el interés máximo permitido, más los gastos juduciales y extra judiciales en los que haya incurrido y '
        . 'los honorarios de su abogado, en los siguientes casos:'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('A) Si los deudores prendarios hubieren incurrido en mora en el pago de cualquier obligación, dividendo, abono o cuota de '
        . 'capital o intereses por obligaciones contraídas con el acreedor prendario.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('B) Si los deudores prendarios, vendieren o gravaren a favor de otra persona el bien que por este contrato prendan a favor '
        . 'de acreedor prendario, o si sobre dicho bien recayere cualquier otro gravamen o limitación de dominio, así como embargo o '
        . 'prohibiciones judiciales.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('C) Si se dicta auto de coactiva en contra de los deudores prendarios.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('D) Si los deudores prendarios fueren declarados en concurso de acreedores.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('E) Si la prenda desapareciere o se destruye sustancialmente.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('F) En los casos de violación de cualquiera de las estipulaciones constantes en este constrato.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('El acreedor prendario y los deudores prendarios, convienen en que no será necesaria prueba alguna para justificar los '
        . 'hechos que faculten al acreedor prendario a exigir el pago total inmediato de lo debido.  Será suficiente para ello la sola '
        . 'aseveración en que el acreedor prendario hiciere, en tal sentido, en la demanda respectiva.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('Al aplicar esta cláusula el acreedor prendario queda autorizado por los deudores prendarios para retener y aplicar a lo '
        . 'adeudado cualquier cantidad de dinero que tengan cancelada al acreedor prendario, sin reclamo posterior alguno.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('DECIMA: GASTOS.- Los gastos de celebración e inscripción de este contrato, así como los de cancelación, cuando llegue '
        . 'el caso, serán de cuenta de los deudores prendarios.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('Se estipulan en indefinido el plazo de duración del presente contrato, desde su inscripción en el Registro Mercantil.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('UNDECIMA: Las partes para los efectos derivados de este contrato, renuncian domicilio y se someten a los jueces '
        . 'competentes de la ciudad de Cuenca.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('El presente contrato deberá inscribirse en el Registro Mercantil.'));
$pdf->Ln(8);
$pdf->Write(4, \utf8_decode('Para constancia de lo expuesto firman en cuatro ejemplares iguales en la ciudad y fechas indicadas en el encabezamiento del '
        . 'presente contrato.'));
$pdf->Ln(26);
$pdf->Line(50, 212, 100, 212);
$pdf->Line(120, 212, 170, 212);
$pdf->SetFont('Times', '', 8);
$pdf->Cell(30, 4, '', 0, 0, 'C');
$pdf->Cell(50, 4, \utf8_decode(''.$comitente.''), 0, 0, '');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(50, 4, \utf8_decode(''.$conyuge.''), 0, 1, '');
$pdf->Cell(30, 4, '', 0, 0, 'C');
$pdf->Cell(50, 4, \utf8_decode('C.I.# '.$ced_comt.''), 0, 0, 'C');
$pdf->Cell(30, 4, '', 0, 0, 'C');
$pdf->Cell(50, 4, \utf8_decode('C.I.# '.$ced_conyuge.''), 0, 1, '');

$pdf->ln(20);
$pdf->Line(72, 240, 132, 240);
$pdf->Cell(50, 4, '', 0, 0, 'C');
$pdf->Cell(50, 4, \utf8_decode(''.$comisionista.''), 0, 1, '');
$pdf->Cell(50, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, \utf8_decode('C.I.# '.$ced_coms.''), 0, 1, 'C');
$pdf->Output();