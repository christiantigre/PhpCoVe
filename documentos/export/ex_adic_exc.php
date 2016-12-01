<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
date_default_timezone_set("America/Guayaquil");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=credito.xls");
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ADICIONALES GENERADAS</title>
</head>
<body>
 <?Php
 include_once '../../class/trandetalle.php';
 $conn = new Trandetalle();
 $conn->conec_base();
 $conn->adicionales_temporal();
 ?>
</body>
</html>