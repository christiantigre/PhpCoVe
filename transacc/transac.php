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
                        TRANSACCIONES
                    </div>        
                    <div class="panel-body"  style="font-size: 9px">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <div class="panel-body">
                                    <p>
                                        <button type="submit" title="NUEVA" name="nueva_trs" class="btn btn-outline btn-info glyphicon glyphicon-pencil"></button>
                                    </p>
                                </div>                        
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once 'class/transacc.php';
                                            $objtrs = new Transacc();
                                            $objtrs->conec_base();
//                                            if(isset($_POST['buscar_com_trs'])){
//                                                $objtrs->buscar_trans($_POST['idtran_cab']);
//                                            }else{
                                                $objtrs->listar_trans();
//                                            }
                                        ?>
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
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body" id="caja">
                <?php
                    include 'ver_veh.php';
                ?>
              </div>
            </div>
          </div>
        </div>
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
        </script>        
    </body>
</html>