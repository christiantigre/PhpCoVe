<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Transacc {

    public $idtran_cab;
    public $tran_cab_tipo;
    public $tran_cab_fecha;
    public $tran_veh_placas;
    public $tran_cli_ident;
    public $tran_cab_precio;
    public $tran_cab_seguro;
    public $tran_cab_gastos;

//function __construct($idtran_cab, $tran_cab_tipo, $tran_cab_fecha, $tran_veh_placas, $tran_cli_ident, $tran_cab_precio, $tran_cab_seguro, $tran_cab_gastos){
//    $this->idtran_cab = $idtran_cab;
//    $this->tran_cab_tipo = $tran_cab_tipo;
//    $this->tran_cab_fecha = $tran_cab_fecha;
//    $this->tran_veh_placas = $tran_veh_placas;
//    $this->tran_cli_ident = $tran_cli_ident;
//    $this->tran_cab_precio = $tran_cab_precio;
//    $this->tran_cab_seguro = $tran_cab_seguro;
//    $this->tran_cab_gastos = $tran_cab_gastos;
//}
    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function verifica_transac($tran_veh_placa, $tran_tipo) {
        $conn = $this->objconec;
        $query = "SELECT * from tran_cab where tran_veh_placas = '$tran_veh_placa' order by idtran_cab ";
        $resul = mysqli_query($conn, $query);
        $cont = count($resul);
        if (($cont) != 0) {
            while ($row = mysqli_fetch_array($resul)) {
                $sec_tipo = $row['tran_cab_tipo'];
            }
            if (($sec_tipo) == 'INGRESO' & ($tran_tipo) == 'INGRESO') {
                echo "<script>alert('NO PUEDE INGRESAR, EL VEHICULO ESTA INGRESADO')</script>";
                return $tran_tipo;
            }
            if (($sec_tipo) == 'EGRESO' & ($tran_tipo) == 'EGRESO') {
                echo "<script>alert('NO PUEDE VENDER, EL VEHICULO NO ESTA INGRESADO')</script>";
                return $tran_tipo;
            }
        }
    }

    function insertar_cabecera($idtran_cab, $tipo, $fecha, $tran_veh_placas, $tran_cli_ident, $tran_cab_precio, $tran_cab_seguro, $tran_cab_gastos) {
        $trs_tipo = $tipo;
        $conn = $this->objconec;
        $query = "SELECT * FROM tran_cab where tran_cab_tipo = '$trs_tipo' ORDER BY tran_sec_tipo DESC";
        $result = mysqli_query($conn, $query);
        $cont = mysqli_num_rows($result);
        if (($cont) == 0) {
            $sec_trs = 1;
        } else {
            $num_sec = mysqli_fetch_array($result);
            $sec_trs = $num_sec['tran_sec_tipo'];
            $sec_trs = $sec_trs + 1;
        }
        $query = "INSERT INTO tran_cab(idtran_cab, tran_sec_tipo, tran_cab_tipo, tran_cab_fecha, tran_veh_placas, tran_cli_ident, tran_cab_precio, tran_cab_seguro, tran_cab_gastos) "
                . "VALUES('$idtran_cab', '$sec_trs', '$tipo', '$fecha', '$tran_veh_placas', '$tran_cli_ident', '$tran_cab_precio', '$tran_cab_seguro', '$tran_cab_gastos')";
        mysqli_query($conn, $query);
    }

    function insertar_detalle() {
        $conn = $this->objconec;
        $query = "INSERT INTO tran_det (idtran_det_cab, tran_det_pago, tran_det_forma, tran_det_dcto, tran_det_monto, tran_det_fecha, tran_det_interes, tran_det_plazo, tran_det_estado, tran_det_obs) SELECT * FROM tran_det_temp";
        mysqli_query($conn, $query);
    }

    function ver_creditos($placa) {
        $conn = $this->objconec;
        $cant = 0;
        $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'CREDITO'";
        $result = mysqli_query($conn, $query);
        $cant = mysqli_num_rows($result);
        if (($cant) > 0) {
            $datocre = mysqli_fetch_array($result, MYSQLI_BOTH);
            $numerocre = $datocre['idtran_det_cab'];
            $fechacre = $datocre['tran_det_fecha'];
            $montocre = $datocre['tran_det_monto'];
            $interes = ($datocre['tran_det_interes']) / 100;
            $plazocre = $datocre['tran_det_plazo'];
            $interes_mes = $montocre * $interes;
            $interes_dia = ($montocre * $interes) / 30;
            $totalcre = $montocre + (($interes_dia) * $plazocre);
            $pago_mes = $totalcre / ($plazocre / 30);
            $montomes = $montocre / ($plazocre / 30);
            $tiempo = $plazocre / 30;
            $saldocre = $totalcre;
            for ($i = 1; $i <= $tiempo; $i++) {
                $saldocre = $saldocre - $pago_mes;
                $fechacre = strtotime('+30 day', strtotime($fechacre));
                $fechacre = date('Y-m-j', $fechacre);
                $query = "INSERT INTO tran_cre (idtran_cre_cab, tran_cre_sec, tran_cre_fecha_venc, tran_cre_fecha_pago, tran_cre_cuota, tran_cre_interes, tran_cre_monto, tran_cre_sal, tran_cre_estado)"
                        . "VALUES ($numerocre, $i, '$fechacre', '', $pago_mes, $interes_mes, $montomes, $saldocre, 0)";
                mysqli_query($conn, $query);
            }

            $ver_id = "SELECT tc.idtran_cab as carpeta,concat(cd.cli_nombre ,' ', cd.cli_apellido) as cliente,sum(tr.`tran_cre_interes`) as tot_intrs, cd.idcli_ident as id_cli  FROM `tran_cre` tr join tran_cab tc join cli_datos cd where tr.`idtran_cre_cab`=tc.idtran_cab and tc.tran_cli_ident=cd.idcli_ident "
                    . "and tc.idtran_cab='$numerocre'";
            $res_id = mysqli_query($conn, $ver_id);
            $datoid = mysqli_fetch_array($res_id, MYSQLI_BOTH);
            $id_cli = $datoid['id_cli'];
            $cli_nom = $datoid['cliente'];
            $tot_intr = $datoid['tot_intrs'];

            $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
            $sql_vrcta = "SELECT * FROM `int_datcli` where id_cli='$id_cli'";
            $res_vrcta = mysqli_query($con, $sql_vrcta);
            $dato_cta = mysqli_fetch_array($res_vrcta, MYSQLI_BOTH);
            $nom_cta = $dato_cta['nom_cli'];
            $deu = $dato_cta['deud'];
            $acre = $dato_cta['acree'];
            include_once './contabilidad.php';
            include_once './vehiculo.php';
            $objcont = new contabilidad();
            $objVeh = new Vehiculo();
            $tipo_estado = $objVeh->ver_tipoEstado($placa);
            if ($tipo_estado != '0') {
                $objcont->gen_ass_interes($id_cli, $cli_nom, $tot_intr, $nom_cta, $deu, $acre);
            }
//            enviar parametros para generar el asiento nuevo con intereses a contabilidad
//            consultar numero de cuenta de interes del cliente
//            
        }   
    }

    function ver_adicional() {
        $conn = $this->objconec;
        $cant = 0;
        $fija = 99;
        $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'ADICIONAL'";
        $result = mysqli_query($conn, $query);

//    $cantt = mysqli_num_rows($result); 
        if (isset($result)) {
            $cont = 0;
            while ($adicional = mysqli_fetch_array($result)) {
                $numerocre = $adicional['idtran_det_cab'];
                $fechacre = $adicional['tran_det_fecha'];
                $incr = $fija . $cont;
                $montocre = $adicional['tran_det_monto'];
                $interes = ($adicional['tran_det_interes']) / 100;
                $plazocre = $adicional['tran_det_plazo'];
                $interes_dia = ($montocre * $interes) / 30;
                $interes_tot = $interes_dia * $plazocre;
                $totalcre = $montocre + $interes_tot;
                $saldocre = $totalcre;
                $fechacre = strtotime('+' . $plazocre . ' days', strtotime($fechacre));
                $fechacre = date('Y-m-j', $fechacre);

                $query = "INSERT INTO tran_cre (idtran_cre_cab, tran_cre_sec, tran_cre_fecha_venc, tran_cre_fecha_pago, tran_cre_cuota, tran_cre_interes, tran_cre_monto, tran_cre_sal, tran_cre_estado)"
                        . "VALUES ($numerocre, $incr, '$fechacre', '', $totalcre, $interes_tot, $montocre, 0, 0)";
                mysqli_query($conn, $query);
                $cont++;

                $ver_id = "SELECT tc.idtran_cab as carpeta,concat(cd.cli_nombre ,' ', cd.cli_apellido) as cliente,"
                        . "tr.`tran_cre_interes` as tot_intrs, cd.idcli_ident as id_cli  "
                        . "FROM `tran_cre` tr join tran_cab tc join cli_datos cd where tr.`idtran_cre_cab`=tc.idtran_cab and tc.tran_cli_ident=cd.idcli_ident "
                        . "and tc.idtran_cab='$numerocre' and tr.tran_cre_sec>=990";
                $res_id = mysqli_query($conn, $ver_id);
                $datoid = mysqli_fetch_array($res_id, MYSQLI_BOTH);
                $id_cli = $datoid['id_cli'];
                $cli_nom = $datoid['cliente'];
                $tot_intr = $datoid['tot_intrs'];
                $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
                $sql_vrcta = "SELECT * FROM `int_datcli` where id_cli='$id_cli'";
                $res_vrcta = mysqli_query($con, $sql_vrcta);
                $dato_cta = mysqli_fetch_array($res_vrcta, MYSQLI_BOTH);
                $nom_cta = $dato_cta['nom_cli'];
                $deu = $dato_cta['deud'];
                $acre = $dato_cta['acree'];
                include_once './contabilidad.php';
                $objcont = new contabilidad();
                $objcont->gen_ass_interes_adic($id_cli, $cli_nom, $interes_tot, $nom_cta, $deu, $acre); //$tot_intr
            }
        }
    }

    function insert_adicional() {
        $conn = $this->objconec;
        $cant = 0;
        $fija = 99;
        $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'ADICIONAL'";
        $result = mysqli_query($conn, $query);
        if (isset($result)) {


            $ver_id = "SELECT tc.idtran_cab as carpeta,concat(cd.cli_nombre ,' ', cd.cli_apellido) as cliente,"
                    . "sum(tr.`tran_cre_interes`) as tot_intrs, cd.idcli_ident as id_cli  "
                    . "FROM `tran_cre` tr join tran_cab tc join cli_datos cd where tr.`idtran_cre_cab`=tc.idtran_cab and tc.tran_cli_ident=cd.idcli_ident "
                    . "and tc.idtran_cab='$numerocre' and tr.tran_cre_sec>=990";
            $res_id = mysqli_query($conn, $ver_id);
            $datoid = mysqli_fetch_array($res_id, MYSQLI_BOTH);
            $id_cli = $datoid['id_cli'];
            $cli_nom = $datoid['cliente'];
            $tot_intr = $datoid['tot_intrs'];
            $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'condata');
            $sql_vrcta = "SELECT * FROM `int_datcli` where id_cli='$id_cli'";
            $res_vrcta = mysqli_query($con, $sql_vrcta);
            $dato_cta = mysqli_fetch_array($res_vrcta, MYSQLI_BOTH);
            $nom_cta = $dato_cta['nom_cli'];
            $deu = $dato_cta['deud'];
            $acre = $dato_cta['acree'];
            include_once './contabilidad.php';
            $objcont = new contabilidad();
            $objcont->gen_ass_interes_adic($id_cli, $cli_nom, $tot_intr, $nom_cta, $deu, $acre);
        }
    }

