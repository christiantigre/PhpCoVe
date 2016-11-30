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
                        DATOS DE LA EMPRESA
                    </div>        
                    <div class="panel-body" style="font-size: 9px">
                        <?php
                            include_once 'class/datempre.php';
                            $objempre = new Empresa();
                            $objempre->mostrarempresa();
                        ?>
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
