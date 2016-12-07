<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contabilidad
 *
 * @author alberto
 */
class contabilidad {

    public $cli_id;
    public $nombre_cauxiliar;

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
        return $this->objconec;
    }

    function crear_cta_clte($nombre_cauxiliar, $cli_id) {
        $conn = $this->objconec;
        $sql = "SELECT * FROM t_plan_de_cuentas where t_subcuenta_cod_subcuenta = '1.1.2.1.' order by idt_plan_de_cuentas DESC";
        $result = mysqli_query($conn, $sql);
        $dato = mysqli_fetch_array($result);
        $cont = $dato['cod_cuenta'];
        $cont = substr($cont, 8);
        $cont = $cont + 1;
        $cont = $cont . '.';
        $cuenta = '1.1.2.1.' . $cont;
        $sql = "INSERT INTO t_plan_de_cuentas(cod_cuenta, nombre_cuenta_plan, descripcion_cuenta_plan, t_clase_cod_clase, t_grupo_cod_grupo, t_cuenta_cod_cuenta, t_subcuenta_cod_subcuenta, t_auxiliar_cod_cauxiliar, t_subauxiliar_cod_subauxiliar) "
        . "VALUES ('$cuenta', '$nombre_cauxiliar', ' ', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '$cuenta', '')";
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO t_auxiliar(nombre_cauxiliar, cod_cauxiliar, descrip_auxiliar, "
        . "t_subcuenta_cod_subcuenta, t_cuenta_cod_cuenta, t_grupo_cod_grupo, t_clase_cod_clase, placa_id, cli_id) "
        . "VALUES ('$nombre_cauxiliar', '$cuenta', ' ', '1.1.2.1.', '1.1.2.', '1.1.', '1.', ' ', '$cli_id')";
        mysqli_query($conn, $sql);
    }

    function crear_cta_interes($cli) {
        $conn = $this->objconec;
        $sql = "select * from t_auxiliar where cli_id='$cli' ";
        $result = mysqli_query($conn, $sql);
        $dato = mysqli_fetch_array($result);
        $nom_cta = $dato['nombre_cauxiliar'];
        $id_clicta = $dato['cli_id'];

        $sqldeu = "SELECT * FROM t_plan_de_cuentas where t_clase_cod_clase = '7.' order by idt_plan_de_cuentas DESC";
        $resultdeu = mysqli_query($conn, $sqldeu);
        $datodeu = mysqli_fetch_array($resultdeu);
        $contdeu = $datodeu['cod_cuenta'];
        $contdeu = substr($contdeu, 2);
        $contdeu = $contdeu + 1;
        $contdeu = $contdeu . '.';
        $cuentadeu = '7.' . $contdeu;

        $sqlac = "SELECT * FROM t_plan_de_cuentas where t_clase_cod_clase = '8.' order by idt_plan_de_cuentas DESC";
        $resultac = mysqli_query($conn, $sqlac);
        $datoac = mysqli_fetch_array($resultac);
        $contac = $datoac['cod_cuenta'];
        $contac = substr($contac, 2);
        $contac = $contac + 1;
        $contac = $contac . '.';
        $cuentaac = '8.' . $contac;

        $inser_deu = "INSERT INTO `t_grupo`(`nombre_grupo`, `cod_grupo`, `descrip_grupo`, `t_clase_cod_clase`) "
        . "VALUES ('$nom_cta','$cuentadeu','$nom_cta','7.')";
        mysqli_query($conn, $inser_deu);

        $ins_pln = "INSERT INTO t_plan_de_cuentas(cod_cuenta, nombre_cuenta_plan, t_clase_cod_clase, t_grupo_cod_grupo) "
        . "VALUES ('$cuentadeu', '$nom_cta', '7.', '$cuentadeu')";
        mysqli_query($conn, $ins_pln);

        $inser_ac = "INSERT INTO `t_grupo`(`nombre_grupo`, `cod_grupo`, `descrip_grupo`, `t_clase_cod_clase`) "
        . "VALUES ('$nom_cta','$cuentaac','$nom_cta','8.')";
        mysqli_query($conn, $inser_ac);

        $ins_plac = "INSERT INTO t_plan_de_cuentas(cod_cuenta, nombre_cuenta_plan, t_clase_cod_clase, t_grupo_cod_grupo) "
        . "VALUES ('$cuentaac', '$nom_cta', '8.', '$cuentaac')";
        mysqli_query($conn, $ins_plac);

        $ins_datcli = "INSERT INTO `int_datcli` (`id_cli`, `nom_cli`, `acree`, `deud`) VALUES"
        . "('$id_clicta', '$nom_cta',  '$cuentaac', '$cuentadeu');";
        mysqli_query($conn, $ins_datcli);

//        echo '<script language = javascript>
//  alert("' . $nom_cta . ' ' . $cuentadeu . '")
//  </script>';
    }

    function crear_cta_veh($nombre_cauxiliar, $placa_id) {
        $conn = $this->objconec;
        $estado = $_POST['veh_estado'];
        if (($estado) == 0) {
            $sql = "SELECT * FROM t_plan_de_cuentas where t_subcuenta_cod_subcuenta = '1.1.3.1.' order by idt_plan_de_cuentas DESC";
            $cuenta0 = '1.1.3.1.';
        }
        if (($estado) == 1) {
            $sql = "SELECT * FROM t_plan_de_cuentas where t_subcuenta_cod_subcuenta = '1.1.3.2.' order by idt_plan_de_cuentas DESC";
            $cuenta0 = '1.1.3.2.';
        }
        $result = mysqli_query($conn, $sql);
        $dato = mysqli_fetch_array($result);
        $cont = $dato['cod_cuenta'];
        $cont = substr($cont, 8);
        $cont = $cont + 1;
        $cont = $cont . '.';
        $cuenta = $cuenta0 . $cont;
        $sql = "INSERT INTO t_plan_de_cuentas(cod_cuenta, nombre_cuenta_plan, descripcion_cuenta_plan, t_clase_cod_clase, t_grupo_cod_grupo, t_cuenta_cod_cuenta, t_subcuenta_cod_subcuenta, t_auxiliar_cod_cauxiliar, t_subauxiliar_cod_subauxiliar) "
        . "VALUES ('$cuenta', '$nombre_cauxiliar', ' ', '1.', '1.1.', '1.1.3.', '$cuenta0', '$cuenta', '')";
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO t_auxiliar(nombre_cauxiliar, cod_cauxiliar, descrip_auxiliar, "
        . "t_subcuenta_cod_subcuenta, t_cuenta_cod_cuenta, t_grupo_cod_grupo, t_clase_cod_clase, placa_id, cli_id) "
        . "VALUES ('$nombre_cauxiliar', '$cuenta', ' ', '$cuenta0', '1.1.3.', '1.1.', '1.', '$placa_id', '')";
        mysqli_query($conn, $sql);
    }

    function vercuenta($id_veh) {
        if ($id_veh == "") {
            ?>

            <p style="font-size:13px; text-align: center; color: #CC0000;">
                <label>Complete el campo</label>&nbsp;&nbsp;
            </br>

        </p>
        <?Php
    } else {
        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
        $sql = "SELECT * FROM `t_auxiliar` WHERE `placa_id`='$id_veh' ";
        $result = mysqli_query($c, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($c), E_USER_ERROR);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $varveh = $row["cod_cauxiliar"];
            ?>
            <!--<p style="font-size:13px; text-align: left">-->
            <tr>
                <td>                   
                    <label>Cuenta :</label>
                    <input type="text" style="width:200px;" id="cod_veh" name="cod_veh" value="<?php echo $varveh; ?>" readonly="readonly" placeholder="Cod." />
                </td>
            </tr>
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
    mysqli_close($c);
}
}

function vercuentacli($id_cli) {
    if ($id_cli == "") {
        ?>
        <p style="font-size:13px; text-align: center; color: #CC0000;">
            <label>Complete el campo</label>&nbsp;&nbsp;
        </br>
    </p>
    <?Php
} else {
    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
    $sqlcli = "SELECT * FROM `t_auxiliar` WHERE `cli_id`='" . $id_cli . "' ";
    $resultcli = mysqli_query($c, $sqlcli) or trigger_error("Query Failed! SQL: $sqlcli - Error: " . mysqli_error($c), E_USER_ERROR);
    if ($resultcli->num_rows > 0) {
        $rowcli = mysqli_fetch_assoc($resultcli);
        $varcli = $rowcli["cod_cauxiliar"];
        ?>
        <!--<p style="font-size:13px; text-align: left">-->
        <tr>
            <td>
                <label>Cuenta :</label>
                <input type="text" style="width:200px;" id="cod_cli" name="cod_cli" value="<?php echo $varcli; ?>" readonly="readonly" placeholder="Cod." />
            </td>
        </tr>
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
mysqli_close($c);
}
}

function gen_ass_temp($campos) {
    date_default_timezone_set("America/Guayaquil");
    $fecha = date('Y-m-d');
    if ($campos[9] == "") {
        echo '<script>alert("SELECCIONE INGRESO O EGRESO")</script>';
    } else {
        $cc = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
        $c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query1 = "SELECT * FROM `t_auxiliar` WHERE `placa_id`='$campos[12]' ";
        $result1 = mysqli_query($cc, $query1) or trigger_error("Query Failed! SQL: $query1 - Error: " . mysqli_error($cc), E_USER_ERROR);
        $row1 = mysqli_fetch_assoc($result1);
        $daton1 = $row1["nombre_cauxiliar"];
        $dato1 = $row1["cod_cauxiliar"];
        $dato1g = $row1["t_grupo_cod_grupo"];

        $query2 = "SELECT * FROM `t_auxiliar` WHERE `cli_id`='" . $campos[11] . "' ";
        $result2 = mysqli_query($cc, $query2) or trigger_error("Query Failed! SQL: $query2 - Error: " . mysqli_error($cc), E_USER_ERROR);
        $row2 = mysqli_fetch_assoc($result2);
        $daton2 = $row2["nombre_cauxiliar"];
        $dato2 = $row2["cod_cauxiliar"];
        $dato2g = $row2["t_grupo_cod_grupo"];

        $query = "INSERT INTO `gen_ass_temp` ( `tip_pg`, `frm`, `doc`, `mnt`, `fecha`, `interes`, `plazo`, `estado`, `concepto`, `user`, `transacc`, `carpeta`,cli,veh,cod_cli,cod_veh,tot_val_veh,"
        . "g_cli,g_veh,n_cli,n_veh) VALUES"
        . " ( '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $fecha . "', '" . $campos[5] . "', '" . $campos[6] . "', '" . $campos[7] . "', 'Concepto de ass', '" . $campos[8] . "',"
        . " '" . $campos[9] . "', '" . $campos[10] . "','" . $campos[11] . "','" . $campos[12] . "','$dato2','$dato1','" . $campos[13] . "',"
        . "'" . $dato2g . "','" . $dato1g . "','" . $daton2 . "','" . $daton1 . "');";
        mysqli_query($c, $query);
        $cc->close();
        $c->close();
    }
}

function gen_ass_interes($id_cli, $cli_nom, $tot_intr, $nom_cta, $deu, $acre) {
    $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
    date_default_timezone_set("America/Guayaquil");
    $fecha = date('Y-m-d');
    $conceptoass = "Asiento generado por intereses de cliente " . $cli_nom . " con ID " . $id_cli;
    $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
    $resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcont) {
        while ($rowcont = mysqli_fetch_assoc($resultcont)) {
            $incremento = $rowcont['id'];
            $asiento_num = $incremento;
        }
    }
    $user = $_SESSION['user'];
    if ($user == "root") {
        $userident = "2";
    } else {
        $userident = "1";
    }
    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
    $result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $maxbalancedato = $row['id'];
        }
    }
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
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
    $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
    . " `t_ejercicio_idt_corrientes`, mes,year)VALUES ('" . $incremento . "' , '" . $fecha . "', '" . trim($conceptoass) . "', "
    . "'" . $maxbalancedato . "','" . $asiento_num . "','" . $month . "','" . $year . "');";
    mysqli_query($con, $insertasientoconcepto);


    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $acre . "',"
    . "'" . $nom_cta . "','0.00','" . $tot_intr . "','" . $maxbalancedato . "','$acre',"
    . "'" . $userident . "','$acre','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
    . "'" . $deu . "','" . $nom_cta . "','" . $tot_intr . "','0.00','" . $maxbalancedato . "',"
    . "'$deu','" . $userident . "','$deu','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
}

