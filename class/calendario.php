<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calendario
 *
 * @author Alberto
 */
class Calendario {
    public $fecdia;
    public $fecmes;
    public $mes;
    
    function fecha_actual(){
        date_default_timezone_set("America/Guayaquil");
        $fecdia = date('N');
        $fecmes = date('n');
        switch ($fecdia) {
            case 1:
                $fecdia = "Lunes";
                break;
            case 2:
                $fecdia = "Martes";
                break;
            case 3:
                $fecdia = "Miercoles";
                break;
            case 4:
                $fecdia = "Jueves";
                break;
            case 5:
                $fecdia = "Viernes";
                break;
            case 6:
                $fecdia = "Sabado";
                break;
            case 7:
                $fecdia = "Domingo";
                break;
            default:
                break;
        }
        switch ($fecmes) {
            case 1:
                $fecmes = "ENERO";
                break;
            case 2:
                $fecmes = "FEBRERO";
                break;
            case 3:
                $fecmes = "MARZO";
                break;
            case 4:
                $fecmes = "ABRIL";
                break;
            case 5:
                $fecmes = "MAYO";
                break;
            case 6:
                $fecmes = "JUNIO";
                break;
            case 7:
                $fecmes = "JULIO";
                break;
            case 8:
                $fecmes = "AGOSTO";
                break;
            case 9:
                $fecmes = "SEPTIEMBRE";
                break;
            case 10:
                $fecmes = "OCTUBRE";
                break;
            case 11:
                $fecmes = "NOVIEMBRE";
                break;
            case 12:
                $fecmes = "DICIEMBRE";
                break;
            default:
                break;
        }
        $fechat = $fecdia.', '.date('j').' de '.$fecmes.' del '.date('Y');
        echo $fechat;
    }
    function mes_act($mes){
//        date_default_timezone_set("America/Guayaquil");
//        $mes = date('n');
        switch ($mes) {
            case 1:
                $mes = "ENERO";
                break;
            case 2:
                $mes = "FEBRERO";
                break;
            case 3:
                $mes = "MARZO";
                break;
            case 4:
                $mes = "ABRIL";
                break;
            case 5:
                $mes = "MAYO";
                break;
            case 6:
                $mes = "JUNIO";
                break;
            case 7:
                $mes = "JULIO";
                break;
            case 8:
                $mes = "AGOSTO";
                break;
            case 9:
                $mes = "SEPTIEMBRE";
                break;
            case 10:
                $mes = "OCTUBRE";
                break;
            case 11:
                $mes = "NOVIEMBRE";
                break;
            case 12:
                $mes = "DICIEMBRE";
                break;
            default:
                break;        
    }
    return $mes;
}
}
