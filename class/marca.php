<?php
if(!isset($_SESSION)){
session_start();
}  
class Marca{
    public $marca;
    public $objconec;
//function __construct($marca) {
//    $this->marca = $marca;
//}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
    return $this->objconec;
}
function guardar_marca($marca){
    $conn = $this->objconec;
    $query = "INSERT INTO veh_marca(veh_marca) VALUES ('$marca')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}
public function listar_marca(){
    $conn = $this->objconec;
    $query = "SELECT veh_marca.veh_marca from veh_marca order by veh_marca";
    $resmarca = mysqli_query($conn, $query);
//    echo "<table border=2><tr align=center style='color:red'><td width=200>Marca</td>";
    while($datomarca = mysqli_fetch_array($resmarca, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$datomarca['veh_marca']. "</td>";
        echo "</tr>";               
    }
//    echo "</table>";
    mysqli_close($conn);    
}
public function mostrar_marca(){
    $conn = $this->objconec;
    $query = "SELECT * FROM veh_marca order by veh_marca";
    $resmostrar = mysqli_query($conn, $query);    
    echo "<option> </option>";
    while($row = mysqli_fetch_array($resmostrar)){
    
        echo "<option value=".$row[idveh_marca].">$row[veh_marca]</option>";
        }
    mysqli_close($conn);    
}
}