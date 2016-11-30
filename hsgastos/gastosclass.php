<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Gastos {

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

//vehiculo
    function buscar_gastos($key) {
        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
        ?>
        <table border="0" >
                            <thead>
                                <tr>
                                    <th>Pago</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Observacion</th>
                                </tr>
                            </thead>
        <?php
        $conn = $this->conec_base();
        $query = "SELECT * FROM `det_pag` WHERE `veh_datos_idveh_placa`='$key' ";
        $querysuma = "SELECT SUM(`monto`) as suma FROM `det_pag` WHERE `veh_datos_idveh_placa`='$key'";
        $querydatosveh = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des, "
                . "veh_datos.veh_anio, veh_datos.veh_color1, veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
                . "veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, veh_datos.veh_estado FROM veh_datos, veh_marca, "
                . "veh_vehiculo, veh_tipo, mat_lugar where veh_datos.idveh_placa = '" . $key . "' and "
                . "veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo and veh_marca.idveh_marca=veh_vehiculo.veh_marca "
                . "and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar";
        $resveh = mysqli_query($conn, $querydatosveh);
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            $tran_veh_placas = $datomarca['idveh_placa'];
            $veh_marca = $datomarca['veh_marca'];
            $veh_modelo = $datomarca['veh_modelo'];
            $veh_tipo_des = $datomarca['veh_tipo_des'];
            $veh_anio = $datomarca['veh_anio'];
        }
        ?>
        <p style="font-size:12px; text-align: left">
            <label>Placa :</label>&nbsp; <input type="text" name="veh" value="<?php echo $key;  ?>" disabled=""/>
            <label>Marca :</label>&nbsp; <input type="text" name="mrk" value="<?php echo $veh_marca;  ?>" disabled=""/>
            <label>Modelo :</label>&nbsp; <input type="text" name="mdl" value="<?php echo $veh_modelo;  ?>" disabled=""/>
            <label>Des :</label>&nbsp; <input type="text" name="vtdes" value="<?php echo $veh_tipo_des;  ?>" disabled=""/>
            <label>A&ncaron;o :</label>&nbsp; <input type="text" name="vta" value="<?php echo $veh_anio;  ?>" disabled=""/>
        </p>
        <?php
        
        $ejec = mysqli_query($conn, $querysuma);
        $dato = mysqli_fetch_assoc($ejec);
        $suma = $dato['suma'];
        
        $resveh = mysqli_query($conn, $query);
        
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            $iddet_pag = $datomarca['iddet_pag'];
            $lis_pag_id_pag = $datomarca['lis_pag_id_pag'];
            $cli_datos_idcli_ident = $datomarca['cli_datos_idcli_ident'];
            $veh_datos_idveh_placa = $datomarca['veh_datos_idveh_placa'];
            
            $querydat = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='".$lis_pag_id_pag."' ";
            $ej = mysqli_query($c, $querydat);
            $data = mysqli_fetch_assoc($ej);
            $nomgst = $data['nombre_cuenta_plan'];
            
            $fech_reg = $datomarca['fech_reg'];
            $monto = $datomarca['monto'];
            $tran_realiz = $datomarca['tran_realiz'];
            $user = $datomarca['user'];
            $observ = $datomarca['observ'];
            $clien = $datomarca['clien'];
            ?>
            
                            <tbody>
                                <tr>
                                    <td><input type="text" name="pago" style="width: 150px" value="<?php echo $nomgst; ?>" disabled=""/></td>
                                    <td><input type="text" name="fech" value="<?php echo $fech_reg; ?>" disabled=""/></td>
                                    <td><input type="text" name="mont" style="width: 50px" value="<?php echo $monto; ?>" disabled=""/></td>
                                    <td><input type="text" name="obser" style="width: 250px" value="<?php echo $observ; ?>" disabled=""/></td>
                                </tr>
                            </tbody>
                        </table>
            </p>
            <?php
            
        }
        ?>
        <p style="font-size:12px; text-align: left">
            <label>Suma :</label>&nbsp; <input type="text" name="sm" value="<?php echo $suma;  ?>" disabled=""/>
        </p>
        <?php
    }

    function listar_gastos() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM `det_pag` ";
        $resveh = mysqli_query($conn, $query);
        echo "<table border=1>"
        . "<tr align=center style='color:red'>"
        . "<td>PLACA</td><td>RAZÓN</td><td>FECHA</td><td>MONTO</td><td>CLIENTE</td>";
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            echo "<tr>";
//            echo "<td>" . $datomarca['iddet_pag'] . "</td>";
//            echo "<td>" . $datomarca['lis_pag_id_pag'] . "</td>";
            echo "<td>" . $datomarca['veh_datos_idveh_placa'] . "</td>";
            echo "<td>" . $datomarca['observ'] . "</td>";
            echo "<td>" . $datomarca['fech_reg'] . "</td>";
            echo "<td>" . $datomarca['monto'] . "</td>";
//            echo "<td>" . $datomarca['tran_realiz'] . "</td>";
            echo "<td>" . $datomarca['cli_datos_idcli_ident'] . "</td>";
//            echo "<td>" . $datomarca['user'] . "</td>";
//            echo "<td>" . $datomarca['clien'] . "</td>";
//            echo "</tr>";
        }
        echo "</table>";
    }

}
