<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Otrospag {

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

    function otpag($cuentatxt) {
        $conn = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
        echo '<datalist id="cuenta" >';
        $query = "SELECT * FROM `t_plan_de_cuentas` WHERE `t_subcuenta_cod_subcuenta`='5.1.1.1.'";
//        $query = "select * from lis_pag where id_pag != 1";
        $resul1 = mysqli_query($conn, $query);
        while ($dato1 = mysqli_fetch_array($resul1)) {
            if ($_REQUEST['cuenta'] == $dato1['nombre_cuenta_plan']) {
                $cod1 = $dato1['cod_cuenta'];
                echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' selected>&nbsp;&nbsp;";
                echo $dato1['nombre_cuenta_plan'];
                echo '</option>';
            } else {
                $cod1 = $dato1['cod_cuenta'];
                echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                echo $dato1['nombre_cuenta_plan'];
                echo '</option>';
            }
        }
        echo '</datalist>';
        global $cuentatxt;
        ?>
        <h1>COMPLETE EL PAGO</h1>
        <p style="font-size:12px; text-align: left">
            <label>Fecha registrado :</label>&nbsp;<input type="date" name="datepag" id="datepg" value="<?Php echo date("Y-m-d"); ?>"/> &nbsp; &nbsp;
            <label>Por concepto de :</label>&nbsp; 
            <!--<input type="text" name="tipde_pag" id="tipde_pag" list="cuenta" style="width:200px;" value="" />-->
            <?Php echo '<input list="cuenta"  onclick="realiz_pag.disabled=false;" name="cuentatxt" style="width:180px;" id="cuentatxt" value=""/>&nbsp'; ?>
            &nbsp;&nbsp;
            <label>Total :</label>&nbsp; <input type="text" name="monto_pag" autocomplete="off" onblur="vaciar();" id="monto_pag" min="0" value="" placeholder="Ejm... 50.33" />
            <!--<br></br>-->
            <label>Iva :</label>&nbsp;
            <select name="iva" id="iva" size="0" style="alignment-adjust: central; width: 85px;" onchange="calcular();">
                <?php
                $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                $consulint = "select iva from iva";
                $queryclases = mysqli_query($c, $consulint);
				echo "<option>seleccione valor</option>";
                while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
					
                    if ($_POST['iva'] == $arreglorepalmtu['iva']) {
                        echo "<option value='" . $arreglorepalmtu['iva'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['iva'] . "</option>";
                    } else {
                        ?>
                        <option class="form-control" value="<?php echo $arreglorepalmtu['iva'] ?>">
                            <?php echo $arreglorepalmtu['iva'] ?></option>     
                            <?php
                        }
                    }
                    mysqli_close($conn);
                    ?>
                </select>
                <label>IVA % :</label>&nbsp;
                <input type="text" style="width:70px;" id="valiva" name="valiva" value="" readonly="readonly" placeholder=""/>&nbsp;&nbsp;
                <label>Subtotal :</label>&nbsp;
                <input type="text" style="width:70px;" id="subtotal" name="subtotal" value="" readonly="readonly" placeholder=""/>&nbsp;&nbsp;
                <br></br>
                <label>Cuenta de pago :</label>&nbsp;
                <input type="text" id="dcto" name="dcto" onchange="" style="width: 120px" list="cta" autocomplete="off"/>
                <datalist id="cta">
                    <optgroup label="bancos">
                        <?php
                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                        $query = "select * from t_plan_de_cuentas where t_subcuenta_cod_subcuenta='1.1.1.2.' and nombre_cuenta_plan !='BANCOS' ";
                        $resul1 = mysqli_query($c, $query);
                        while ($dato1 = mysqli_fetch_array($resul1)) {
                            $cod1 = $dato1['cod_cuenta'];
echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
echo '</option>';
}
mysqli_close($c);
?>
</optgroup>
<optgroup label="caja1">
    <?php
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    $query = "select * from t_plan_de_cuentas where cod_cuenta='1.1.1.1.1.'";
    $resul1 = mysqli_query($c, $query);
    while ($dato1 = mysqli_fetch_array($resul1)) {
        $cod1 = $dato1['cod_cuenta'];
echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
echo '</option>';
}
mysqli_close($c);
?>
</optgroup>
<optgroup label="caja2">
    <?php
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    $query = "select * from t_plan_de_cuentas where cod_cuenta='1.1.1.1.2.'";
    $resul1 = mysqli_query($c, $query);
    while ($dato1 = mysqli_fetch_array($resul1)) {
        $cod1 = $dato1['cod_cuenta'];
echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
echo '</option>';
}
mysqli_close($c);
?>
</optgroup>
</datalist>
<label>Pago realizado por :</label>&nbsp;
<input type="text" style="width:200px;" id="pag_por" name="pag_por" value="" placeholder=""/>&nbsp;&nbsp;
<br></br>
<label>Cliente :</label>&nbsp;
<input type="text" list="cli" style="width:200px;" autocomplete="off" id="pag_cli" name="pag_cli" value="" placeholder=""/>&nbsp;&nbsp;
<datalist id="cli" name="cli" style="width: 250px">
    <?php
    include_once 'class/otrospagos.php';
    $objltmodelo = new Otrospag();
    $objltmodelo->conec_base();
    $objltmodelo->mostrar_opcionescli();
    ?>                    
</datalist>
<label>Vehiculo :</label>&nbsp;
<input type="text" style="width:200px;" autocomplete="off" list="veh" id="pag_veh" name="pag_veh" value="" placeholder=""/>&nbsp;&nbsp;
<datalist id="veh" name="veh" style="width: 250px">
    <?php
    include_once 'class/otrospagos.php';
    $objltmodelo = new Otrospag();
    $objltmodelo->conec_base();
    $objltmodelo->mostrar_opcionesveh();
    ?>                    
</datalist>
<br>
<br>
<label>Observaci&oacute;n :</label> &nbsp; 
<textarea id="observ" name="observ" maxlength="255" rows="5" cols="90" placeholder="Max 255..."></textarea>
</p>
<?php
}

function mostrar_opcionescli() {
    $conn = $this->objconec;
    $query = "SELECT * FROM `cli_datos` ";
    $resmostrar = mysqli_query($conn, $query);
    echo "<option> </option>";
    while ($row = mysqli_fetch_array($resmostrar)) {
        echo "<option value=" . $row['idcli_ident'] . ">$row[cli_nombre] $row[cli_apellido] </option>";
    }
    mysqli_close($conn);
}

function mostrar_opcionesveh() {
    $conn = $this->objconec;
    $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar where veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar ";
    $resmostrar = mysqli_query($conn, $query);
    echo "<option> </option>";
    while ($row = mysqli_fetch_array($resmostrar)) {
        echo "<option value=" . $row['idveh_placa'] . ">$row[veh_marca] $row[veh_tipo_des]$row[veh_modelo] </option>";
    }
    mysqli_close($conn);
}

function realizarpago($fech_reg, $tip_pag, $monto_pag, $pag_por, $observ, $cli, $veh, $valiva, $subtotal,$porcentaje,$dcto) {
    require 'class/Conectar.php';
    $dbi = new Conectar();
    $c = $dbi->conexion();

    $conn = $this->objconec;

    $ejeccontador = "select count(*)+1 as cont from det_pag";
    $rescont = mysqli_query($conn, $ejeccontador) or trigger_error("Query Failed! SQL: $ejeccontador - Error: " . mysqli_error($conn), E_USER_ERROR);
    $datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH);
    $contadordp = $datocont['cont'];
    echo '<input type="hidden" name="val" id="val" value="' . $contadordp . '"/>';

    $obten_idlist = "SELECT `cod_cuenta` as id FROM `t_plan_de_cuentas` WHERE `nombre_cuenta_plan`='" . $tip_pag . "'";
    $reslist = mysqli_query($c, $obten_idlist) or trigger_error("Query Failed! SQL: $obten_idlist - Error: " . mysqli_error($c), E_USER_ERROR);
    $datolist = mysqli_fetch_array($reslist, MYSQLI_BOTH);
    $datolista = $datolist['id'];

    $obten_cod = "SELECT `cod_cuenta` as id FROM `t_plan_de_cuentas` WHERE `nombre_cuenta_plan`='" . $dcto . "'";
    $res_cod = mysqli_query($c, $obten_cod) or trigger_error("Query Failed! SQL: $obten_cod - Error: " . mysqli_error($c), E_USER_ERROR);
    $datocod = mysqli_fetch_array($res_cod, MYSQLI_BOTH);
    $datocodigo = $datocod['id'];

    $queryinsert = "INSERT INTO `cove_veh`.`det_pag` "
    . "(`iddet_pag`, `lis_pag_id_pag`, `cli_datos_idcli_ident`, `veh_datos_idveh_placa`, `fech_reg`, `monto`, "
    . "`tran_realiz`, `user`, `observ`, `clien`,`iva`,`subtotal`,`porcentaje`) VALUES ('" . $contadordp . "', '" . $datolista . "', '" . $cli . "', '" . $veh . "', '" . $fech_reg . "',"
    . " '" . $monto_pag . "', '" . $pag_por . "',"
    . " '" . $_SESSION['user'] . "', '" . trim($observ) . "', NULL,'".$valiva."','".$subtotal."','".$porcentaje."');";
//      
    mysqli_query($conn, $queryinsert) or trigger_error("Query Failed! SQL: $queryinsert - Error: " . mysqli_error($conn), E_USER_ERROR);
//      

    $c = $dbi->conexion();
    $datepick = date("Y-m-d");
    list($year, $mes, $dia) = explode("-", $datepick);
$dia; // Imprime 12
$mes; // Imprime 01
$year; // Imprime 2005
if ($mes == '01') {
    $mes = "Enero";
} elseif ($mes == "02") {
    $mes = "Febrero";
} elseif ($mes == "03") {
    $mes = "Marzo";
} elseif ($mes == "04") {
    $mes = "Abril";
} elseif ($mes == "05") {
    $mes = "Mayo";
} elseif ($mes == "06") {
    $mes = "Junio";
} elseif ($mes == "07") {
    $mes = "Julio";
} elseif ($mes == "08") {
    $mes = "Agosto";
} elseif ($mes == "09") {
    $mes = "Septiembre";
} elseif ($mes == "10") {
    $mes = "Octubre";
} elseif ($mes == "11") {
    $mes = "Noviembre";
} elseif ($mes == "12") {
    $mes = "Diciembre";
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
. "( '" . $incremento . "', '" . $datepick . "', '" . trim($_POST['observ'] . " Vehiculo " . $veh . " / Cliente " . $cli) . "', '" . $maxbalancedato . "',"
. "'" . $contador_ass . "','" . $mes . "','" . $year . "');";
mysqli_query($c, $insertasientoconcepto) or trigger_error("Query Failed! SQL: $insertasientoconcepto - Error: " . mysqli_error($c), E_USER_ERROR);


if ($_SESSION['user'] == 'root') {
    $us = '1';
} else {
    $us = '2';
}

$sqldata = "SELECT * FROM `t_plan_de_cuentas` WHERE `nombre_cuenta_plan`='" . $tip_pag . "'";
$resdata = mysqli_query($c, $sqldata);
while ($row1 = mysqli_fetch_array($resdata)) {
    $ccta = $row1['nombre_cuenta_plan'];
    $codcta = $row1['cod_cuenta'];
    $gcta = $row1['t_grupo_cod_grupo'];
}

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
//debe
$insertactivo = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
`logeo_idlogeo`, `mes`, `year`) VALUES ('" . $datepick . "','" . $contador_ass . "','" . $codcta . "','" . $ccta . "','" . $subtotal . "','0.00','" . $maxbalancedato . "','" . $gcta . "','" . $gcta . "','" . $us . "','" . $mes . "','" . $year . "');";
//debe
$insertpasivo1 = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
`logeo_idlogeo`, `mes`, `year`) VALUES ('" . $datepick . "','" . $contador_ass . "','1.1.5.1.1.','Iva en Compras','" . $valiva . "','00.00','1','1.1.','1.1.','" . $us . "','" . $mes . "','" . $year . "');";
//haber
$insertpasivo2 = "INSERT INTO `libro`(`fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, 
`logeo_idlogeo`, `mes`, `year`) VALUES ('" . $datepick . "','" . $contador_ass . "','".$datocodigo."','".$dcto."','00.00','".$monto_pag."', '1','1.1.','1.1.','" . $us . "','" . $mes . "','" . $year . "');";

