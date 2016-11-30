<?php

class Database {
    private $servidor;
    private $usuario;
    private $clave;
    private $dbase;
    
    function conec_base(){
        $this->objconec = mysqli_connect($_SERVER['SERVER_NAME'], $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        return $this->objconec;
    }        
}