function gen_ass_interes_adic($id_cli, $cli_nom, $tot_intr, $nom_cta, $deu, $acre) {
//         echo '<script>alert("aqui addic")</script>';
    $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
    date_default_timezone_set("America/Guayaquil");
    $fecha = date('Y-m-d');
    $conceptoass = "Asiento generado por intereses adicionales de cliente " . $cli_nom . " con ID " . $id_cli;
    $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
    $resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcont) {
        while ($rowcont = mysqli_fetch_assoc($resultcont)) {
            $incremento = $rowcont['id'];
            $asiento_num = $incremento;
        }
    }
    $user = $_SESSION['user'];
    if ($user == "root") {
        $userident = "2";
    } else {
        $userident = "1";
    }
    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
    $result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $maxbalancedato = $row['id'];
        }
    }
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
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
    $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
    . " `t_ejercicio_idt_corrientes`, mes,year)VALUES ('" . $incremento . "' , '" . $fecha . "', '" . trim($conceptoass) . "', "
    . "'" . $maxbalancedato . "','" . $asiento_num . "','" . $month . "','" . $year . "');";
    mysqli_query($con, $insertasientoconcepto);


    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $acre . "',"
    . "'" . $nom_cta . "','0.00','" . $tot_intr . "','" . $maxbalancedato . "','$acre',"
    . "'" . $userident . "','$acre','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
    . "'" . $deu . "','" . $nom_cta . "','" . $tot_intr . "','0.00','" . $maxbalancedato . "',"
    . "'$deu','" . $userident . "','$deu','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
}