mysqli_query($c, $insertactivo) or trigger_error("Query Failed! SQL: $insertactivo - Error: " . mysqli_error($c), E_USER_ERROR);
mysqli_query($c, $insertpasivo1) or trigger_error("Query Failed! SQL: $insertpasivo1 - Error: " . mysqli_error($c), E_USER_ERROR);
mysqli_query($c, $insertpasivo2) or trigger_error("Query Failed! SQL: $insertpasivo2 - Error: " . mysqli_error($c), E_USER_ERROR);
echo '<input type="hidden" name="idhei" id="idhei" value=' . $contadordp . '/>';
echo '<script>alert("Guardado con exito.")</script>';
?>
<?php
}

function detallot_pag() {
    $conn = $this->objconec;
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    $sqlmaxid = "SELECT MAX(`iddet_pag`) as id FROM `det_pag`";
    $result = mysqli_query($conn, $sqlmaxid) or trigger_error("Query Failed! SQL: $sqlmaxid - Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ultimoingreso = $row['id'];
        }
    }

    $selecdatos = "SELECT * FROM `det_pag` WHERE `iddet_pag`='" . $ultimoingreso . "'";
    $resultdatos = mysqli_query($conn, $selecdatos) or trigger_error("Query Failed! SQL: $selecdatos - Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultdatos) {
        while ($rowdata = mysqli_fetch_assoc($resultdatos)) {
            $id = $rowdata['iddet_pag'];
            $list_id = $rowdata['lis_pag_id_pag'];
            $cli_id = $rowdata['cli_datos_idcli_ident'];
            $veh_id = $rowdata['veh_datos_idveh_placa'];
            $fech_reg = $rowdata['fech_reg'];
            $mont = $rowdata['monto'];
            $porcentaje = $rowdata['porcentaje'];
            $valiva = $rowdata['iva'];
            $subtotal = $rowdata['subtotal'];
            $tranrealiz = $rowdata['tran_realiz'];
            $user = $rowdata['user'];
            $observ = $rowdata['observ'];
            $clien = $rowdata['clien'];
        }
    }

