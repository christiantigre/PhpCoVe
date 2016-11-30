<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Pagos {

    public $idtran_cab;
    public $tran_cab_tipo;
    public $tran_cab_fecha;
    public $tran_veh_placas;
    public $tran_cli_ident;
    public $tran_cab_precio;
    public $tran_cab_seguro;
    public $tran_cab_gastos;

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function listar_transpagos() {
        $conn = $this->conec_base();
        $query = "SELECT idtran_cab, tran_cab_fecha, tran_cab_tipo, tran_veh_placas, tran_cli_ident, "
                . "tran_cab_precio, tran_cab_seguro, tran_cab_gastos FROM tran_cab where "
                . "tran_cab_tipo='INGRESO' order by idtran_cab";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            $fecha = date("d-m-Y", strtotime($datomarca['tran_cab_fecha']));
            echo "<td>" . $fecha . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_precio'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_seguro'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_gastos'] . "</td>";
            echo "<td align='center'><button name='vertrspag' value='" . $datomarca['idtran_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_transcarppag($idtran_cab) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where idtran_cab = '" . $idtran_cab . "' and tran_cab_tipo='INGRESO' ";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_fecha'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_precio'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_seguro'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_gastos'] . "</td>";
            echo "<td align='center'>"
            . "<button name='vertrspag' value='" . $datomarca['idtran_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_transclipag($id_clicob) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab, tran_cre where tran_cab.idtran_cab=tran_cre.idtran_cre_cab and tran_cab.tran_cli_ident = '" . $id_clicob . "' and tran_cab.tran_cab_tipo='COMPRA'";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>CUOTA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td><td>ESTADO</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $datocab = $datomarca['idtran_cre_cab'];
            $datosec = $datomarca['tran_cre_sec'];
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_sec'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_fecha'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_precio'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_seguro'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_gastos'] . "</td>";
            if ($datomarca['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
                echo "<td align='center'>"
                . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
            }
            echo "<td align='center'><button name='vertrspag' value='" . $datomarca['idtran_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_transvehpag($id_vehcob) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where tran_veh_placas = '" . $id_vehcob . "' and tran_cab.tran_cab_tipo='INGRESO' ";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_fecha'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_precio'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_seguro'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_gastos'] . "</td>";
            echo "<td align='center'><button name='vertrspag' value='" . $datomarca['idtran_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

//PAGOS
    function detalle_transacpag($numtra) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_det, tran_cab where tran_det.idtran_det_cab = tran_cab.idtran_cab and"
                . " tran_det.idtran_det_cab='" . $numtra . "' and tran_cab.tran_cab_tipo='INGRESO'";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>PAGO</td><td>FORMA</td><td>DOCUMENTO</td><td>VALOR</td><td>FECHA</td><td>INTERES</td><td>PLAZO</td><td>ESTADO</td>";
        while ($datotrans = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datotrans['idtran_det_cab'] . "</td>";
            echo "<td>" . $datotrans['tran_det_pago'] . "</td>";
            echo "<td>" . $datotrans['tran_det_forma'] . "</td>";
            echo "<td>" . $datotrans['tran_det_dcto'] . "</td>";
            echo "<td>" . $datotrans['tran_det_monto'] . "</td>";
            echo "<td>" . $datotrans['tran_det_fecha'] . "</td>";
            echo "<td>" . $datotrans['tran_det_interes'] . "</td>";
            echo "<td>" . $datotrans['tran_det_plazo'] . "</td>";
            if ($datotrans['tran_det_estado'] == 0) {
                $estado = 'PENDIENTE';
            } else {
                $estado = 'PAGADO';
            }
            echo "<td>" . $estado . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_close($conn);
    }

//CREDITO
    function ver_creditospag($numtra) {
        $datocab = 0;
        $datosec = 0;
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cre, tran_cab where tran_cre.idtran_cre_cab = tran_cab.idtran_cab and "
                . "tran_cre.idtran_cre_cab='" . $numtra . "' and tran_cab.tran_cab_tipo='INGRESO'";
        $vercred = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td width=40># PAGO</td><td width=80>FECHA PAGO</td><td width=80>PAGADO EL</td><td width=60>VALOR</td><td width=50>INTERES</td><td width=60>CAPITAL</td><td width=60>SALDO</td><td width=60>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($vercred, MYSQLI_BOTH)) {
            echo "<tr>";
            $datocab = $datocred['idtran_cre_cab'];
            $datosec = $datocred['tran_cre_sec'];
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $datocred['tran_cre_cuota'] . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
//        echo "<td>" .$datocred['tran_cre_estado']."</td>";
            if ($datocred['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
                echo "<td align='center'>"
                . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
                echo "<td style='display:NONE'>";
                echo "<input type='hidden' name='numcretxtcob' value='" . $datocab . "' >";
                echo "<input type='hidden' name='numsectxtcob' value='" . $datosec . "' >";
                echo "</td>";
                echo "<td><button name='detpag' value='" . $datocab . "-" . $datosec . "' >VER</button></td>";
            }



            echo "</tr>";
        }
        echo "</table>";

    }

//vehiculo
    function buscar_veh_pag($numtra) {
        $conn = $this->conec_base();
        $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo,
            veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2,
            veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, 
            veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, tran_cab where
veh_datos.idveh_placa = tran_cab.tran_veh_placas and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and 
veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and
veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and tran_cab.idtran_cab='" . $numtra . "'"
                . " and tran_cab.tran_cab_tipo='INGRESO'";
        $resveh = mysqli_query($conn, $query);
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
            $veh_estado = $datomarca['veh_estado'];
            ?>
            <p style="font-size:15px; text-align: left">
                <!--            <label>Placa:</label>&nbsp; -->
                <?php //echo $tran_veh_placas;  ?> 
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
        }
    }

//cliente
    function buscar_cliente_pag($numtra) {
        $conn = $this->conec_base();
        $query = "SELECT * from cli_datos, tran_cab where cli_datos.idcli_ident = tran_cab.tran_cli_ident and"
                . " tran_cab.idtran_cab='" . $numtra . "' and tran_cab.tran_cab_tipo='INGRESO'";
        $resveh = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
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
    }

    function detallpago($numcre, $numsec) {
        $conn = $this->conec_base();
        $query = "SELECT `idtran_cre_cab`, `tran_cre_sec`, `tran_cre_fecha_venc`, `tran_cre_fecha_pago`, "
                . "`tran_cre_cuota`, `tran_cre_interes`, `tran_cre_monto`, `tran_cre_sal`, `tran_cre_estado` "
                . "FROM `tran_cre` "
                . "WHERE `idtran_cre_cab`='" . $numcre . "' AND `tran_cre_sec`='" . $numsec . "'";

        $verdetcob = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td width=40># CARPETA</td><td width=80>CUOTA</td>"
        . "<td width=80>VENCE EL</td><td width=80>PAGADO EL</td><td width=60>MONTO</td><td width=50>INTERES</td>"
        . "<td width=60>CUOTA</td><td width=60>SALDO</td><td width=60>ESTADO</td></tr>";
        while ($datocred = mysqli_fetch_array($verdetcob, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datocred['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sec'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datocred['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $datocred['tran_cre_monto'] . "</td>";
            echo "<td>" . $datocred['tran_cre_interes'] . "</td>";
            echo "<td>" . $datocred['tran_cre_cuota'] . "</td>";
            echo "<td>" . $datocred['tran_cre_sal'] . "</td>";
//        echo "<td>" .$datocred['tran_cre_estado']."</td>";
            if ($datocred['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
                echo "<td align='center'>"
                . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";
            } else {
                echo "<td>PAGADO</td>";
                echo "<td>PAGADO</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    function ver_trans($idtran_cab) {
        global $numtra, $placa, $cliente;
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where idtran_cab = $idtran_cab";
        $resver = mysqli_query($conn, $query);
        while ($datover = mysqli_fetch_array($resver, MYSQLI_BOTH)) {
            $idtran_cab = $datover['idtran_cab'];
            $tran_cab_fecha = $datover['tran_cab_fecha'];
            $tran_cab_tipo = $datover['tran_cab_tipo'];
            $tran_veh_placas = $datover['tran_veh_placas'];
            $tran_cli_ident = $datover['tran_cli_ident'];
            $tran_cab_precio = $datover['tran_cab_precio'];
            $tran_cab_seguro = $datover['tran_cab_seguro'];
            $tran_cab_gastos = $datover['tran_cab_gastos'];
        }
        ?>
        <label>Transacci&oacute;n:</label>&nbsp;<input type="text" name="idtran_cab" value="<?php echo $idtran_cab; ?>" disabled="">&nbsp;&nbsp;
        <label>Fecha:</label>&nbsp;<input type="text" name="tran_cab_fecha" value="<?php echo $tran_cab_fecha; ?>" disabled="">&nbsp;&nbsp;
        <label>Tipo:</label>&nbsp;<input type="text" name="tran_cab_tipo" value="<?php echo $tran_cab_tipo; ?>" disabled="">&nbsp;&nbsp;
        <br><br>
        <label>Vehiculo:</label>&nbsp;<input type="text" name="tran_veh_placas" value="<?php echo $tran_veh_placas; ?>" disabled="">&nbsp;&nbsp;
        <label>Cliente:</label>&nbsp;<input type="text" name="tran_cli_ident" value="<?php echo $tran_cli_ident; ?>" disabled="">
        <br><br>
        <?php
        $numtra = $idtran_cab;
        $placa = $tran_veh_placas;
        $cliente = $tran_cli_ident;
    }

    function verpendientespag() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cre, tran_cab where tran_cre.idtran_cre_cab=tran_cab.idtran_cab and "
                . "tran_cre_estado = '0' and tran_cab.tran_cab_tipo='INGRESO' ";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $datocab = $datomarca['idtran_cre_cab'];
            $datosec = $datomarca['tran_cre_sec'];
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_sec'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_cuota'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_interes'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_monto'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_sal'] . "</td>";
            if ($datomarca['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
                echo "<td align='center'>"
                . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";
            } else {
                echo "<td>PAGADO</td>";
            }
            echo "<td align='center'>"
            . "<button name='vertrspag' value='" . $datomarca['idtran_cre_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function verpagadospag() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cre, tran_cab where tran_cre.idtran_cre_cab=tran_cab.idtran_cab and"
                . " tran_cre_estado = '1' and tran_cab.tran_cab_tipo='INGRESO' ";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $datocab = $datomarca['idtran_cre_cab'];
            $datosec = $datomarca['tran_cre_sec'];
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cre_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_sec'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_fecha_venc'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_fecha_pago'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_cuota'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_interes'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_monto'] . "</td>";
            echo "<td>" . $datomarca['tran_cre_sal'] . "</td>";
            if ($datomarca['tran_cre_estado'] == '0') {
                echo "<td>PENDIENTE</td>";
                echo "<td align='center'>"
                . "<button name='pagacrepag' value='" . $datocab . "-" . $datosec . "' >PAGAR</button></td>";
            } else {
                echo "<td>PAGADO</td>";
            }
            echo "<td align='center'>"
            . "<button name='vertrspag' value='" . $datomarca['idtran_cre_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

}