//function insertar_creditos($idtran_cab){
//    $conn = $this->objconec; 
//    $query = "INSERT INTO tran_cre(idtran_cre_cab, tran_cre_sec, tran_cre_dcto, tran_cre_valor, tran_cre_fecha, tran_cre_fecha_pago, tran_cre_estado) VALUES"
//            . "($idtran_det_cab, $i, NULL, 0.00, $fec_pri_pago, '0000-00-00', '1')";
//
//        mysqli_query($conn, $query);
//    }
    function mostrar_trans() {
        $conn = $this->conec_base();
        $query = "SELECT idtran_cab, tran_cab_fecha FROM tran_cab order by tran_cab_fecha";
        $restrans = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($restrans)) {
            echo "<option value='" . $row['idtran_cab'] . "'>'" . $row['tran_cab_fecha'] . "'</option>";
        }
    }

    function numerar_trans() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab order by idtran_cab DESC";
        $resnum = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($resnum);
        $numero = $row['idtran_cab'];
        return $numero++;
    }

    function listar_trans() {
        $conn = $this->conec_base();
        $query = "SELECT idtran_cab, tran_cab_fecha, tran_cab_tipo, tran_veh_placas, tran_cli_ident, "
                . "tran_cab_precio, tran_cab_seguro, tran_cab_gastos FROM tran_cab order by idtran_cab";
        $restrs = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            $fecha = date("Y-m-d", strtotime($datomarca['tran_cab_fecha']));
            echo "<td>" . $fecha . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td align='right'>" . number_format(($datomarca['tran_cab_precio']), 2) . "</td>";
            echo "<td align='right'>" . $datomarca['tran_cab_seguro'] . "</td>";
            echo "<td align='right'>" . $datomarca['tran_cab_gastos'] . "</td>";
//            echo "<td align='center'>"
//            . "<button name='vertrs' value='" . $datomarca['idtran_cab'] . "'>VER</button>"
//            . "<button name='hstveh' value='" . $datomarca['tran_veh_placas'] . "'>GASTOS</button>"
//            . "</td>";
            echo "<td align='center'><a href='inicio.php?variable=ver_transaccion&vertrans=".$datomarca["idtran_cab"]."' data-toggle='modal''><button type='button' title='VER' class='btn btn-outline btn-info glyphicon glyphicon-eye-open'></button></a></td>";            
            echo "</tr>";
        }
