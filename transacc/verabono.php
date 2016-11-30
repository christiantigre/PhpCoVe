
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
        <form action="inicio.php" method="POST" id="myform">
            <?Php
            if (isset($numcre) and isset($numsec)) {
                ?>
                <input type="hidden" name="numcretxt" value="<?Php echo $numcre ?>"/>
                <input type="hidden" name="numsectxt" value="<?Php echo $numsec ?>"/>
                <?php
            }
            ?>
            <fieldset>
                <?php
                if (isset($_POST['pagacredito'])) {

                } else {
                    include_once 'class/trancredito.php';
                    $objtrs = new Trancredito();
                    $objtrs->conec_base();
                    $objtrs->ver_abonos($numcre, $numsec);
                    $objtrs->ver_abono();
                }
                ?>

            </fieldset> 
            <br><br>
            <input type="submit" name="transac" value="REGRESAR">
        </form>
    </center>
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
</body>
</html>