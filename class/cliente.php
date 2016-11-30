<?php
if (!isset($_SESSION)) {
    session_start();
}

class Cliente {

    public $idcli_ident;
    public $cli_nombre;
    public $cli_apellido;
    public $cli_dir_casa;
    public $cli_dir_tra;
    public $cli_tel_fijos;
    public $cli_tel_cel;
    public $cli_nom_ref;
    public $cli_dir_ref;
    public $cli_tel_ref;
    public $objconec;

//function __construct($idcli_ident, $cli_nombre, $cli_apellido, $cli_dir_casa, $cli_dir_tra, $cli_tel_fijos, $cli_tel_cel, $cli_nom_ref, $cli_dir_ref, $cli_tel_ref){
//    $this->idcli_ident = $idcli_ident;
//    $this->cli_nombre = $cli_nombre;
//    $this->cli_apellido = $cli_apellido;
//    $this->cli_dir_casa = $cli_dir_casa;
//    $this->cli_dir_tra = $cli_dir_tra;
//    $this->cli_tel_fijos = $cli_tel_fijos;
//    $this->cli_tel_cel = $cli_tel_cel;
//    $this->cli_nom_ref = $cli_nom_ref;
//    $this->cli_dir_ref = $cli_dir_ref;
//    $this->cli_tel_ref = $cli_tel_ref;
//}
    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function insertar_cliente($idcli_ident, $cli_nombre, $cli_apellido, $cli_dir_casa, $cli_dir_tra, $cli_tel_fijos, $cli_tel_cel, $cli_correo, $cli_ciudad, $cli_nom_ref, $cli_dir_ref, $cli_tel_ref, $cli_est_civ, $cli_conyuge, $ced_conyuge) {
        $conn = $this->objconec;
        $query = "INSERT INTO cli_datos(idcli_ident, cli_nombre, cli_apellido, cli_dir_casa, cli_dir_tra, cli_tel_fijos, cli_tel_cel, cli_correo, cli_ciudad, cli_nom_ref, cli_dir_ref, cli_tel_ref, cli_est_civ, cli_conyuge,ced_conyuge) "
        . "VALUE('$idcli_ident', '$cli_nombre', '$cli_apellido', '$cli_dir_casa', '$cli_dir_tra', '$cli_tel_fijos',"
        . " '$cli_tel_cel', '$cli_correo', '$cli_ciudad','$cli_nom_ref', '$cli_dir_ref', '$cli_tel_ref', '$cli_est_civ',"
        . " '$cli_conyuge','$ced_conyuge')";
        if (mysqli_query($conn, $query)) {
            return $query;
        }
        mysqli_close($conn);
    }

    function modifica_cliente($idcli_ident, $cli_nombre, $cli_apellidos, $cli_dir_casa, $cli_dir_tra, 
        $cli_tel_fijos, $cli_tel_cel, $cli_correo, $cod_ciudad, $cli_nom_ref, $cli_dir_ref, $cli_tel_ref, $cli_est_civ, $cli_conyuge,$ced_conyuge) {
        $conn = $this->objconec;
        $query = "UPDATE cli_datos SET "
        . "cli_nombre= '$cli_nombre', "
        . "cli_apellido= '$cli_apellidos', "
        . "cli_dir_casa = '$cli_dir_casa', "
        . "cli_dir_tra = '$cli_dir_tra', "
        . "cli_tel_fijos = '$cli_tel_fijos', "
        . "cli_tel_cel = '$cli_tel_cel', cli_correo = '$cli_correo', cli_ciudad = '$cod_ciudad', "
        . "cli_nom_ref = '$cli_nom_ref', cli_dir_ref = '$cli_dir_ref', cli_tel_ref = '$cli_tel_ref', "
        . "cli_est_civ = '$cli_est_civ',"
        . " cli_conyuge = '$cli_conyuge',"
        . " ced_conyuge = '$ced_conyuge'"
        . " WHERE idcli_ident = '$idcli_ident'";
        mysqli_query($conn, $query);
    }

