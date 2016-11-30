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
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default"  style="font-size: 9px">
<!--                    <div class="panel-heading">
                        NUEVO VEHICULO
                    </div>        -->
                    <div class="panel-body">
                        <div class="table-responsive">                        
                            <form method="POST" id="form" name="form" action="inicio.php">                        
                                <div><label>Placa:</label>&nbsp;<input type="text" name="idveh_placa" required="" autocomplete="on" style="text-transform:uppercase; width: 80px;" onkeyup="this.value=this.value.toUpperCase();" autofocus=""><label style="color: red">*</label>
                                <label>Vehiculo:</label>&nbsp;
                                <select id="veh_vehiculo" name="veh_vehiculo" required="" style="width: 250px">
                                    <?php
                                        include_once 'class/modelo.php';
                                        $objltmodelo = new Modelo();
                                        $objltmodelo->conec_base();
                                        $objltmodelo->mostrar_modelo_marca();
                                    ?>                    
                                </select></div>
                                <label>A&ntilde;o:</label>&nbsp; 
                                <input type="text" name="veh_anio" required="" style="width: 50px">
                                &nbsp;&nbsp;
                                <label># Motor:</label>&nbsp;
                                <input type="text" name="veh_motor" required="">
                                &nbsp;&nbsp;   
                                <label># Chasis:</label>&nbsp;
                                <input type="text" name="veh_chasis" required="">
                                </br>
                                <label>Color1:</label>&nbsp;
                                <input type="text" name="veh_color1" required="" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
                                &nbsp;&nbsp;
                                <label>Color2:</label>&nbsp;
                                <input type="text" name="veh_color2" required="" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
                                &nbsp;&nbsp;
                                <label>Kilometraje:</label>&nbsp;
                                <input type="text" name="veh_km" value="0" style="width: 115px">                
                                <hr>
                                <label>Matriculado en:</label>&nbsp; 
                                <select name="veh_mat_lugar" required="">
                                    <?php
                                        include_once 'class/lugar.php';
                                        $objltlugar = new Lugar();
                                        $objltlugar->conec_base();
                                        $objltlugar->mostrar_lugar();
                                    ?>                    
                                </select>
                                &nbsp;&nbsp;
                                <label>Por el a&ntilde;o:</label>&nbsp;
                                <input type="text" name="veh_mat_anio" required="" style="width: 50px">
                                <hr>
                                <label>Estado:</label>&nbsp;
                                <select name="veh_estado" required="">
                                    <option> </option>
                                    <option value="0">CONSIGNACION</option>
                                    <option value="1">COMISION</option>
                                </select>
                                <br><br>
                                <input type="submit" name="guarda_vehiculo" value="GUARDAR">
                                <!--<a href='inicio.php?variable=guarda_vehiculo' data-toggle='modal''>GUARDAR</a>-->                               
                                <!--<button type="submit" id="inserta_veh" name="inserta_veh">GUARDAR</button>-->
                                &nbsp;
                                <input type="reset" value="CANCELAR">
<!--                                &nbsp;
                                <input type="submit" name="vehiculos" value="REGRESAR">-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery Version 1.11.0 -->
        <script src="../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/sb-admin-2.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
        </script>        
    </body>
</html>