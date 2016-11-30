<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$placa = $_GET['idveh_placa'];
// echo  $placa ;

$conn = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
$c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');



$query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
        . "veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, "
        . "veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
        . "veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, "
        . "veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, "
        . "veh_tipo, mat_lugar where veh_datos.idveh_placa = '$placa' "
        . "and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo "
        . "and veh_marca.idveh_marca=veh_vehiculo.veh_marca "
        . "and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo "
        . "and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar";
$resveh = mysqli_query($conn, $query);
$row_cnt = $resveh->num_rows;
while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
    $tran_veh_placas = $datomarca['idveh_placa'];
    $veh_marca = $datomarca['veh_marca'];
    $veh_modelo = $datomarca['veh_modelo'];
    $veh_tipo_des = $datomarca['veh_tipo_des'];
    $veh_anio = $datomarca['veh_anio'];
    $veh_motor = $datomarca['veh_motor'];
    $veh_chasis = $datomarca['veh_chasis'];
    $veh_km = $datomarca['veh_km'];
    $veh_color1 = $datomarca['veh_color1'];
    $veh_color2 = $datomarca['veh_color2'];
    $veh_mat_lugar = $datomarca['mat_lugar'];
    $veh_mat_anio = $datomarca['veh_mat_anio'];
    switch ($datomarca['veh_estado']) {
        case 0:
            $estado = 'CONSIGNACION';
            break;
        case 1:
            $estado = 'COMISION';
            break;
        case 2:
            $estado = 'VENDIDO';
            break;
    }
}
if ($row_cnt != 0) {
    ?>

    <p style="font-size:15px; text-align: left">
        <!--            <label>Placa:</label>&nbsp; -->
        <label>Estado:</label>&nbsp; <input type="text" name="estado" id="estado" value="<?php echo $estado; ?>" disabled=""/> 
        &nbsp;&nbsp;
        <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" style="width: 250px" disabled=""/>
        &nbsp;&nbsp;
        <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>Kilometraje:</label>&nbsp; <input type="text" name="veh_km" style="width: 80px" value="<?php echo $veh_km; ?>" disabled=""/>             
        <br>
        <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>Color 2</label>&nbsp; <input type="text" name="veh_color2" value="<?php echo $veh_color2; ?>" disabled=""/>            
        &nbsp;&nbsp;
        <label>Chasis:</label>&nbsp; <input type="text" name="veh_chasis" style="width: 150px" value="<?php echo $veh_chasis; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>Motor</label>&nbsp; <input type="text" name="veh_motor" style="width: 150px" value="<?php echo $veh_motor; ?>" disabled=""/>
        <br>
        <label>Matriculado en:</label>&nbsp; <input type="text" name="veh_mat_lugar" value="<?php echo $veh_mat_lugar; ?>" disabled=""/>
        &nbsp;&nbsp;
        <label>Por el a&ntilde;o:</label>&nbsp; <input type="text" name="veh_mat_anio" value="<?php echo $veh_mat_anio; ?>" disabled=""/>
        &nbsp;&nbsp;
    </p>
    <?Php
} else {
        ?>
    <p style="font-size:13px; text-align: center; color: #CC0000;">
        <label>No tiene registro </label>&nbsp;&nbsp;
        </br>
    </p>
    <?Php
}
?>

<?php
$sql = "SELECT * FROM `t_auxiliar` WHERE `placa_id`='$placa' ";
$result = mysqli_query($c, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $varveh = $row["cod_cauxiliar"];
    $varta = $row["nombre_cauxiliar"];
    ?>
    <p style="font-size:13px; text-align: left">
        <label>Cod. Cuenta :</label>&nbsp;&nbsp;
        <input type="text" style="width:200px;" id="cod_veh" name="cod_veh" value="<?php echo $varveh; ?>" readonly="readonly" disabled="" placeholder="Cod."/>&nbsp;&nbsp;
        <br>
        <label>Nombre Cuenta :</label>&nbsp;&nbsp;
        <input type="text" name="nom_cte_veh" style="width: 250px" id="nom_cte_veh" value="<?Php echo $varta; ?>"/>
        <!--</p>-->
        <?php
    } else {
        ?>
    <p style="font-size:13px; text-align: center; color: #CC0000;">
        <label>No tiene registro contable</label>&nbsp;&nbsp;
        </br>
    </p>
    <?Php
}

$query = "SELECT max(`tran_sec_tipo`) as max,`tran_cab_precio` FROM `tran_cab` WHERE"
                . " `tran_veh_placas` = '$placa' and tran_cab_tipo='INGRESO' order by tran_sec_tipo";
        $res_val = mysqli_query($conn, $query) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res_val)) {
            $val = $row['tran_cab_precio'];
            $tip = $row['max'];
        }
    ?>
                    <!--<p style="font-size:13px; text-align: left">-->
            <label>Precio ultimo <?Php echo "INGRESO"; ?></label>&nbsp;&nbsp;
            <input type="text" style="width:200px;" id="val_veh" name="val_veh" value="<?php echo $val; ?>" readonly="readonly" disabled="" placeholder="Cod."/>&nbsp;&nbsp;
            </p>
            <?Php

mysqli_close($c);
mysqli_close($conn);