//        $selectnompag = "select nom_pag from lis_pag where id_pag='" . $list_id . "'";
    $selectnompag = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='" . $list_id . "'";
    $resultnom_pag = mysqli_query($c, $selectnompag) or trigger_error("Query Failed! SQL: $selectnompag- Error: " . mysqli_error($c), E_USER_ERROR);
    if ($resultnom_pag) {
        while ($rownom = mysqli_fetch_assoc($resultnom_pag)) {
            $nom_pag = $rownom['nombre_cuenta_plan'];
        }
    }
    ?>
    <p style="font-size:12px; text-align: left">
        <input type="hidden" name="idhei" id="idhei" value="<?Php echo $id; ?>"/>
        <label>Fecha registrado :</label>&nbsp;<input type="text" name="datepag" id="datepg" value="<?Php echo $fech_reg; ?>" disabled=""/> &nbsp; &nbsp;
        <label>Por concepto de :</label>&nbsp; 
        <input type="text" name="tipde_pag" id="tipde_pag" list="cuenta" style="width:180px;" value="<?Php echo $nom_pag ?>" disabled=""/>
        &nbsp;&nbsp;            <br></br>

        <label>Total :</label>&nbsp; <input type="text" name="monto_pag" id="monto_pag" value="<?Php echo $mont; ?>" disabled="" placeholder="Ejm... 50.33"/>
        <label>Iva <?Php echo $porcentaje ?>% :</label>&nbsp; <input type="text" name="valiva" id="valiva" value="<?Php echo $valiva; ?>" disabled="" placeholder="Ejm... 50.33"/>
        <label>Subtotal :</label>&nbsp; <input type="text" name="subtotal" id="subtotal" value="<?Php echo $subtotal; ?>" disabled="" placeholder="Ejm... 50.33"/>
        <br></br>
        <label>Pago realizado por :</label>&nbsp;
        <input type="text" style="width:200px;" id="pag_por" name="pag_por" value="<?Php echo $tranrealiz ?>" placeholder="" disabled=""/>
        <label>Observaci&oacute;n :</label> &nbsp; 
        <textarea id="observ" name="observ" maxlength="255" rows="5" cols="90" placeholder="Max 255..." disabled=""><?Php echo $observ; ?></textarea>
    </p>
    <?php
}

