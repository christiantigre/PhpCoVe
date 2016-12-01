<?php

class Trandetalle{
    public $idtran_det_cab;
    public $tran_det_entrada;
    public $tran_det_cre;
    public $tran_det_cre_plazo;
    public $tran_det_adicional;
    public $tran_det_ad_num;
    public $tran_det_trq_valor;
    public $tran_det_trq_des;
    public $tran_cab_idtran_cab;

    function conec_base(){
        $this->objconec = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');    
        return $this->objconec;        
    }
    function numero_det(){
        $conn = $this->conec_base();
        $query = "SELECT * FROM tran_det order by idtran_det_cab DESC";
        $resnum = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($resnum);
        $numero_td = $row['idtran_det_cab'];
        return $numero_td++;        
    }
    function limpia_detalles(){
        $conn = $this->conec_base();
        $query = "DELETE FROM tran_det_temp";
        mysqli_query($conn, $query);
    }
    function delete_pay($carpeta,$monto){
        $conn = $this->conec_base();
        if ($conn == true) {
            $query = "DELETE FROM tran_det_temp where idtran_det_cab='".$carpeta."' and tran_det_monto='".$monto."'";
            $query2 = "DELETE FROM gen_ass_temp where carpeta='".$carpeta."' and mnt='".$monto."'";
            $borrar = "DELETE FROM prv_cre";            
            mysqli_query($conn, $query2);
            mysqli_query($conn, $borrar);
            return mysqli_query($conn, $query);
            mysqli_close($conn);    
        }
    }
    function credit_temporal_where($carpeta,$monto,$id){
        $conn = $this->conec_base();
        $borrar = "DELETE FROM prv_cre";
        $conn->query($borrar);
        $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'CREDITO' and idtran_det_cab='".$carpeta."' and tran_det_monto='".$monto."' and id_ref='".$id."'";
        $result = mysqli_query($conn, $query);
        $cant = mysqli_num_rows($result);
        if (($cant) > 0) {
            $data = mysqli_fetch_array($result, MYSQLI_BOTH);
            $fechacre = $data['tran_det_fecha'];
            $montocre = $data['tran_det_monto'];
            $interes = ($data['tran_det_interes']) / 100;
            $plazocre = $data['tran_det_plazo'];
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
            ?>
            <h3>CREDITO GENERADO</h3>
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
//$conn = new mysqli('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh'); 
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
                        ?>

                    </table>
                    <?php
                }
            }
            function credit_temporal(){
                $conn = $this->conec_base();
                $borrar = "DELETE FROM prv_cre";
                $conn->query($borrar);
                $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'CREDITO'";
                $result = mysqli_query($conn, $query);
                $cant = mysqli_num_rows($result);
                if (($cant) > 0) {
                    $data = mysqli_fetch_array($result, MYSQLI_BOTH);
                    $fechacre = $data['tran_det_fecha'];
                    $montocre = $data['tran_det_monto'];
                    $interes = ($data['tran_det_interes']) / 100;
                    $plazocre = $data['tran_det_plazo'];
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
                    ?>
                    <h3>CREDITO GENERADO</h3>
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
//$conn = new mysqli('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh'); 
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
                                ?>

                            </table>
                            <?php
                        }
                    }
                    function adicional_temporal(){
                        $conn = $this->conec_base();
                        $query = "SELECT * FROM tran_det_temp where tran_det_pago = 'ADICIONAL'";
                        $result = mysqli_query($conn, $query);
                        $cant = mysqli_num_rows($result);
                        if (($cant) > 0) {
                            $data = mysqli_fetch_array($result, MYSQLI_BOTH);
                            ?>
                            <h3>ADICIONALES GENERADAS</h3>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr rol="row">                                
                                        <td width="80">PAGO</td>
                                        <td width="80">FORMA</td>
                                        <td width="80">MONTO</td>
                                        <td width="80">FECHA DE PAGO</td>
                                        <td width="80">PLAZO</td>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                    <?php
//$conn = new mysqli('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh'); 
                                    $consulta = "SELECT * FROM tran_det_temp where tran_det_pago = 'ADICIONAL'";
                                    $rescons = $conn->query($consulta);
                                    ?>       
                                    <tr rol="row">                                               
                                        <?php       
                                        while ($cuota = mysqli_fetch_array($rescons, MYSQLI_BOTH)) {
                                            ?>           
                                            <td align='center'> <?php echo $cuota[1] ?> </td>
                                            <td align='center'> <?php echo $cuota[2] ?> </td>
                                            <td align='center'> <?php echo number_format(($cuota[4]*$cuota[6]), 2) ?> </td>
                                            <td align='center'> <?php echo $cuota[5] ?> </td>
                                            <td align='center'> <?php echo $cuota[7] ?> </td>
                                            <tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                        <?php
                                        mysqli_close($conn);
                                        ?>

                                    </table>
                                    <?PHP
                                }
                            }
                            function inserta_detalle($idtran_cab, $pago, $forma, $dcto, $valor, $fecha_det, $interes, $plazo, $lststd, $observacion){
                                $conn = $this->conec_base();
                                if($lststd=='PENDIENTE'){
                                    $estado = 0;
                                }else{
                                    $estado = 1;
                                }
                                $query = "INSERT INTO tran_det_temp(idtran_det_cab, tran_det_pago, tran_det_forma, tran_det_dcto, tran_det_monto, tran_det_fecha, tran_det_interes, tran_det_plazo, tran_det_estado, tran_det_obs)"
                                . "VALUES ('$idtran_cab', '$pago', '$forma', '$dcto', '$valor', '$fecha_det', '$interes', '$plazo', '$estado', '$observacion')";
                                mysqli_query($conn, $query);
                            }
                            function detalle_transac($numtra){
                                $conn = $this->conec_base();
                                $query = "SELECT * FROM tran_det where idtran_det_cab = '$numtra'";
                                $restrs = mysqli_query($conn, $query);
//    echo "<table border=1><tr align=center style='color:red'><td>CARPETA</td><td>PAGO</td><td>FORMA</td><td>DOCUMENTO</td><td>VALOR</td><td>INTERES</td><td>PLAZO</td><td>ESTADO</td><td>OBSERVACION</td>";
                                while($datotrans = mysqli_fetch_array($restrs, MYSQLI_BOTH)){
                                    echo "<tr>";
                                    echo "<td>".$datotrans['idtran_det_cab']. "</td>";
                                    echo "<td>".$datotrans['tran_det_pago']. "</td>";
                                    echo "<td>".$datotrans['tran_det_forma']. "</td>";
                                    echo "<td>".$datotrans['tran_det_dcto']. "</td>";
                                    echo "<td>".$datotrans['tran_det_monto']. "</td>";
                                    echo "<td>".$datotrans['tran_det_interes']. "</td>";
                                    echo "<td>".$datotrans['tran_det_plazo']. "</td>";
                                    if($datotrans['tran_det_estado']==0){
                                        $estado = 'PENDIENTE';
                                    }else{
                                        $estado = 'PAGADO';
                                    }
                                    echo "<td>".$estado. "</td>";
                                    echo "<td>".$datotrans['tran_det_obs']. "</td>";
                                    echo "</tr>";               
                                }
//    echo "</table>";
                                mysqli_close($conn);
                            }

                            function listar_detalle(){
                                $conn = $this->conec_base();
                                $query = "SELECT * FROM tran_det_temp";
                                $restrs = mysqli_query($conn, $query);
                                echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example' border=2><th><center><button type='submit' name='refresh' id='refresh' value='ACTUALIZAR TABLA' title='ACTUALIZAR TABLA' class='btn btn-outline btn-sm btn-info glyphicon glyphicon-refresh'></button></center></th><tr align=center style='color:red'><td width=80>Pago</td><td width=100>Forma</td><td width=120>Documento</td><td width=60>Valor</td><td width=100>Fecha</td><td width=50>Interes</td><td width=50>Plazo</td><td width=60>Estado</td><td width=150>Observaci&oacute;n</td width='20'><td></td><td></td>";
                                while($datotrans = mysqli_fetch_array($restrs, MYSQLI_BOTH)){
                                    $carpeta=$datotrans['idtran_det_cab'];
                                    $monto=$datotrans['tran_det_monto'];
                                    $id=$datotrans['id_ref'];
                                    echo "<tr>";
                                    echo "<td>".$datotrans['tran_det_pago']. "</td>";
                                    echo "<td>".$datotrans['tran_det_forma']. "</td>";
                                    echo "<td>".$datotrans['tran_det_dcto']. "</td>";
                                    echo "<td>".$datotrans['tran_det_monto']. "</td>";
                                    echo "<td>".$datotrans['tran_det_fecha']. "</td>";
                                    echo "<td>".$datotrans['tran_det_interes']. "</td>";
                                    echo "<td>".$datotrans['tran_det_plazo']. "</td>";
                                    if($datotrans['tran_det_estado']==0){
                                        $estado = 'PENDIENTE';
                                    }else{
                                        $estado = 'PAGADO';
                                    }            
                                    echo "<td>".$estado. "</td>";
                                    echo "<td>".$datotrans['tran_det_obs']. "</td>";
                                    ?>
                                    <td width=20>
                                        <button type='button' title='ELIMNAR PAGO' class='btn btn-outline btn-sm btn-info glyphicon glyphicon-trash' 
                                        onclick='confirma_delet(<?Php echo $carpeta; ?>,<?Php echo $monto; ?>);revome(this);'></button>
                                    </td>
                                    <td width=20>                        
                                        <button type='button' title='VER <?php echo $datotrans['tran_det_pago']; ?>' class='btn btn-outline btn-sm btn-info glyphicon glyphicon-eye-open' 
                                            data-toggle="modal" onclick="detall(<?Php echo $carpeta; ?>,<?Php echo $monto; ?>,<?Php echo $id; ?>);" data-target="#<?php echo $datotrans['tran_det_pago']; ?>" ></button>
                                        </td>
<!--<center>
<button type="button" data-toggle="modal" title="Registrar Vehículo" data-target="#myModal" class="btn btn-outline btn-sm btn-info glyphicon glyphicon-plus-sign" onclick=""/>
</center>-->
<?Php
echo "</tr>";               
}
echo "</table>";
mysqli_close($conn);
}
function imprimir_det($numero){
    global $detalle;
    $conn = $this->conec_base();
    $query = "SELECT * FROM tran_det WHERE idtran_det_cab = '$numero'";
    $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $detalle = $resveh;
}
function suma_gastos($numero){
    global $detalle;
    $conn = $this->conec_base();
    $query = "SELECT sum(tran_cre_interes) as gastos FROM tran_cre WHERE idtran_det_cab = '$numero'";
    $resveh = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $gastos = $resveh['gastos'];
}
}
