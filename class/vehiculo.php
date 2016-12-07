<?php
if (!isset($_SESSION)) {
    session_start();
}

class Vehiculo {

    public $idveh_placa;
    public $veh_marca;
    public $veh_modelo;
    public $veh_tipo;
    public $veh_anio;
    public $veh_color1;
    public $veh_color2;
    public $veh_motor;
    public $veh_chasis;
    public $veh_km;
    public $veh_mat_lugar;
    public $veh_mat_anio;
    public $veh_estado;
    public $objconec;

//function __construct($idveh_placa, $veh_marca, $veh_modelo, $veh_tipo, $veh_anio, $veh_color1, $veh_color2, $veh_motor, $veh_chasis, $veh_km, $veh_mat_lugar, $veh_mat_anio, $veh_estado){
//    $this->idveh_placa = $idveh_placa;
//    $this->veh_marca = $veh_marca;
//    $this->veh_modelo = $veh_modelo;
//    $this->veh_tipo = $veh_tipo;
//    $this->veh_anio = $veh_anio;
//    $this->veh_color1 = $veh_color1;
//    $this->veh_color2 = $veh_color2;
//    $this->veh_motor = $veh_motor;
//    $this->veh_chasis = $veh_chasis;
//    $this->veh_km = $veh_km;
//    $this->veh_mat_lugar = $veh_mat_lugar;
//    $this->veh_mat_anio = $veh_mat_anio;
//    $this->veh_estado = $veh_estado;
//}
    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function insertar_vehiculo($idveh_placa, $veh_vehiculo, $veh_anio, $veh_color1, $veh_color2, $veh_motor, $veh_chasis, $veh_km, $veh_mat_lugar, $veh_mat_anio, $veh_estado) {
        $conn = $this->objconec;
        $query = "INSERT INTO veh_datos(idveh_placa, veh_vehiculo, veh_anio, veh_color1, veh_color2, veh_motor, veh_chasis, veh_km, veh_mat_lugar, veh_mat_anio, veh_estado) "
        . "values ('$idveh_placa', '$veh_vehiculo', '$veh_anio', '$veh_color1', '$veh_color2', '$veh_motor', '$veh_chasis', '$veh_km', '$veh_mat_lugar', '$veh_mat_anio', '$veh_estado')";
        if (mysqli_query($conn, $query)) {
            $query1 = "INSERT INTO veh_docu(idveh_placa) values ('$idveh_placa')";
            mysqli_query($conn, $query1);
            $query2 = "INSERT INTO veh_estado(idveh_placa) values ('$idveh_placa')";
            mysqli_query($conn, $query2);
            return $query;
        }
    }

    function modifica_vehiculo($placa, $veh_km, $veh_cod_lugar, $veh_mat_anio, $veh_anio,  
        $veh_chasis, $veh_motor, $veh_color1,$veh_color2, $estado_a, $estado1, $estado2, 
        $estado3, $estado4, $estado5, $estado6, $estado7, $estado8, $estado9, $estado10, 
        $estado11, $estado12, $estado13) {
        $conn = $this->objconec;
//        switch ($estado_a) {
//            case 'CONSIGNACION':
//                $estado_a = 0;
//                break;
//            case 'COMISION':
//                $estado_a = 1;
//                break;
//            case 'VENDIDO':
//                $estado_a = 2;
//                break;
//        }
        $query = "UPDATE veh_datos SET "
        . "veh_km = '$veh_km',"
        . "veh_mat_lugar = '$veh_cod_lugar', "
        . "veh_mat_anio = '$veh_mat_anio', "
        . "veh_anio = '$veh_anio', "
        . "veh_chasis= '$veh_chasis', "
        . "veh_motor= '$veh_motor', "
        . "veh_color1= '$veh_color1', "
        . "veh_color2= '$veh_color2', "
        . "veh_estado = '$estado_a' WHERE idveh_placa = '$placa'";
        mysqli_query($conn, $query);
        $query = "UPDATE veh_estado SET est_alfombras = '$estado1', est_brazosplumas = '$estado2', est_cinturones = '$estado3', est_espejos = '$estado4', est_gata = '$estado5', est_llaveruedas = '$estado6', est_manual = '$estado7', est_radioparlantes = '$estado8', est_tapatuerca = '$estado9', esta_mecanico = '$estado11', esta_sistelect = '$estado12', esta_pintura = '$estado13', est_otros = '$estado10' WHERE idveh_placa = '$placa'";
        mysqli_query($conn, $query);
    }

