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
    </head>
    <body>
        <form action="inicio.php" method="POST">
            <fieldset>
                <legend>Datos Vehiculo</legend>
            </fieldset>
            <fieldset>
                <legend>Datos Cliente</legend>
            </fieldset>
            <input type="submit" name="compra" value="SALIR">
        </form>
    </body>
</html>