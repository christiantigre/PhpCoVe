<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *  echo '<script language = javascript>
  alert("' . $placa . '")
  </script>';
 */

  session_start();
  error_reporting(0);
  error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
  $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
  if (isset($_POST["texto"])) {
//    if ($_GET["texto"])
    $placa = $_POST["texto"];
    $tipo  = $_POST["tipo"];
    $B_BUSCAR = "SELECT max(`tran_sec_tipo`) as max,`tran_cab_precio` FROM `tran_cab` WHERE"
                . " `tran_veh_placas` = '$placa' and tran_cab_tipo='INGRESO' "; //and tran_cab_tipo='$tipo'
                $rnom = mysqli_query($c, $B_BUSCAR);

                $vergastos="SELECT sum(monto) as gastos FROM `det_pag` where veh_datos_idveh_placa='$placa'";
                $rgst = mysqli_query($c, $vergastos);

                while ($row = mysqli_fetch_array($rnom)) {
                    $val = $row['tran_cab_precio'];
                    $tip = $row['max'];
                }
                while ($rowgst = mysqli_fetch_array($rgst)) {
                    $gasto = $rowgst['gastos'];
                }
                if ($gasto=="") {
                    $gastos=0;
                } else {
                    $gastos=$gasto;
                }
                
                echo $val.'-'.$gastos;
            }
            mysqli_close($c);
            ?>
