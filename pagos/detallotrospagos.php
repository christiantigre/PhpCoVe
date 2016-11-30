
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
            <fieldset>
                <?Php
                if (isset($fech_reg) && isset($tipde_pag) && isset($monto_pag) && isset($pag_por) && isset($observ) && isset($cli) && isset($veh) && isset($valiva) && isset($subtotal) && isset($porcentaje)) {
                    include_once 'class/otrospagos.php';
                    $objotpag = new Otrospag();
                    $conn = $objotpag->conec_base();
                    $sqlmaxid = "SELECT MAX(`iddet_pag`) as id FROM `det_pag`";
                    $result = mysqli_query($conn, $sqlmaxid) or trigger_error("Query Failed! SQL: $sqlmaxid - Error: " . mysqli_error($conn), E_USER_ERROR);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $ultimoingreso = $row['id'];
                        }
                    }
                    ?>
                    <br></br>
                    <p style="font-size:12px; text-align: left">
                        <input type="hidden" name="idhei" id="idhei" value="<?php echo $ultimoingreso; ?>"/>
                        <label>Fecha registrado :</label>&nbsp;
                        <input type="text" name="datepag" id="datepag" value="<?Php print_r($fech_reg); ?>" disabled=""/> &nbsp; &nbsp;
                        <label>Por concepto de :</label>&nbsp; 
                        <input list="cuenta" name="cuentatxt" style="width:180px;" id="cuentatxt" value="<?php echo $tipde_pag; ?>" disabled=""/> &nbsp;&nbsp;
                        <br></br>
                        <label>Monto :</label>&nbsp; 
                        <input type="text" name="monto_pag" id="monto_pag" value="<?php echo $monto_pag ?>" disabled=""/>                        
                        <label>Subtotal :</label>&nbsp; 
                        <input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal ?>" disabled=""/>
                        <label>Iva <?Php echo $porcentaje ?> % :</label>&nbsp; 
                        <input type="text" name="valiva" id="valiva" value="<?php echo $valiva ?>" disabled=""/>
                        <br></br>
                        <label>Pago realizado por :</label>&nbsp;
                        <input type="text" style="width:200px;" id="pag_por" name="pag_por" value="<?Php echo $pag_por ?>" disabled=""/>
                        <br></br>
                        <label>Pagado a :</label>&nbsp;
                        <input type="text" style="width:200px;" id="pag_a" name="pag_a" value="<?Php echo $cli ?>" disabled=""/>
                        <label>Veh&iacute;culo :</label>&nbsp;
                        <input type="text" style="width:200px;" id="pag_veh" name="pag_veh" value="<?Php echo $veh ?>" disabled=""/>
                        <br></br>
                        <label>Observaci&oacute;n :</label> &nbsp; 
                        <textarea id="observ" name="observ" maxlength="255" rows="5" cols="90" disabled=""><?Php echo trim($observ); ?></textarea>
                    </p>
                    <br></br>
                    <?php
                } elseif (isset($verpagootros)) {
//                    echo '<script>alert("'.$verpagootros.'")</script>';
                    include_once 'class/otrospagos.php';
                    $objotpag = new Otrospag();
                    $objotpag->conec_base();
                    $objotpag->verpagoswhere($verpagootros);
                } else {
                    echo '';
                    include_once 'class/otrospagos.php';
                    $objotpag = new Otrospag();
                    $objotpag->conec_base();
                    $objotpag->detallot_pag();
                }
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
                        formulario.request();
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
            <br><br>
            <input type="submit" name="impcomprobantepagotros" onclick="return confirmar();" value="IMPRIMIR">
            <input type="submit" name="regresarapag" value="REGRESAR">
        </form>
    </center>
</body>
</html>