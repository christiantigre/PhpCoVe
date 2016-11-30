<?php
    date_default_timezone_set("America/Guayaquil");
    $fecha = date("Y-m-d");
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
                            COBRO DE CREDITOS
                        </div>        
                        <div class="panel-body"  style="font-size: 9px">
                            <div class="table-responsive">
                                <form method="POST" id="form" name="form" action="inicio.php">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr rol="row">
                                            <th>Carpeta</th>
                                            <th>Fecha</th>
                                            <th>Transacción</th>
                                            <th>Placa</th>
                                            <th>Cliente</th>
                                            <th>Precio</th>
                                            <th>Seguro</th>
                                            <th>Gastos</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once 'class/cobrosclass.php';
                                        $objtrs = new Cobros();
                                        $objtrs->conec_base();
                                        if (isset($_POST['buscar_cobcar'])) {
                                            $objtrs->buscar_transcarp($_POST['txt_carpeta']);
                                            echo '<hr><br>';
                                            echo '<h1>VEHICULO</h1>';
                                            $objtrs->buscar_veh_cob($_POST['txt_carpeta']);
                                            echo '<hr><br>';
                                            echo '<h1>CLIENTE</h1>';
                                            $objtrs->buscar_cliente_cob($_POST['txt_carpeta']);
                                        } else if (isset($_POST['buscar_cobcli'])) {
                                            $objtrs->buscar_transcli($_POST['txt_idcli']);
                                        } elseif (isset($_POST['buscar_cobveh'])) {
                                            $objtrs->buscar_transveh($_POST['txt_idveh']);
                                        } elseif (isset($_POST['verpendientes'])) {
                                            $objtrs->verpendientes();
                                        } elseif (isset ($_POST['verpagados'])) {
                                            $objtrs->verpagados();
                                        }else {
                                            $objtrs->listar_trans();
                                        }
                                        include_once 'class/cobrosclass.php';
                                        $objtrs = new Cobros();
                                        $objtrs->conec_base();
                                        if (isset($_POST['buscar_cobcar'])) {
                                            $objtrs->detalle_transaccob($_POST['txt_carpeta']);
                                        }
                                        include_once 'class/cobrosclass.php';
                                        $objtrs = new Cobros();
                                        $objtrs->conec_base();
                                        if (isset($_POST['buscar_cobcar'])) {
                                            $objtrs->ver_creditoscob($_POST['txt_carpeta']);
                                        }
                                        ?>
                                        <!--<input type="reset" value="CANCELAR">-->
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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