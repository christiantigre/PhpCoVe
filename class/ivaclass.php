<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_SESSION)){
session_start();
}  
class Iva{
    public $iva;
    public $objconec;
function __construct($iva) {
    $this->iva= $iva;
}
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');    
    return $this->objconec;
}
function insertar_iva(){
    $conn = $this->objconec;
    $query = "INSERT INTO iva(iva,active) VALUE('$this->iva','0')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}
function listar_iva(){
    $conn = $this->objconec;
    $query = "SELECT * from iva where iva !='SELECCIONE' order by idiva asc";
    $restipo = mysqli_query($conn, $query);
    echo "<table border=2><tr align=center style='color:red'><td width=200>Iva</td><td width=200>Estado</td>";
    while($dato =  mysqli_fetch_array($restipo, MYSQLI_BOTH)){
        echo "<tr>";
        echo "<td>".$dato['iva']. "</td>";
        echo "<td>";
        if ($dato['active'] == '1') {
            echo "Activo";
        }else{
            echo "Inactivo";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);
}
function mostrar_iva(){
    $conn = $this->objconec;
    $query = "SELECT * FROM iva order by idiva";
    $restipo = mysqli_query($conn, $query);
    echo "<option> </option>";
    while($row = mysqli_fetch_array($restipo)){
        echo "<option value=".$row[idveh_tipo].">$row[prm_int]</option>";
    }
    mysqli_close($conn);
}
}