    function listar_cliente() {
        $conn = $this->objconec;
        $query = "SELECT cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido, "
        . "cli_datos.cli_dir_casa, cli_datos.cli_dir_tra, cli_datos.cli_tel_fijos, "
        . "cli_datos.cli_tel_cel, cli_datos.cli_correo, mat_lugar.mat_lugar, "
        . "cli_datos.cli_nom_ref, cli_datos.cli_dir_ref, cli_datos.cli_tel_ref, "
        . "cli_datos.cli_est_civ, cli_datos.cli_conyuge,cli_datos.ced_conyuge from cli_datos, mat_lugar "
        . "where mat_lugar.idmat_lugar = cli_datos.cli_ciudad "
        . "order by cli_datos.cli_nombre, cli_datos.cli_apellido";
        $resveh = mysqli_query($conn, $query);
//        echo "<table border=1><tr align=center style='color:red'><td>CEDULA</td><td>NOMBRE</td><td>APELLIDO</td><td>DIRECCION CASA</td><td>DIRECCION TRABAJO</td><td>TELEFONO</td><td>CELULAR</td>"
//        . "<td>CORREO</td><td>CIUDAD</td><td>REFERENCIA</td><td>DIRECCION</td><td>TELEFONO</td><td>ESTADO CIVIL</td><td>CONYUGE</td><td>CED</td></tr>";
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idcli_ident'] . "</td>";
            echo "<td>" . $datomarca['cli_nombre'] . "</td>";
            echo "<td>" . $datomarca['cli_apellido'] . "</td>";
            echo "<td>" . $datomarca['cli_dir_casa'] . "</td>";
//            echo "<td>" . $datomarca['cli_dir_tra'] . "</td>";
//            echo "<td>" . $datomarca['cli_tel_fijos'] . "</td>";
//            echo "<td>" . $datomarca['cli_tel_cel'] . "</td>";
            echo "<td>" . $datomarca['cli_correo'] . "</td>";
            echo "<td>" . $datomarca['mat_lugar'] . "</td>";
//            echo "<td>" . $datomarca['cli_nom_ref'] . "</td>";
//            echo "<td>" . $datomarca['cli_dir_ref'] . "</td>";
//            echo "<td>" . $datomarca['cli_tel_ref'] . "</td>";
//            echo "<td>" . $datomarca['cli_est_civ'] . "</td>";
//            if (($datomarca['cli_conyuge'] == '')or ( $datomarca['ced_conyuge'] == '')) {
//                echo "<td>s/n</td>";
//                echo "<td>s/n</td>";
//            } else {
//                echo "<td>" . $datomarca['cli_conyuge'] . "</td>";
//                echo "<td>" . $datomarca['ced_conyuge'] . "</td>";
//            }
            echo "<td><a href='inicio.php?variable=modifica_cliente&vercedula=".$datomarca["idcli_ident"]."' data-toggle='modal''><button type='button' title='VER' class='btn btn-outline btn-info glyphicon glyphicon-eye-open'></button></a></td>";
//            echo "<td align='center'><button name='vercli' value='" . $datomarca['idcli_ident'] . "'>EDITAR</button></td>";
            echo "</tr>";
        }
        mysqli_close($conn);
//        echo "</table>";
    }

    public function mostrar_cliente() {
        $conn = $this->objconec;
        $query = "SELECT idcli_ident, cli_nombre, cli_apellido FROM cli_datos order by cli_nombre";
        $resveh = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($resveh)) {
            echo "<option value=" . $row[idcli_ident] . ">$row[cli_nombre] $row[cli_apellido]</option>";
        }
    }

    function buscar_cliente($idcli_ident) {
        $conn = $this->objconec;
        $query = "SELECT cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido, "
        . "cli_datos.cli_dir_casa, cli_datos.cli_dir_tra, cli_datos.cli_tel_fijos, "
        . "cli_datos.cli_tel_cel, cli_datos.cli_correo, mat_lugar.mat_lugar, "
        . "cli_datos.cli_nom_ref, cli_datos.cli_dir_ref, cli_datos.cli_tel_ref, "
        . "cli_datos.cli_est_civ, cli_datos.cli_conyuge, cli_datos.ced_conyuge "
        . "FROM cli_datos, mat_lugar where mat_lugar.idmat_lugar = cli_datos.cli_ciudad "
        . "and cli_datos.idcli_ident = '" . $idcli_ident . "' "
        . "order by cli_datos.cli_nombre, cli_datos.cli_apellido";
        $resveh = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>CEDULA</td><td>NOMBRE</td><td>APELLIDO</td><td>DIRECCION CASA</td><td>DIRECCION TRABAJO</td><td>TELEFONO</td><td>CELULAR</td>"
        . "<td>CORREO</td><td>CIUDAD</td><td>REFERENCIA</td><td>DIRECCION</td><td>TELEFONO</td><td>ESTADO CIVIL</td><td>CONYUGE</td><td>CED</td></tr>";
        while ($datomarca = mysqli_fetch_array($resveh, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['idcli_ident'] . "</td>";
            echo "<td>" . $datomarca['cli_nombre'] . "</td>";
            echo "<td>" . $datomarca['cli_apellido'] . "</td>";
            echo "<td>" . $datomarca['cli_dir_casa'] . "</td>";
            echo "<td>" . $datomarca['cli_dir_tra'] . "</td>";
            echo "<td>" . $datomarca['cli_tel_fijos'] . "</td>";
            echo "<td>" . $datomarca['cli_tel_cel'] . "</td>";
            echo "<td>" . $datomarca['cli_correo'] . "</td>";
            echo "<td>" . $datomarca['mat_lugar'] . "</td>";
            echo "<td>" . $datomarca['cli_nom_ref'] . "</td>";
            echo "<td>" . $datomarca['cli_dir_ref'] . "</td>";
            echo "<td>" . $datomarca['cli_tel_ref'] . "</td>";
            echo "<td>" . $datomarca['cli_est_civ'] . "</td>";
            echo "<td>" . $datomarca['cli_conyuge'] . "</td>";
            echo "<td>" . $datomarca['ced_conyuge'] . "</td>";
            echo "<td align='center'><button name='vercli' value='" . $datomarca['idcli_ident'] . "'>EDITAR</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_cliente_com($cliente) {
        $conn = $this->objconec;
        $query = "SELECT cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido, "
        . "cli_datos.cli_dir_casa, cli_datos.cli_dir_tra, cli_datos.cli_tel_fijos, "
        . "cli_datos.cli_tel_cel, cli_datos.cli_correo, mat_lugar.mat_lugar, "
        . "cli_datos.cli_nom_ref, cli_datos.cli_dir_ref, cli_datos.cli_tel_ref, "
        . "cli_datos.cli_est_civ, cli_datos.cli_conyuge, cli_datos.ced_conyuge FROM cli_datos, mat_lugar "
        . "where mat_lugar.idmat_lugar = cli_datos.cli_ciudad and cli_datos.idcli_ident = '" . $cliente . "' "
        . "order by cli_datos.cli_nombre, cli_datos.cli_apellido";
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
            $cli_ciudad = $datomarca['mat_lugar'];
            $cli_nom_ref = $datomarca['cli_nom_ref'];
            $cli_dir_ref = $datomarca['cli_dir_ref'];
            $cli_tel_ref = $datomarca['cli_tel_ref'];
            $cli_est_civ = $datomarca['cli_est_civ'];
            $cli_conyuge = $datomarca['cli_conyuge'];
            $ced_conyuge = $datomarca['ced_conyuge'];
            
            ?>
            <!--<p style="font-size:9px; text-align: center">-->
            <div class="col-lg-6">   


                <!--    <label>C&eacute;cula:</label>&nbsp; <?php echo $idcli_ident ?> -->
                <div class="form-group">
                <label>Nombres:</label> <input type="text" name="cli_nombre" value="<?php echo $cli_nombre ?>" disabled="" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Apellidos:</label> <input type="text" name="cli_apellidos" value="<?php echo $cli_apellido ?>" disabled="" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Tel&eacute;fonos:</label> <input type="text" name="cli_tel_fijos" value="<?php echo $cli_tel_fijos . ' ' . $cli_tel_cel ?>" disabled="" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Direcci&oacute;n casa:</label> 
                    <textarea name="cli_dir_casa" cols="55" rows="2" disabled="" class="form-control"><?php echo $cli_dir_casa ?></textarea>
                </div>                

                <div class="form-group">
                    <label>Direcci&oacute;n trabajo:</label>
                    <textarea name="cli_dir_casa" cols="55" rows="2" disabled="" class="form-control"><?php echo $cli_dir_tra ?></textarea>
                </div>
                <div class="form-group">
                    <label>Correo Electr&oacute;nico:</label><input type="text" name="cli_correo" value="<?php echo $cli_correo ?>" disabled="" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Ciudad:</label><input type="text" name="cli_ciudad" value="<?php echo $cli_ciudad ?>" disabled="" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Estado civil:</label><input type="text" name="cli_est_civ" value="<?php echo $cli_est_civ ?>" disabled="" class="form-control"/>
                </div>

                <!--</p>-->
            </div>
            <div class="col-lg-6"> 


                <div class="form-group">
                    <label>Conyuge:</label><input type="text" name="cli_conyuge" value="<?php echo $cli_conyuge ?>" disabled="" class="form-control"/>
                </div>    
                <div class="form-group">
                    <label>C&eacute;dula Conyuge:</label>
                    <input type="text" name="ced_conyuge" value="<?php echo $ced_conyuge ?>" disabled="" class="form-control"/>                
                </div>
                <div class="form-group">                
                    <label>Referencia:</label> <input type="text" name="cli_nom_ref" value="<?php echo $cli_nom_ref ?>" disabled="" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Direcci&oacute;n:</label> 
                    <textarea name="cli_dir_ref" cols="55" rows="2" disabled="" class="form-control"><?php echo $cli_dir_ref ?></textarea>
                </div>
                <div class="form-group">
                    <label>Tel&eacute;fono:</label> <input type="text" name="cli_tel_ref" value="<?php echo $cli_tel_ref ?>" disabled="" class="form-control"/>
                </div>
                
            </div>

            <?php
        }
    }

    function imprime_cli($cliente) {
        global $ident, $nombre, $apellido, $dire_casa, $dire_tra, $tel_fijo, $tel_cel, $correo, $ciudad, $referencia, $dir_refe, $tel_ref, $est_civil, $conyuge,$cedu_conyuge;
        $conn = $this->conec_base();
        $query = "SELECT cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido, "
        . "cli_datos.cli_dir_casa, cli_datos.cli_dir_tra, cli_datos.cli_tel_fijos, "
        . "cli_datos.cli_tel_cel, cli_datos.cli_correo, mat_lugar.mat_lugar, "
        . "cli_datos.cli_nom_ref, cli_datos.cli_dir_ref, cli_datos.cli_tel_ref, "
        . "cli_datos.cli_est_civ, cli_datos.cli_conyuge,cli_datos.ced_conyuge FROM cli_datos, mat_lugar "
        . "where mat_lugar.idmat_lugar = cli_datos.cli_ciudad and cli_datos.idcli_ident = $cliente "
        . "order by cli_datos.cli_nombre, cli_datos.cli_apellido";
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
            $cli_ciudad = $datomarca['mat_lugar'];
            $cli_nom_ref = $datomarca['cli_nom_ref'];
            $cli_dir_ref = $datomarca['cli_dir_ref'];
            $cli_tel_ref = $datomarca['cli_tel_ref'];
            $cli_est_civ = $datomarca['cli_est_civ'];
            $cli_conyuge = $datomarca['cli_conyuge'];
            $ced_conyuge = $datomarca['ced_conyuge'];
        }
        $ident = $idcli_ident;
        $nombre = $cli_nombre;
        $apellido = $cli_apellido;
        $dire_casa = $cli_dir_casa;
        $dire_tra = $cli_dir_tra;
        $tel_fijo = $cli_tel_fijos;
        $tel_cel = $cli_tel_cel;
        $correo = $cli_correo;
        $ciudad = $cli_ciudad;
        $referencia = $cli_nom_ref;
        $dir_refe = $cli_dir_ref;
        $tel_ref = $cli_tel_ref;
        $est_civil = $cli_est_civ;
        $conyuge = $cli_conyuge;
        $cedu_conyuge = $ced_conyuge;
    }

    function ver_cliente($cliente) {
        $conn = $this->objconec;
        $query = "SELECT cli_datos.idcli_ident, cli_datos.cli_nombre, cli_datos.cli_apellido, "
        . "cli_datos.cli_dir_casa, cli_datos.cli_dir_tra, cli_datos.cli_tel_fijos, "
        . "cli_datos.cli_tel_cel, cli_datos.cli_correo, cli_datos.cli_ciudad, mat_lugar.mat_lugar, "
        . "cli_datos.cli_nom_ref, cli_datos.cli_dir_ref, cli_datos.cli_tel_ref, "
        . "cli_datos.cli_est_civ, cli_datos.cli_conyuge,cli_datos.ced_conyuge FROM cli_datos, mat_lugar "
        . "where mat_lugar.idmat_lugar = cli_datos.cli_ciudad and cli_datos.idcli_ident = $cliente "
        . "order by cli_datos.cli_nombre, cli_datos.cli_apellido";
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
            $cod_ciudad = $datomarca['cli_ciudad'];
            $cli_ciudad = $datomarca['mat_lugar'];
            $cli_nom_ref = $datomarca['cli_nom_ref'];
            $cli_dir_ref = $datomarca['cli_dir_ref'];
            $cli_tel_ref = $datomarca['cli_tel_ref'];
            $cli_est_civ = $datomarca['cli_est_civ'];
            $cli_conyuge = $datomarca['cli_conyuge'];
            $ced_conyuge = $datomarca['ced_conyuge'];
            ?>
            <p style="font-size:9px; text-align: left">
                <!--    <label>C&eacute;cula:</label>&nbsp; -->
                <label>Cédula:</label>&nbsp;<input type="text" value="<?php echo $idcli_ident ?>" disabled=""/>
                <input type="text" name="idcli_ident" value="<?php echo $idcli_ident ?>" hidden=""/>
                <br/>
                <label>Nombres:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="text" name="cli_nombre" style="width: 300px" value="<?php echo $cli_nombre ?>" /><!--disabled=""-->
                &nbsp;&nbsp;
                <label>Apellidos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="text" name="cli_apellidos" style="width: 300px" value="<?php echo $cli_apellido ?>" /><!--disabled=""-->
                <br>
                <label>Direcci&oacute;n casa:</label>&nbsp; 
                <textarea name="cli_dir_casa" cols="55" rows="2" ><?php echo $cli_dir_casa ?></textarea>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Direcci&oacute;n trabajo:</label>&nbsp;
                <textarea name="cli_dir_tra" cols="55" rows="2" ><?php echo $cli_dir_tra ?></textarea>
                <br>
                <label>Tel&eacute;fonos fijos:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="text" name="cli_tel_fijos" style="width: 300px" value="<?php echo $cli_tel_fijos ?>" />
                &nbsp;&nbsp;
                <label>Tel&eacute;fono Celular:</label>&nbsp;&nbsp;&nbsp;
                <input type="text" name="cli_tel_cel" style="width: 300px" value="<?php echo $cli_tel_cel ?>" />
                <br>
                <label>Correo Electr&oacute;nico:</label>
                <input type="text" name="cli_correo" style="width: 300px" value="<?php echo $cli_correo ?>" />
                &nbsp;&nbsp;
                <label>Ciudad:</label> <input type="text" name="cli_ciudad" value="<?php echo $cli_ciudad ?>" hidden=""/>
                <select id="cod_ciudad" name="cod_ciudad" >
                    <option value="<?php echo $cod_ciudad ?>"><?php echo $cli_ciudad ?></option>
                    <?php
                    include_once 'lugar.php';
                    $objlugar = new Lugar();
                    $objlugar->conec_base();
                    $objlugar->mostrar_lugar();
                    ?>                
                </select>                
<!--                <label>Ciudad:</label>
    <input type="text" name="cli_ciudad" value="<?php echo $cli_ciudad ?>" />-->
    <br>
    <label>Estado civil:</label> <input list="cli_est_civ" name="cli_est_civ" <?php echo $cli_ciudad ?> hidden="" />
    <select id="cli_est_civ" name="cli_est_civ">
        <option value="<?php echo $cli_est_civ ?>"><?php echo $cli_est_civ ?></option>
        <option></option>
        <option value="SOLTERO/A">SOLTERO/A</option>
        <option value="CASADO/A">CASADO/A</option>
        <option value="DIVORCIADO/A">DIVORCIADO/A</option>
        <option value="VIUDO/A">VIUDO/A</option>
    </select>                
<!--                <label>Estado civil:</label>
    <input type="text" name="cli_est_civ" value="<?php echo $cli_est_civ ?>" />-->
    &nbsp;&nbsp;
    <label>Conyuge:</label>
    <input type="text" name="cli_conyuge" style="width: 300px" value="<?php echo $cli_conyuge ?>" /> 
    &nbsp;&nbsp;
    <label>C&eacute;dula Conyuge:</label>
    <input type="text" name="ced_conyuge" value="<?php echo $ced_conyuge ?>" />
    <hr>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Referencia:</label>&nbsp; <input type="text" name="cli_nom_ref" style="width: 150px" value="<?php echo $cli_nom_ref ?>"/>
    &nbsp;&nbsp;
    <label>Direcci&oacute;n:</label>&nbsp; <input type="text" name="cli_dir_ref" style="width: 150px" value="<?php echo $cli_dir_ref ?>"/>
    &nbsp;&nbsp;
    <label>Tel&eacute;fono:</label>&nbsp; <input type="text" name="cli_tel_ref" style="width: 150px" value="<?php echo $cli_tel_ref ?>"/>
</p>
<?php
}
}

}
