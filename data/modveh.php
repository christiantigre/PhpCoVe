<?php
if(!isset($_SESSION)){
session_start();
}  
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="../style/style.css" />
    </head>
    <body>
        <br>
    <center>
        <form action="inicio.php" method="POST">
            <fieldset>
                <legend>DATOS VEHICULO</legend>
                <label>Placa:</label>&nbsp;<input type="text" name="idveh_placa"  value="" disabled="on">
                &nbsp;&nbsp;
                <label>Marca:</label>&nbsp;<input type="text" name="veh_marca" value="<?php $veh_marca?>" disabled="on">
                &nbsp;&nbsp;
                <label>Modelo:</label>&nbsp;<input type="text" name="veh_modelo" value="" disabled="on">
                &nbsp;&nbsp;
                <label>Tipo:</label>&nbsp;<input type="text" name="veh_tipo" value="" disabled="on"> 
                <br><br>
                <label>A&ntilde;o:</label>&nbsp;<input type="text" name="veh_anio" value="" disabled="on" style="width: 50px">
                &nbsp;&nbsp;
                <label># Motor:</label>&nbsp;<input type="text" name="veh_motor" value="" disabled="on">
                &nbsp;&nbsp;   
                <label># Chasis:</label>&nbsp;<input type="text" name="veh_chasis" value="" disabled="">
                <br><br>                    
                <label>Kilometraje:</label>&nbsp;<input type="text" name="veh_km" value="" style="width: 115px">
                &nbsp;&nbsp;
                <label>Color1:</label>&nbsp;<input type="text" name="veh_color1" value="" disabled="on">
                &nbsp;&nbsp;
                <label>Color2:</label>&nbsp;<input type="text" name="veh_color2" value="" disabled="on">
                <br><br>
                <label>Matriculado en:</label>&nbsp; 
                <select name="veh_mat_lugar">
                    <?php
                        include_once 'class/lugar.php';
                        $objltlugar = new Lugar();
                        $objltlugar->conec_base();
                        $objltlugar->mostrar_lugar();
                    ?>                    
                </select>
                &nbsp;
                <label>Por el a&ntilde;o:</label>&nbsp;<input type="text" name="veh_mat_anio" value="" style="width: 50px">
                <!--&nbsp;&nbsp;-->
                <br><br>
                <input type="submit" name="modifica_veh" value="ACTUALIZAR">
                &nbsp;
                <input type="reset" value="CANCELAR">
                &nbsp;
                <input type="submit" name="vehiculos" value="REGRESAR">
            </fieldset>
        </form>
        <br>
    </body>
    </center>
</html>