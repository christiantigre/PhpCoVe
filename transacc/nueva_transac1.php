<?php
//error_reporting(0);
//error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include_once 'class/calendario.php';
include_once 'class/contabilidad.php';
$objcontbl = new contabilidad();
$objcal = new Calendario();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Control Parqueadero - </title>
        <!--<link rel="stylesheet" type="text/css" href="style/style.css" />--> 
        <!--        <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css" /> 
                <script src="js/jquery-1.11.3.js"></script>
                <link href="style/font-awesome.min.css" rel="stylesheet" type="text/css">-->

        <!-- Bootstrap Core CSS -->
<!--        <link href="style/bootstrap.min.css" rel="stylesheet">

         MetisMenu CSS 
        <link href="style/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

         Timeline CSS 
        <link href="style/plugins/timeline.css" rel="stylesheet">

         Custom CSS 
        <link href="style/sb-admin-2.css" rel="stylesheet">

         Morris Charts CSS 
        <link href="style/plugins/morris.css" rel="stylesheet">

         Custom Fonts 
        <link href="style/font-awesome.min.css" rel="stylesheet" type="text/css">

        <script src="js/jquery-1.11.3.js"></script>
        -->
<!--        <script type="text/javascript">
            function valida_placa(){
                var placa;
                placa = document.getElementById("tran_veh_placas").value;
                if((placa)==''){
                    alert('Debe ingresar un valor')
                }                 
            }
        </script>
        <script type="text/javascript">
            function valida_cedula(){
                var cedula;
                cedula = document.getElementById("tran_cli_ident").value;
                if((cedula)==''){
                    alert('Debe ingresar un valor')
                }
            }            
        </script>-->
</head>
    <body>
    <div class="row">  
        <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                NUEVA TRANSACCION
            </div>        
            <div class="panel-body" style="font-size: 9px">            
                <center>
                <?php
                include_once 'class/transacc.php';
                $objtrs = new Transacc();
                $numero = $objtrs->numerar_trans();
                $numero = $numero + 1;
                ?>
                <form action="inicio.php" id="form" name="form" method="POST">
                    <label>Carpeta #:</label>&nbsp;
                    <input type="text" name="idtran_cab" value="<?php echo $numero ?>">
                    &nbsp;            &nbsp;            &nbsp;            &nbsp;            &nbsp;            &nbsp;

