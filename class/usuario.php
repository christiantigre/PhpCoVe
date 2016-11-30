<?php
if(!isset($_SESSION)){
session_start();
}  
class Usuario {
    public $usuario;
    public $clave;
    
function conec_base(){
    $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'mysql');
    return $this->objconec;
}
function inserta_usua($usuario, $clave){
    $conn = $this->objconec;
    $sql = "CREATE USER '" . $usuario . "'@'localhost' IDENTIFIED BY '" . $clave . "'";
    mysqli_query($conn, $sql);
    $sql = "GRANT SELECT , INSERT , UPDATE , DELETE ON  mysql.* TO '" . $usuario . "'@'localhost' IDENTIFIED BY '" . $clave . "'";
    mysqli_query($conn, $sql);  
    $sql = "FLUSH PRIVILEGES";
    mysqli_query($conn, $sql);
}
function listar_usua(){
    $conn = $this->objconec;
    $pdf = "SELECT User, Select_priv, Insert_priv, Update_priv, Delete_priv FROM user where User != 'root'" ;
    $result = mysqli_query($conn, $pdf);
    echo "<br><br>";
    echo "<table border=1><tr align=center style='color:red'><td>Usuario</td><td>Select</td><td>Insert</td><td>Update</td><td>Delete</td><td>Acciones</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" .$row['User']. "</td>";
        echo "<td>" .$row['Select_priv']. "</td>";
        echo "<td>" .$row['Insert_priv']. "</td>";
        echo "<td>" .$row['Update_priv']. "</td>";
        echo "<td>" .$row['Delete_priv']. "</td>";
        echo "<td align='center'><button name='veruser' value='".$row['User']."'>Modificar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
}
function buscar_usua(){
    global $usuario, $clave;
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
}
}