function ass_intrs_cuot($id_cta_int, $cta_int, $acree, $deud, $tran_cre_interes) {
    $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
    date_default_timezone_set("America/Guayaquil");
    $fecha = date('Y-m-j');
    $conceptoass = "Cobro de interes cuenta " . $cta_int . " con ID " . $id_cta_int . " por el valor " . $tran_cre_interes;
    $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
    $resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcont) {
        while ($rowcont = mysqli_fetch_assoc($resultcont)) {
            $incremento = $rowcont['id'];
            $asiento_num = $incremento;
        }
    }
    $user = $_SESSION['user'];
    if ($user == "root") {
        $userident = "2";
    } else {
        $userident = "1";
    }
    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
    $result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $maxbalancedato = $row['id'];
        }
    }
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
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
    $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
    . " `t_ejercicio_idt_corrientes`, mes,year)VALUES ('" . $incremento . "' , '" . $fecha . "', '" . trim($conceptoass) . "', "
    . "'" . $maxbalancedato . "','" . $asiento_num . "','" . $month . "','" . $year . "');";
    mysqli_query($con, $insertasientoconcepto);
    $intereses_ganados = '4.1.2.1.';
    $intereses_ganados_cta = 'INTERESES GANADOS';
    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $intereses_ganados . "',"
    . "'" . $intereses_ganados_cta . "','0.00','" . $tran_cre_interes . "','" . $maxbalancedato . "','4.1.',"
    . "'" . $userident . "','4.1.','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }
    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
    . "'" . $deud . "','" . $cta_int . "','" . $tran_cre_interes . "','0.00','" . $maxbalancedato . "',"
    . "'$deud','" . $userident . "','$deud','" . $month . "','" . $year . "');";
    mysqli_query($con, $sqldeb);
}

