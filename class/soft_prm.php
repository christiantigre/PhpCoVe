<?php
if(!isset($_SESSION)){
session_start();
}  
class Interes{
    public $interes;
    public $objconec;
function __construct($interes) {
    $this->interes = $interes;
}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');    
    return $this->objconec;
}
function insertar_interes(){
    $conn = $this->objconec;
    $query = "INSERT INTO soft_prm(prm_int) VALUE('$this->interes')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}
function listar_interes(){
    $conn = $this->objconec;
    $query = "SELECT * from soft_prm order by prm_int";
    $restipo = mysqli_query($conn, $query);
//    echo "<table border=2><tr align=center style='color:red'><td width=200>Interes</td>";
    while($dato =  mysqli_fetch_array($restipo, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$dato['prm_int']. "</td>";
        echo "</tr>";
    }
//    echo "</table>";
    mysqli_close($conn);
}
function mostrar_interes(){
    $conn = $this->objconec;
    $query = "SELECT * FROM soft_prm order by prm_int";
    $restipo = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($restipo)){
        echo "<option value=".$row[idveh_tipo].">$row[prm_int]</option>";
    }
    mysqli_close($conn);
}
}