//        echo "</table>";
    }

    function imprime_trans($idtran_cab) {
        global $numtra, $sec_trs, $fecha_t, $placa, $cliente, $precio, $seguro, $gastos, $valor;
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where idtran_cab = $idtran_cab";
        $resver = mysqli_query($conn, $query);
        while ($datover = mysqli_fetch_array($resver, MYSQLI_BOTH)) {
            $idtran_cab = $datover['idtran_cab'];
            $tran_sec_tipo = $datover['tran_sec_tipo'];
            $tran_cab_fecha = $datover['tran_cab_fecha'];
            $tran_cab_tipo = $datover['tran_cab_tipo'];
            $tran_veh_placas = $datover['tran_veh_placas'];
            $tran_cli_ident = $datover['tran_cli_ident'];
            $tran_cab_precio = $datover['tran_cab_precio'];
            $tran_cab_seguro = $datover['tran_cab_seguro'];
            $tran_cab_gastos = $datover['tran_cab_gastos'];
        }
        $numtra = $idtran_cab;
        $sec_trs = $tran_sec_tipo;
        $fecha_t = $tran_cab_fecha;
        $placa = $tran_veh_placas;
        $cliente = $tran_cli_ident;
        $precio = $tran_cab_precio;
        $seguro = $tran_cab_seguro;
        $gastos = $tran_cab_gastos;
        $valor = $tran_cab_precio + $tran_cab_seguro + $tran_cab_gastos;
    }

    function buscar_trans($idtran_cab) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where idtran_cab LIKE '%" . $idtran_cab . "%' OR tran_cab_fecha LIKE '%" . $idtran_cab . "%' OR tran_cab_tipo LIKE '%" . $idtran_cab . "%' OR tran_veh_placas LIKE '%" . $idtran_cab . "%' OR tran_cli_ident LIKE '%" . $idtran_cab . "%' order by tran_cab_fecha";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            echo "<td>" . $datomarca['tran_cab_fecha'] . "</td>";
