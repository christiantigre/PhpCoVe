<?php
if(!isset($_SESSION)){
session_start();
}  
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Control Parqueadero - </title>
        </head>
        <body>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        CARTERA DE CLIENTES
                    </div>        
                    <div class="panel-body" style="font-size: 9px">
                        <div class="table-responsive">
                            <p style="font-size:20px"><b>
                                <legend>COBROS POR VENCER</legend>
                            </b></p>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr rol="row">
                                        <th style="width: 100px">Carpeta</th>
                                        <th style="width: 200px">Pago</th>
                                        <th style="width: 200px">Fecha Pago</th>
                                        <th style="width: 400px">Valor</th>
                                        <th style="width: 300px">Nombres</th>
                                        <th style="width: 200px">Apellidos</th>
                                        <th style="width: 50px">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include_once 'class/trancredito.php';
                                    $objpago = new Trancredito();
                                    $objpago->conec_base();
                                    $objpago->carga_creditos_vencer();
                                    ?>
                                </tbody>
                            </table>
                            <p style="font-size:20px"><b>
                                <legend>COBROS VENCEN HOY</legend>
                            </b></p>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr rol="row">
                                        <th style="width: 100px">Carpeta</th>
                                        <th style="width: 200px">Pago</th>
                                        <th style="width: 200px">Fecha Pago</th>
                                        <th style="width: 400px">Valor</th>
                                        <th style="width: 300px">Nombres</th>
                                        <th style="width: 200px">Apellidos</th>
                                        <th style="width: 50px">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include_once 'class/trancredito.php';
                                    $objpago = new Trancredito();
                                    $objpago->conec_base();
                                    $objpago->carga_creditos_hoy();
                                    ?>
                                </tbody>
                            </table>
                            <p style="font-size:20px"><b>
                                <legend>COBROS VENCIDOS</legend>
                            </b></p>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr rol="row">
                                        <th style="width: 100px">Carpeta</th>
                                        <th style="width: 200px">Pago</th>
                                        <th style="width: 200px">Fecha Pago</th>
                                        <th style="width: 400px">Valor</th>
                                        <th style="width: 300px">Nombres</th>
                                        <th style="width: 200px">Apellidos</th>
                                        <th style="width: 50px">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include_once 'class/trancredito.php';
                                    $objpago = new Trancredito();
                                    $objpago->conec_base();
                                    $objpago->carga_creditos_vencidos();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
