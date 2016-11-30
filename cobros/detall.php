
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Control Parqueadero - </title>
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST" id="myformimp">
            <?Php
            $varcre = $_REQUEST['numcretxt'];
            $varsec = $_REQUEST['numsectxt'];
            if (isset($varcre) and isset($varsec)) {
                ?>
                <input type="hidden" name="numcretxt" value="<?Php echo $varcre ?>"/>
                <input type="hidden" name="numsectxt" value="<?Php echo $varsec ?>"/>
                <?php
            }
            ?>
            <fieldset>
                <p style="font-size:9px;text-align: right">
                <?php
                include_once 'class/cobrosclass.php';
                $objtrs = new Cobros();
                $objtrs->conec_base();
                echo '<hr><br>';
                echo '<h1>GENERAL</h1>';
                $objtrs->buscar_transcarp($_POST['numcretxt']);
                echo '<hr><br>';
                echo '<h1>VEHICULO</h1>';
                $objtrs->buscar_veh_cob($_POST['numcretxt']);
                echo '<hr><br>';
                echo '<h1>CLIENTE</h1>';
                $objtrs->buscar_cliente_cob($_POST['numcretxt']);
                echo '<hr><br>';
                echo '<h1>COBRO</h1>';
                $objtrs->detallcobro($_POST['numcretxt'],$_POST['numsectxt']);
                ?>
                </p>
                <hr><br>
            </fieldset> 
            <script>
                var bPreguntar = true;
                function confirmar() {
                    var formulario = document.getElementById("myformimp");
                    var dato = formulario[0];
                    respuesta = confirm('¿Desea imprimir comprobante?');
                    if (respuesta) {
                        formulario.submit();
                        return true;
                    } else {
                        return false;
                    }
                }
                
                
                var bPreguntarass = true;
                function genasientocontt() {
                    var formulario = document.getElementById("myformimp");
                    var dato = formulario[0];
                    respuesta = confirm('¿Desea generar el asiento contable?');
                    if (respuesta) {
                        formulario.submit();
                        return true;
                    } else {
                        return false;
                    }
                }
                
                
            </script>
            <br><br>
            <input type="submit" name="impcomprobante" onclick="return confirmar();" value="IMPRIMIR">
            <input type="submit" name="transac" value="REGRESAR">
        </form>
    </center>
        <br><br>
    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
</body>
</html>