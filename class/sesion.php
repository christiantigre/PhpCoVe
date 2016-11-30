<?php
class Sesion{
    private $user;
    private $pass;
function __construct($user, $pass){
    $this->user = $user;
    $this->pass = $pass;
}
function abrir_sesion(){
    session_start();
    $_SESSION['user'] = $this->user;
    $_SESSION['pass'] = $this->pass;
}
function cerrar_sesion(){
    session_start();
    session_unset();
    session_destroy();
}
}