function verpagos() {
    $conn = $this->objconec;
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    ?>
    <?Php
//        $sentenverpag = "SELECT * FROM `det_pag`, lis_pag WHERE det_pag.lis_pag_id_pag=lis_pag.id_pag ORDER BY det_pag.iddet_pag DESC ";
    $sentenverpag = "SELECT * FROM `det_pag` ORDER BY det_pag.iddet_pag DESC ";
    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        echo '<h1>PAGOS ANTERIORES</h1>';
        echo "<table border=1><tr align=center style='color:red'><td>CONCEPTO</td><td>FECHA</td><td>VALOR</td>";
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            echo "<tr>";
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];


            $sqldata = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='" . $lis_pag_id_pag . "'";
            $dat = mysqli_query($c, $sqldata);
            $row1 = mysqli_fetch_assoc($dat);
            $nom_pag = $row1['nombre_cuenta_plan'];

            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observ = $row['observ'];
            $clien = $row['clien'];
            echo "<td>" . $nom_pag . "</td>";
            echo "<td>" . $fech_reg . "</td>";
            echo "<td>" . $monto . "</td>";
            echo "<td>" . "<button name='verpagootros' value='" . $row['iddet_pag'] . "' >VER</button>" . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function verpagoswhere($campo_id) {
    $conn = $this->objconec;
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    $sentenverpag = "SELECT * FROM `det_pag` WHERE det_pag.iddet_pag='" . $campo_id . "' ORDER BY det_pag.iddet_pag DESC ";
//        $sentenverpag = "SELECT * FROM `det_pag` WHERE det_pag.iddet_pag='" . $campo_id . "' ORDER BY det_pag.iddet_pag DESC ";
    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];
            $sqldata = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='" . $lis_pag_id_pag . "'";
            $dat = mysqli_query($c, $sqldata);
            $row1 = mysqli_fetch_assoc($dat);
            $nom_pag = $row1['nombre_cuenta_plan'];
            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $porcentaje = $row['porcentaje'];
            $valiva = $row['iva'];
            $subtotal = $row['subtotal'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observac = $row['observ'];
            $clien = $row['clien'];
        }
    }
    echo '<script>alert(' . $observac . ')</script>';
    ?>
    <p style="font-size:12px; text-align: left">
        <input type="hidden" name="idhei" id="idhei" value="<?Php echo $iddet_pag; ?>"/>
        <label>Fecha registrado :</label>&nbsp;<input type="text" name="datepag" id="datepg" value="<?Php echo $fech_reg; ?>" disabled=""/> &nbsp; &nbsp;
        <label>Por concepto de :</label>&nbsp; 
        <input type="text" name="tipde_pag" id="tipde_pag" list="cuenta" style="width:180px;" value="<?Php echo $nom_pag ?>" disabled=""/>
        &nbsp;&nbsp;
        <br></br>
        <label>Total :</label>&nbsp; <input type="text" name="monto_pag" id="monto_pag" value="<?Php echo $monto; ?>" disabled="" placeholder="Ejm... 50.33"/>
        <label>Iva <?Php echo $porcentaje ?> % :</label>&nbsp; <input type="text" name="valiva" id="valiva" value="<?Php echo $valiva; ?>" disabled="" />
        <label>Subtotal :</label>&nbsp; <input type="text" name="subtotal" id="subtotal" value="<?Php echo $subtotal; ?>" disabled="" />
        <br></br>
        <label>Pago realizado por :</label>&nbsp;
        <input type="text" style="width:200px;" id="pag_por" name="pag_por" value="<?Php echo $tran_realiz; ?>" placeholder="" disabled=""/>
        <br></br>
        <label>Pagado a :</label>&nbsp;
        <input type="text" style="width:200px;" id="pag_a" name="pag_a" value="<?Php echo $cli_datos_idcli_ident ?>" disabled=""/>
        <label>Veh&iacute;culo :</label>&nbsp;
        <input type="text" style="width:200px;" id="pag_veh" name="pag_veh" value="<?Php echo $veh_datos_idveh_placa ?>" disabled=""/>
        <br></br>

        <label>Observaci&oacute;n :</label> &nbsp; 
        <textarea id="observ" name="observ" maxlength="255" rows="5" cols="90" placeholder="Max 255..." disabled=""><?Php echo $observac; ?></textarea>
    </p>
    <?Php
}