//        $fecha = date_format($datomarca['tran_cab_fecha'], 'd/m/Y H:i:s');
//        echo "<td>". $fecha ."</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_precio']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_seguro']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_gastos']), 2) . "</td>";
            echo "<td align='center'><button name='vertrs' value='" . $datomarca['idtran_cab'] . "'>VER</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function ver_trans($idtran_cab) {
        global $numtra, $placa, $cliente, $trans;
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
        $trans = $tran_cab_tipo;
    }

    function doc_list_trans() {
        $conn = $this->conec_base();
        $query = "SELECT idtran_cab, tran_cab_fecha, tran_cab_tipo, tran_veh_placas, tran_cli_ident, tran_cab_precio, tran_cab_seguro, tran_cab_gastos FROM tran_cab order by idtran_cab";
        $restrs = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td><td colspan=3 align=center>DOCUMENTOS</td></tr>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            $fecha = date("d-m-Y", strtotime($datomarca['tran_cab_fecha']));
            echo "<td>" . $fecha . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_precio']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_seguro']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_gastos']), 2) . "</td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/1_doc_acla.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>DOC. ACLARATORIO</a></td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/enlace_anexo.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>DOC. ANEXO AUTORIZACION</a></td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/enlace_prenda.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>CONT. PRENDA INDUSTRIAL</a></td>";
