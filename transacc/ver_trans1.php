<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style/style.css" /> 
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST">
        <fieldset>

        <?php
            include_once 'class/transacc.php';
            $objtrs = new Transacc();
            $objtrs->conec_base();
            $objtrs->ver_trans($codigo);
            
        if(($GLOBALS['trans'])=='INGRESO'){
        ?>
            <a href='../../PhpCoVe/documentos/compras/1_cont_comis.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE COMISION" /></a>
            &nbsp;&nbsp;
            <a href='../../PhpCoVe/documentos/compras/2_con_com_ven.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE COMPRA" /></a>
            &nbsp;&nbsp;
            <a href='../../PhpCoVe/documentos/compras/3_ing_veh.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="INGRESO DE VEHICULO" /></a>
            &nbsp;&nbsp;
            <a href='../../PhpCoVe/documentos/compras/4_rec_impr.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="RECEPCION DE IMPRONTAS" /></a>
            &nbsp;&nbsp;                           
            <hr><br>            
        <?php
        }
        if(($GLOBALS['trans'])=='EGRESO'){
        ?>
            <a href='../../PhpCoVe/documentos/ventas/1_con_ven.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE VENTA" /></a>
            &nbsp;&nbsp;
            <a href='../../PhpCoVe/documentos/ventas/2_egr_veh.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="EGRESO DE VEHICULO" /></a>
            &nbsp;&nbsp;               
            <hr><br>                        
        <?php
        }        
            include_once 'class/vehiculo.php';
            $objveh = new Vehiculo();
            $objveh->conec_base();
            $objveh->buscar_veh_com($GLOBALS['placa']);
        ?>
            <hr><br>
        <?php
            include_once 'class/cliente.php';
            $objcli = new Cliente();
            $objcli->conec_base();
            $objcli->buscar_cliente_com($GLOBALS['cliente']);
        ?>
            <hr>
            <h1>PAGOS</h1>
        <?php
            include_once 'class/trandetalle.php';
            $objtrs = new Trandetalle();
            $objtrs->conec_base();
            $objtrs->detalle_transac($codigo);
        ?>
            <hr>
            <h1>CREDITOS</h1>
        <?php
            include_once 'class/trancredito.php';
            $objcre = new Trancredito();
            $objcre->conec_base();
            $objcre->ver_creditos($codigo);
        ?>
        </fieldset> 
        <br><br>
        <!--<input type="reset" value="CANCELAR">-->
        <input type="submit" name="transac" value="REGRESAR">            
        </form>
    </center>
    </body>
</html>
