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
                        LISTA DE MODELOS POR MARCA Y TIPO
                    </div> 
                    <div class="table-responsive">                    
                        <div class="panel-body">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <center>
                                <div class="panel-body">
                                    <label>Agregar NUEVO MODELO</label>
                                    <br/>
                                    <label>Marca:</label>&nbsp;
                                    <!--<input list="lstmarca" name="veh_marca">-->
                                    <select id="veh_marca" name="veh_marca">
                                        <?php
                                            include_once 'class/marca.php';
                                            $objltmarca = new Marca();
                                            $objltmarca->conec_base();
                                            $objltmarca->mostrar_marca();
                                        ?>                    
                                    </select>
                                    &nbsp;&nbsp;
                                    <label>Modelo:</label>&nbsp;<input type="text" name="veh_modelo" style="text-transform:uppercase; width: 200px;" onkeyup="this.value=this.value.toUpperCase();">
                                    &nbsp;&nbsp;
                                    <label>Tipo:</label>&nbsp;
                                    <!--<input list="lstipo" name="veh_tipo">-->
                                    <select id="veh_tipo" name="veh_tipo">
                                        <?php
                                            include_once 'class/tipo.php';
                                            $objtipo = new Tipo();
                                            $objtipo->conec_base();
                                            $objtipo->mostrar_tipo();
                                        ?>                    
                                    </select>  
                                    &nbsp;&nbsp;
                                    <input type="submit" name="insertar_modelo" value="GUARDAR">
                                    &nbsp;&nbsp;
                                    <input type="reset" value="CANCELAR">
                                    &nbsp;&nbsp;
                                    <input type="submit" name="salir_para" value="SALIR">
                                </div>
                                </center>
                            </form>
                            <hr>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr rol="row">
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once 'class/modelo.php';
                                            $conn = new Modelo();
                                            $conn->conec_base();
                                            $conn->listar_modelo();
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