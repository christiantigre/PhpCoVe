
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style/style.css" /> 
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST" id="myform">
            <?Php
            if (isset($numcre) and isset($numsec)) {
                ?>
                <input type="hidden" name="numcretxtcob" value="<?Php echo $numcre ?>"/>
                <input type="hidden" name="numsectxtcob" value="<?Php echo $numsec ?>"/>
                <?php
            }
            ?>
            <fieldset>
                <?php
                if (isset($_POST['pagacredito'])) {
                   
                } else {
                    include_once 'class/trancredito.php';
                    $objtrs = new Trancredito();
                    $objtrs->conec_base();
                    $objtrs->cobra_credito();
                }
                ?>
                <hr><br>
            </fieldset> 
            <script>
                var bPreguntar = true;
                function confirmar() {
                    var formulario = document.getElementById("myform");
                    var dato = formulario[0];
                    respuesta = confirm('¿Desea aplicar los cambios?');
                    if (respuesta) {
                        formulario.submit();
                        return true;
                    } else {
                        alert("No se aplicaran los cambios...!!!");
                        return false;
                    }
                }
            </script>
            <br><br>
            <input type="submit" name="cobrarcredito" onclick="return confirmar();" value="PAGAR">
            <input type="submit" name="transac" value="REGRESAR">
        </form>
    </center>
</body>
</html>