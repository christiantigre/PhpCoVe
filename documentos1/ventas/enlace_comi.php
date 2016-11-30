<?php
    $tran_num = $_GET['numtrs'];
    include_once '../../class/transacc.php';
    $objcliente = new Transacc();
    $objcliente->imprime_trans($tran_num);
    include_once '../../class/cliente.php';
    $objcliente = new Cliente();
    $objcliente->imprime_cli($cliente);
    $datonombre = $nombre.' '.' '.$apellido
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
        <form action="ven_comi.php" method="POST">
            <input type="text" name="numtrs" value="<?php echo $tran_num ?>" hidden="">
            <input type="text" name="benef" value="<?php echo $nombre.' '.$apellido ?>" style="width: 300px">
            <input type="submit" value="CONTRATO COMISION">
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
