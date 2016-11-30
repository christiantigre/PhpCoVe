<?php
if(!isset($_SESSION)){
session_start();
}
class Lugar{
    public $mat_lugar;
    public $objconec;
function __construct($mat_lugar) {
    $this->mat_lugar = $mat_lugar;
}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');    
    return $this->objconec;
}
function insertar_lugar(){
    $conn = $this->objconec;
    $query = "INSERT INTO mat_lugar(mat_lugar) VALUE('$this->mat_lugar')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}
function listar_lugar(){
    $conn = $this->objconec;
    $query = "SELECT * from mat_lugar order by mat_lugar";
    $reslugar = mysqli_query($conn, $query);
//    echo "<table border=2><tr align=center style='color:red'><td width=200>Lugar</td>";
    while($dato =  mysqli_fetch_array($reslugar, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$dato['mat_lugar']. "</td>";
        echo "</tr>";
    }
//    echo "</table>";
    mysqli_close($conn);
}
function mostrar_lugar(){
    $conn = $this->objconec;
    $query = "SELECT * FROM mat_lugar order by mat_lugar";
    $reslugar = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($reslugar)){
        echo "<option value=".$row[idmat_lugar].">$row[mat_lugar]</option>";
    }
    mysqli_close($conn);
    }
}