function verpagoswherecondition($fech, $mnt, $bplaca) 
{
    $conn = $this->objconec;
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
//        $sentenverpag = "SELECT * FROM `det_pag`, lis_pag WHERE det_pag.lis_pag_id_pag=lis_pag.id_pag and det_pag.fech_reg='" . $fech . "' or det_pag.monto='" floatval($mnt) . "' ORDER BY det_pag.iddet_pag DESC ";
    $sentenverpag = "SELECT * FROM `det_pag` WHERE det_pag.fech_reg='" . $fech . "' or"
    . " det_pag.monto='" . $mnt . "' or veh_datos_idveh_placa='" . $bplaca . "' ORDER BY det_pag.iddet_pag DESC ";

    $sumadetot = "SELECT SUM(`monto`) as suma FROM `det_pag` WHERE det_pag.fech_reg='" . $fech . "' or veh_datos_idveh_placa='" . $bplaca . "' ";
    $ejesuma = mysqli_query($conn, $sumadetot);
    $datsuma = mysqli_fetch_assoc($ejesuma);
    $total = $datsuma['suma'];

    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        echo "<table border=1><tr align=center style='color:red'><td>PLACA</td><td>RAZÓN</td><td>FECHA</td><td>VALOR</td>";
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            echo "<tr>";
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];

            $sqldata = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='" . $lis_pag_id_pag . "'";
            $dat = mysqli_query($c, $sqldata);
            $row1 = mysqli_fetch_assoc($dat);
            $nom_pag = $row1['nombre_cuenta_plan'];

            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observ = $row['observ'];
            $clien = $row['clien'];
            echo "<td>" . $veh_datos_idveh_placa . "</td>";
            echo "<td>" . $nom_pag . "</td>";
            echo "<td>" . $fech_reg . "</td>";
            echo "<td>" . $monto . "</td>";
            echo "<td>" . "<button name='verpagootros' value='" . $row['iddet_pag'] . "' >VER</button>" . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo 'Total : ' . $total;
    }
}

