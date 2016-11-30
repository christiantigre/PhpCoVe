
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style/style.css" /> 
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST" id="myformimp">
            <?Php
            $varcre = $_POST['numcretxtcob'];
            $varsec = $_POST['numsectxtcob'];
            if (isset($varcre) and isset($varsec)) {
                ?>
                <input type="hidden" name="numcretxtcob" value="<?Php echo $varcre ?>"/>
                <input type="hidden" name="numsectxtcob" value="<?Php echo $varsec ?>"/>
                <?php
            }
            ?>
            <fieldset>
                <?php
                include_once 'class/pagosclass.php';
                $objtrs = new Pagos();
                $objtrs->conec_base();
                echo '<hr><br>';
                echo '<h1>GENERAL</h1>';
                $objtrs->buscar_transcarppag($_POST['numcretxtcob']);
                echo '<hr><br>';
                echo '<h1>VEHICULO</h1>';
                $objtrs->buscar_veh_pag($_POST['numcretxtcob']);
                echo '<hr><br>';
                echo '<h1>CLIENTE</h1>';
                $objtrs->buscar_cliente_pag($_POST['numcretxtcob']);
                echo '<hr><br>';
                echo '<h1>COBRO</h1>';
                $objtrs->detallpago($_POST['numcretxtcob'], $_POST['numsectxtcob']);
                
                ?>
                <hr><br>
            </fieldset> 
            <script>
                var bPreguntar = true;
                function confirmar() {
                    var formulario = document.getElementById("myformimp");
                    var dato = formulario[0];
                    respuesta = confirm('¿Desea imprimir comprobante?');
                    if (respuesta) {
                        formulario.submit();
                        return true;
                    } else {
                        return false;
                    }
                }




            </script>
            <br><br>
            <input type="submit" name="impcomprobantepag" onclick="return confirmar();" value="IMPRIMIR">
            <input type="submit" name="transac" value="REGRESAR">
        </form>
    </center>
</body>
</html>