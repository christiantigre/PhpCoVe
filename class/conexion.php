<?php
class Conexion{
    private $server;
    private $user;
    private $pass;
    private $dbase;
    private $conn;
    function __construct($server, $user, $pass, $dbase) {
        $this->server = $server;
        $this->user = $user;
        $this->pass =$pass;
        $this->dbase = $dbase;
    }
    function conectar(){
        mysqli_connect($this->server, $this->user, $this->pass, $this->dbase) or die(mysql_errno());
    }
    function desconectar(){
        mysqli_close($this->conn);
    }
}