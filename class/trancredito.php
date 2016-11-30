<?php
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Trancredito {

    public $idtran_cre_cab;
    public $tran_cre_sec;
    public $tran_cre_dcto;
    public $tran_cre_valor;
    public $tran_cre_fecha;
    public $tran_cre_fecha_pago;
    public $tran_cre_estado;

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function cobro() {
        global $numcre, $numsec;
        $con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query = "UPDATE tran_cre SET tran_cre_fecha_pago = '" . date("Y-m-d") . "' where idtran_cre_cab = '" . $numcre . "' and tran_cre_sec = '" . $numsec . "'";
        mysqli_query($con, $query);
    }

    function carga_creditos_vencer() {
        $conn = $this->objconec;
        $fecha1 = strtotime('-5 day', strtotime(date("Y-m-d")));
        $fecha2 = strtotime('-1 day', strtotime(date("Y-m-d")));
        $query = "SELECT tran_cre.idtran_cre_cab, tran_cre.tran_cre_sec, tran_cre.tran_cre_fecha_venc, "
                . "tran_cre.tran_cre_cuota, tran_cre.tran_cre_estado, tran_cab.idtran_cab, tran_cab.tran_cli_ident, "
                . "cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido FROM tran_cre, tran_cab, cli_datos "
                . "WHERE tran_cab.idtran_cab = tran_cre.idtran_cre_cab AND cli_datos.idcli_ident = tran_cab.tran_cli_ident "
                . "AND tran_cre.tran_cre_fecha_venc BETWEEN '$fecha1' AND '$fecha2' AND tran_cre.tran_cre_estado = 0";
        $verpagos = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td width=50>CARPETA</td><td width=30>PAGO</td>"
//        . "<td width=90>FECHA PAGO</td><td width=70>VALOR</td><td width=180>NOMBRE</td><td width=180>APELLIDO</td>"
//        . "<td width=70>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($verpagos, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td align='center'>" . $datocred['idtran_cre_cab'] . "</td>";
//            echo "<td align='center'>" . $datocred['tran_cre_sec'] . "</td>";
            if (($datocred['tran_cre_sec']) > 899) {
                $cre_sec = 'ADICIONAL';
            } else {
                $cre_sec = $datocred['tran_cre_sec'];
            }
            echo "<td align='center'>" . $cre_sec . "</td>";
            echo "<td align='center'>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td align='right'>" . number_format($datocred['tran_cre_cuota'], 2) . "</td>";
            echo "<td align='right'>" . $datocred['cli_nombre'] . "</td>";
            echo "<td align='right'>" . $datocred['cli_apellido'] . "</td>";
            if (($datocred['tran_cre_estado'] == 0)) {
                $tran_cre_estado = "PENDIENTE";
            }
            echo "<td>" . $tran_cre_estado . "</td>";

            echo "</tr>";
        }
//        echo "</table>";
        mysqli_close($conn);
    }

    function carga_creditos_hoy() {
        $conn = $this->objconec;
        $fecha = date("Y-m-d");
        $query = "SELECT tran_cre.idtran_cre_cab, tran_cre.tran_cre_sec, tran_cre.tran_cre_fecha_venc, "
                . "tran_cre.tran_cre_cuota, tran_cre.tran_cre_estado, tran_cab.idtran_cab, tran_cab.tran_cli_ident, "
                . "cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido FROM tran_cre, tran_cab, cli_datos "
                . "WHERE tran_cab.idtran_cab = tran_cre.idtran_cre_cab AND cli_datos.idcli_ident = tran_cab.tran_cli_ident "
                . "AND tran_cre.tran_cre_fecha_venc = '$fecha' AND tran_cre.tran_cre_estado = 0";
        $verpagos = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td width=50>CARPETA</td><td width=30>PAGO</td>"
//        . "<td width=90>FECHA PAGO</td><td width=70>VALOR</td><td width=180>NOMBRE</td><td width=180>APELLIDO</td>"
//        . "<td width=70>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($verpagos, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td align='center'>" . $datocred['idtran_cre_cab'] . "</td>";
//            echo "<td align='center'>" . $datocred['tran_cre_sec'] . "</td>";
            if (($datocred['tran_cre_sec']) > 899) {
                $cre_sec = 'ADICIONAL';
            } else {
                $cre_sec = $datocred['tran_cre_sec'];
            }
            echo "<td align='center'>" . $cre_sec . "</td>";
            echo "<td align='center'>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td align='right'>" . number_format($datocred['tran_cre_cuota'], 2) . "</td>";
            echo "<td align='right'>" . $datocred['cli_nombre'] . "</td>";
            echo "<td align='right'>" . $datocred['cli_apellido'] . "</td>";
            if (($datocred['tran_cre_estado'] == 0)) {
                $tran_cre_estado = "PENDIENTE";
            }
            echo "<td>" . $tran_cre_estado . "</td>";

            echo "</tr>";
        }
