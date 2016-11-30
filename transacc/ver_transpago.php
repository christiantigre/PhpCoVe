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
        ?>
            <hr><br>
        <?php
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
            include_once 'class/pagosclass.php';
            $objcre = new Pagos();
            $objcre->conec_base();
            $objcre->ver_creditospag($codigo);
        ?>
        </fieldset> 
        <br><br>
            <!--<input type="reset" value="CANCELAR">-->
            <input type="submit" name="transac" value="REGRESAR">
        </form>
    </center>
    </body>
</html>