function insert_ass_venta($id_pl, $id_cli, $tip_trs, $pago, $forma) {
    date_default_timezone_set("America/Guayaquil");
    $fecha = date('Y-m-j');
    if ($tip_trs == "") {
        echo '<script>alert("SELECCIONE INGRESO O EGRESO O VENTA")</script>';
    } else {
        if (($id_cli == "") or ( $id_pl == "")) {
            echo '<script>alert("UNO DE LOS CAMPOS ESTA VACIO, DEBE COMPLETARLOS")</script>';
        } else {
//              inicia realiza multi-consulta de cuntas
            $c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');

            $query1 = "SELECT * FROM `t_auxiliar` WHERE `placa_id`='$id_pl'; ";
            $query2 = "SELECT * FROM `t_auxiliar` WHERE `cli_id`='" . $id_cli . "'; ";
            $result1 = mysqli_query($c, $query1) or trigger_error("Query Failed! SQL: $query1 - Error: " . mysqli_error($c), E_USER_ERROR);
            $result2 = mysqli_query($c, $query2) or trigger_error("Query Failed! SQL: $query2 - Error: " . mysqli_error($c), E_USER_ERROR);
            $row1 = mysqli_fetch_assoc($result1);
            $row2 = mysqli_fetch_assoc($result2);
            $dato1 = $row1["cod_cauxiliar"];
            $dato2 = $row2["cod_cauxiliar"];
            /* cerrar conexión */
            if ($tip_trs == "COMPRA") {
//                    echo '<script>alert("COMPRA")</script>';
            } else {
//                    echo '<script>alert("VENTA")</script>';                
            }
            $c->close();
//              fin realiza multi-consulta de cuntas
        }
    }
}

    function insert_ass($tip, $pl, $cli, $ganancia, $carpeta, $cuenta_ganancia) { //, $cuenta
        date_default_timezone_set("America/Guayaquil");
        $fecha = date('Y-m-d');
        $c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
        $queryconsul = "SELECT * FROM `gen_ass_temp` order BY `idgen_ass_temp` DESC ";
        $restrs = mysqli_query($c, $queryconsul);
        $user = $_SESSION['user'];
        if ($user == "root") {
            $userident = "2";
        } else {
            $userident = "1";
        }

        $conceptoass = ".../ Asiento generado / " . $tip . " vehículo de placa " . $pl . " por cliente con Id num " . $cli;

        $contreg = "SELECT count( * ) as contreg FROM `gen_ass_temp`";
        $ejequery = mysqli_query($c, $contreg);
        $datocont = mysqli_fetch_array($ejequery);
        $cont = $datocont['contreg'];

//        inserta la cabecera del asiento contable

        $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
        $resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
        if ($resultcont) {
            while ($rowcont = mysqli_fetch_assoc($resultcont)) {
                $incremento = $rowcont['id'];
                $asiento_num = $incremento;
            }
        }
        $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
        $result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $maxbalancedato = $row['id'];
            }
        }
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
        $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
        . " `t_ejercicio_idt_corrientes`, mes,year)VALUES ('" . $incremento . "' , '" . $fecha . "', '" . trim($conceptoass) . "', "
        . "'" . $maxbalancedato . "','" . $asiento_num . "','" . $month . "','" . $year . "');";
        mysqli_query($con, $insertasientoconcepto);


