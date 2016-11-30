<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../style/style.css" />
        <link rel="stylesheet" type="text/css" href="../style/style.css" />          
    </head>
    <body>
    <center>
        <br>
        <fieldset>
            <form action="inicio.php" method="POST">
                Nombres: &nbsp;<input type="text" name="nom_user" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();" autofocus="">
                <br>
                Apellidos: &nbsp;<input type="text" name="ape_user" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();">
                <br>
                <input type="submit" name="inserta_lugar" value="GUARDAR">
                &nbsp;&nbsp;
                <input type="reset" value="CANCELAR">
                &nbsp;&nbsp;
                <input type="submit" name="salir_para" value="SALIR">
            </form>
        </fieldset> 
        <br>
        <div id="lstveh">
        <?php
            include_once 'class/lugar.php';
            $objcon = new Lugar('*');
            $objcon->conec_base();
            $objcon->listar_lugar();
        ?>   
        </div>
     </center>        
        <?php
        // put your code here
        ?>
    </body>
</html>
