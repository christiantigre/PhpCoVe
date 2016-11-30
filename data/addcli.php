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
        <title>Control Parqueadero</title>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default" style="font-size: 9px">
    
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form method="POST" id="form" name="form" action="inicio.php">
                                <label>C&eacute;dula:</label> &nbsp; <input type="text" name="idcli_ident" required="" size="10px" autocomplete="off" autofocus="">
                                &nbsp;&nbsp;
                                <div><label>Nombres:</label> &nbsp;<input type="text" name="cli_nombre" required="" autocomplete="off" style="width: 200px" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
                                &nbsp;&nbsp;
                                <label>Apellidos:</label> &nbsp;<input type="text" name="cli_apellido" required="" autocomplete="off" style="width: 200px" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></div>
                                <label>Direcci&oacute;n principal:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>Direcci&oacute;n Oficina-Trabajo:</label>
                                <textarea name="cli_dir_casa" cols="40" rows="1" required="" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <textarea name="cli_dir_tra" cols="40" rows="1" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
                                <label>Tel&eacute;fonos fijos:</label> &nbsp; <input type="text" name="cli_tel_fijos" autocomplete="off" style="width: 150px">
                                &nbsp;&nbsp;
                                <label>Tel&eacute;fonos celulares:</label> &nbsp; <input type="text" name="cli_tel_cel" autocomplete="off" style="width: 150px">
                                &nbsp;&nbsp;
                                <label>Correo electr&oacute;nico:</label> &nbsp;<input type="text" name="cli_correo" autocomplete="off" style="width: 250px">
                                &nbsp;&nbsp;
                                <div><label>Origen:</label>
                                    <select id="cli_ciudad" name="cli_ciudad" required="">
                                        <?php
                                        include_once 'class/lugar.php';
                                        $objlugar = new Lugar();
                                        $objlugar->conec_base();
                                        $objlugar->mostrar_lugar();
                                        ?>                
                                </select>
                                    </br>
                                <label>Estado civil:</label>&nbsp; 
                                <select id="cli_est_civ" name="cli_est_civ" required="" style="width: 150px">
                                    <option value=" "> </option>
                                    <option value="SOLTERO/A">SOLTERO/A</option>
                                    <option value="CASADO/A">CASADO/A</option>
                                    <option value="DIVORCIADO/A">DIVORCIADO/A</option>
                                    <option value="VIUDO/A">VIUDO/A</option>
                                </select></div>
                                <label>Nombre conyuge:</label>&nbsp;<input type="text" name="cli_conyuge" autocomplete="off" style="text-transform:uppercase; width: 250px;" onkeyup="this.value=this.value.toUpperCase();">
                                </br>
                                <label>Cedula conyuge:</label>&nbsp;<input type="text" name="ced_conyuge" >
                                <hr>
                                <label>Referencia:</label> &nbsp; <input type="text" name="cli_nom_ref" autocomplete="off" size="30px" style="text-transform:uppercase; width: 250px;" onkeyup="this.value=this.value.toUpperCase();">
                                </br>
                                <label>Direcci&oacute;n referencia:</label></br>
                                <textarea name="cli_dir_ref" cols="40" rows="2" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
                                &nbsp;
                                <label>Tel&eacute;fonos referencia:</label> &nbsp;<input type="text" name="cli_tel_ref" autocomplete="off" style="width: 150px">
                                <br><br>
                                <input type="submit" name="guarda_cliente" value="GUARDAR">
                                &nbsp;
                                <input type="reset" value="CANCELAR">
<!--                                &nbsp;
                                <input type="submit" name="clientes" value="REGRESAR">-->
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