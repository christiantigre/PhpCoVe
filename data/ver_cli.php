<?php
if(!isset($_SESSION)){
session_start();
}
if(isset($_REQUEST['vercedula'])){
    $cedula = $_REQUEST['vercedula'];
}else{
    $cedula = $idcli_ident;
}
?>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MODIFICAR CLIENTE
                    </div>        
                    <div class="panel-body" style="font-size: 9px">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <div class="panel-body">
                                    <?php
                                    include_once 'class/cliente.php';
                                    $objcli = new Cliente();
                                    $objcli->conec_base();
                                    $objcli->ver_cliente($cedula);
                                    ?>
                                    <input type="submit" name="modificar_cliente" value="MODIFICAR"/>
                                    &nbsp;&nbsp;
                                    <button type="button"><a href="inicio.php?variable=cliente">SALIR</a></button>
                                    <!--<input type="submit" name="clientes" value="SALIR">-->            
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
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
    </body>
</html>