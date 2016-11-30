<?php
if(!isset($_SESSION)){
session_start();
}  
$usuario = "";
if(isset($_SESSION['user'])){
    $usuario = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <header>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
        <p style="font-size:10px">Sesi&oacute;n iniciada por:&nbsp;<?php echo $usuario ?></p>
        <img src="images/logo_pag.png"  width="400px" height="70px" alt="logo_empresa" align="left">
        <img src="images/encabezado.png" width="380px" height="60px" alt="logo_com-ven">
    </header>
    </head>
    <body>
    </body>
</html>