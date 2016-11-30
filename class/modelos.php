<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$options="";
if ($_POST["elegido"]=='0') {
    $options= '
    <option value="---">---</option>
    ';    
}
if ($_POST["elegido"]=='ENTRADA') {
    $options= '
    <option value="EFECTIVO">EFECTIVO</option>
    <option value="CHEQUE">CHEQUE</option>
    <option value="VEHICULO">VEHICULO</option>
    <option value="OTRA FORMA">OTRA FORMA</option>
    ';    
}
if ($_POST["elegido"]=='ADICIONAL') {
    $options= '
    <option value="CHEQUE">CHEQUE</option>
    <option value="LETRA DE CAMBIO">LETRA DE CAMBIO</option>
    ';    
}
if ($_POST["elegido"]=='CREDITO') {
    $options= '
    <option value="LETRA DE CAMBIO">LETRA DE CAMBIO</option>
    ';    
}
echo $options;    
?>