//            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/3_con_pre_ind.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>CONT. PRENDA INDUSTRIAL</a></td>";
            echo "</tr>";
        }
        mysqli_close($conn);
//        echo "</table>";
    }

    function doc_busc_trans($idtran_cab) {
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_cab where idtran_cab LIKE '%" . $idtran_cab . "%' "
                . "OR tran_cab_fecha LIKE '%" . $idtran_cab . "%' OR tran_cab_tipo LIKE '%" . $idtran_cab . "%' "
                . "OR tran_veh_placas LIKE '%" . $idtran_cab . "%' OR tran_cli_ident LIKE '%" . $idtran_cab . "%' "
                . "order by idtran_cab";
        $restrs = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>FECHA</td><td>TRANSACCION</td><td>PLACA</td><td>CLIENTE</td><td>PRECIO</td><td>SEGURO</td><td>GASTOS</td><td colspan=3 align=center>DOCUMENTOS</td></tr>";
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idtran_cab'] . "</td>";
            $fecha = date("d-m-Y", strtotime($datomarca['tran_cab_fecha']));
            echo "<td>" . $fecha . "</td>";
            echo "<td>" . $datomarca['tran_cab_tipo'] . "</td>";
            echo "<td>" . $datomarca['tran_veh_placas'] . "</td>";
            echo "<td>" . $datomarca['tran_cli_ident'] . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_precio']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_seguro']), 2) . "</td>";
            echo "<td>" . number_format(($datomarca['tran_cab_gastos']), 2) . "</td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/1_doc_acla.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>DOC. ACLARATORIO</a></td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/2_doc_ane_aut.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>DOC. ANEXO AUTORIZACION</a></td>";
            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/enlace_prenda.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>CONT. PRENDA INDUSTRIAL</a></td>";
//            echo "<td align='center'><a href='../../PhpCoVe/documentos/varios/3_con_pre_ind.php?numtrs=" . $datomarca['idtran_cab'] . "' target='_blank'>CONT. PRENDA INDUSTRIAL</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

}