//        echo "</table>";
        mysqli_close($conn);
    }

    function carga_creditos_vencidos() {
        $conn = $this->objconec;
        $fecha = date("Y-m-d");
        $query = "SELECT tran_cre.idtran_cre_cab, tran_cre.tran_cre_sec, tran_cre.tran_cre_fecha_venc, "
                . "tran_cre.tran_cre_cuota, tran_cre.tran_cre_estado, tran_cab.idtran_cab, tran_cab.tran_cli_ident, "
                . "cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido FROM tran_cre, tran_cab, cli_datos "
                . "WHERE tran_cab.idtran_cab = tran_cre.idtran_cre_cab AND cli_datos.idcli_ident = tran_cab.tran_cli_ident "
                . "AND tran_cre.tran_cre_fecha_venc < '$fecha' AND tran_cre.tran_cre_estado = 0";
        $verpagos = mysqli_query($conn, $query);
        echo "<form action='inicio.php' method='POST'>";
//        echo "<table border=1><tr align=center style='color:red'><td width=50>CARPETA</td><td width=30>PAGO</td>"
//        . "<td width=90>FECHA PAGO</td><td width=70>VALOR</td><td width=180>NOMBRE</td><td width=180>APELLIDO</td>"
//        . "<td width=70>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($verpagos, MYSQLI_BOTH)) {
            $datocab = $datocred['idtran_cre_cab'];
            $datosec = $datocred['tran_cre_sec'];
            echo "<tr>";
            echo "<td align='center'>" . $datocred['idtran_cre_cab'] . "</td>";
//            echo "<td align='center'>" . $datocred['tran_cre_sec'] . "</td>";
            if (($datocred['tran_cre_sec']) > 899) {
                $cre_sec = 'ADICIONAL';
            } else {
                $cre_sec = $datocred['tran_cre_sec'];
            }
            echo "<td align='center'>" . $cre_sec . "</td>";
            echo "<td align='center'>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td align='right'>" . number_format($datocred['tran_cre_cuota'], 2) . "</td>";
            echo "<td align='right'>" . $datocred['cli_nombre'] . "</td>";
            echo "<td align='right'>" . $datocred['cli_apellido'] . "</td>";
            if (($datocred['tran_cre_estado'] == 0)) {
                $tran_cre_estado = "PENDIENTE";
            }
            echo "<td>" . $tran_cre_estado . "</td>";
//            echo "<td align='center'>"
//            . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";

            echo "</tr>";
        }
//        echo "</table>";
        echo "</form>";
        mysqli_close($conn);
    }

    function carga_creditos() {
        $conn = $this->objconec;
        $query = "update tran_cre set tran_cre_fecha_pago = $fecha, tran_cre_estado = '1' where";
    }

    function ver_creditos($numtra) {
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cre where idtran_cre_cab = '$numtra' order by tran_cre_fecha_venc";
        $vercred = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td width=40># PAGO</td><td width=80>FECHA PAGO</td>"
//        . "<td width=80>PAGADO EL</td>"
//        . "<td width=60>VALOR</td>"
//        . "<td width=50>INTERES</td>"
//        . "<td width=60>CAPITAL</td>"
//        . "<td width=60>SALDO</td>"
//        . "<td width=70>ABONO</td>"
//        . "<td width=60>ESTADO</td>"
//        . "</tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            echo "<tr>";
            $datocred['idtran_cre_cab'];
            $suma = $datocred['tran_cre_cuota'] - $datocred['abono'];
//            $datocred['tran_cre_cuota']
            if (($datocred['tran_cre_sec']) > 899) {
                $cre_sec = 'ADICIONAL';
            } else {
                $cre_sec = $datocred['tran_cre_sec'];
            }
            echo "<td align='center'>" . $cre_sec . "</td>";
            echo "<td align='center'>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td align='center'>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td align='right'>" . number_format($suma, 2) . "</td>";
            echo "<td align='right'>" . number_format($datocred['tran_cre_interes'], 2) . "</td>";
            echo "<td align='right'>" . number_format($datocred['tran_cre_monto'], 2) . "</td>";
//            echo "<td align='right'>" . number_format($datocred['tran_cre_sal'], 2) . "</td>";
            echo "<td align='right'>" . number_format($datocred['abono'], 2) . "</td>";
//        echo "<td>" .$datocred['tran_cre_estado']."</td>";
            if ($datocred['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
            echo "<td align='center'><a href='inicio.php?variable=paga_credito&pagacre=". $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] ."' data-toggle='modal''><button type='button' title='PAGAR' class='btn btn-outline btn-info glyphicon glyphicon glyphicon-usd'></button></a></td>";                            
//                echo "<td align='center'><button name='pagacre' value='" . $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] . "'>PAGAR</button></td>";
            echo "<td align='center'><a href='inicio.php?variable=abono_credito&abonocre=". $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] ."' data-toggle='modal''><button type='button' title='ABONAR' class='btn btn-outline btn-info glyphicon glyphicon glyphicon-edit'></button></a></td>";                            
//            echo "<td align='center'><button name='abonocre' value='" . $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] . "'>ABONO</button></td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
                echo "<td align='center'><a href='inicio.php?variable=ver_abonos&verabono=". $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] ."' data-toggle='modal''><button type='button' title='VER ABONOS REALIZADOS' class='btn btn-outline btn-info glyphicon glyphicon-eye-open'></button></a></td>";                            
//                echo "<td align='center'><button name='verabono' value='" . $datocred['idtran_cre_cab'] . "-" . $datocred['tran_cre_sec'] . "'>VER ABONOS</button></td>";
            }
            echo "</tr>";
        }
