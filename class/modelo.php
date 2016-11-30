<?php
if(!isset($_SESSION)){
session_start();
}  
class Modelo{
    public $veh_marca;
    public $veh_modelo;
    public $veh_tipo;
    public $objconec;
    
//function __construct($veh_marca, $veh_modelo) {
//    $this->veh_marca = $veh_marca;
//    $this->veh_modelo = $veh_modelo;
//}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
    return $this->objconec;
}
function guardar_modelo($veh_marca, $veh_modelo, $veh_tipo){
    $conn = $this->objconec;
    $query = "INSERT INTO veh_vehiculo(veh_marca, veh_modelo, veh_tipo) VALUES ('$veh_marca', '$veh_modelo', '$veh_tipo')";
    mysqli_query($conn, $query);
    mysqli_close($conn);    
}
function listar_modelo(){
    $conn = $this->objconec;
    $query = "SELECT veh_marca.veh_marca, veh_vehiculo.veh_modelo, veh_tipo.veh_tipo_des FROM veh_marca, veh_vehiculo, veh_tipo "
            . "where veh_marca.idveh_marca=veh_vehiculo.veh_marca and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo order by veh_marca, veh_modelo";
    $resmarca = mysqli_query($conn, $query);
//    echo "<table border=2><tr align=center style='color:red'><td width=200>Marca</td><td width=200>Modelo</td><td width=200>Tipo</td>";
    while($datomarca = mysqli_fetch_array($resmarca, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$datomarca['veh_marca']. "</td>";
        echo "<td>".$datomarca['veh_modelo']. "</td>";
        echo "<td>".$datomarca['veh_tipo_des']. "</td>";
        echo "</tr>";               
    }
//    echo "</table>";
    mysqli_close($conn);    
}
function mostrar_modelo(){
    $conn = $this->objconec;
    $query = "SELECT * FROM veh_modelo order by veh_modelo";
    $resmostrar = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($resmostrar)){
        echo "<option value=".$row[idveh_modelo].">$row[veh_modelo]</option>";
    }
    mysqli_close($conn);
}
function mostrar_modelo_marca(){
    $conn = $this->objconec;
    $query = "SELECT veh_vehiculo.idveh_vehiculo, veh_marca.veh_marca, veh_vehiculo.veh_modelo, "
            . "veh_tipo.veh_tipo_des FROM veh_marca, veh_vehiculo, veh_tipo "
            . "where veh_marca.idveh_marca=veh_vehiculo.veh_marca "
            . "and veh_tipo.idveh_tipo=veh_vehiculo.veh_tipo  "
            . "order by veh_marca, veh_modelo";
    $resmostrar = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($resmostrar)){
        echo "<option value=".$row[idveh_vehiculo].">$row[veh_marca]  $row[veh_modelo]  $row[veh_tipo_des]</option>";
    }
    mysqli_close($conn);
}
function modelo_cuenta($vehiculo){
    $conn = $this->objconec;
    $query = "SELECT veh_datos.veh_color1, veh_datos.veh_anio, veh_vehiculo.veh_modelo FROM veh_datos, veh_vehiculo "
            . "WHERE veh_datos.idveh_placa = '$vehiculo' and veh_vehiculo.idveh_vehiculo = veh_datos.veh_vehiculo";
    $resmodelo = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($resmodelo);
    $modelo = $row['veh_modelo'].' '.$row['veh_color1'].' '.$row['veh_anio'];
    return $modelo;
}
}