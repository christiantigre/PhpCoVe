<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

$idtran_cab = $_GET['numtrs'];

require('../../fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
//    $this->SetMargins(20, 80);
//    $this->SetFont('Arial','BU',15);
//    $this->Ln(50);
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

$alfombras_trs = $alfombras; 
$brazosplumas_trs = $brazosplumas;
$cinturones_trs = $cinturones;
$espejos_trs = $espejos;
$gata_trs = $gata;
$llaveruedas_trs = $llaveruedas;
$manual_trs = $manual;
$otros_trs = $otros;
$radioparlantes_trs = $radioparlantes;
$tapatuerca_trs = $tapatuerca;
$mecanico_trs = $mecanico;
$sistelect_trs = $sistelect;
$pintura_trs = $pintura;

include_once '../../class/vehiculo.php';
$objveh = new Vehiculo();
$objveh->imprime_docu($idveh_placa);

$resprint = $resultado;

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
$pdf->SetFont('Arial','BU', 15);
$pdf->Ln(15);
$pdf->Cell(0,10,\utf8_decode('CONTRATO DE COMISIÓN'),0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode('En la ciudad de'));
$pdf->SetFont('Times', 'B', 8);
$pdf->write(4, \utf8_decode(' CUENCA A, '.$dia.' DE '.$mes.' DE '.$anio.','));
$pdf->SetFont('Times', '', 8);
$pdf->write(4, \utf8_decode(' se celebra el siguiente contrato de comisión, contenido en las siguientes clausulas:'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode('PRIMERA.- '));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode('Intervienen en la celebración del presente contrato, por una parte el Señor '));
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode(''.$comisionista.'')); 
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode(' de cédula de ciudadania número ')); 
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode(''.$ced_coms.''));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode(', a quien se le conocerá como '));
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode('"EL COMISIONISTA" '));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode('y por otra parte, el Señor '));
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode(''.$comitente.''));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode(' con cédula de ciudadania número '));
$pdf->SetFont('Times', 'B', 8);
$pdf->Write(4, \utf8_decode(''.$ced_comt.''));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode(', quién será'));
$pdf->SetFont('Times', 'B', 8);                
$pdf->Write(4, \utf8_decode('"EL COMITENTE".'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode('Los comparecientes son de nacionalidad ecuatoriana, mayores de edad, de estado civil '));
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('CASADO y '.$est_civil_trs.' '));
$pdf->SetFont('Times', '', 8);
$pdf->Write(4, \utf8_decode('domiciliados en la ciudad de Cuenca y hábiles para obligarse y contratar.'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('SEGUNDA.-ANTECEDENTES'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('El comitente es dueño y legítimo propietario de un vehículo de un vehiculo cuyas '
        . 'características son las siguientes:'));
$pdf->Ln(4);
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->Cell(60, 5, \utf8_decode('MARCA'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($marca_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('MODELO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($modelo_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('AÑO DE FABRICACION'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($anio_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('COLOR 1 + 2'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($color_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('TIPO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($tipo_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('MATRICULADO EN'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($mat_en_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('POR EL AÑO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($mat_anio_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('PLACAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($idveh_placa), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('MOTOR'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($motor_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 5, \utf8_decode('CHASIS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 5, \utf8_decode($chasis_trs), 1, 1, 'L');
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('TERCERA.-OBJETO DEL CONTRATO'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Por medio del presente contrato el comitente se obliga '
        . 'a entregar el vehículo de su propiedad descrito en la clausula anterior al '
        . 'comisionista para que este, busque comprador, pacte precio, reciba el mismo '
        . 'y en general para que venda dicho bien, para lo cual el comisionista dentro '
        . 'del giro de su negocio de manera personal y voluntaria y a su arbitrio siendo '
        . 'exclusiva decisión unilateral pueda emplear los mejores medios para la consecución '
        . 'de dicho fin, en base al cobro efectivo de su respectiva comisión. En el ejercicio '
        . 'de esta comisión, el comisionista desempeñará por si mismo la comisión, utilizando '
        . 'sus propios locales y almacenes de exhibición u otros medios, así como los recursos '
        . 'financieros y logísticos que sean necesarios.'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('CUARTO.-OBLIGACIONES DEL COMITENTE'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Son obligaciones del Comitente o propietario del vehiculo '
        . 'objeto del presente contrato las siguientes:'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('a) Asumir la responsabilidad por multas e infracciones de tránsito y los impuestos e intereses generados por este.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('b) Asumir la responsabilidad por multas municipales(parqueo ciudadano) y los impuestos e intereses generados por este.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('c) Asumir la responsabilidad por Vicios redhibitorios y vicios ocultos en el vehículo.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('d) Asumir la responsabilidad por gravámenes e impedimento impuestos sobre el vehiculo'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('e) Asumir la responsabilidad sobre acreedores o derecho habientes sobre el bien objeto del presente contrato'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('f) Entregar al comisionista la Matrícula vigente al año de negociación o en su defecto el comprobante de pago del valor respectivo; si es '
        . 'que en dicha matrícula constare como observación el detalle de no negociable,  el comitente se obliga a entregar los documentos de descargo '
        . 'respectivos tales como cancelación de prenda, terminación de contrato de fideicomiso entre otros.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('g) Proveer del vehículo cuyas características se detallaron en la cláusula segunda'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('QUINTO.-DURACION DEL CONTRATO'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Este contrato fenecerá, una vez incluida, la venta del vehículo materia de este instrumento.'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('SEXTA.-CONTROVERSIAS'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('En caso de suscitarse alguna controversia derivada de la aplicación del presente contrato, las partes de manera libre y voluntaria se someterán a '
        . 'un método alternativo de solución de conflictos, para ello acudirán al Centro de Arbitraje y Mediación de las Cámaras de la Producción del '
        . 'Azuay. El método alternativo de solución de conflictos deberá ser al Arbitraje en Derecho, el arbitraje se sujetará al procedimiento previsto en '
        . 'la Ley de Arbitraje y Mediación Vigente, así como al Reglamento Interno del Centro.'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('Sin perjuicio de lo anteriomente establecido, y por tratarse de un procedimiento voluntario,en cualquier momento, en caso de controversia, '
        . 'cualquiera de las partes podrán acudir a la jurusdicción ordinaria ante uno de los jueces de lo civil del Cantón Cuenca, para lo cual renuncia al '
        . 'fuero y domicilio'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('En todo lo no previsto en el presente contrato habrá que estar a lo dispuesto en el Código de Comercio, el Código Civil, en las Leyes '
        . 'especiales y en las reglas generales del Derecho común'));
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('Para constancia de lo antes estipulado y luego de harse leídoel contrato en su integridad, los comparecientes firman a pie del presente.'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('SEPTIMA.-RECEPCION Y ESTADO FISICO DEL BIEN'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Las partes declaran conjuntamente que el vehículo, materia de este instrumento se encuentra en las siguientes condiciones:'));
$pdf->Ln(4);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('DOCUMENTOS REFERENTES AL VEHICULO'));
$pdf->Ln(4);

while ($row = mysqli_fetch_array($resprint)) {
    $pdf->cell(50,5, '', 0, 0, 'C');
    $pdf->Cell(60, 4, ($row[1]), 1, 1, '');
}

//$pdf->Ln(4);
//$pdf->Write(4, \utf8_decode('Herramientas y Accesorios del Vehiculo'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(80, 4, \utf8_decode('HERRAMIENTAS Y ACCESORIOS'), 0, 0, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('ESTADO'), 0, 1, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(80, 4, \utf8_decode('ALFOMBRAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($alfombras_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('BRAZOS Y PLUMAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($brazosplumas_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('CINTURONES DE SEGURIDAD'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($cinturones_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('ESPEJOS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($espejos_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('GATA'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($gata_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('LLAVE DE RUEDAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($llaveruedas_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('MANUAL'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($manual_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('CLAVE / OTROS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($otros_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('RADIO Y PARLANTES'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($radioparlantes_trs), 1, 1, 'L');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(80, 4, \utf8_decode('TAPACUBOS Y TUERCAS'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode($tapatuerca_trs), 1, 1, 'L');
$pdf->Ln(4);
$pdf->Write(4, \utf8_decode('ESTADO DE VEHICULO'));
$pdf->Ln(4);
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 4, \utf8_decode('MECANICO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 4, \utf8_decode($mecanico_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 4, \utf8_decode('SISTEMA ELECTRICO'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 4, \utf8_decode($sistelect_trs), 1, 1, 'L');
$pdf->cell(25,5, '', 0, 0, 'C');
$pdf->SetFont('Times', '', 8); 
$pdf->Cell(60, 4, \utf8_decode('PINTURA'), 1, 0, 'L');
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(60, 4, \utf8_decode($pintura_trs), 1, 1, 'L');
$pdf->Ln(4);
$pdf->cell(0, 4, \utf8_decode('IMPRONTAS DEL VEHICULO'), 0, 1, 'C');
$pdf->Ln(50);
$pdf->Write(4, \utf8_decode('OCTAVA.-GRAVAMENES Y PROHIBICIONES'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Así mismo, el comitente declara bajo juramento, que el vehículo entregado en consignació es de su exclusivo uso y dominio; y, que éste se'
        . 'encuentra libre de todo gravamen, prohibición o embargo; y además que los números tanto de motor y de chasis constantes en la impronta que '
        . 'precede esta cláusula no han sufrido alteración alguna, siendo por lo tanto los legítimos y originales de la fábrica ensambladora del mismo.'));
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Write(4, \utf8_decode('NOVENA.-ACEPTACION'));
$pdf->Ln(4);
$pdf->SetFont('Times', '', 8); 
$pdf->Write(4, \utf8_decode('Las partes manifiestan aceptan en su integridad todo el contenido del presente contrato por estar de acuerdo con sus estipulaciones, firmando '
        . 'para constancia. al pie del presente.'));
$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 8); 
$pdf->Cell(80, 4, \utf8_decode(''.$comitente.''), 0, 0, 'C');
$pdf->Cell(80, 4, \utf8_decode(''.$comisionista.''), 0, 1, 'C');
$pdf->Cell(80, 4, \utf8_decode('COMITENTE'), 0, 0, 'C');
$pdf->Cell(80, 4, \utf8_decode('COMISIONISTA'), 0, 1, 'C');
$pdf->Output();