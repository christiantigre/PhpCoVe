<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!isset($_SESSION)) {
    session_start();
}

$cc = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
$c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
$query1 = "SELECT * FROM `t_auxiliar` WHERE `placa_id`= '" .$_POST['tran_veh_placas']. "' ";
$query2 = "SELECT * FROM `t_auxiliar` WHERE `cli_id`='" . $_POST['tran_cli_ident'] . "' ";
$result1 = mysqli_query($cc, $query1) or trigger_error("Query Failed! SQL: $query1 - Error: " . mysqli_error($cc), E_USER_ERROR);
$result2 = mysqli_query($cc, $query2) or trigger_error("Query Failed! SQL: $query2 - Error: " . mysqli_error($cc), E_USER_ERROR);
$row1 = mysqli_fetch_assoc($result1);
$row2 = mysqli_fetch_assoc($result2);
$dato1 = $row1["cod_cauxiliar"];
$dato2 = $row2["cod_cauxiliar"];
$query = "INSERT INTO `gen_ass_temp` ( `tip_pg`, `frm`, `doc`, `mnt`, `fecha`, `interes`, `plazo`, `estado`, `concepto`, `user`, `transacc`, `carpeta`,cli,veh,cod_cli,cod_veh,tot_val_veh) VALUES"
        . " ( '".$_POST['pago']."','".$_POST['forma']."', '".$_POST['dcto']."','".$_POST['valor']."', '".$_POST['fecha_det']."','".$_POST['interes']."',
        '".$_POST['plazo']."','".$_POST['lststd']."','".$_SESSION['user']."','".$_REQUEST['tipo']."','".$_POST['idtran_cab']."',"
        . "'".$_POST['tran_cli_ident']."','".$_POST['tran_veh_placas']."','".$_POST['total']."' );";
mysqli_query($c, $query);
$cc->close();
$c->close();
echo '<script>alert("Guardado")</script>';