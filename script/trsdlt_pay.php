<?Php
session_start();
$carpeta=$_POST['carpeta'];
$monto=$_POST['monto'];
$pago=$_POST['pago'];
$tipodelete=$_POST['tipodelete'];
if ($pago=='1') {$pg='ENTRADA';}
if ($pago=='2') {$pg='ADICIONAL';}
if ($pago=='3') {$pg='CREDITO';}
include_once '../class/trandetalle.php';
$objdel= new Trandetalle();
$objdel->conec_base();
if ($tipodelete=='1') {
	if ($objdel->trs_delete_pay($carpeta,$monto,$pg)==true) {
		echo "Eliminado correctamente";
	} else {
		echo "No se pudo eliminar este pago";
	}

}else{
	if ($objdel->trs_delete_trash_pay($carpeta,$monto,$pg=0)==true) {
		echo "Eliminado correctamente";
	} else {
		echo "No se pudo eliminar este pago";
	}
}

?>