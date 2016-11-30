<!DOCTYPE html>

<html lang="es">
    <head>
        <title></title>
        <style>
            #cabecera{
                text-align: center;
                font-size: 15px;
            }
        </style>
    </head>
    <body>
        <header id="cabecera"> REPORTES </header>
        <br>
    <center>
        Fecha inicial: &nbsp; <input type="date" name="fecini" value=""> &nbsp;
        Fecha final: &nbsp; <input type="date" name="fecfin" value="">
        <br><br>
        <input type="radio" name="selec" value="Compras">COMPRAS<br>
        <input type="radio" name="selec" value="Ventas">VENTAS<br>
        <br><br>
        <a href="#"><input type="button" name="genrep" value="Genera reporte"></a>
        <a href="#"><input type="button" name="imprep" value="Imprime reporte"></a>
        <a href="mocove.php"><input type="button" value="Salir"></a>
    </center>
    </body>
</html>