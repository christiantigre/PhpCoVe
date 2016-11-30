<?Php
session_start();
$carpeta=$_POST['carpeta'];
$monto=$_POST['monto'];
include_once '../class/trandetalle.php';
$objdel= new Trandetalle();
$objdel->conec_base();
if ($objdel->delete_pay($carpeta,$monto)==true) {
	echo "Eliminado correctamente";
} else {
	echo "No se pudo eliminar este pago";
}
?>