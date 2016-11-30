<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style/style.css" /> 
    </head>
    <body>
    <center>
        <form action="inicio.php" method="POST">
            </br>
            <?php
            if (isset($key) != "") {
                ?>            
            <input type="hidden" value="<?php echo $key ?>" name="key"  readonly="readonly"/>
                <?php
                include_once 'hsgastos/gastosclass.php';
                $objgts = new Gastos();
                $objgts->conec_base();
                
            ?>
            <input type="submit" name="transac_cob" value="REGRESAR">
            </br>
            </br>
            <fieldset>
                <?Php
                $objgts->buscar_gastos($key);
            }
                ?> 
            </fieldset> 
            <br><br>
        </form>
    </center>
</body>
</html>