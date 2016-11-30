<?php
if (!isset($_SESSION)) {
    session_start();
}

class tip_pago {

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

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }

    function insertar_tpago($campo,$campoob) {
        $conn = $this->objconec;  
        $ejeccontador = "select count(*)+1 as cont from lis_pag";
        $rescont = mysqli_query($conn, $ejeccontador) or trigger_error("Query Failed! SQL: $ejeccontador - Error: " . mysqli_error($conn), E_USER_ERROR);
        $datocont = mysqli_fetch_array($rescont, MYSQLI_BOTH);
        $contadordp = $datocont['cont'];

        $query = "INSERT INTO `lis_pag`(`id_pag`, `nom_pag`, `observ_lp`) VALUES ('".$contadordp."','".$campo."','".$campoob."')";
        mysqli_query($conn, $query);     
    }

    function mostrar_opciones(){
    $conn = $this->objconec;
    $query = "SELECT * FROM `lis_pag` ";
    $resmostrar = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($resmostrar)){
        echo "<option value=".$row['nom_pag'].">$row[nom_pag] </option>";
    }
    mysqli_close($conn);
}
    
    function listar_pag() {
        $conn = $this->objconec;
        $query = "SELECT * FROM `lis_pag`";
        $respag = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>TIPO</td><td>DETALLES</td>";
        while ($datomarca = mysqli_fetch_array($respag, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['nom_pag'] . "</td>";
            echo "<td>" . $datomarca['observ_lp'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function buscar_pag($idpag) {
        $conn = $this->objconec;
        $query = "SELECT * FROM `lis_pag` where nom_pag like '%".$idpag."%' ";
        $respag = mysqli_query($conn, $query);
        echo "<table border=1><tr align=center style='color:red'><td>TIPO</td><td>DETALLES</td>";
        while ($datomarca = mysqli_fetch_array($respag, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $datomarca['nom_pag'] . "</td>";
            echo "<td>" . $datomarca['observ_lp'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


}
