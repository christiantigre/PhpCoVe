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
        <script type="text/javascript" src="js/jquery-1.11.3.js">
        </script>
    </head>
    <body>
    <center>
        <br>
        <fieldset>
            <form action="inicio.php" method="POST">
                Tipo: &nbsp;<input type="text" name="iva" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();" autocomplete="off">
                <br><br>
                <input type="submit" name="inserta_iva" value="GUARDAR">
                &nbsp;&nbsp;
                <input type="reset" value="CANCELAR">
                &nbsp;&nbsp;
                <input type="submit" name="salir_para" value="SALIR"></a>
            </form>
        </fieldset> 
        <br>
        <div id="lstveh">
        <?php
            include_once 'class/ivaclass.php';
            $objcon = new Iva('*');
            $objcon->conec_base();
            $objcon->listar_iva();
        ?>   
        </div>
    </center>

    </body>
</html>