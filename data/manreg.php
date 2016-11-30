<?php
if(!isset($_SESSION)){
session_start();
}  
?>
<!DOCTYPE html>
<html>
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
                        HISTORIAL
                    </div>        
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <label>Historial de:</label>&nbsp;
                                <input type="date" name="fec_arc">&nbsp;&nbsp;
                                <input type="submit" name="ver_reg" value="REGISTRO">&nbsp;
                                <input type="submit" name="salir_admin" value="SALIR">  
                                <br><br>
                            <?php
                                if(isset($_POST['fec_arc'])){
                                    $fecha = $_POST['fec_arc'];
                                    $dia= substr($fecha, 8, 2);
                                    $mes= substr($fecha, 5, 2);
                                    $anio= substr($fecha, 0, 4);
                                    $fec_arc = $dia.$mes.$anio;
                                    include_once 'class/registro.php';
                                    $objreg = new Registro();
                                    $objreg->mostrar($fec_arc);                
                    //            $nom_arc = $fec_arc;
                    //            $nombre_archivo = "document/$nom_arc";            
                    //            if(file_exists($nombre_archivo)) 
                    //            {
                    //                echo  nl2br(file_get_contents($nombre_archivo));
                    //            }
                    //            else
                    //            {
                    //                $mensaje = "El archivo no existe";
                    //            }
                                }
                            ?>
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
        
        <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
        </script>                                       
    </body>
</html>
