<?php
if(!isset($_SESSION)){
session_start();
}  
?>
<!DOCTYPE html>
<html lang="es">
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
                        CLIENTES
                    </div>        
                    <div class="panel-body" style="font-size: 9px">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="mancli.php">
                                <div class="panel-body">
                                    <p>
                                        <!--<button class="btn btn-outline btn-primary"><a href="inicio.php?variable=listar_cliente">TODOS</a></button>-->
                                        <button type="button" title="NUEVO" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-plus-sign"></button>
                                    </p>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr rol="row">
                                            <th style="width: 100px">C&eacute;dula</th>
                                            <th style="width: 200px">Nombres</th>
                                            <th style="width: 200px">Apellidos</th>
                                            <th style="width: 400px">Direccion Casa</th>
                                            <th style="width: 300px">Correo</th>
                                            <th style="width: 200px">Ciudad</th>
                                            <th style="width: 50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once 'class/cliente.php';
                                        $objcli = new Cliente();
                                        $objcli->conec_base();
//                                        if(isset($_POST['buscar_cli'])){
//                                            $objcli->buscar_cliente($_POST['idcli_ident']);
//                                        }else{
                                            $objcli->listar_cliente();
//                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
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
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">NUEVO CLIENTE</h4>
              </div>
              <div class="modal-body" id="caja">
                    <?php
                        include 'addcli.php';
                    ?>                          
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body" id="caja">
                    <?php
                        include 'ver_cli.php';
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