<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="../style/style.css" />
    </head>
    <body>
        <br>
    <center>
        <br>
        <section>
            <form action="inicio.php" method="post">
                <label>Ingrese la tipo de pago :</label>&nbsp;
                <input type="text" id="idpag" name="idpag" list="pagos" autofocus="">
                <datalist id="pagos" name="pagos" style="width: 250px">
                    <?php
                    include_once 'class/tip_pago.php';
                    $objltmodelo = new tip_pago();
                    $objltmodelo->conec_base();
                    $objltmodelo->mostrar_opciones();
                    ?>                    
                </datalist>
                &nbsp;&nbsp;
                <input type="submit" name="buscar_pag" value="BUSCAR">
                &nbsp;
                <input type="submit" name="listar_pag" value="LISTAR TODO">
                &nbsp;
                <input type="submit" name="nuevo_pag" value="NUEVO">
                &nbsp;
                <input type="submit" name="salir_cont" value="SALIR">
                <br><br>
                <div id="lstveh">
                    <?php
                    include_once 'class/tip_pago.php';
                    $objveh = new tip_pago();
                    $objveh->conec_base();
                    if (isset($_POST['buscar_pag'])) {
                        $objveh->buscar_pag($_POST['idpag']);
                    } else {
                        $objveh->listar_pag();
                    }
                    ?>
                </div>
            </form>
        </section>
    </body>
</center>
</html>