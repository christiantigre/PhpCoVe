<?php
    date_default_timezone_set("America/Guayaquil");
    $fecha = date("Y-m-d");

    if(isset($_POST['cal_credito'])){
        $conn = new mysqli('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
        $borrar = "DELETE FROM prv_cre";
        $conn->query($borrar);

        $fechacre = $_REQUEST['fecha'];
        $montocre = $_REQUEST['valor'];
        $interes = ($_REQUEST['interes']) / 100;
        $plazocre = $_REQUEST['plazo'];
        $interes_dia = ($montocre * $interes)/30;
        $interes_mes = $montocre * $interes;
        $totalcre = $montocre + (($interes_dia) * $plazocre);
        $pago_mes = $totalcre / (($plazocre)/30);
        $montomes = $montocre / (($plazocre)/30);
        $tiempo = $plazocre / 30;
        $saldocre = $totalcre;
        for ($i = 1; $i <= $tiempo; $i++) {
            $saldocre = $saldocre - $pago_mes;
            $fechacre = strtotime('+30 days', strtotime($fechacre));
            $fechacre = date('Y-m-j', $fechacre);
            $cuota = "INSERT INTO prv_cre (secuencial, fecha_pago, valor_pago, interes, monto)"
                    . "VALUES ($i, '$fechacre', $pago_mes, $interes_mes, $montomes)";
            $conn->query($cuota);
        }
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Control Parqueadero - </title>
</head>
    <body>
        <div class="row">  
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        TABLA DE AMORTIZACION
                    </div>        
                    <div class="panel-body" style="font-size: 9px"> 
                        <center>
                        <form action="inicio.php" id="form" name="form" method="POST">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr rol="row">
                                            <td width="80">Monto</td>
                                            <td width="80">Fecha de cr&eacute;dito</td>
                                            <td width="80">Interes</td>
                                            <td width="80">Plazo d&iacute;as</td>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <tr style="font-size: 12px">
                                        <td>
                                            <input type="text" id="valor" name="valor" placeholder="0.00" value="<?php if (isset($_REQUEST['valor'])) { echo $_REQUEST['valor']; }?>"  style="text-align:right">
                                        </td>
                                        <td>
                                            <input type="text" id="fecha" name="fecha" placeholder="yyyy-mm-dd"  value="<?php if (isset($_REQUEST['fecha'])) { echo $_REQUEST['fecha']; }?>" style="height: 20px; text-align:center;">
                                        </td>
                                        <td>
                                            <!--<input type="text" id="interes" name="interes" style="width: 50px" placeholder="0.00">-->
                                            <select name="interes" id="interes" placeholder="0.00" value="<?php if (isset($_REQUEST['interes'])) { echo $_REQUEST['interes']; }?>" style="width: 80px">
                                                <?php
                                                $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                                                $consulint = "select prm_int from soft_prm";
                                                $queryclases = mysqli_query($c, $consulint);
                                                while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                    if ($_POST['prm_int'] == $arreglorepalmtu['prm_int']) {
                                                        echo "<option value='" . $arreglorepalmtu['prm_int'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['prm_int'] . "</option>";
                                                    } else {
                                                        ?>
                                                        <option><?php if (isset($_REQUEST['interes'])) { echo $_REQUEST['interes']; }?></option>
                                                        <option class="form-control" value="<?php echo $arreglorepalmtu['prm_int'] ?>">
                                                            <?php echo $arreglorepalmtu['prm_int'] ?></option>     
                                                        <?php
                                                    }
                                                }
                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="plazo" name="plazo"  placeholder="0" value="<?php if (isset($_REQUEST['plazo'])) { echo $_REQUEST['plazo']; }?>" style="text-align:right">
                                        </td>                                
                                    </tr>
                                    
                                </tbody>
                                </table>
                                <br/>
                                <br/>
                                <input type="submit" name="cal_credito" value="CALCULAR"/>
                                &nbsp;&nbsp;
                                <button type="button"><a href="inicio.php?variable=amortizacion">LIMPIAR</a></button>
                                <br/><br/>

                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr rol="row">                                
                                            <td width="80">CUOTA</td>
                                            <td width="80">FECHA DE PAGO</td>
                                            <td width="80">VALOR CUOTA</td>
                                            <td width="80">INTERES</td>
                                            <td width="80">MONTO</td>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        <?php
                                            if(isset($_POST['cal_credito'])){
                                               $conn = new mysqli('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh'); 
                                               $consulta = "SELECT * FROM prv_cre";
                                               $rescons = $conn->query($consulta);
                                        ?>       
                                                <tr rol="row">                                               
                                        <?php       
                                            while ($cuota = mysqli_fetch_array($rescons, MYSQLI_BOTH)) {
                                        ?>           
                                                   <td align='center'> <?php echo $cuota[0] ?> </td>
                                                   <td align='center'> <?php echo $cuota[1] ?> </td>
                                                   <td align='center'> <?php echo number_format(($cuota[2]), 2) ?> </td>
                                                   <td align='center'> <?php echo number_format(($cuota[3]), 2) ?> </td>
                                                   <td align='center'> <?php echo number_format(($cuota[4]), 2) ?> </td>
                                                <tr>
                                        <?php
                                               }
                                        ?>
                                    </tbody>
                                        <?php
                                               mysqli_close($conn);
                                            }
                                        ?>

                                </table>
                        </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!-- jQuery Version 1.11.0 -->
        <script src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
        <!--<script src="js/js.js"></script>-->

        <!-- Modal1-->        
    </body>
</html>
