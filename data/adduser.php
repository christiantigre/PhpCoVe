<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <center>
        <fieldset>
            <form action="inicio.php" method="POST">
                <label>Usuario:</label>&nbsp;
                <input type="text" name="usuario" value="<?php if(isset($_REQUEST['usuario'])){echo $_REQUEST['usuario']; }?>">
                <br><br>
                <label>Clave:</label>&nbsp;
                <input type="password" name="clave" value="">
                <br><br>
                <label>Repetir Clave:</label>
                <input type="password" name="reclave" value="">
                <br><br>
                <input type="submit" name="inserta_usuario" value="Agregar Usuario">
                &nbsp;&nbsp;
                <input type="submit" name="salir_usuario" value="Salir">
            </form>
        </fieldset>
    </center>
    </body>
</html>
