<?Php
session_start();
$pago=$_POST['pago'];
$forma=$_POST['forma'];
$dcto=$_POST['dcto'];
$valor=$_POST['valor'];
$fecha_det=$_POST['fecha_det'];
$interes=$_POST['interes'];
$plazo=$_POST['plazo'];
$lststd=$_POST['lststd'];
$observacion=$_POST['observacion'];
$tipotrs=$_POST['tipotrs'];
$trs=$_POST['trs'];
include_once '../class/trandetalle.php';
$objdet= new Trandetalle();
$objdet->conec_base();
if($pago=='ENTRADA'){
    if ($objdet->insertar_detall($pago,$forma,$dcto,$valor,$fecha_det,$interes,$plazo,$lststd,$observacion,$tipotrs,$trs)==true) {
        echo "Registrado correctamente";
    } else {
        echo "No se pudo registrar este pago";
    }
}elseif($pago=='ADICIONAL'){    
    if ($objdet->insertar_adicional_edit($pago,$forma,$dcto,$valor,$fecha_det,$interes,$plazo,$lststd,$observacion,$tipotrs,$trs)==true) {
        echo "Registrado correctamente";
    } else {
        echo "No se pudo registrar este pago";
    }
}elseif($pago=='CREDITO'){
    if ($objdet->insertar_credito_edit($pago,$forma,$dcto,$valor,$fecha_det,$interes,$plazo,$lststd,$observacion,$tipotrs,$trs)==true) {
        echo "Registrado correctamente";
    } else {
        echo "No se pudo registrar este pago";
    }
}

?>