//        echo "</table>";
        mysqli_close($conn);
    }

    function paga_credito() {
        date_default_timezone_set("America/Guayaquil");
        $fecha = date('Y-m-d');
        global $numcre, $numsec;
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cre where idtran_cre_cab = '$numcre' and tran_cre_sec = '$numsec'";
        $subquery = "select * from tran_cab where idtran_cab='" . $numcre . "'";
        $vercred = mysqli_query($conn, $query);
        echo '<hr><br>';
        echo '<h1>COBRO POR REALIZAR</h1>';
        echo "<table border=1><tr align=center style='color:red'>"
        . "<td width=40>CARPETA</td>"
        . "<td width=40># PAGO</td>"
        . "<td width=80>FECHA PAGO</td>"
        . "<td width=80>PAGADO EL</td>"
        . "<td width=60>VALOR</td>"
        . "<td width=50>INTERES</td>"
        . "<td width=60>CAPITAL</td>"
        . "<td width=60>SALDO</td>"
        . "<td width=60>ABONO</td>"
        . "<td width=60>ESTADO</td>"
        . "</tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            $numcuota = $datocred['tran_cre_sec'];
            $valorcuota = $datocred['tran_cre_cuota'];
            $suma = $datocred['tran_cre_cuota'] - $datocred['abono'];
            echo "<tr>";
            echo "<td>" . $datocred['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $suma . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
            echo "<td>" . $datocred['abono'] . "</td>";
            echo "<td></td>";
        }
        echo "</tr>";
        echo "</table>";

        $numcre = $datocred['idtran_cre_cab'];
        $numsec = $datocred['tran_cre_sec'];


        $versubquery = mysqli_query($conn, $subquery);
        while ($datosubquery = mysqli_fetch_array($versubquery, MYSQLI_BOTH)) {
            $placac = $datosubquery['tran_veh_placas'];
            $idclien = $datosubquery['tran_cli_ident'];
        }
        echo '<hr><br>';
        echo '<h1>VEHICULO</h1>';

        $query1 = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
        veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.tran_veh_placas='" . $placac . "'";
        $resveh = mysqli_query($conn, $query1);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
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
        $veh_estado = $datomarca['veh_estado'];
        ?>
        <p style="font-size:9px; text-align: left">
            <!--            <label>Placa:</label>&nbsp; -->
            <?php //echo $tran_veh_placas;     ?> 
            <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" disabled=""/>
            &nbsp;&nbsp;
        </p>
        <?php
        echo '<hr><br>';
        echo '<h1>CLIENTE</h1>';
        $query3 = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident and tran_cab.tran_cli_ident='" . $idclien . "'";
        $resveh = mysqli_query($conn, $query3);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
        $idcli_ident = $datomarca['idcli_ident'];
        $cli_nombre = $datomarca['cli_nombre'];
        $cli_apellido = $datomarca['cli_apellido'];
        $cli_dir_casa = $datomarca['cli_dir_casa'];
        $cli_dir_tra = $datomarca['cli_dir_tra'];
        $cli_tel_fijos = $datomarca['cli_tel_fijos'];
        $cli_tel_cel = $datomarca['cli_tel_cel'];
        $cli_correo = $datomarca['cli_correo'];
        $cli_ciudad = $datomarca['cli_ciudad'];
        $cli_nom_ref = $datomarca['cli_nom_ref'];
        $cli_dir_ref = $datomarca['cli_dir_ref'];
        $cli_tel_ref = $datomarca['cli_tel_ref'];
        $cli_est_civ = $datomarca['cli_est_civ'];
        $cli_conyuge = $datomarca['cli_conyuge'];
        ?>
        <p style="font-size:9px; text-align: left">
            <!--    <label>C&eacute;cula:</label>&nbsp; <?php echo $idcli_ident ?> -->
            <label>Cliente :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="text" name="cli_nombre" style="width: 300px" value="<?php echo $cli_nombre . " " . $cli_apellido ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tel&eacute;fonos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="cli_tel_fijos" style="width: 300px" value="<?php echo $cli_tel_fijos . ' ' . $cli_tel_cel ?>" disabled=""/>
            <br>
            <label>Correo Electr&oacute;nico:</label><input type="text" name="cli_correo" style="width: 300px" value="<?php echo $cli_correo ?>" />
            &nbsp;&nbsp;
            <label>Direcci&oacute;n casa:</label>&nbsp; 
            <textarea name="cli_dir_casa" cols="55" rows="2" disabled=""><?php echo $cli_dir_casa ?></textarea>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <?php
    }

    function abono_credito() {
        date_default_timezone_set("America/Guayaquil");
        $fecha = date('Y-m-d');
        global $numcre, $numsec;
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cre where idtran_cre_cab = '$numcre' and tran_cre_sec = '$numsec'";
        $subquery = "select * from tran_cab where idtran_cab='" . $numcre . "'";
        $vercred = mysqli_query($conn, $query);
        echo '<hr><br>';
        echo '<h1>COBRO POR REALIZAR</h1>';
        echo "<table border=1><tr align=center style='color:red'>"
        . "<td width=40>CARPETA</td>"
        . "<td width=40># PAGO</td>"
        . "<td width=80>FECHA PAGO</td>"
        . "<td width=80>PAGADO EL</td>"
        . "<td width=60>VALOR</td>"
        . "<td width=50>INTERES</td>"
        . "<td width=60>CAPITAL</td>"
        . "<td width=60>SALDO</td>"
        . "<td width=60>ABONO</td>"
        . "<td width=60>ESTADO</td>"
        . "</tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            $numcuota = $datocred['tran_cre_sec'];
            $valorcuota = $datocred['tran_cre_cuota'];
            $suma = ($datocred['tran_cre_cuota']) - ($datocred['abono']);
            echo "<tr>";
            echo "<td>" . $datocred['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $suma . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
            echo "<td>" . $datocred['abono'] . "</td>";
            if ($datocred['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
            }
        }
        echo "</tr>";
        echo "</table>";

        echo '<hr><br>';
        echo '<h1>ABONO</h1>';
        ?>


        <center>
            <p style="font-size:9px; text-align: left">
                <?php //echo $tran_veh_placas;    ?> 
                <input type="hidden" id="cuotavalor" name="cuotavalor" value="<?php echo $valorcuota; ?>" disabled=""/>
                <label>Cuota Numero:</label>&nbsp; <input type="text" id="cuota" name="cuota" value="<?php echo $numcuota; ?>" disabled=""/>
                &nbsp;&nbsp;
                <label>Fecha abono :</label>&nbsp; <input type="text" id="fechaabono" name="fechaabono" value="<?php echo $fecha; ?>" readonly="readonly"/>
                &nbsp;&nbsp;
                </br>
                <input type="hidden" name="valorcuota" id="valorcuota" value="<?Php echo $suma; ?>" />
                <label>Valor de abono a esta cuota :</label>&nbsp; <input type="number" name="valorabono" id="valorabono" onchange="velidavalor();" onblur="mensaje();"  value="" />
                &nbsp;&nbsp;
                
                <label>Detalles :</label>&nbsp; 
                <!--<input type="text" name="detallabono" style="width:120px;" value="" />-->
                <textarea name="detallabono" cols="55" rows="2" placeholder="Máx 255 caracteres..." maxlength="255"></textarea>
                </br>
                &nbsp;&nbsp;
            </p>
        </center>
        <?php
        $numcre = $datocred['idtran_cre_cab'];
        $numsec = $datocred['tran_cre_sec'];


        $versubquery = mysqli_query($conn, $subquery);
        while ($datosubquery = mysqli_fetch_array($versubquery, MYSQLI_BOTH)) {
            $placac = $datosubquery['tran_veh_placas'];
            $idclien = $datosubquery['tran_cli_ident'];
        }
        echo '<hr><br>';
        echo '<h1>VEHICULO</h1>';

        $query1 = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
        veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.tran_veh_placas='" . $placac . "'";
        $resveh = mysqli_query($conn, $query1);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
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
        $veh_estado = $datomarca['veh_estado'];
        ?>
        <p style="font-size:9px; text-align: left">
            <!--            <label>Placa:</label>&nbsp; -->
            <?php //echo $tran_veh_placas;     ?> 
            <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" disabled=""/>
            &nbsp;&nbsp;
        </p>
        <?php
        echo '<hr><br>';
        echo '<h1>CLIENTE</h1>';
        $query3 = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident and tran_cab.tran_cli_ident='" . $idclien . "'";
        $resveh = mysqli_query($conn, $query3);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
        $idcli_ident = $datomarca['idcli_ident'];
        $cli_nombre = $datomarca['cli_nombre'];
        $cli_apellido = $datomarca['cli_apellido'];
        $cli_dir_casa = $datomarca['cli_dir_casa'];
        $cli_dir_tra = $datomarca['cli_dir_tra'];
        $cli_tel_fijos = $datomarca['cli_tel_fijos'];
        $cli_tel_cel = $datomarca['cli_tel_cel'];
        $cli_correo = $datomarca['cli_correo'];
        $cli_ciudad = $datomarca['cli_ciudad'];
        $cli_nom_ref = $datomarca['cli_nom_ref'];
        $cli_dir_ref = $datomarca['cli_dir_ref'];
        $cli_tel_ref = $datomarca['cli_tel_ref'];
        $cli_est_civ = $datomarca['cli_est_civ'];
        $cli_conyuge = $datomarca['cli_conyuge'];
        ?>
        <p style="font-size:9px; text-align: left">
            <!--    <label>C&eacute;cula:</label>&nbsp; <?php echo $idcli_ident ?> -->
            <label>Cliente :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="text" name="cli_nombre" style="width: 300px" value="<?php echo $cli_nombre . " " . $cli_apellido ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tel&eacute;fonos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="cli_tel_fijos" style="width: 300px" value="<?php echo $cli_tel_fijos . ' ' . $cli_tel_cel ?>" disabled=""/>
            <br>
            <label>Correo Electr&oacute;nico:</label><input type="text" name="cli_correo" style="width: 300px" value="<?php echo $cli_correo ?>" />
            &nbsp;&nbsp;
            <label>Direcci&oacute;n casa:</label>&nbsp; 
            <textarea name="cli_dir_casa" cols="55" rows="2" disabled=""><?php echo $cli_dir_casa ?></textarea>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <?php
    }

    function ver_abono() {
        date_default_timezone_set("America/Guayaquil");
        $fecha = date('Y-m-d');
        global $numcre, $numsec;
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cre where idtran_cre_cab = '$numcre' and tran_cre_sec = '$numsec'";
        $subquery = "select * from tran_cab where idtran_cab='" . $numcre . "'";
        $vercred = mysqli_query($conn, $query);
        echo '<hr>';
        echo '<h1>COBRO</h1>';
        echo "<table border=1><tr align=center style='color:red; font-size: 9px'>"
        . "<td width=40>CARPETA</td>"
        . "<td width=40># PAGO</td>"
        . "<td width=80>FECHA PAGO</td>"
        . "<td width=80>PAGADO EL</td>"
        . "<td width=60>VALOR</td>"
        . "<td width=50>INTERES</td>"
        . "<td width=60>CAPITAL</td>"
        . "<td width=60>SALDO</td>"
        . "<td width=60>ABONO</td>"
        . "<td width=60>ESTADO</td>"
        . "</tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            $numcuota = $datocred['tran_cre_sec'];
            $valorcuota = $datocred['tran_cre_cuota'];
            $suma = ($datocred['tran_cre_cuota']) - ($datocred['abono']);
            echo "<tr style='font-size: 9px'>";
            echo "<td>" . $datocred['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $suma . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
            echo "<td>" . $datocred['abono'] . "</td>";
            if ($datocred['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
            }
        }
        echo "</tr>";
        echo "</table>";


        $numcre = $datocred['idtran_cre_cab'];
        $numsec = $datocred['tran_cre_sec'];


        $versubquery = mysqli_query($conn, $subquery);
        while ($datosubquery = mysqli_fetch_array($versubquery, MYSQLI_BOTH)) {
            $placac = $datosubquery['tran_veh_placas'];
            $idclien = $datosubquery['tran_cli_ident'];
        }
        echo '<hr>';
        echo '<h1>VEHICULO</h1>';

        $query1 = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
        veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.tran_veh_placas='" . $placac . "'";
        $resveh = mysqli_query($conn, $query1);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
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
        $veh_estado = $datomarca['veh_estado'];
        ?>

        <p style="font-size:9px; text-align: left">
            <label>Placa:</label><input type="text" name="veh_marca" value="<?php echo $tran_veh_placas; ?>" disabled=""/>
            <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" disabled=""/>
            &nbsp;&nbsp;
        </p>

        <?php
        echo '<hr>';
        echo '<h1>CLIENTE</h1>';
        $query3 = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident and tran_cab.tran_cli_ident='" . $idclien . "'";
        $resveh = mysqli_query($conn, $query3);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
        $idcli_ident = $datomarca['idcli_ident'];
        $cli_nombre = $datomarca['cli_nombre'];
        $cli_apellido = $datomarca['cli_apellido'];
        $cli_dir_casa = $datomarca['cli_dir_casa'];
        $cli_dir_tra = $datomarca['cli_dir_tra'];
        $cli_tel_fijos = $datomarca['cli_tel_fijos'];
        $cli_tel_cel = $datomarca['cli_tel_cel'];
        $cli_correo = $datomarca['cli_correo'];
        $cli_ciudad = $datomarca['cli_ciudad'];
        $cli_nom_ref = $datomarca['cli_nom_ref'];
        $cli_dir_ref = $datomarca['cli_dir_ref'];
        $cli_tel_ref = $datomarca['cli_tel_ref'];
        $cli_est_civ = $datomarca['cli_est_civ'];
        $cli_conyuge = $datomarca['cli_conyuge'];
        ?>

        <p style="font-size:9px; text-align: left">
            <!--    <label>C&eacute;cula:</label>&nbsp; <?php echo $idcli_ident ?> -->
            <label>Cliente :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="text" name="cli_nombre" style="width: 300px" value="<?php echo $cli_nombre . " " . $cli_apellido ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tel&eacute;fonos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="cli_tel_fijos" style="width: 300px" value="<?php echo $cli_tel_fijos . ' ' . $cli_tel_cel ?>" disabled=""/>
            <br>
            <label>Correo Electr&oacute;nico:</label><input type="text" name="cli_correo" style="width: 300px" value="<?php echo $cli_correo ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Direcci&oacute;n casa:</label>&nbsp; 
            <textarea name="cli_dir_casa" cols="55" rows="2" disabled=""><?php echo $cli_dir_casa ?></textarea>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>

        <?php
    }

    function cobra_credito() {
        global $numcre, $numsec;
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cre where idtran_cre_cab = '$numcre' and tran_cre_sec = '$numsec'";
        $subquery = "select * from tran_cab where idtran_cab='" . $numcre . "'";
        $vercred = mysqli_query($conn, $query);
        echo '<hr><br>';
        echo '<h1>COBRO POR REALIZAR</h1>';
        echo "<table border=1><tr align=center style='color:red'><td width=40>CARPETA</td><td width=40># PAGO</td><td width=80>FECHA PAGO</td><td width=80>PAGADO EL</td><td width=60>VALOR</td><td width=50>INTERES</td><td width=60>CAPITAL</td><td width=60>SALDO</td><td width=60>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            $suma = $datocred['tran_cre_cuota'] - $datocred['abono'];
            echo "<tr>";
            echo "<td>" . $datocred['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $suma . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
        }
        echo "</tr>";
        echo "</table>";
        $numcre = $datocred['idtran_cre_cab'];
        $numsec = $datocred['tran_cre_sec'];


        $versubquery = mysqli_query($conn, $subquery);
        while ($datosubquery = mysqli_fetch_array($versubquery, MYSQLI_BOTH)) {
            $placac = $datosubquery['tran_veh_placas'];
            $idclien = $datosubquery['tran_cli_ident'];
        }
        echo '<hr><br>';
        echo '<h1>VEHICULO</h1>';

        $query1 = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
        veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo
        and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and 
        veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.tran_veh_placas='" . $placac . "'";
        $resveh = mysqli_query($conn, $query1);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
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
        $veh_estado = $datomarca['veh_estado'];
        ?>
        <p style="font-size:15px; text-align: left">
            <!--            <label>Placa:</label>&nbsp; -->
            <?php //echo $tran_veh_placas;       ?> 
            <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" disabled=""/>
            &nbsp;&nbsp;
        </p>
        <?php
        echo '<hr><br>';
        echo '<h1>CLIENTE</h1>';
        $query3 = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident "
                . "and tran_cab.tran_cli_ident='" . $idclien . "'";
        $resveh = mysqli_query($conn, $query3);
        $datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH);
        $idcli_ident = $datomarca['idcli_ident'];
        $cli_nombre = $datomarca['cli_nombre'];
        $cli_apellido = $datomarca['cli_apellido'];
        $cli_dir_casa = $datomarca['cli_dir_casa'];
        $cli_dir_tra = $datomarca['cli_dir_tra'];
        $cli_tel_fijos = $datomarca['cli_tel_fijos'];
        $cli_tel_cel = $datomarca['cli_tel_cel'];
        $cli_correo = $datomarca['cli_correo'];
        $cli_ciudad = $datomarca['cli_ciudad'];
        $cli_nom_ref = $datomarca['cli_nom_ref'];
        $cli_dir_ref = $datomarca['cli_dir_ref'];
        $cli_tel_ref = $datomarca['cli_tel_ref'];
        $cli_est_civ = $datomarca['cli_est_civ'];
        $cli_conyuge = $datomarca['cli_conyuge'];
        ?>
        <p style="font-size:15px; text-align: left">
            <!--    <label>C&eacute;cula:</label>&nbsp; <?php echo $idcli_ident ?> -->
            <label>Cliente :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="text" name="cli_nombre" style="width: 300px" value="<?php echo $cli_nombre . " " . $cli_apellido ?>" disabled=""/>
            &nbsp;&nbsp;
            <label>Tel&eacute;fonos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="cli_tel_fijos" style="width: 300px" value="<?php echo $cli_tel_fijos . ' ' . $cli_tel_cel ?>" disabled=""/>
            <br>
            <label>Correo Electr&oacute;nico:</label><input type="text" name="cli_correo" style="width: 300px" value="<?php echo $cli_correo ?>" />
            &nbsp;&nbsp;
            <label>Direcci&oacute;n casa:</label>&nbsp; 
            <textarea name="cli_dir_casa" cols="55" rows="2" disabled=""><?php echo $cli_dir_casa ?></textarea>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <?php
    }

    function ver_abonos($numcre, $numsec) {
        $con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query = "SELECT * FROM `abono` where tran_cre_idtran_cre_cab = '$numcre' and cuota= '$numsec'";
        $vercred = mysqli_query($con, $query);
        echo '<hr>';
        echo '<h1>ABONOS</h1>';
        if (count($vercred) > 0) {
            echo "<table border=1><tr align=center style='color:red; font-size: 9px'>"
            . "<td width=40>#</td>"
            . "<td width=40>ABONO</td>"
            . "<td width=80>FECHA DE ABONO</td>"
            . "<td width=120>Detalle</td>"
            . "</tr>";
            $i = 1;
            while ($datoabono = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
                echo "<tr style='font-size:9px' >";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $datoabono['abono'] . "</td>";
                echo "<td>" . $datoabono['fechaabono'] . "</td>";
                echo "<td>" . $datoabono['detall'] . "</td>";
                $i++;
            }
            echo "</tr>";
            echo "</table>";
        } else {
            echo '<h1>NO SE ENCONTRARON ABONOS</h1>';
        }
    }

    function guarda_abono($numcretxt, $numsectxt, $fecha, $abono, $detallabono) {
        $con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $insertaabono = "INSERT INTO `abono` (`id`, `abono`, `fechaabono`, `cuota`, `tip_abono`, `tran_cre_idtran_cre_cab`,detall) VALUES"
                . " (NULL, '" . $abono . "', '" . $fecha . "', '" . $numsectxt . "', ' ', '" . $numcretxt . "','" . $detallabono . "');";
        mysqli_query($con, $insertaabono) or trigger_error("Query Failed! SQL: $insertaabono- Error: " . mysqli_error($con), E_USER_ERROR);

        $sumaabonos = "SELECT sum(`abono`) as total FROM `abono` WHERE `tran_cre_idtran_cre_cab`='" . $numcretxt . "' and `cuota`='" . $numsectxt . "' ";
        $rescont = mysqli_query($con, $sumaabonos);
        $datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH);
        $total = $datocont['total'];

        $query = "UPDATE tran_cre SET fechaabono= '" . $fecha . "',  abono ='" . $total . "' where tran_cre_sec= '" . $numsectxt . "' and idtran_cre_cab = '" . $numcretxt . "'";
        mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($con), E_USER_ERROR);
    }

    function pagodecredito($numcretxt, $numsectxt, $observ) {
        date_default_timezone_set("America/Guayaquil");
        $fecha = date('Y-m-j');
        $con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
        $query = "UPDATE tran_cre SET tran_cre_fecha_pago = '" . date("Y-m-d") . "',  tran_cre_estado ='1' where idtran_cre_cab = '" . $numcretxt . "' and tran_cre_sec = '" . $numsectxt . "'";
        mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($con), E_USER_ERROR);



        $querycontador = "SELECT COUNT(*)+1 as contador FROM `det_cob`";
        $rescont = mysqli_query($con, $querycontador);
        $datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH);
        $contador = $datocont['contador'];

        $querydatos = "SELECT * FROM tran_cre, tran_cab, veh_datos WHERE tran_cre.`idtran_cre_cab`= tran_cab.idtran_cab and tran_cab.tran_veh_placas = veh_datos.idveh_placa and tran_cre.idtran_cre_cab='" . $numcretxt . "' and tran_cre.tran_cre_sec='" . $numsectxt . "'";
        $resdatos = mysqli_query($con, $querydatos);
        $resdato = mysqli_fetch_array($resdatos, MYSQLI_BOTH);
        $idtran_cre_cab = $resdato['idtran_cre_cab'];
        $tran_cre_sec = $resdato['tran_cre_sec'];
        $tran_cre_fecha_venc = $resdato['tran_cre_fecha_venc'];
        $tran_cre_fecha_pago = $resdato['tran_cre_fecha_pago'];
        $tran_cre_cuota = $resdato['tran_cre_cuota'];
        $tran_cre_interes = $resdato['tran_cre_interes'];
        $tran_cre_monto = $resdato['tran_cre_monto'];
        $tran_cre_sal = $resdato['tran_cre_sal'];
        $tran_cre_estado = $resdato['tran_cre_estado'];
        $idplacasdata = $resdato['tran_veh_placas'];
        $idclidata = $resdato['tran_cli_ident'];


        $queryinsert = "INSERT INTO `cove_veh`.`det_cob` (`id_det_cob`, `idtran_cab`, `idcli_ident`, "
                . "`idveh_placa`, `sec`, `fechavence`, `fechapago`, `cuota`, `interes`, `monto`, `saldo`, "
                . "`estado`, observ,`emp`) VALUES"
                . " ('" . $contador . "', '" . $numcretxt . "', '" . $idclidata . "', '" . $idplacasdata . "', '" . $numsectxt . "', '" . $tran_cre_fecha_venc . "',"
                . " '" . date("Y-m-d") . "', "
                . "'" . $tran_cre_cuota . "', '" . $tran_cre_interes . "', '" . $tran_cre_monto . "', '" . $tran_cre_sal . "', '" . $tran_cre_estado . "',"
                . " '" . trim($observ) . "' ,'" . $_SESSION['user'] . "');";
        mysqli_query($con, $queryinsert) or trigger_error("Query Failed! SQL: $queryinsert - Error: " . mysqli_error($con), E_USER_ERROR);


        $viewdata = "SELECT * FROM `det_cob` WHERE `idtran_cab`= '" . $numcretxt . "' and `sec`='" . $numsectxt . "'";
        $eject = mysqli_query($con, $viewdata) or trigger_error("Query Failed! SQL: $viewdata - Error: " . mysqli_error($con), E_USER_ERROR);
        while ($row1 = mysqli_fetch_assoc($eject)) {
            $cli = $row1['idcli_ident'];
            $veh = $row1['idveh_placa'];
        }

        include_once 'class/vehiculo.php';
        $objVeh = new Vehiculo();
        $tipo_estado = $objVeh->ver_tipoEstado($veh);
        if ($tipo_estado != '0') {



            list($year, $month, $dia) = explode("-", $fecha);
            if ($month == '01') {
                $month = "Enero";
            } elseif ($month == "02") {
                $month = "Febrero";
            } elseif ($month == "03") {
                $month = "Marzo";
            } elseif ($month == "04") {
                $month = "Abril";
            } elseif ($month == "05") {
                $month = "Mayo";
            } elseif ($month == "06") {
                $month = "Junio";
            } elseif ($month == "07") {
                $month = "Julio";
            } elseif ($month == "08") {
                $month = "Agosto";
            } elseif ($month == "09") {
                $month = "Septiembre";
            } elseif ($month == "10") {
                $month = "Octubre";
            } elseif ($month == "11") {
                $month = "Noviembre";
            } elseif ($month == "12") {
                $month = "Diciembre";
            }

//        $year = date("Y");
//        $mes = date("F");

            $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
            $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $maxbalancedato = $row['id'];
                }
            }
            $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
            $resultcont = mysqli_query($c, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($c), E_USER_ERROR);
            if ($resultcont) {
                while ($rowcont = mysqli_fetch_assoc($resultcont)) {
                    $incremento = $rowcont['id'];
                }
            }

            $contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos where `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year='" . $year . "' ";
            $query_contador = mysqli_query($c, $contador_de_asientosSQL) or trigger_error("Query Failed! SQL: $contador_de_asientosSQL - Error: " . mysqli_error($c), E_USER_ERROR);
            $row_cont = mysqli_fetch_array($query_contador);
            $contador_ass = $row_cont['CON'];

            $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year)VALUES "
                    . "( '" . $incremento . "', '" . $fecha . "', '" . trim($_POST['observ']) . "', '" . $maxbalancedato . "',"
                    . "'" . $contador_ass . "','" . $month . "','" . $year . "');";
            mysqli_query($c, $insertasientoconcepto) or trigger_error("Query Failed! SQL: $insertasientoconcepto - Error: " . mysqli_error($c), E_USER_ERROR);

            if ($_SESSION['user'] == 'root') {
                $us = '1';
            } else {
                $us = '2';
            }


            $verveh = "SELECT * FROM `t_auxiliar` WHERE `placa_id`='" . $veh . "'";
            $ejecverveh = mysqli_query($c, $verveh) or trigger_error("Query Failed! SQL: $verveh - Error: " . mysqli_error($c), E_USER_ERROR);
            while ($row2 = mysqli_fetch_assoc($ejecverveh)) {
                $nomcuentadeb = $row2['nombre_cauxiliar'];
                $codcuentadeb = $row2['cod_cauxiliar'];
                $gctadeb = $row2['t_grupo_cod_grupo'];
            }

            $insertactivo = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
            `logeo_idlogeo`, `mes`, `year`) VALUES ('" . $fecha . "','" . $contador_ass . "','1.1.1.1.','CAJAS','" . $tran_cre_cuota . "','0.00',"
                    . "'" . $maxbalancedato . "','1.1.','1.1.','" . $us . "','" . $month . "','" . $year . "');";


            $vercli = "SELECT * FROM `t_auxiliar` WHERE `cli_id`='" . $cli . "'";
            $ejecvercli = mysqli_query($c, $vercli) or trigger_error("Query Failed! SQL: $vercli- Error: " . mysqli_error($c), E_USER_ERROR);
            while ($row3 = mysqli_fetch_assoc($ejecvercli)) {
                $nomcuentahab = $row3['nombre_cauxiliar'];
                $codcuentahab = $row3['cod_cauxiliar'];
                $gctahab = $row3['t_grupo_cod_grupo'];
            }

            $insertpasivo = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
            `logeo_idlogeo`, `mes`, `year`) VALUES ('" . $fecha . "','" . $contador_ass . "','" . $codcuentahab . "','" . $nomcuentahab . "','00.00','" . $tran_cre_cuota . "',"
                    . "'" . $maxbalancedato . "','" . $gctahab . "','" . $gctahab . "','" . $us . "','" . $month . "','" . $year . "');";

            mysqli_query($c, $insertactivo) or trigger_error("Query Failed! SQL: $insertactivo - Error: " . mysqli_error($c), E_USER_ERROR);
            mysqli_query($c, $insertpasivo) or trigger_error("Query Failed! SQL: $insertpasivo - Error: " . mysqli_error($c), E_USER_ERROR);

            $sql_ctaintrs = "SELECT * FROM `int_datcli` WHERE `nom_cli`='$nomcuentahab' and `id_cli`='$cli' ";
            $res_intrs = mysqli_query($c, $sql_ctaintrs)or trigger_error("Query Failed! SQL: $sql_ctaintrs- Error: " . mysqli_error($c), E_USER_ERROR);
            while ($row_i = mysqli_fetch_assoc($res_intrs)) {
                $id_cta_int = $row_i['id_cli'];
                $cta_int = $row_i['nom_cli'];
                $acree = $row_i['acree'];
                $deud = $row_i['deud'];
            }
            include_once 'class/contabilidad.php';
            $objcont = new contabilidad();
            $objcont->ass_intrs_cuot($id_cta_int, $cta_int, $acree, $deud, $tran_cre_interes);
        }
    }

    function pagodecreditopag($numcretxt, $numsectxt, $observ) {
        require 'class/Conectar.php';
        $dbi = new Conectar();
        $c = $dbi->conexion();
//        actualizado de estado a pagado
        $con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query = "UPDATE tran_cre SET tran_cre_fecha_pago = '" . date("Y-m-d") . "',  tran_cre_estado ='1' where idtran_cre_cab = '" . $numcretxt . "' and tran_cre_sec = '" . $numsectxt . "'";
        mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($con), E_USER_ERROR);
//        fin actualizado de estado a pagado    
//        Obten datos para detalle
        $queryobtendatos = "SELECT `tran_veh_placas` ,`tran_cli_ident` FROM `tran_cab` WHERE `idtran_cab`='" . $numcretxt . "' ";
        $resobtdatos = mysqli_query($con, $queryobtendatos) or trigger_error("Query Failed! SQL: $queryobtendatos - Error: " . mysqli_error($con), E_USER_ERROR);
        $resdts = mysqli_fetch_array($resobtdatos, MYSQLI_BOTH);
        $placa = $resdts['tran_veh_placas'];
        $cli = $resdts['tran_cli_ident'];

        $queryobtdts = "SELECT * FROM `tran_cre` WHERE `idtran_cre_cab`='" . $numcretxt . "' and `tran_cre_sec`='" . $numsectxt . "'";
        $resmonto = mysqli_query($con, $queryobtdts) or trigger_error("Query Failed! SQL: $queryobtdts - Error: " . mysqli_error($con), E_USER_ERROR);
        $resmnt = mysqli_fetch_array($resmonto);
        $monto_pag = $resmnt['tran_cre_cuota'];

//        Fin datos para detalle
//        Inicio de registro de transaccion en tabla de pagos        
        $ejeccontador = "select count(*)+1 as cont from det_pag";
        $rescont = mysqli_query($con, $ejeccontador) or trigger_error("Query Failed! SQL: $ejeccontador - Error: " . mysqli_error($con), E_USER_ERROR);
        $datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH);
        $contadordp = $datocont['cont'];

        $queryinsert = "INSERT INTO `cove_veh`.`det_pag` "
                . "(`iddet_pag`, `lis_pag_id_pag`, `cli_datos_idcli_ident`, `veh_datos_idveh_placa`, `fech_reg`, `monto`, "
                . "`tran_realiz`, `user`, `observ`, `clien`) VALUES "
                . "('" . $contadordp . "', '1', '" . $cli . "', '" . $placa . "', '" . date("Y-m-d") . "','" . $monto_pag . "', '" . $_SESSION['user'] . "',"
                . " '" . $_SESSION['user'] . "', '" . trim($observ) . "', '" . $cli . "');";
        mysqli_query($con, $queryinsert) or trigger_error("Query Failed! SQL: $queryinsert - Error: " . mysqli_error($conn), E_USER_ERROR);
//        Fin de registro de transaccion en tabla de pagos
//        Insertado de transaccion en contabilidad
        $fech = date("Y-m-d");
        list($year, $month, $dia) = explode("-", $fech);
        if ($month == '01') {
            $month = "Enero";
        } elseif ($month == "02") {
            $month = "Febrero";
        } elseif ($month == "03") {
            $month = "Marzo";
        } elseif ($month == "04") {
            $month = "Abril";
        } elseif ($month == "05") {
            $month = "Mayo";
        } elseif ($month == "06") {
            $month = "Junio";
        } elseif ($month == "07") {
            $month = "Julio";
        } elseif ($month == "08") {
            $month = "Agosto";
        } elseif ($month == "09") {
            $month = "Septiembre";
        } elseif ($month == "10") {
            $month = "Octubre";
        } elseif ($month == "11") {
            $month = "Noviembre";
        } elseif ($month == "12") {
            $month = "Diciembre";
        }
        $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
        $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $maxbalancedato = $row['id'];
            }
        }
        $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
        $resultcont = mysqli_query($c, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
        if ($resultcont) {
            while ($rowcont = mysqli_fetch_assoc($resultcont)) {
                $incremento = $rowcont['id'];
            }
        }

        $contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos where `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year='" . $year . "' ";
        $query_contador = mysqli_query($c, $contador_de_asientosSQL) or trigger_error("Query Failed! SQL: $contador_de_asientosSQL - Error: " . mysqli_error($c), E_USER_ERROR);
        $row_cont = mysqli_fetch_array($query_contador);
        $contador_ass = $row_cont['CON'];

        $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year)VALUES "
                . "( '" . $incremento . "', '" . $fech . "', '" . trim($observ) . "', '" . $maxbalancedato . "',"
                . "'" . $contador_ass . "','" . $month . "','" . $year . "');";
        mysqli_query($c, $insertasientoconcepto) or trigger_error("Query Failed! SQL: $insertasientoconcepto - Error: " . mysqli_error($c), E_USER_ERROR);


        if ($_SESSION['user'] == 'root') {
            $us = '1';
        } else {
            $us = '2';
        }
        $insertactivo = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
        `logeo_idlogeo`, `mes`, `year`) VALUES ('" . $fech . "','" . $contador_ass . "','1.1.1.','Cuenta Activo pago',"
                . "'" . $monto_pag . "','0.00','1','1.1.','1.1.','" . $us . "','" . $month . "','" . $year . "');";

        $insertpasivo = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
        `logeo_idlogeo`, `mes`, `year`) VALUES ('" . $fech . "','" . $contador_ass . "','2.1.1.',"
                . "'Cuenta Pasivo pago','00.00','" . $monto_pag . "','1','1.1.','1.1.','" . $us . "','" . $month . "','" . $year . "');";

        mysqli_query($c, $insertactivo) or trigger_error("Query Failed! SQL: $insertactivo - Error: " . mysqli_error($c), E_USER_ERROR);
        mysqli_query($c, $insertpasivo) or trigger_error("Query Failed! SQL: $insertpasivo - Error: " . mysqli_error($c), E_USER_ERROR);

        echo '<script>alert("Guardado con exito.")</script>';
        //        Fin de transaccion en contabilidad
    }

    function imprimir_cred($numero) {
        global $credito;
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cre WHERE idtran_cre_cab = '$numero'";
        $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));

        $credito = $resveh;
    }

}
