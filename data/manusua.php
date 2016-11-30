<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../style/style.css" />        
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST">
            <input type="submit" name="nuevo_usuario" value="NUEVO USUARIO">
            &nbsp;&nbsp;
            <input type="submit" name="salir_admin" value="SALIR">
            <?php
                include_once '/class/usuario.php';
                $objuser = new Usuario();
                $objuser->conec_base();
                $objuser->listar_usua();
            ?>
        </form>        
    </center>

    </body>
</html>