//        obtiene datos temporales para generar assiento contable.
        while ($datotrans = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $idgen_ass_temp = $datotrans['idgen_ass_temp'];
            $tip_pg = $datotrans['tip_pg'];
            $frm = $datotrans['frm'];
            $doc = $datotrans['doc'];
            $mnt = $datotrans['mnt'];
            $fecha = $datotrans['fecha'];
            $interes = $datotrans['interes'];
            $plazo = $datotrans['plazo'];
            $estado = $datotrans['estado'];
            $concepto = $datotrans['concepto'];
            $user = $datotrans['user'];
            $transacc = $datotrans['transacc'];
            $carpeta = $datotrans['carpeta'];
            $cli = $datotrans['cli'];
            $veh = $datotrans['veh'];
            $n_cli = $datotrans['n_cli'];
            $n_veh = $datotrans['n_veh'];
            $cod_cli = $datotrans['cod_cli'];
            $cod_veh = $datotrans['cod_veh'];
            $g_cli = $datotrans['g_cli'];
            $g_veh = $datotrans['g_veh'];
            $tot_val_veh = $datotrans['tot_val_veh'];
//            $conceptoass = "Asiento " . $tip_pg . " de " . $n_veh . " con el valor de " . $mnt . " carpeta generada " . $carpeta . " a " . $n_cli . " el " . $fecha . " forma " . $frm;
            list($year, $month, $dia) = explode("-", $fecha);
            $n_cu = $doc;
            $con_cod = "SELECT * FROM `t_plan_de_cuentas` WHERE `nombre_cuenta_plan`='$n_cu' ";
            $res_cod = mysqli_query($con, $con_cod) or trigger_error("Query Failed! SQL: $con_cod - Error: " . mysqli_error($con), E_USER_ERROR);
            if ($res_cod) {
                while ($row_cod = mysqli_fetch_assoc($res_cod)) {
                    $c_cu = $row_cod['cod_cuenta'];
                }
            }
//            Banco de Guayaquil
//            list($n_cu, $c_cu) = explode("_", $doc);
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
            if ($transacc == "INGRESO") {
                $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
                $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
                if ($resultcontej) {
                    while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
                        $incrementoej = $rowcontej['id'];
                    }
                }
                if ($tip_pg == "ENTRADA" && $frm == "EFECTIVO") {
                    $c_nomhab = "Caja General";
                    $cod_cuenthab = "1.1.1.1.2.";
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $cod_cuenthab . "',"
                    . "'" . $c_nomhab . "','0.00','" . $mnt . "','" . $maxbalancedato . "','" . $grup_hab . "',"
                    . "'" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ENTRADA" && $frm == "CHEQUE") {
                    $c_nomhab = $n_cu;
                    $cod_cuenthab = $c_cu;
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $cod_cuenthab . "',"
                    . "'" . $c_nomhab . "','0.00','" . $mnt . "','" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "',"
                    . "'" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ENTRADA" && $frm == "VEHICULO") {
                    $c_nomhab = $n_cu;
                    $cod_cuenthab = $c_cu;
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $cod_cuenthab . "',"
                    . "'" . $c_nomhab . "','0.00','" . $mnt . "','" . $maxbalancedato . "','" . $grup_hab . "',"
                    . "'" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                    
                    $sql_ver_veh_ct = "select * from t_auxiliar where nombre_cauxiliar='".$c_nomhab."'";
                    $res_vr_vh_ct = mysqli_query($con, $sql_ver_veh_ct);
                    $resd_vr = mysqli_fetch_array($res_vr_vh_ct, MYSQLI_BOTH);
                    $pl_ver_ct = $resd_vr['placa_id'];
                    $query_up = "UPDATE veh_datos SET veh_estado = '2' where idveh_placa='".$pl_ver_ct."'";
                    mysqli_query($c, $query_up);
                    
                }
                
                if ($tip_pg == "ADICIONAL" && $frm == "EFECTIVO") {
                    $c_nomhab = "Caja General";
                    $cod_cuenthab = "1.1.1.1.2.";
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,"
                    . "`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "',"
                    . "'" . $asiento_num . "','" . $cod_cuenthab . "','" . $c_nomhab . "','0.00','" . $mnt . "',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ADICIONAL" && $frm == "CHEQUE") {
                    $c_nomhab = "BANCOS";
                    $cod_cuenthab = "1.1.1.2.";
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,"
                    . "`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "',"
                    . "'" . $asiento_num . "','" . $cod_cuenthab . "','" . $c_nomhab . "','0.00','" . $mnt . "',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ADICIONAL" && $frm == "VEHICULO") {
                    $c_nomhab = $n_cu;
                    $cod_cuenthab = $c_cu;
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,"
                    . "`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','0.00','" . $mnt . "','" . $maxbalancedato . "',"
                    . "'" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                    
                    $sql_ver_veh_ct = "select * from t_auxiliar where nombre_cauxiliar='".$c_nomhab."'";
                    $res_vr_vh_ct = mysqli_query($con, $sql_ver_veh_ct);
                    $resd_vr = mysqli_fetch_array($res_vr_vh_ct, MYSQLI_BOTH);
                    $pl_ver_ct = $resd_vr['placa_id'];
                    $query_up = "UPDATE veh_datos SET veh_estado = '2' where idveh_placa='".$pl_ver_ct."'";
                    mysqli_query($c, $query_up);
                    
                    
                }
                if ($tip_pg == "ADICIONAL" && $frm == "LETRA DE CAMBIO") {
                    $c_nomhab = $n_cli;
                    $cod_cuenthab = $cod_cli;
                    $grup_hab = $g_cli;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','0.00','" . $mnt . "','" . $maxbalancedato . "',"
                    . "'" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                
                if ($tip_pg == "CREDITO" && $frm == "LETRA DE CAMBIO") {
                    $c_nomhab = $n_cli;
                    $cod_cuenthab = $cod_cli;
                    $grup_hab = $g_cli;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "',"
                    . "'" . $asiento_num . "','" . $cod_cuenthab . "','" . $c_nomhab . "','0.00','" . $mnt . "',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                
                if ($tip_pg == "INGRESO" && $frm == "VALOR TOTAL") {
                    $c_nomdeb = $n_veh;
                    $cod_cuentdeb = $cod_veh;
                    $grup_deb = $g_veh;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuentdeb . "','" . $c_nomdeb . "','" . $mnt . "','0.00','" . $maxbalancedato . "',"
                    . "'" . $grup_deb . "','" . $userident . "','" . $grup_deb . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                mysqli_query($c, "DELETE FROM gen_ass_temp");
            } elseif ($transacc == "EGRESO") {

                $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
                $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
                if ($resultcontej) {
                    while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
                        $incrementoej = $rowcontej['id'];
                    }
                }
                if ($tip_pg == "ENTRADA" && $frm == "EFECTIVO") {
                    $c_nomhab = "Caja General";
                    $cod_cuenthab = "1.1.1.1.2.";
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "','" . $cod_cuenthab . "',"
                    . "'" . $c_nomhab . "','" . $mnt . "','0.00','" . $maxbalancedato . "','" . $grup_hab . "',"
                    . "'" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ENTRADA" && $frm == "CHEQUE") {
                    $c_nomhab = $n_cu;
                    $cod_cuenthab = $c_cu;
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','" . $mnt . "','0.00',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ENTRADA" && $frm == "VEHICULO") {
                    $c_nomhab = $n_cu;
                    $cod_cuenthab = $c_cu;
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','" . $mnt . "','0.00',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                
                if ($tip_pg == "ADICIONAL" && $frm == "CHEQUE") {
                    $c_nomhab = $n_cu;//"BANCOS";
                    $cod_cuenthab = $c_cu;// "1.1.1.2.";
                    $grup_hab = "1.1.";
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,"
                    . "`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','" . $mnt . "','0.00',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "ADICIONAL" && $frm == "LETRA DE CAMBIO") {
                    $c_nomhab = $n_cli;
                    $cod_cuenthab = $cod_cli;
                    $grup_hab = $g_cli;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','" . $mnt . "','0.00','" . $maxbalancedato . "','" . $grup_hab . "',"
                    . "'" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                
                if ($tip_pg == "CREDITO" && $frm == "LETRA DE CAMBIO") {
                    $c_nomhab = $n_cli;
                    $cod_cuenthab = $cod_cli;
                    $grup_hab = $g_cli;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,"
                    . "`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuenthab . "','" . $c_nomhab . "','" . $mnt . "','0.00',"
                    . "'" . $maxbalancedato . "','" . $grup_hab . "','" . $userident . "','" . $grup_hab . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);
                }
                if ($tip_pg == "EGRESO" && $frm == "VALOR TOTAL") {
                    $c_nomdeb = $n_veh;
                    $cod_cuentdeb = $cod_veh;
                    $grup_deb = $g_veh;
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES ('" . $incrementoej . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cod_cuentdeb . "','" . $c_nomdeb . "','0.00','" . $mnt . "','" . $maxbalancedato . "','" . $grup_deb . "',"
                    . "'" . $userident . "','" . $grup_deb . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);

                    $consultacontadorejg = "SELECT count( * )+1 as id FROM `libro`";
                    $resultcontejg = mysqli_query($con, $consultacontadorejg) or trigger_error("Query Failed! SQL: $consultacontadorejg - Error: " . mysqli_error($con), E_USER_ERROR);
                    if ($resultcontejg) {
                        while ($rowcontejg = mysqli_fetch_assoc($resultcontejg)) {
                            $incrementoejg = $rowcontejg['id'];
                        }
                    }
                    $query1 = "SELECT * FROM `tran_cab` tc JOIN veh_datos vh WHERE tc.`tran_veh_placas`='$pl' and tc.`idtran_cab`='$carpeta' and tc.`tran_veh_placas`=vh.idveh_placa ";
                    $result1 = mysqli_query($c, $query1) or trigger_error("Query Failed! SQL: $query1 - Error: " . mysqli_error($c), E_USER_ERROR);
                    $row1 = mysqli_fetch_assoc($result1);
                    $tip_ganancia = $row1["veh_estado"];
                    if ($tip_ganancia == '0') {
                        $estado_g = "CONSIGNACION";
                        $cuenta_g = "4.1.1.2.";
                        $grp_g = "4.1.1.";
                    }
                    if ($tip_ganancia == '1') {
                        $estado_g = "COMISION";
                        $cuenta_g = "4.1.1.1.";
                        $grp_g = "4.1.1.";
                    }
                    $nom_cuenta = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='$cuenta_g' ";
                    $result_nom = mysqli_query($con, $nom_cuenta) or trigger_error("Query Failed! SQL: $nom_cuenta- Error: " . mysqli_error($con), E_USER_ERROR);
                    while ($row_nom = mysqli_fetch_array($result_nom)) {
                        $nombre_c_gnc = $row_nom['nombre_cuenta_plan'];
                    }
                    $sqldeb = "INSERT INTO `condata`.`libro` (`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,`t_bl_inicial_idt_bl_inicial` ,"
                    . "`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,`year`) VALUES "
                    . "('" . $incrementoejg . "','" . $fecha . "','" . $asiento_num . "',"
                    . "'" . $cuenta_g . "','" . $nombre_c_gnc . "','0.00','" . $ganancia . "','" . $maxbalancedato . "','" . $grp_g . "',"
                    . "'" . $userident . "','" . $grp_g . "','" . $month . "','" . $year . "');";
                    mysqli_query($con, $sqldeb);

//        if (($tipo)=='EGRESO' ) {
                    $query_up = "UPDATE veh_datos SET veh_estado = '2' where idveh_placa='$pl'";
                    mysqli_query($c, $query_up);
//        }
//                mysqli_query($c, "delete from gen_ass_temp");
                }
            }
        }
    }

    function eliminarfila($key) {
        $c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query = "DELETE FROM `gen_ass_temp` WHERE `gen_ass_temp`.`carpeta` = '" . $key . "' ";
        $query2 = "DELETE FROM `tran_det_temp` WHERE `idtran_det_cab` = '" . $key . "' ";
        mysqli_query($c, $query);
        mysqli_query($c, $query2);
    }

    function vaciar_tab() {
        $c = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $query = "DELETE from gen_ass_temp";
        $query2 = "DELETE from tran_det_temp";
        mysqli_query($c, $query);
        mysqli_query($c, $query2);
    }

}
