<?php
if(!isset($_SESSION)){
session_start();
}  
class Tipo{
    public $veh_tipo_des;
    public $objconec;
function __construct($veh_tipo_des) {
    $this->veh_tipo_des = $veh_tipo_des;
}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');    
    return $this->objconec;
}
function insertar_tipo(){
    $conn = $this->objconec;
    $query = "INSERT INTO veh_tipo(veh_tipo_des) VALUE('$this->veh_tipo_des')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}
function listar_tipo(){
    $conn = $this->objconec;
    $query = "SELECT * from veh_tipo order by veh_tipo_des";
    $restipo = mysqli_query($conn, $query);
//    echo "<table border=2><tr align=center style='color:red'><td width=200>Tipo</td>";
    while($dato =  mysqli_fetch_array($restipo, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$dato['veh_tipo_des']. "</td>";
        echo "</tr>";
    }
//    echo "</table>";
    mysqli_close($conn);
}
function mostrar_tipo(){
    $conn = $this->objconec;
    $query = "SELECT * FROM veh_tipo order by veh_tipo_des";
    $restipo = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($restipo)){
        echo "<option value=".$row[idveh_tipo].">$row[veh_tipo_des]</option>";
    }
    mysqli_close($conn);
}
}