function verpagfech($fech) 
{
    $conn = $this->objconec;
    $sentenverpag = "SELECT * FROM `det_pag`, lis_pag WHERE det_pag.lis_pag_id_pag=lis_pag.id_pag and det_pag.fech_reg='" . $fech . "'"
    . " ORDER BY det_pag.iddet_pag DESC ";
    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        echo "<table border=1><tr align=center style='color:red'><td>CONCEPTO</td><td>FECHA</td><td>VALOR</td>";
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            echo "<tr>";
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];
            $nom_pag = $row['nom_pag'];
            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observ = $row['observ'];
            $clien = $row['clien'];
            echo "<td>" . $nom_pag . "</td>";
            echo "<td>" . $fech_reg . "</td>";
            echo "<td>" . $monto . "</td>";
            echo "<td>" . "<button name='verpagootros' value='" . $row['iddet_pag'] . "' >VER</button>" . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function verpagmonto($monto) 
{
    $conn = $this->objconec;
    $sentenverpag = "SELECT * FROM `det_pag`, lis_pag WHERE det_pag.lis_pag_id_pag=lis_pag.id_pag and det_pag.monto='" . $monto . "'"
    . " ORDER BY det_pag.iddet_pag DESC ";
    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        echo "<table border=1><tr align=center style='color:red'><td>CONCEPTO</td><td>FECHA</td><td>VALOR</td>";
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            echo "<tr>";
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];
            $nom_pag = $row['nom_pag'];
            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observ = $row['observ'];
            $clien = $row['clien'];
            echo "<td>" . $nom_pag . "</td>";
            echo "<td>" . $fech_reg . "</td>";
            echo "<td>" . $monto . "</td>";
            echo "<td>" . "<button name='verpagootros' value='" . $row['iddet_pag'] . "' >VER</button>" . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function verpagdepos($depos) 
{
    $conn = $this->objconec;
    $sentenverpag = "SELECT * FROM `det_pag`, lis_pag WHERE det_pag.lis_pag_id_pag=lis_pag.id_pag and det_pag.tran_realiz='" . $depos . "'"
    . " ORDER BY det_pag.iddet_pag DESC ";
    $resultpagos = mysqli_query($conn, $sentenverpag) or trigger_error("Query Failed! SQL: $sentenverpag- Error: " . mysqli_error($conn), E_USER_ERROR);
    if ($resultpagos) {
        echo "<table border=1><tr align=center style='color:red'><td>CONCEPTO</td><td>FECHA</td><td>VALOR</td>";
        while ($row = mysqli_fetch_assoc($resultpagos)) {
            echo "<tr>";
            $iddet_pag = $row['iddet_pag'];
            $lis_pag_id_pag = $row['lis_pag_id_pag'];
            $nom_pag = $row['nom_pag'];
            $cli_datos_idcli_ident = $row['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $row['veh_datos_idveh_placa'];
            $fech_reg = $row['fech_reg'];
            $monto = $row['monto'];
            $tran_realiz = $row['tran_realiz'];
            $user = $row['user'];
            $observ = $row['observ'];
            $clien = $row['clien'];
            echo "<td>" . $nom_pag . "</td>";
            echo "<td>" . $fech_reg . "</td>";
            echo "<td>" . $monto . "</td>";
            echo "<td>" . "<button name='verpagootros' value='" . $row['iddet_pag'] . "' >VER</button>" . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

}
