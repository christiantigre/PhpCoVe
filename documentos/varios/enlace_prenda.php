<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

    $tran_num = $_GET['numtrs'];
    include_once '../../class/transacc.php';
    $objprenda = new Transacc();
    $objprenda->imprime_trans($tran_num);
    $fecha_prenda = $fecha_t;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <center>
        <form action="3_con_pre_ind.php" method="POST">
            <label>Ingrese fecha: </label>
            <input type="text" name="numtrs" value="<?php echo $tran_num ?>" hidden="">
            <input type="date" name="fecha_prenda" value="<?php echo $fecha_prenda ?>" style="width: 150px">
            <input type="submit" value="CONTRATO PRENDA INDUSTRIAL">
<?php
//    global $benef;
//    $tran_num = $_GET['numtrs'];
//    echo "<script> var benef = prompt('INGRESE EL BENEFICIARIO')</script>";
//    $benef = "<script> document.write(benef) </script>";
//    if(!isset($benef)){
//        $benef = 'VALDIMIR ENDERICA';
//    }
//        echo "<a href='2_doc_ane_aut.php?numtrs=".$tran_num."'>DOC. ANEXO AUTORIZACION</a>";
//
//    echo $benef; 
?>
        </form>
    </body>
</html>