    function agrega_dcto($placa, $documento) {
        $conn = $this->objconec;
        $sql = "INSERT INTO veh_docu (idveh_placa, nom_docu, est_doc) VALUES ('$placa', '$documento', ' ')";
        mysqli_query($conn, $sql);
    }

    function listar_vehiculo() {
        $conn = $this->objconec;
        $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
        . "veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, "
        . "veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
        . "veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, "
        . "veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar "
        . "where veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo "
        . "and veh_marca.idveh_marca=veh_vehiculo.veh_marca "
        . "and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar";
        $resveh = mysqli_query($conn, $query);
//        echo "<table border=1 style='font-size:9px; text-align: left'><tr align=center style='color:red'><td>PLACAS</td><td>MARCA</td><td>MODELO</td><td>TIPO</td><td>A&Ntilde;O</td><td># MOTOR</td><td># CHASIS</td><td>KILOMETRAJE</td> "
//        . "<td>COLOR 1</td><td>COLOR 2</td><td>MATRICULADO EN</td><td>DEL A&Ntilde;O</td><td>ESTADO</td>";
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idveh_placa'] . "</td>";
            echo "<td>" . $datomarca['veh_marca'] . "</td>";
            echo "<td>" . $datomarca['veh_modelo'] . "</td>";
            echo "<td>" . $datomarca['veh_tipo_des'] . "</td>";
            echo "<td>" . $datomarca['veh_anio'] . "</td>";
//            echo "<td>" . $datomarca['veh_motor'] . "</td>";
//            echo "<td>" . $datomarca['veh_chasis'] . "</td>";
            echo "<td>" . $datomarca['veh_km'] . "</td>";
            echo "<td>" . $datomarca['veh_color1'] . "</td>";
            echo "<td>" . $datomarca['veh_color2'] . "</td>";
//            echo "<td>" . $datomarca['mat_lugar'] . "</td>";
//            echo "<td>" . $datomarca['veh_mat_anio'] . "</td>";
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
            echo "<td>" . $estado . "</td>";
            echo "<td><a href='inicio.php?variable=modifica_vehiculo&verplaca=".$datomarca["idveh_placa"]."' data-toggle='modal''><button type='button' title='VER' class='btn btn-outline btn-info glyphicon glyphicon-eye-open'></button></a></td>";
//            echo "<td align='center'><button name='verveh' value='" . $datomarca['idveh_placa'] . "'>EDITAR</button></td>";
            echo "</tr>";
        }
        mysqli_close($conn);
//        echo "</table>";
    }

    function mostrar_vehiculo() {
        $conn = $this->objconec;
        $query = "SELECT * FROM veh_datos";
        $resveh = mysqli_query($conn, $query);
        echo "<option> </option>";
        while ($row = mysqli_fetch_array($resveh)) {
            echo "<option value=" . $row[idveh_placa] . ">$row[idveh_placa]</option>";
        }
        mysqli_close($conn);
    }

    function buscar_veh($idveh_placa) {
        $conn = $this->objconec;
        $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
        . "veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, "
        . "veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
        . "veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, "
        . "veh_datos.veh_estado FROM veh_datos, veh_marca, veh_vehiculo, "
        . "veh_tipo, mat_lugar where veh_datos.idveh_placa = '" . $idveh_placa . "' "
        . "and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo "
        . "and veh_marca.idveh_marca=veh_vehiculo.veh_marca "
        . "and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo "
        . "and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar";
        $resveh = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>PLACAS</td><td>MARCA</td><td>MODELO</td><td>TIPO</td><td>A&Ntilde;O</td><td># MOTOR</td><td># CHASIS</td><td>KILOMETRAJE</td> "
        . "<td>COLOR 1</td><td>COLOR 2</td><td>MATRICULADO EN</td><td>DEL A&Ntilde;O</td><td>ESTADO</td>";
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idveh_placa'] . "</td>";
            echo "<td>" . $datomarca['veh_marca'] . "</td>";
            echo "<td>" . $datomarca['veh_modelo'] . "</td>";
            echo "<td>" . $datomarca['veh_tipo_des'] . "</td>";
            echo "<td>" . $datomarca['veh_anio'] . "</td>";
            echo "<td>" . $datomarca['veh_motor'] . "</td>";
            echo "<td>" . $datomarca['veh_chasis'] . "</td>";
            echo "<td>" . $datomarca['veh_km'] . "</td>";
            echo "<td>" . $datomarca['veh_color1'] . "</td>";
            echo "<td>" . $datomarca['veh_color2'] . "</td>";
            echo "<td>" . $datomarca['mat_lugar'] . "</td>";
            echo "<td>" . $datomarca['veh_mat_anio'] . "</td>";
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
            echo "<td>" . $estado . "</td>";
            echo "<td align='center'><button name='verveh' value='" . $datomarca['idveh_placa'] . "'>EDITAR</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_veh_com($placa) {
        $conn = $this->objconec;
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
        ?>
        <p style="font-size:9px; text-align: center">
            <table>                
                <tr>
                    <td>
                        <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" style="width: 250px" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Kilometraje:</label>&nbsp; <input type="text" name="veh_km" style="width: 80px" value="<?php echo $veh_km; ?>" readonly="readonly"/>             
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Color 2</label>&nbsp; <input type="text" name="veh_color2" value="<?php echo $veh_color2; ?>" readonly="readonly"/>            
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Chasis:</label>&nbsp; <input type="text" name="veh_chasis" style="width: 150px" value="<?php echo $veh_chasis; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Motor</label>&nbsp; <input type="text" name="veh_motor" style="width: 150px" value="<?php echo $veh_motor; ?>" readonly="readonly"/>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Matriculado en:</label>&nbsp; <input type="text" name="veh_mat_lugar" value="<?php echo $veh_mat_lugar; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Por el a&ntilde;o:</label>&nbsp; <input type="text" name="veh_mat_anio" value="<?php echo $veh_mat_anio; ?>" readonly="readonly"/>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        <label>Estado:</label>&nbsp; <input type="text" name="estado" value="<?php echo $estado; ?>" readonly="readonly"/>
                    </td>
                </tr>    
            </table>     
        </p>
        <?php
    }

    function buscar_veh_trs($placa, $tipo) {
//    echo '<script>alert("llega")</script>';
        $conn = $this->objconec;
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
        $bandera = 0;
        if (isset($estado)) {
            if (($estado) == "VENDIDO") {
                echo "<script> alert('El vehiculo esta vendido') </script>";
                ?>
                <p style="font-size:25px">
                    <?php
                    echo "EL VEHICULO ESTA VENDIDO";
                    $bandera = 1;
                    ?>
                </p>
                <?php
            }
        } else {
            echo "<script> alert('El vehiculo no existe') </script>";
            ?>
            <p style="font-size:25px">
                <?php
                echo "EL VEHICULO NO EXISTE";
                $bandera = 1;
                ?>
            </p>
            <?php
        }
        include_once 'transacc.php';
        $objtrs = new Transacc();
        $objtrs->conec_base();

        $verifica = $objtrs->verifica_transac($placa, $tipo);
        if (($verifica) == 'INGRESO') {
            ?>
            <p style="font-size:25px">
                <?php
                echo "EL VEHICULO ESTA INGRESADO";
                $bandera = 1;
                ?>
            </p>
            <?php
        }
        if (($verifica) == 'EGRESO') {
            ?>
            <p style="font-size:25px">
                <?php
                echo "EL VEHICULO NO ESTA INGRESADO";
                $bandera = 1;
                ?>
            </p>
            <?php
        }
        if (($bandera) == 0) {
            ?>
                <tr>
                    <td>
                        <label>Marca:</label>
                        <input type="text" class="text-col3" name="veh_marca" value="<?php echo $veh_marca; ?>" readonly="readonly"  />     
                    </td>
                    <td>           
                        <label>Tipo:</label>
                        <input type="text" class="text-col3" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        <label>Kilometraje:</label> 
                        <input type="text" class="text-col6" name="veh_km" value="<?php echo $veh_km; ?>" readonly="readonly"  />       
                    </td>
                    <td>
                        <label>Chasis:</label> 
                        <input type="text" class="text-col6" name="veh_chasis"  value="<?php echo $veh_chasis; ?>" readonly="readonly" />
                    </td>
                    <td>
                        <label>Motor</label> 
                        <input type="text" class="text-col6" name="veh_motor"  value="<?php echo $veh_motor; ?>" readonly="readonly" />             
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Estado:</label> 
                        <input type="text" class="text-col3" name="estado" value="<?php echo $estado; ?>" readonly="readonly"  />   
                    </td>
                    <td>
                        <label>Modelo:</label> 
                        <input type="text" class="text-col8" name="veh_modelo" value="<?php echo $veh_modelo; ?>"  readonly="readonly" />
                    </td>
                    <td>
                        <label>A&ntilde;o:</label> 
                        <input type="text" class="text-col2" name="veh_anio" value="<?php echo $veh_anio; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        <label>Color 1:</label> 
                        <input type="text" class="text-col4" name="veh_color1" value="<?php echo $veh_color1; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        <label>Color 2</label> 
                        <input type="text" class="text-col4" name="veh_color2" value="<?php echo $veh_color2; ?>" readonly="readonly"  />    
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Matriculado en:</label> 
                        <input type="text" name="veh_mat_lugar" value="<?php echo $veh_mat_lugar; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        <label>Por el a&ntilde;o:</label> 
                        <input type="text" name="veh_mat_anio" value="<?php echo $veh_mat_anio; ?>" readonly="readonly"  />
                    </td>
                </tr>
            <?php
        }

//        $valor = $objtrs->trae_valor($placa);
//        echo $valor;
    }

    function ver_vehiculo($placa) {
//        $cont_doc = 0;
        $conn = $this->objconec;
        $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
        . "veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, "
        . "veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
        . "veh_datos.veh_km, veh_datos.veh_mat_lugar, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, "
        . "veh_datos.veh_estado, veh_docu.nom_docu, veh_docu.est_doc, "
        . "veh_estado.est_alfombras, veh_estado.est_brazosplumas, "
        . "veh_estado.est_cinturones, veh_estado.est_espejos, veh_estado.est_gata, "
        . "veh_estado.est_llaveruedas, veh_estado.est_manual, veh_estado.est_radioparlantes, "
        . "veh_estado.est_tapatuerca, veh_estado.esta_mecanico, veh_estado.esta_sistelect, "
        . "veh_estado.esta_pintura, veh_estado.est_otros "
        . "FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, veh_docu, veh_estado "
        . "WHERE veh_datos.idveh_placa = '$placa' and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo "
        . "and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo "
        . "and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and  veh_datos.idveh_placa=veh_docu.idveh_placa "
        . "and veh_datos.idveh_placa=veh_estado.idveh_placa";
        $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));

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
            $veh_cod_lugar = $datomarca['veh_mat_lugar'];
            $veh_mat_lugar = $datomarca['mat_lugar'];
            $veh_mat_anio = $datomarca['veh_mat_anio'];
            switch ($datomarca['veh_estado']) {
                case 0:
                $varestado = 0;
                $estado = 'CONSIGNACION';
                break;
                case 1:
                $varestado = 1;
                $estado = 'COMISION';
                break;
                case 2:
                $varestado = 2;
                $estado = 'VENDIDO';
                break;
            }
            $nom_docu = $datomarca['nom_docu'];
            $est_doc = $datomarca['est_doc'];
            $est_alfombras = $datomarca['est_alfombras'];
            $est_brazosplumas = $datomarca['est_brazosplumas'];
            $est_cinturones = $datomarca['est_cinturones'];
            $est_espejos = $datomarca['est_espejos'];
            $est_gata = $datomarca['est_gata'];
            $est_llaveruedas = $datomarca['est_llaveruedas'];
            $est_manual = $datomarca['est_manual'];
            $est_radioparlantes = $datomarca['est_radioparlantes'];
            $est_tapatuerca = $datomarca['est_tapatuerca'];
            $esta_mecanico = $datomarca['esta_mecanico'];
            $esta_sistelect = $datomarca['esta_sistelect'];
            $esta_pintura = $datomarca['esta_pintura'];
            $est_otros = $datomarca['est_otros'];

            $vec_doc[] = ($datomarca['nom_docu']);
        }
        ?>
        <p style="font-size:9px; text-align: left">
            <label>Placa:</label>&nbsp;<input type="text" value="<?php echo $tran_veh_placas; ?>" disabled=""/>
            <input type="text" id="idveh_placa" name="idveh_placa" value="<?php echo $tran_veh_placas; ?>" hidden=""/>
            <br/>
            <label>Marca:</label>&nbsp; <input type="text" name="veh_marca" value="<?php echo $veh_marca; ?>" style="width: 200px" disabled=""/>
            &nbsp;&nbsp;
            <label>Modelo:</label>&nbsp; <input type="text" name="veh_modelo" value="<?php echo $veh_modelo; ?>" style="width: 300px" disabled=""/>
            &nbsp;&nbsp;
            <label>Tipo:</label>&nbsp; <input type="text" name="veh_tipo_des" value="<?php echo $veh_tipo_des; ?>" disabled=""/>
            <br/>
            <label>A&ntilde;o:</label>&nbsp; <input type="text" name="veh_anio" style="width: 50px" value="<?php echo $veh_anio; ?>" /><!--disabled=""-->
            &nbsp;&nbsp;
            <label>Kilometraje:</label>&nbsp; <input type="text" name="veh_km" style="width: 80px" value="<?php echo $veh_km; ?>"/>             
            &nbsp;&nbsp;
            <label>Color 1:</label>&nbsp; <input type="text" name="veh_color1" value="<?php echo $veh_color1; ?>" /><!--disabled=""-->
            &nbsp;&nbsp;
            <label>Color 2</label>&nbsp; <input type="text" name="veh_color2" value="<?php echo $veh_color2; ?>" />          <!--disabled=""-->  
            <br/>
            <label>Chasis:</label>&nbsp; <input type="text" name="veh_chasis" style="width: 150px" value="<?php echo $veh_chasis; ?>" /><!--disabled=""-->
            &nbsp;&nbsp;
            <label>Motor</label>&nbsp; <input type="text" name="veh_motor" style="width: 150px" value="<?php echo $veh_motor; ?>" /><!--disabled=""-->
            <br>
            <label>Matriculado en:</label>&nbsp; <input type="text" name="veh_cod_lugar" value="<?php echo $veh_cod_lugar; ?>" hidden=""/>
            <select id="veh_cod_lugar" name="veh_cod_lugar" required="">
                <option value="<?php echo $veh_cod_lugar ?>"><?php echo $veh_mat_lugar ?></option>
                <?php
                include_once 'class/lugar.php';
                $objltlugar = new Lugar();
                $objltlugar->conec_base();
                $objltlugar->mostrar_lugar();
                ?>                    
            </select>            

            &nbsp;&nbsp;
            <label>Por el a&ntilde;o:</label>&nbsp; <input type="text" name="veh_mat_anio" value="<?php echo $veh_mat_anio; ?>"/>
            &nbsp;&nbsp;
            <label>Estado:</label>&nbsp;
            <select id="estado_a" name="estado_a">
                <option value="<?php echo $varestado ?>"><?php echo $estado ?></option>
                <option></option>
                <option value="0">CONSIGNACION</option>
                <option value="1">COMISION</option>
            </select>

            <br/>
            <hr>
            <label>ESTADO DE ACCESORIOS</label>
            <hr>
            <label>Alfombras:</label>&nbsp;<input list="estado1" name="estado1" value="<?php echo $est_alfombras; ?>" />
            <datalist id="estado1">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>
            </datalist>
            &nbsp;
            <label>Brazos y Plumas:</label>&nbsp;<input list="estado2" name="estado2" value="<?php echo $est_brazosplumas; ?>" />
            <datalist id="estado2">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist>
            &nbsp;
            <label>Cinturones:</label>&nbsp;<input list="estado3" name="estado3" value="<?php echo $est_cinturones; ?>" />
            <datalist id="estado3">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist>  
            &nbsp;
            <label>Espejos:</label>&nbsp;<input list="estado4" name="estado4" value="<?php echo $est_espejos; ?>" />
            <datalist id="estado4">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist>  
            <br/><br/>
            <label>Gata:</label>&nbsp;<input list="estado5" name="estado5" value="<?php echo $est_gata; ?>" />
            <datalist id="estado5">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist> 
            &nbsp;
            <label>Llave de ruedas:</label>&nbsp;<input list="estado6" name="estado6" value="<?php echo $est_brazosplumas; ?>" />
            <datalist id="estado6">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist>  
            &nbsp;
            <label>Manual:</label>&nbsp;<input list="estado7" name="estado7" value="<?php echo $est_manual; ?>" />
            <datalist id="estado7">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist> 
            &nbsp;            
            <label>Radio y Parlantes:</label>&nbsp;<input list="estado8" name="estado8" value="<?php echo $est_radioparlantes; ?>" />
            <datalist id="estado8">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist> 
            <br/><br/>
            <label>Tapacubos y Tuercas:</label>&nbsp;<input list="estado9" name="estado9" value="<?php echo $est_tapatuerca; ?>" />
            <datalist id="estado9">
                <option>BUENO</option>
                <option>MALO</option>
                <option>SI</option>
                <option>NO</option>                
            </datalist> 
            &nbsp; 
            <label>Clave/Otros:</label>&nbsp;<input type="text" name="estado10" value="<?php echo $est_otros; ?>" height="150" />
        <!--            <datalist id="estado10">
                        <option>BUENO</option>
                        <option>MALO</option>
                    </datalist> -->
                    <br/><br/>
                    <label>Mec&aacute;nico:</label>&nbsp;<input list="estado11" name="estado11" value="<?php echo $esta_mecanico; ?>" />
                    <datalist id="estado11">
                        <option>BUENO</option>
                        <option>MALO</option>
                        <option>SI</option>
                        <option>NO</option>                
                    </datalist> 
                    &nbsp; 
                    <label>Sistema El&eacute;ctrico:</label>&nbsp;<input list="estado12" name="estado12" value="<?php echo $esta_sistelect; ?>" />
                    <datalist id="estado12">
                        <option>BUENO</option>
                        <option>MALO</option>
                        <option>SI</option>
                        <option>NO</option>                
                    </datalist> 
                    &nbsp; 
                    <label>Pintura:</label>&nbsp;<input list="estado13" name="estado13" value="<?php echo $esta_pintura; ?>" />
                    <datalist id="estado13">
                        <option>BUENO</option>
                        <option>MALO</option>
                        <option>SI</option>
                        <option>NO</option>                
                    </datalist> 
                    &nbsp;             
                    <hr>
                    <label>DOCUMENTOS DEL VEHICULO</label>
                    <hr>
                    <?php
                    $cont_doc = count($vec_doc);
                    echo "<table border=1>";
                    for ($i = 0; $i < $cont_doc; $i++) {
                        echo "<tr>";
                        echo "<td>" . $vec_doc[$i] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </p>
                <?php
            }

            function imprime_veh($placa) {
                global $marca, $modelo, $anio, $color_1_2, $tipo, $mat_en, $mat_anio, $placa, $motor, $chasis, $km, $alfombras, $brazosplumas, $cinturones, $espejos, $gata, $llaveruedas, $manual, $otros, $radioparlantes, $tapatuerca, $mecanico, $sistelect, $pintura;
                $conn = $this->conec_base();
                $query = "SELECT veh_datos.idveh_placa, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
                . "veh_tipo.veh_tipo_des, veh_datos.veh_anio, veh_datos.veh_color1, "
                . "veh_datos.veh_color2, veh_datos.veh_motor, veh_datos.veh_chasis, "
                . "veh_datos.veh_km, mat_lugar.mat_lugar, veh_datos.veh_mat_anio, "
                . "veh_datos.veh_estado, veh_docu.nom_docu, veh_docu.est_doc, "
                . "veh_estado.est_alfombras, veh_estado.est_brazosplumas, "
                . "veh_estado.est_cinturones, veh_estado.est_espejos, veh_estado.est_gata, "
                . "veh_estado.est_llaveruedas, veh_estado.est_manual, veh_estado.est_radioparlantes, "
                . "veh_estado.est_tapatuerca, veh_estado.esta_mecanico, veh_estado.esta_sistelect, "
                . "veh_estado.esta_pintura, veh_estado.est_otros "
                . "FROM veh_datos, veh_marca, veh_vehiculo, veh_tipo, mat_lugar, veh_docu, veh_estado "
                . "WHERE veh_datos.idveh_placa = '$placa' and veh_datos.veh_vehiculo=veh_vehiculo.idveh_vehiculo "
                . "and veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo "
                . "and veh_datos.veh_mat_lugar=mat_lugar.idmat_lugar and  veh_datos.idveh_placa=veh_docu.idveh_placa "
                . "and veh_datos.idveh_placa=veh_estado.idveh_placa";
                $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));
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
                    }
                    $nom_docu = $datomarca['nom_docu'];
                    $est_doc = $datomarca['est_doc'];
                    $est_alfombras = $datomarca['est_alfombras'];
                    $est_brazosplumas = $datomarca['est_brazosplumas'];
                    $est_cinturones = $datomarca['est_cinturones'];
                    $est_espejos = $datomarca['est_espejos'];
                    $est_gata = $datomarca['est_gata'];
                    $est_llaveruedas = $datomarca['est_llaveruedas'];
                    $est_manual = $datomarca['est_manual'];
                    $est_radioparlantes = $datomarca['est_radioparlantes'];
                    $est_tapatuerca = $datomarca['est_tapatuerca'];
                    $esta_mecanico = $datomarca['esta_mecanico'];
                    $esta_sistelect = $datomarca['esta_sistelect'];
                    $esta_pintura = $datomarca['esta_pintura'];
                    $est_otros = $datomarca['est_otros'];
                }
                $marca = $veh_marca;
                $modelo = $veh_modelo;
                $anio = $veh_anio;
                $color_1_2 = $veh_color1 . ' / ' . $veh_color2;
                $tipo = $veh_tipo_des;
                $mat_en = $veh_mat_lugar;
                $mat_anio = $veh_mat_anio;
                $placa = $tran_veh_placas;
                $motor = $veh_motor;
                $chasis = $veh_chasis;
                $km = $veh_km;
                $alfombras = $est_alfombras;
                $brazosplumas = $est_brazosplumas;
                $cinturones = $est_cinturones;
                $espejos = $est_espejos;
                $gata = $est_gata;
                $llaveruedas = $est_llaveruedas;
                $manual = $est_manual;
                $otros = $est_otros;
                $radioparlantes = $est_radioparlantes;
                $tapatuerca = $est_tapatuerca;
                $mecanico = $esta_mecanico;
                $sistelect = $esta_sistelect;
                $pintura = $esta_pintura;
            }

            function imprime_docu($placa) {
                global $resultado;
                $conn = $this->conec_base();
                $query = "SELECT * FROM veh_docu WHERE idveh_placa = '$placa'";
                $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));

                $resultado = $resveh;
            }

            function trae_valor($placa, $tipo) {
                $conn = $this->conec_base();
//        $query = "SELECT * FROM `tran_cab` WHERE `tran_veh_placas` = '$placa' and tran_cab_tipo='INGRESO' order by tran_sec_tipo ";
                $query = "SELECT max(`tran_sec_tipo`) as max,`tran_cab_precio` FROM `tran_cab` WHERE"
                . " `tran_veh_placas` = '$placa' and tran_cab_tipo='INGRESO' order by tran_sec_tipo";
                $res_val = mysqli_query($conn, $query) or die(mysqli_error($conn));
                while ($row = mysqli_fetch_array($res_val)) {
                    $val = $row['tran_cab_precio'];
                    $tip = $row['max'];
                }
//        if ($tip == 'INGRESO') {
                ?>
                <!--<p style="font-size:13px; text-align: left">-->
                <div class="form-group" style="display: none;">
                    <label>Precio ultimo <?Php echo "INGRESO"; ?></label>&nbsp;&nbsp;
                    <input type="text" style="width:200px;" id="val_veh" name="val_veh" value="<?php echo $val; ?>" readonly="readonly" disabled="" placeholder="Cod." class="form-control" />&nbsp;&nbsp;
                </div>
            </p>
            <?Php
//        }  else{
//            echo '';
//        }
        }

        public function ver_tipoEstado($placa)
        {
            $conn = $this->conec_base();
            $query = "SELECT * FROM `veh_datos` WHERE `idveh_placa` = '$placa'";
            $res_val = mysqli_query($conn, $query) or die(mysqli_error($conn));
            while ($row = mysqli_fetch_array($res_val)) {
                $estado = $row['veh_estado'];
            }
            return $estado;
        }

    }