<!--<input type="text" name="idtran_det_cab" value="<?php echo $numero ?>" hidden="">-->
                    <label>Tipo de Transacci&oacute;n:</label>&nbsp;
                    <?php
                    if (!isset($_REQUEST['tipo'])) {
                        ?>      &nbsp;<input type="radio" name="tipo" value="INGRESO" onselect="vaciar()" onclick="vaciar()" checked="checked">INGRESO &nbsp;
                        &nbsp;<input type="radio" name="tipo" value="EGRESO" onselect="cargaval()" onclick="cargaval();
                                mostrar()">EGRESO &nbsp;      
                                     <?php
                                 } else {
                                     if ($_REQUEST['tipo'] == 'INGRESO') {
                                         ?>              &nbsp;<input type="radio" name="tipo" value="INGRESO" checked="">INGRESO &nbsp;
                            &nbsp;<input type="radio" name="tipo" value="EGRESO" >EGRESO &nbsp;
                        <?php } else {
                            ?>              &nbsp;<input type="radio" name="tipo" value="INGRESO" >INGRESO &nbsp;
                            &nbsp;<input type="radio" name="tipo" value="EGRESO" checked="">EGRESO &nbsp;
                            <?php
                        }
                    }
                    ?>    
                    <br><br>
                    <fieldset>
                        <label>Ingrese la placa:</label>&nbsp;<input type="text" list="tran_veh_placas" id="tran_veh_placas" name="tran_veh_placas" value="<?php
                        if (isset($_REQUEST['tran_veh_placas'])) {
                            echo $_REQUEST['tran_veh_placas'];
                        }
                        ?>" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();" autofocus="" onblur="valida_placa()" autocomplete="off" >
            <!--            <select id="lstlugar" name="tran_veh_placas" value=" -->
                        <?php
    //                                    if (isset($_REQUEST['tran_veh_placas'])) {
    //                                        echo $_REQUEST['tran_veh_placas'];
    //                                    }
                        ?> 
            <!--            " style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();" autofocus=""> -->

                        <?php
    //                                    if (isset($_POST['buscar_cli_com']) or isset($_POST['buscar_veh_trs'])) {
    //                                        include_once 'class/vehiculo.php';
    //                                        $objlugar = new Vehiculo();
    //                                        $objlugar->conec_base();
    //                                        $objlugar->mostrar_vehiculo($_POST['tran_veh_placa']);
    //                                    }
                        ?>

            <!--            </select>-->
                        &nbsp;&nbsp;
                        <input type="submit" name="buscar_veh_trs" value="BUSCAR VEHICULO">
                        <br><br>
                        <?php
                        if (isset($_POST['buscar_veh_trs']) or isset($_POST['buscar_cli_com'])) {
                            include_once 'class/vehiculo.php';
                            $objveh = new Vehiculo();
                            $objveh->conec_base();
                            $objveh->buscar_veh_trs($_POST['tran_veh_placas'], $_POST['tipo']);
                            $objcontbl->vercuenta($_POST['tran_veh_placas']);
                            $objveh->trae_valor($_POST['tran_veh_placas'], $_POST['tipo']);
                        }
                        ?>
                        <br>
                    </fieldset>
                    <fieldset>
                        <label>Ingresar c&eacute;dula:&nbsp;</label><input type="text" id="tran_cli_ident" name="tran_cli_ident" value="<?php
                        if (isset($_REQUEST['tran_cli_ident'])) {
                            echo $_REQUEST['tran_cli_ident'];
                        }
                        ?>" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();" onblur="valida_cedula()" autocomplete="off" >
                        &nbsp;&nbsp;
                        <input type="submit" name="buscar_cli_com" id="buscar_cli_com" value="BUSCAR CLIENTE">            
                        <!--disabled="true"--> 
                        <br><br>
                        <?php
                        if (isset($_POST['buscar_cli_com']) or isset($_POST['buscar_veh_trs'])) {
                            include_once 'class/cliente.php';
                            $objcli = new Cliente();
                            $objcli->conec_base();
                            $objcli->buscar_cliente_com($_POST['tran_cli_ident']);
                            $objcontbl->vercuentacli($_POST['tran_cli_ident']);
                        }
                        ?>
                    </fieldset> 
                    <fieldset>
                        <p style="text-align: left;font-size:13px; ">
                            <label>Creaci&oacute;n carpeta:</label>&nbsp;
                            <?php
                            $objcal->fecha_actual();
                            $hoy = date('Y-m-d');
                            ?>
                            <input type="hidden" name="fecha" value="<?php echo $hoy ?>"/>
                            <br><br>



                        </p>
                        <p style="text-align: left; font-size:13px; ">
        <!--<input type="button" name="btn_reg_veh" id="btn_reg_veh" onclick="reg_veh()" value="Vehículo">-->   
                            <input type="button" name="btn_val" id="btn_val" onclick="cargaval()" value="PRECIO">   
                        <hr>
                            <!--<input type="button" name="cal_val" id="cal_val" onclick="calculo_ganancia()" value="PRUEBA">-->   
                        <input type="hidden" name="prec_compra" id="prec_compra" placeholder="Valor de compra" value="<?php
                        if (isset($_REQUEST['prec_compra'])) {
                            echo $_REQUEST['prec_compra'];
                        }
                        ?>">
                        <label>Valor veh&iacute;culo:</label>&nbsp; 
                        <input type="text" name="tran_cab_precio" id="tran_cab_precio"
                               placeholder="0.00" value="<?php
                               if (isset($_REQUEST['tran_cab_precio'])) {
                                   echo $_REQUEST['tran_cab_precio'];
                               }
                               ?>" onchange="totaliza();
                                       calculo_ganancia()" min="0">
                        <label>Seguro:</label>&nbsp; <input type="text" name="tran_cab_seguro" readonly=""  placeholder="0.00" value="<?php
                        echo 0;
                        if (isset($_REQUEST['tran_cab_seguro'])) {
                            echo $_REQUEST['tran_cab_seguro'];
                        }
                        ?>" onchange="totaliza()">                    
                        <label>Gastos:</label>&nbsp; <input type="text" name="tran_cab_gastos" readonly="" placeholder="0.00" value="<?php
                        echo 0;
                        if (isset($_REQUEST['tran_cab_gastos'])) {
                            echo $_REQUEST['tran_cab_gastos'];
                        } else {
                            echo '';
                        }
                        ?>" onchange="totaliza()">
                        <label>TOTAL : </label>&nbsp;<input type="text" name="total" id="total" value="<?php
                        if (isset($_REQUEST['total'])) {
                            echo $_REQUEST['total'];
                        } else {
                            echo '';
                        }
                        ?>" id="total" readonly>

                        <label>Ganancia : </label>&nbsp;<input type="text" id="ganancia" name="ganancia" value="<?php
                        if (isset($_REQUEST['ganancia'])) {
                            echo $_REQUEST['ganancia'];
                        }
                        ?>" readonly=""/>


                        <script type = "text/javascript" >
                            function tables() {
                                $(document).ready(function () {
                                    $('#dataTables-example').dataTable();
                                });
                            }

                            function totaliza() {
                                var precio = document.getElementsByName("tran_cab_precio").item(0);
                                var upload = $("#val_veh").val();
                                var seguro = document.getElementsByName("tran_cab_seguro").item(0);
                                var gastos = document.getElementsByName("tran_cab_gastos").item(0);
                                var total = document.getElementsByName("total").item(0);
                                var p, s, g, t, pre;
                                p = parseFloat(precio.value);
                                pre = parseInt(precio.value);
                                var upvar = parseInt(upload);
                                if (pre < upvar) {
                                    respuesta = confirm("Esta seguro de realizar la venta por el precio menor a $" + upload);
                                    if (respuesta) {
                                        $("#tran_cab_precio").val(precio.toFixed(2).toString().replace(',', '.'));
                                    } else {
                                        $("#tran_cab_precio").val("0.00");
                                    }
                                    //                                alert('El valor no puede ser menor a $' + upload);
                                }
                                if (seguro != '') {
                                    s = parseFloat(seguro.value);
                                } else {
                                    seguro = 0;
                                }
                                if (gastos != '') {
                                    g = parseFloat(gastos.value);
                                } else {
                                    gastos = 0;
                                }
                                s = parseFloat(seguro.value);
                                g = parseFloat(gastos.value);
                                t = p + s + g;
                                //                            total.value = t.toString();
                                $("#total").val(t.toFixed(2).toString().replace(',', '.'));
                                //                            calculo_ganancia();
                            }


                        </script>

                        <script>
                            var bPreguntar = true;
                            function confirmareliminar() {
                                var formulario = document.getElementById("formu");
                                var dato = formulario[0];
                                respuesta = confirm('¿Desea eliminar la fila seleccionada?');
                                if (respuesta) {
                                    formulario.submit();
                                    return true;
                                } else {
                                    alert("No se aplicaran los cambios...!!!");
                                    return false;
                                }
                            }
                        </script>

                        <script>
                            var bPreguntar = true;
                            function cvereficarvalores() {

                                if (document.formu.tran_veh_placas.value.length == 0) {
                                    alert("INGRESE PLACA PORFAVOR")
                                    document.formu.tran_veh_placas.focus()
                                    return false;
                                }

                                if (document.formu.tran_cli_ident.value.length == 0) {
                                    alert("INGRESE ID CLIENTE PORFAVOR")
                                    document.formu.tran_cli_ident.focus()
                                    return false;
                                }

                                var tipo = 0;
                                for (i = 0; ele = document.formu.elements[i]; i++) {
                                    if (ele.type == 'radio')
                                        if (ele.checked) {
                                            tipo = 1;
                                            break;
                                        }
                                }
                                if (tipo == 1) {
                                    //                                document.formu.submit();
                                } else {
                                    alert('SELECCIONE EL TIPO TRANSACCIÓN PORFAVOR');
                                    return false;
                                }

                                if (document.formu.tran_cab_precio.value.length == 0) {
                                    alert("INGRESE PRECIO DEL VEHICULO PORFAVOR")
                                    document.formu.tran_cab_precio.focus()
                                    return false;
                                }
                                if (document.formu.tran_cab_seguro.value.length == 0) {
                                    alert("INGRESE SEGURO DEL VEHICULO PORFAVOR")
                                    document.formu.tran_cab_seguro.focus()
                                    return false;
                                }
                                if (document.formu.tran_cab_gastos.value.length == 0) {
                                    alert("INGRESE GASTOS DEL VEHICULO PORFAVOR")
                                    document.formu.tran_cab_gastos.focus()
                                    return false;
                                }


                                var formulario = document.getElementById("formu");
                                var val1 = $("#totalsumadb1").val();
                                var val2 = $("#totalsumadb2").val();
                                var dato = formulario[0];
                                confirmar = confirm("¿ DESEA GUARDAR LA TRANSACCIÓN ?...")
                                if (confirmar) {
                                    if (val1 == val2) {
                                        document.formulario.submit();
                                        return true;
                                    } else {
                                        alert("DEBE AJUSTAR TODO EL VALOR DE LA TRANSACCIÓN...!!!");
                                        return false;
                                    }
                                } else {
                                    alert("SE CANCELO LA TRANSACCIÓN");
                                    return false;
                                }

                            }
                            function calculo_ganancia() {
                                var upload = $("#val_veh").val();
                                var precio = $("#tran_cab_precio").val();
                                var up_int, pre_int, tot;
                                up_int = parseFloat(upload);
                                pre_int = parseFloat(precio);
                                $("#prec_compra").val(upload);
                                if (up_int == pre_int) {
                                    alert("Se va a generar la venta por el mismo valor de su compra, sin ganacias");
                                }
                                if (pre_int > up_int) {
                                    tot = pre_int - up_int;
                                    //                                alert("Ganancia : "+tot);
                                    //                                document.getElementById('ganancia').value = tot;
                                    $("#ganancia").val(tot.toFixed(2).toString().replace(',', '.'));
                                }
                                if (pre_int == up_int) {
                                    tot = pre_int - up_int;
                                    $("#ganancia").val(tot.toFixed(2).toString().replace(',', '.'));
                                }
                            }
                            function vaciar() {
                                $("#tran_cab_precio").val("");
                            }
                            function cargaval() {
                                var placa = $('#tran_veh_placas').attr('value');
                                var tipo = $('#tipo').attr('value');
                                var tipo = 0;
                                for (i = 0; ele = document.formu.elements[i]; i++) {
                                    if (ele.type == 'radio')
                                        if (ele.checked) {
                                            tipo = "INGRESO";
                                            break;
                                        } else {
                                            tipo = "EGRESO";
                                            break;
                                        }
                                }//                            alert(tipo);
                                $.post("./class/script_val.php", {"texto": placa, "tipo": tipo},
                                function (respuestag) {
                                    document.getElementById('tran_cab_precio').value = respuestag;
                                    $("#tran_cab_precio").val(respuestag.toFixed(2).toString().replace(',', '.'));
                                });
                            }
                        </script>

                        <script>
                            function objetoAjax() {
                                var xmlhttp = false;
                                try {
                                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                                } catch (e) {
                                    try {
                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    } catch (E) {
                                        xmlhttp = false;
                                    }
                                }

                                if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
                                    xmlhttp = new XMLHttpRequest();
                                }
                                return xmlhttp;
                            }
                            function mostrar() {
                                var tipo = $('#tipo').attr('value');
                                if (tipo == "EGRESO") {
                                    document.getElementById('oculto').style.display = 'block';
                                    //                                    document.getElementById('').style.display = 'hidden';
                                }
                            }
                            function reset() {
                                document.getElementById("reg_veh_form").reset();
                            }
                            function new_veh() {
                                var idveh_placa = $("#idveh_placa").val();
                                var veh_vehiculo = document.getElementById("veh_vehiculo").value;
                                var veh_anio = document.getElementById("veh_anio").value;
                                var veh_color2 = document.getElementById("veh_color2").value;
                                var veh_mat_lugar = document.getElementById("veh_mat_lugar").value;
                                var veh_estado = document.getElementById("veh_estado").value;
                                var veh_motor = document.getElementById("veh_motor").value;
                                var veh_chasis = document.getElementById("veh_chasis").value;
                                var veh_color1 = document.getElementById("veh_color1").value;
                                var veh_km = document.getElementById("veh_km").value;
                                var veh_mat_anio = document.getElementById("veh_mat_anio").value;
                            }

                            function ver_cta_veh() {
                                var idveh_placa = $("#idveh_placa_add").val();
                                ajax = objetoAjax();
                                ajax.open('POST', './class/script_bs.php?idveh_placa=' + idveh_placa, true);
                                ajax.onreadystatechange = function () {
                                    if (ajax.readyState == 4) {
                                        resultado.innerHTML = ajax.responseText;
                                    }
                                }
                                ajax.send(null);
                            }

                            function carga_cta() {

                                var estado = $("#estado").val();
                                var val_veh = $("#val_veh").val();
                                if (estado == 'VENDIDO') {
                                    alert("No se puede seleccionar este vehículo");
                                } else {
                                    var idveh_placa = $("#nom_cte_veh").val();
                                    document.getElementById('dcto').value = idveh_placa;
                                    document.getElementById('valor').value = val_veh;
                                    alert("Se agrego el vehículo : " + idveh_placa);
                                }
                            }
                        </script>

                        <!--Carga los select-->
                        <script language="javascript">
                            $(document).ready(function () {
                                $("#pago").change(function () {
                                    $("#pago option:selected").each(function () {
                                        elegido = $(this).val();
                                        $.post("class/modelos.php", {elegido: elegido}, function (data) {
                                            $("#forma").html(data);
                                        });
                                    });
                                })
                            });
                        </script>
                        <script>
                            function contts() {
                                var data = $("#dcto").val();
                                var tipo = $('#tipo').attr('value');
                                var tipo = 0;
                                for (i = 0; ele = document.formu.elements[i]; i++) {
                                    if (ele.type == 'radio')
                                        if (ele.checked) {
                                            tipo = "INGRESO";
                                            if (data == 'Gastos Diferidos') {
                                                alert('Opcion invalida');
                                                document.getElementById('dcto').value = '';
                                            }
                                            break;
                                        } else {
                                            tipo = "EGRESO";
                                            if (data == 'Ingresos Diferidos') {
                                                alert('Opcion invalida');
                                                document.getElementById('dcto').value = '';
                                            }
                                            break;
                                        }
                                }
                            }
                        </script>

                        </p>
                    </fieldset>

                        PAGOS

                    <fieldset> 
                        <br>
                        <table border="1" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr align="center">
                                    <td width="80">Pago</td>
                                    <td width="100">Forma</td>
                                    <td width="130">Mantenimiento</td>
                                    <td width="120"># Placa-Dcto-Chq-Letr</td>
                                    <td width="60">Valor</td>
                                    <td width="100">Fecha</td>
                                    <td width="60">Interes</td>
                                    <td width="50">Plazo dias</td>
                                    <td width="60">Estado</td>
                                    <td width="150">Observaci&oacute;n</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center">
                                        <!--<input list="lstpago" id="pago" name="pago" placeholder="seleccione" style="width: 80px">
                                        <datalist id="lstpago">
                                            <option value="ENTRADA">ENTRADA</option>
                                            <option value="ADICIONAL">ADICIONAL</option>
                                            <option value="CREDITO">CREDITO</option>
                                        </datalist>-->
                                        <select name="pago" id="pago" style="width: 75px">    
                                            <option value="0">Selecci&oacute;ne </option>
                                            <option value="ENTRADA">ENTRADA</option>
                                            <option value="ADICIONAL">ADICIONAL</option>
                                            <option value="CREDITO">CREDITO</option>   
                                        </select></p>
                                    </td>
                                    <td class="center">
                                        <!--<input list="lstforma" id="forma" name="forma" placeholder="seleccione" style="width: 100px">
                                        <datalist id="lstforma">
                                            <option value="EFECTIVO">EFECTIVO</option>
                                            <option value="CHEQUE">CHEQUE</option>
                                            <option value="LETRA DE CAMBIO">LETRA DE CAMBIO</option>
                                            <option value="VEHICULO">VEHICULO</option>
                                        </datalist>-->
                                        <select name="forma" id="forma" style="width: 110px">    
                                            <option value="EFECTIVO">Selecci&oacute;ne</option>
                                            <option value="EFECTIVO">EFECTIVO</option>
                                            <option value="CHEQUE">CHEQUE</option>
                                            <option value="LETRA DE CAMBIO">LETRA DE CAMBIO</option>
                                            <option value="VEHICULO">VEHICULO</option>                                                            
                                        </select>
                                    </td>
                                    <td class="center" > <!--width="130"-->
                            <center>
                                <button type="button" data-toggle="modal" title="Registrar Vehículo" data-target="#myModal" class="btn btn-outline btn-sm btn-info glyphicon glyphicon-plus-sign" onclick=""/></button>
                            </center>
                            <!--<button type="button" data-toggle="modal" title="Seleccionar Vehículo" data-target="#myModal2" class="btn btn-outline btn-sm btn-info glyphicon glyphicon-search" onclick=""/>-->
                            </td>
                            <td class="center">
                                <input type="text" id="dcto" name="dcto" onchange="contts();" style="width: 120px" list="cta" autocomplete="off"/>
                                <datalist id="cta">
                                    <optgroup label="bancos">
                                        <?php
                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                        $query = "select * from t_plan_de_cuentas where t_subcuenta_cod_subcuenta='1.1.1.2.' and nombre_cuenta_plan !='BANCOS' ";
                                        $resul1 = mysqli_query($c, $query);
                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                            $cod1 = $dato1['cod_cuenta'];
                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
                                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                            echo '</option>';
                                        }
                                        mysqli_close($c);
                                        ?>
                                    </optgroup>
                                    <optgroup label="ingresos">
                                        <?php
                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                        $query = "select * from t_plan_de_cuentas where cod_cuenta='2.2.1.3.1.'";
                                        $resul1 = mysqli_query($c, $query);
                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                            $cod1 = $dato1['cod_cuenta'];
                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
                                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                            echo '</option>';
                                        }
                                        mysqli_close($c);
                                        ?>
                                    </optgroup>
                                    <optgroup label="gastos">
                                        <?php
                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                        $query = "select * from t_plan_de_cuentas where cod_cuenta='1.2.3.1.'";
                                        $resul1 = mysqli_query($c, $query);
                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                            $cod1 = $dato1['cod_cuenta'];
                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
                                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                            echo '</option>';
                                        }
                                        mysqli_close($c);
                                        ?>
                                    </optgroup>
                                </datalist>




                                <datalist id="cuentas">
                                    <?php
                                    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                    $query = "select * from t_plan_de_cuentas";
                                    $resul1 = mysqli_query($c, $query);
                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                        $cod1 = $dato1['cod_cuenta'];
                                        echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; //_'.$dato1['cod_cuenta']
                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                        echo '</option>';
                                    }
                                    mysqli_close($c);
                                    ?>
                                </datalist>
                                <!--<input type="text" id="dcto" name="dcto" style="width: 120px" list="cuentas" autocomplete="off">-->
                            </td>
                            <td class="center">
                                <input type="text" id="valor" name="valor" placeholder="0.00" style="width: 60px">
                            </td>
                            <td class="center" >
                                <input type="date" id="fecha_det" name="fecha_det" style="height: 20px; width: 120px">
                            </td>
                            <td class="center">
                                <!--<input type="text" id="interes" name="interes" style="width: 50px" placeholder="0.00">-->
                                <select name="interes" id="interes" size="0" style="alignment-adjust: central; width: 50px;" >
                                    <?php
                                    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                                    $consulint = "select prm_int from soft_prm";
                                    $queryclases = mysqli_query($c, $consulint);
                                    while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                        if ($_POST['prm_int'] == $arreglorepalmtu['prm_int']) {
                                            echo "<option value='" . $arreglorepalmtu['prm_int'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['prm_int'] . "</option>";
                                        } else {
                                            ?>
                                            <option class="form-control" value="<?php echo $arreglorepalmtu['prm_int'] ?>">
                                                <?php echo $arreglorepalmtu['prm_int'] ?></option>     
                                            <?php
                                        }
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </td>
                            <td class="center">
                                <input type="text" id="plazo" name="plazo" style="width: 50px" placeholder="0">
                            </td>
                            <td class="center">
                                <select id="lststd" id="lststd" name="lststd" width="60">
                                    <option value="0">Selecci&oacute;ne</option>
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="PAGADO">PAGADO</option>
                                </select>
                            </td>
                            <td class="center">
                                <input type="text" id="observacion" name="observacion" style="width: 150px" />
                            </td>
                            </tr>
                            </tbody>
                        </table>

                        <br>
                        <input type="submit" name="agregar_en" value="Agregar a Pagos"/>
                        <br><br>
                        <div id="lstveh">
                            <?php
                            include_once 'class/trandetalle.php';
                            $conn = new Trandetalle();
                            $conn->conec_base();
                            $conn->listar_detalle();
                            $a = $_POST['tran_cab_precio'];
                            $b = $_POST['tran_cab_seguro'];
                            $c = $_POST['tran_cab_gastos'];
                            $t = $a + $b + $c;
                            ?>      
                            <p style="font-size:9px; text-align: center">
                                <br>
                                <label>Venta por :&nbsp;</label><input type="text" name="totalsumadb1" id="totalsumadb1" value="<?Php echo doubleval($t); ?>" disabled=""/>
                                <?Php
                                $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                                $sqlsuma = "SELECT ROUND(SUM(`mnt`), 2) as suma FROM gen_ass_temp;";
                                $ej = mysqli_query($con, $sqlsuma) or trigger_error("Query Failed! SQL: $sqlsuma - Error: " . mysqli_error($con), E_USER_ERROR);
                                while ($row = mysqli_fetch_array($ej)) {
                                    $row['suma'];
                                    $vl = $row['suma'];
                                    $ajustar = $t - $row['suma'];
                                    ?>    
                                    <label>Justificados :&nbsp;</label><input type="text" name="totalsumadb2" id="totalsumadb2" value="<?Php echo doubleval($vl); ?>" disabled=""/>
                                    <label>Faltan  :&nbsp;</label><input type="text" name="poraj" value="<?Php echo doubleval($ajustar); ?>" disabled=""/>
                                    <?Php
                                }
                                $con->close();
                                ?>
                            </p>
                        </div>  
                    </fieldset>
                    <br><br>
                    <input type="submit" name="insertar_transac" onclick="return cvereficarvalores(this)" value="GRABA TRANSACCION">
                    &nbsp;&nbsp;
                    <input type="submit" name="resettemp" value="CANCELAR">
                    &nbsp;&nbsp;
                    <input type="submit" name="transac" value="SALIR">
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
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">REG. VEH&Iacute;CULO</h4>
                    </div>
                    <div class="modal-body" id="caja">
                        <fieldset>
                            <h3></h3>
                            <div class="row">
                                <div class="col-lg-7">
                                    <form method="POST" name="reg_veh_form" id="reg_veh_form">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Placa:</label>
                                                        <input type="text" class="form-control" name="idveh_placa" id="idveh_placa" autocomplete="on" style="text-transform:uppercase; width: 60px;" onkeyup="this.value = this.value.toUpperCase();" autofocus="">
                                                        <label>Vehiculo:</label>&nbsp;
                                                        <select id="veh_vehiculo" name="veh_vehiculo" id="veh_vehiculo" style="width: 250px" class="form-control" required="required">
                                                            <?php
                                                            include_once 'class/modelo.php';
                                                            $objltmodelo = new Modelo();
                                                            $objltmodelo->conec_base();
                                                            $objltmodelo->mostrar_modelo_marca();
                                                            ?>                    
                                                        </select>
                                                        <label>A&ntilde;o:</label>&nbsp; 
                                                        <input type="text" name="veh_anio" id="veh_anio" class="form-control" required="required" style="width: 50px">
                                                        <label>Color2:</label>&nbsp;
                                                        <input type="text" class="form-control" name="veh_color2" id="veh_color2" required="required" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();">
                                                        <label>Matriculado en:</label>&nbsp; 
                                                        <select class="form-control" name="veh_mat_lugar" id="veh_mat_lugar" style="width: 250px">
                                                            <?php
                                                            include_once 'class/lugar.php';
                                                            $objltlugar = new Lugar();
                                                            $objltlugar->conec_base();
                                                            $objltlugar->mostrar_lugar();
                                                            ?>                    
                                                        </select>
                                                        <label>Estado:</label>&nbsp;
                                                        <select name="veh_estado" id="veh_estado" class="form-control" style="width: 250px">
                                                            <option> </option>
                                                            <option value="0">CONSIGNACION</option>
                                                            <option value="1">COMISION</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        &nbsp;&nbsp;
                                                        <label># Motor:</label>&nbsp;
                                                        <input type="text" name="veh_motor" required="required" id="veh_motor" class="form-control">
                                                        &nbsp;&nbsp;   
                                                        <label># Chasis:</label>&nbsp;
                                                        <input type="text" name="veh_chasis" required="required" id="veh_chasis" class="form-control">
                                                        &nbsp;&nbsp;
                                                        <label>Color1:</label>&nbsp;
                                                        <input type="text" class="form-control" required="required" name="veh_color1" id="veh_color1" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();">
                                                        &nbsp;&nbsp;
                                                        <label>Kilometraje:</label>&nbsp;
                                                        <input type="text" class="form-control" required="required" name="veh_km" id="veh_km" style="width: 115px"> 
                                                        <label>Por el a&ntilde;o:</label>&nbsp;
                                                        <input type="text" name="veh_mat_anio" required="required" id="veh_mat_anio" class="form-control" style="width: 50px">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                </div>


                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <br><br>
                                        <!--onclick="new_veh()"-->
                                        <input type="submit" class="btn btn-success" name="inserta_veh_reg" id="inserta_veh_reg"  value="GUARDAR">&nbsp;
                                        <input type="reset" class="btn btn-primary" onclick="reset()" value="CANCELAR">
                                    </div>
                                </div>

                                </form>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal2 -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">AGREGAR VEH&Iacute;CULO</h4>
                    </div>
                    <div class="modal-body" id="caja">
                        <fieldset>
                            <h3></h3>

                            <div class="row">
                                <form role="form" method="POST" name="add_veh_form" id="add_veh_form">


                                    <div class="col-lg-7">

                                        <table class="table">
                                            <tr>
                                            <label>Ingrese la Placa:</label>
                                            <div class="form-group input-group">


                                                <input type="text" name="idveh_placa_add" id="idveh_placa_add" autocomplete="on" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();" autofocus="" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" name="btn_search" id="btn_search" onclick="ver_cta_veh();" type="button"><i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="resultado" class="form-group">
                                                    </div>
                                                </td>

                                            </tr>
                                        </table>
                                    </div>


                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <br><br>
                                            <!--onclick="new_veh()"-->
                                            <input type="button" onclick="carga_cta();" class="btn btn-primary" name="add_veh_trs" id="add_veh_trs"  value="SELECIONAR">&nbsp;
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
