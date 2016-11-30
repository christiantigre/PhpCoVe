<!DOCTYPE html>
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
                        GASTOS
                    </div>        
                    <div class="panel-body"  style="font-size: 9px">
                        <div class="table-responsive">
                            <form action="inicio.php" method="POST" id="myform" name="myform">
                                </br>

                                <datalist></datalist>
                                <input type="submit" name="realiz_pag" id="realiz_pag" onclick="return confirmar(this);" value="PAGAR">
                                <input type="submit" name="verpagos" value="VER PAGOS">            
                                <input type="submit" name="bpago" id="bpago" value="BUSCAR"/>
                                <input type="submit" name="regresarapagos" value="REGRESAR">
                                </br>
                                </br>
                                <fieldset>
                                    <?php
                                    include_once 'class/otrospagos.php';
                                    $objotpag = new Otrospag();
                                    $objotpag->conec_base();
                                    if (isset($cuentatxt)) {
                                        $objotpag->otpag($cuentatxt);
                                    } elseif (isset($_POST['verpagos'])) {
                    //                    echo '<script>alert("boton ver pagos")</script>';
                                        ?>
                                        <label>Buscar por fecha :</label> &nbsp;
                                        &nbsp;<input type = "date" name = "bpagot" id = "bpagot" onclick="bpago.disabled = false;" value = "" />
                                        &nbsp;&nbsp;
                                        <label>Por monto :</label> &nbsp;&nbsp;
                                        <input type = "text" name = "bmonto" id = "bmonto" value = "0.00" onclick="bpago.disabled = false;" placeholder = "Ejm... 50.33"/> &nbsp;
                                        &nbsp; &nbsp; &nbsp;
                                        <label>Por placa :</label> &nbsp;&nbsp;
                                        <input type = "text" name = "bplaca" id = "bplaca" value = "" onclick="bpago.disabled = false;" placeholder = "ABC0123"/> &nbsp;
                                        &nbsp; &nbsp; &nbsp; <?Php
                                        $objotpag->verpagos();
                                    } elseif (isset($_POST['bpago'])) {                    //echo '<script>alert("buscar")</script>';
                                        $objotpag->verpagoswherecondition($_POST['bpagot'], $_POST['bmonto'], $_POST['bplaca']);
                                    } else {
                                        $cuentatxt = '';
                                        $objotpag->otpag($cuentatxt);
                                        echo '';
                                    }
                                    ?>  
                                </fieldset> 

                                <br><br>
                                <script>
                                    $(document).ready(function () {
                                        $('#monto_pag').numeric(".");
                                    });
                                    function calcular() {
                                        var monto_pag = $('#monto_pag').val();
                                        var iva = $('#iva').val();
                                        var valiva;
                                        var ivf;
                                        if (monto_pag == '') {
                                            alert("El campo total no puede estar vacio");
                                            document.getElementById("monto_pag").focus();
                                        } else {
                                            if (iva == '0') {
                                                document.getElementById('subtotal').value = monto_pag;
                                                document.getElementById('valiva').value = '0';
                                            }
                                            if (iva == 'SELECCIONE') {
                                                $("#subtotal").val('');
                                                $("#valiva").val('');
                                            } else {
                                                var idiv = document.getElementById("iva").value;
                                                ivf = parseFloat(idiv);
                                                document.getElementById('subtotal').value = "";
                                                var v = ivf + 100;
                                                var priv = v / 100;
                                                var subtt = monto_pag / priv;
                                                var valiva = monto_pag - subtt;
                                                $("#valiva").val(valiva.toFixed(2).toString().replace(',', '.'));
                                                $("#subtotal").val(subtt.toFixed(2).toString().replace(',', '.'));
                                            }
                                        }
                                    }

                                    function vaciar() {
                                        $("#subtotal").val('');
                                        $("#valiva").val('');
                                        $('#iva').get(0).selectedIndex = 0;
                                    }

                                </script>
                                <script>
                                    bpago.disabled = true;
                                    realiz_pag.disabled = true;

                                    var bPreguntar = true;
                                    function confirmar() {
                                        var formulario = document.getElementById("myform");
                                        var dato = formulario[0];
                                        if (document.myform.cuentatxt.value.length == 0) {
                                            alert("SELECCIONE GASTO PORFAVOR")
                                            document.myform.cuentatxt.focus()
                                            return false;
                                        }                    
                                        if (document.myform.dcto.value.length == 0) {
                                            alert("SELECCIONE CUENTA DE PAGO PORFAVOR")
                                            document.myform.dcto.focus()
                                            return false;
                                        }
                                        if (document.myform.monto_pag.value.length == 0) {
                                            alert("INGRESE EL TOTAL")
                                            document.myform.monto_pag.focus()
                                            return false;
                                        }
                                        if (document.myform.subtotal.value.length == 0) {
                                            alert("EL CAMPO SUBTOTAL NO PUEDE ESTAR VACIO")
                                            document.myform.subtotal.focus()
                                            return false;
                                        }
                                        if (document.myform.pag_cli.value.length == 0) {
                                            alert("SELECCIONE UN CLIENTE PORFAVOR")
                                            document.myform.pag_cli.focus()
                                            return false;
                                        }
                                        if (document.myform.pag_veh.value.length == 0) {
                                            alert("SELECCIONE UN VEHICULOPORFAVOR")
                                            document.myform.pag_veh.focus()
                                            return false;
                                        }

                                        respuesta = confirm('¿Desea guardar los cambios y generar\n el nuevo asiento contable?');
                                        if (respuesta) {
                                            formulario.submit();
                                            return true;
                                        } else {
                                            alert("No se aplicaran los cambios...!!!");
                                            return false;
                                        }
                                    }
                                </script>
                            </form>
                        </div>
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

    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
</body>
</html>