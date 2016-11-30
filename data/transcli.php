<?php
if(!isset($_SESSION)){
session_start();
}  
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
       <link rel="stylesheet" type="text/css" href="../style/style.css" />        
        <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
    </head>
    <body>
        C&eacute;dula: &nbsp; <input type="text" name="idcli_ident" size="10px">
        &nbsp;&nbsp;
        Nombres: <input type="text" name="cli_nombre" size="100px" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
        &nbsp;&nbsp;
        Apellidos: <input type="text" name="cli_apellido" size="100px" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
        <br><br>
        Direcci&oacute;n principal:
        <textarea name="cli_dir_casa" cols="35" rows="2" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
        Direcci&oacute;n Oficina-Trabajo:
        <textarea name="cli_dir_tra" cols="35" rows="2" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
        <br><br>
        Tel&eacute;fonos fijos: &nbsp; <input type="text" name="cli_tel_fijos" size="50px">
        &nbsp;&nbsp;
        Tel&eacute;fonos celulares: &nbsp; <input type="text" name="cli_tel_cel" size="50px">
        <br>
        <hr>
        Referencia: &nbsp; <input type="text" name="cli_nom_ref" size="30px" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
        &nbsp;
        Direcci&oacute;n referencia:
        <textarea name="cli_dir_ref" cols="35" rows="2" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"></textarea>
        <br><br>
        Tel&eacute;fonos referencia: <input type="text" name="cli_tel_ref" size="25px">
    </body>
</html>