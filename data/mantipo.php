<?php
if(!isset($_SESSION)){
session_start();
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
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default" style="font-size: 9px">
                    <div class="panel-heading">
                        TIPOS DE VEHICULOS
                    </div>        
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <center>
                                <div class="panel-body">
                                    <label>Agregar TIPO:</label> &nbsp;<input type="text" name="veh_tipo_des" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();" autocomplete="off">
                                    <br><br>
                                    <input type="submit" name="inserta_tipo" value="GUARDAR">
                                    &nbsp;&nbsp;
                                    <input type="reset" value="CANCELAR">
                                    &nbsp;&nbsp;
                                    <input type="submit" name="salir_para" value="SALIR"></a>
                                </div>
                                </center>
                            </form>
                            <hr>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr rol="row">
                                        <!--<th style="width: 100px">Orden</th>-->
                                        <th style="width: 200px">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include_once 'class/tipo.php';
                                        $objcon = new Tipo('*');
                                        $objcon->conec_base();
                                        $objcon->listar_tipo();
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
        
        <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
        </script>         
    </body>
</html>