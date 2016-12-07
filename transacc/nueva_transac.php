<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include_once 'class/calendario.php';
include_once 'class/contabilidad.php';
date_default_timezone_set("America/Guayaquil");
$fecha = date("Y-m-d");
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
<link href="style/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="style/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Timeline CSS -->
<link href="style/plugins/timeline.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="style/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="style/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="style/font-awesome.min.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.11.3.js"></script>
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

                        <form action="inicio.php" name="formu" id="formu" method="POST" role="form-inline">
<!--                    <div id="page-wrapper">

<div class="row">
    <div class="col-lg-10">-->

        <div class="form-group">
            <div class="col-lg-4">
                <label>Carpeta #:</label>
                <input type="text" name="idtran_cab" value="<?php echo $numero ?>" style="width:100px;">
            </div>
        </div>

        <!--<input type="text" name="idtran_det_cab" value="<?php echo $numero ?>" hidden="">-->
        <div class="form-group">
            <div class="col-lg-4">
                <label>Tipo de Transacci&oacute;n:</label>&nbsp;
                <?php
                if (!isset($_REQUEST['tipo'])) {
                    ?>      
                    <div class="radio">
                        <label>
                            <input type="radio" name="tipo" value="INGRESO" onselect="vaciar()" onclick="vaciar()" checked="checked">INGRESO 
                        </label>

                        <label>
                            <input type="radio" name="tipo" value="EGRESO" onselect="cargaval()" onclick="cargaval(); mostrar()">EGRESO 
                        </label>     
                    </div>
                    <?php
                } else {
                    if ($_REQUEST['tipo'] == 'INGRESO') {
                        ?> 
                        <div class="radio">

                            <label>
                                <input type="radio" name="tipo" value="INGRESO" checked="">INGRESO 
                            </label>
                            <label>
                                <input type="radio" name="tipo" value="EGRESO" >EGRESO 
                            </label>
                        </div>
                        <?php 
                    } else {
                        ?>       
                        <div class="radio">

                            <label>
                                <input type="radio" name="tipo" value="INGRESO" >INGRESO 
                            </label>
                            <label>
                                <input type="radio" name="tipo" value="EGRESO" checked="">EGRESO 
                            </label>
                        </div>
                        <?php
                    }
                }
                ?> 
            </div>
        </div>

        <br><br>
<!--                            </div>
</div>-->

<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Veh&iacute;culo
            </div>
            <div class="col-lg-3">            
                <label>Ingrese la placa:</label>
                <div class="form-group input-group">
                    <input type="text" list="tran_veh_placas" id="tran_veh_placas" name="tran_veh_placas" value="<?php
                    if (isset($_REQUEST['tran_veh_placas'])) {
                        echo $_REQUEST['tran_veh_placas'];
                    }
                    ?>" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();" autofocus="" autocomplete="off" class="form-control" placeholder="Ingrese la placa" >
                    <span class="input-group-btn">
                        <button class="btn btn-default" name="buscar_veh_trs" type="submit"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>  
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <table>
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
                        </table>
                    </center>
                </div>                
            </div>
            <br>
        </div>

    </div>


    <!--<div class="row">-->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Cliente
            </div>
            <div class="col-lg-3">      
                <label>Ingresar c&eacute;dula:&nbsp;</label>
                <div class="form-group input-group">
                    <input type="text" id="tran_cli_ident" name="tran_cli_ident" value="<?php
                    if (isset($_REQUEST['tran_cli_ident'])) {
                        echo $_REQUEST['tran_cli_ident'];
                    }
                    ?>" style="text-transform:uppercase;" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"  class="form-control" placeholder="Ingrese la cedula">
                    <span class="input-group-btn">
                        <button class="btn btn-default" name="buscar_cli_com" type="submit"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <table>
                            <?php
                            if (isset($_POST['buscar_cli_com']) or isset($_POST['buscar_veh_trs'])) {
                                include_once 'class/cliente.php';
                                $objcli = new Cliente();
                                $objcli->conec_base();
                                $objcli->buscar_cliente_com($_POST['tran_cli_ident']);
                                $objcontbl->vercuentacli($_POST['tran_cli_ident']);
                            }
                            ?>
                        </table>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
</div>

<div class="row">
    <div class="col-lg-12">
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
            <!--<p style="text-align: left; font-size:13px; ">-->
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gastos del veh&iacute;culo
                        </div>
                        <!--<input type="button" name="btn_reg_veh" id="btn_reg_veh" onclick="reg_veh()" value="Vehículo">-->  
                        <table>
                            <tr>                                
                                <td colspan="5">
                                 <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                    <label for="btn_val"></label>
                                    <input type="button" name="btn_val" id="btn_val" onclick="cargaval()" value="GASTOS" class="btn btn-primary btn-sm">
                                </div>
                            </td> 
                        </tr>
                        <tr>                       
                            <td>
                                <!--<div class="col-lg-6">                                    -->
                                <input type="hidden" name="prec_compra" id="prec_compra" placeholder="Valor de compra" value="<?php
                                if (isset($_REQUEST['prec_compra'])) {
                                    echo $_REQUEST['prec_compra'];
                                }
                                ?>">
                            </td>
                            <td>   
                                &nbsp;&nbsp;    
                                <div class="form-group">
                                    <label for="pventa">Valor de venta:</label>
                                    <input type="text" name="pventa" id="pventa"
                                    placeholder="0.00" value="" onchange="verifica();" min="0" >
                                </div>                             
                                <div class="form-group" style="display: none;">
                                    <label for="tran_cab_precio">Valor veh&iacute;culo:</label>                                    
                                    <input type="text" name="tran_cab_precio" id="tran_cab_precio"
                                    placeholder="0.00" value="<?php
                                    if (isset($_REQUEST['tran_cab_precio'])) {
                                        echo $_REQUEST['tran_cab_precio'];
                                    }
                                    ?>" min="0" >
                                </div> 
                            </td>
                            <td>
                                &nbsp;&nbsp;
                                <div class="form-group" style="display: none;">
                                    <label for="tran_cab_seguro">Seguro:</label>
                                    <input type="text" name="tran_cab_seguro" id="tran_cab_seguro" readonly=""  placeholder="0.00" value="<?php
                                    if (isset($_REQUEST['tran_cab_seguro'])) {
                                        echo $_REQUEST['tran_cab_seguro'];
                                    }
                                    ?>"  >  
                                </div>
                            </td>
                            <td>  
                                &nbsp;&nbsp;                                  
                                <div class="form-group">
                                   <label for="tran_cab_gastos">Gastos:</label>
                                   <input type="text" name="tran_cab_gastos" id="tran_cab_gastos" readonly="" placeholder="0.00" value="<?php
                                   if (isset($_REQUEST['tran_cab_gastos'])) {
                                    echo $_REQUEST['tran_cab_gastos'];
                                } else {
                                    echo '';
                                }
                                ?>"  >
                            </div>
                        </td>
                        <td>    
                            &nbsp;&nbsp;                            
                            <div class="form-group">
                                <label for="total">TOTAL : </label>
                                <input type="text" name="total" id="total" value="<?php
                                if (isset($_REQUEST['total'])) {
                                    echo $_REQUEST['total'];
                                } else {
                                    echo '';
                                }
                                ?>" id="total" readonly=""  >
                            </div>
                        </td>
                        <td>  
                            &nbsp;&nbsp;                              
                            <div class="form-group" style="display: none;" ><!---->
                                <label for="ganancia">Ganancia : </label>
                                <input type="text" id="ganancia" name="ganancia" value="<?php
                                if (isset($_REQUEST['ganancia'])) {
                                    echo $_REQUEST['ganancia'];
                                }
                                ?>" readonly="" />
                            </div>
                        </td>
                    </tr>
                </table>
                <!--</p>-->
                <!--</div>-->
            </div>
        </div>

    </div>
    <script type="text/javascript">
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
                }
                $.post("./class/script_val.php", {"texto": placa, "tipo": tipo},
                    function (respuestag) {
                        var valores = respuestag.split("-");
                        precio = valores[0];
                        gastos = valores[1];
                        document.getElementById('tran_cab_precio').value = precio;
                        document.getElementById('tran_cab_gastos').value = gastos;
                        document.getElementById('prec_compra').value = precio;

                        $("#tran_cab_precio").val(respuestag.toFixed(2).toString().replace(',', '.'));
                    });
            }
        </script>
        <script type = "text/javascript" >

            function tables() {
                $(document).ready(function () {
                    $('#dataTables-example').dataTable();
                });
            }
            function verifica(){
                var pventa = $("#pventa").val();
                var tran_cab_precio = $("#tran_cab_precio").val();
                var tran_cab_gastos = $("#tran_cab_gastos").val();
                pvnt=parseFloat(pventa);
                pprc=parseFloat(tran_cab_precio);
                pgst=parseFloat(tran_cab_gastos);
                ganancia = 0;
                gnc=parseFloat(ganancia);
                diferencia=0;
                dif = parseFloat(diferencia);
                perdida=0;
                prd=parseFloat(perdida);
                if (pvnt==pprc) {
                    alert('Se realizará la venta por el mismo precio de adquisición');
                    total = pprc+pgst;
                    gnc = (pvnt-pprc)-pgst;
                    $("#total").val(total.toFixed(2).toString().replace(',', '.'));
                    $("#ganancia").val(gnc.toFixed(2).toString().replace(',', '.'));
                }
                if (pvnt>pprc) {
                    dif = pvnt-pprc;
                    total = (dif+pprc)+pgst;
                    prd=(dif-pgst);
                    $("#total").val(total.toFixed(2).toString().replace(',', '.'));
                    $("#ganancia").val(prd.toFixed(2).toString().replace(',', '.'));
                }
                if (pvnt<pprc) {
                    dif = pprc-pvnt;
                    total =(pprc-dif)+pgst;
                    prd=(dif+pgst);
                    alert('Se realizará la venta por un valor menor al precio de adquisición');
                    $("#total").val(total.toFixed(2).toString().replace(',', '.'));
                    $("#ganancia").val(prd.toFixed(2).toString().replace(',', '.'));
                }
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
                
                function vaciar() {
                    $("#tran_cab_precio").val("");
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
                                }
                                break;
                            } else {
                                tipo = "EGRESO";
                                if (data == 'Ingresos Diferidos') {
                                    alert('Opcion invalida');
                                }
                                break;
                            }
                        }
                    }
                </script>
                <script type="text/javascript">
                    function excel(id){
                        window.open('./documentos/export/' + id + '.php');
                    }
                    function pdf(id){
                        window.open('./documentos/export/' + id + '.php');
                    }
                </script>

            </p>
        </fieldset>

        <script type="text/javascript">
            function confirma_delet(carpeta,monto){
                var answer = confirm("Esta seguro que desea eliminar este pago?");                    
                if (answer) {
                    $.post("./script/delete_pay.php", {"carpeta": carpeta,"monto": monto},
                            //$(this).closes('tr').remove();
                            function (respuestag) {
                                alert(respuestag);
                                //window.location.reload();
                            });
                } 
            }

            function revome(t){
                var td = t.parentNode;
                var tr = td.parentNode;
                var table = tr.parentNode;
                table.removeChild(tr);
                refresh();
            }

            function refresh(){
                $("#refresh").load("nueva_transac.php");  
                $("#lstveh").load("nueva_transac.php");  
            }

            function detall(carpeta,monto,id,tipo) {
                if (tipo==1) {
                    var tp="ENTRADA";
                    var resultado = document.getElementById('cajaentrada');
                    view_modal(carpeta,monto,id,tp,resultado);
                }
                if (tipo==2) {
                    var tp="ADICIONAL";                        
                    var resultado = document.getElementById('cajaadicional');
                    view_modal(carpeta,monto,id,tp,resultado);                        
                }
                if (tipo==3) {
                    var tp="CREDITO";
                    var resultado = document.getElementById('cajacredito');
                    view_modal(carpeta,monto,id,tp,resultado);                        
                }             
                if (tipo==4) {
                    var tp="ADICIONALES"; 
                    var resultado = document.getElementById('cajaadicional');
                    view_modal(carpeta,monto,id,tp,resultado);
                }
                if (tipo==5) {
                    var tp="CREDITOS";                     
                    var resultado = document.getElementById('cajacredito');
                    view_modal(carpeta,monto,id,tp,resultado);                        
                }       
            }

            function view_modal(carpeta,monto,id,tp,resultado){
                ajax = objetoAjax();
                ajax.open('GET', './script/modal_pay.php?carpeta=' + carpeta + "&monto=" + monto + "&id=" +id + "&tipo="+ tp, true);
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4) {
                        resultado.innerHTML = ajax.responseText;
                        tables();
                    }
                }
                ajax.send(null);
            }

            function trash(){
                var carpeta = '0';
                var monto = '0';
                var answer = confirm("Esta seguro que desea vaciar los pagos registrados?");                    
                if (answer) {
                    $.post("./script/trash.php", {"carpeta": carpeta,"monto": monto},
                        function (respuestag) {
                            alert(respuestag);
                        });
                } 
            }
        </script>

    </div>
</div>


<div class="row" id="refresh">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                PAGOS
            </div>
            <div class="panel-body">

                <fieldset> 
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">


                                <table class="table">
                                    <thead>
                                        <tr align="center">
                                            <td width="80">Pago</td>
                                            <td width="100">Forma</td>
                                            <!--<td width="130">Mantenimiento</td>-->
                                            <td width="120"># Placa-Dcto-Chq-Letr</td>
                                            <td width="60">Valor</td>
                                            <td width="100">Fecha transacci&oacuten</td>
                                            <td width="60">Interes</td>
                                            <td width="50">Plazo dias</td>
                                            <td width="60">Estado</td>
                                            <td width="150">Observaci&oacute;n</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="info">
                                            <td class="center">
                                                <select name="pago" id="pago" style="width: 100px;font-size: 9px;" >    
                                                    <option value="0">Selecci&oacute;ne </option>
                                                    <option value="ENTRADA">ENTRADA</option>
                                                    <option value="ADICIONAL">ADICIONAL</option>
                                                    <option value="CREDITO">CREDITO</option>   
                                                </select></p>
                                            </td>
                                            <td class="center">
                                                <select name="forma" id="forma" style="width: 100px;font-size: 9px;" >    
                                                    <option value="EFECTIVO">Selecci&oacute;ne</option>
                                                </select>
                                            </td>
                                            <td class="center">
                                                <input type="text" id="dcto" name="dcto" class="text-lg" onchange="contts();" style="font-size: 9px;" list="cta" autocomplete="off" />
                                                <datalist id="cta">
                                                    <optgroup label="bancos">
                                                        <?php
                                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                                        $query = "select * from t_plan_de_cuentas where t_subcuenta_cod_subcuenta='1.1.1.2.' and nombre_cuenta_plan !='BANCOS' ";
                                                        $resul1 = mysqli_query($c, $query);
                                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                                            $cod1 = $dato1['cod_cuenta'];
                                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; 
                                                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                                            echo '</option>';
                                                        }
                                                        mysqli_close($c);
                                                        ?>
                                                    </optgroup>
                                                    <optgroup label="ingresos" >
                                                        <?php
                                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                                        $query = "select * from t_plan_de_cuentas where cod_cuenta='2.2.1.3.1.'";
                                                        $resul1 = mysqli_query($c, $query);
                                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                                            $cod1 = $dato1['cod_cuenta'];
                                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; 
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
                                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; 
                                                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                                            echo '</option>';
                                                        }
                                                        mysqli_close($c);
                                                        ?>
                                                    </optgroup>
                                                    <optgroup label="cajas">
                                                        <?php
                                                        $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                                                        $query = "select * from t_plan_de_cuentas where cod_cuenta='1.1.1.1.'";
                                                        $resul1 = mysqli_query($c, $query);
                                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                                            $cod1 = $dato1['cod_cuenta'];
                                                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; 
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
                                                        echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >"; 
                                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                                        echo '</option>';
                                                    }
                                                    mysqli_close($c);
                                                    ?>
                                                </datalist>

                                            </td>
                                            <td class="center">
                                                <input type="text" id="valor" name="valor" class="text-sm" placeholder="0.00" style="font-size: 9px;" >
                                            </td>
                                            <td class="center" >
                                                <input type="text" id="fecha_det" name="fecha_det" value="<?Php echo date("Y-m-d"); ?>" style="width: 80px;font-size: 9px;" readonly="readonly" >
                                            </td>
                                            <td class="center">

                                                <select name="interes" id="interes" size="0" style="alignment-adjust: central;width: 70px; font-size: 9px;" >
                                                    <?php
                                                    $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                                                    $consulint = "select prm_int from soft_prm";
                                                    $queryclases = mysqli_query($c, $consulint);
                                                    while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                        if ($_POST['prm_int'] == $arreglorepalmtu['prm_int']) {
                                                            echo "<option value='" . $arreglorepalmtu['prm_int'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['prm_int'] . "</option>";
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $arreglorepalmtu['prm_int'] ?>">
                                                                <?php echo $arreglorepalmtu['prm_int'] ?></option>     
                                                                <?php
                                                            }
                                                        }
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </td>
                                                <td class="center">
                                                    <input type="text" id="plazo" name="plazo" style="font-size: 9px;" class="text-sm" placeholder="0" >
                                                </td>
                                                <td class="center">
                                                    <select id="lststd" id="lststd" name="lststd" width="60" >
                                                        <option value=""></option>
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
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="btn-group btn-group-xs" role="group" aria-label="...">
                            <input type="submit"  name="agregar_en" value="Agregar a Pagos" class="btn btn-primary btn-sm"/>
                        </div>
                        <br><br>
                        <div id="lstveh">
                            <form name="form" id="form" action="" method="post">
                                <?php
                                include_once 'class/trandetalle.php';
                                $conn = new Trandetalle();
                                $conn->conec_base();
                                if(($_POST['refresh']=="ACTUALIZAR TABLA")||($_POST['pago']=='CREDITO')||($_POST['pago']=='ADICIONAL')){
                                    $conn->listar_detalle();
                                    $conn->credit_temporal();            
                                }else{
                                    $conn->listar_detalle();
                                }
                                $t = $_POST['total'];
                                ?>      
                            </form>
                            <p style="font-size:13px; text-align: center">
                                <table>
                                    <tr>
                                        <td>
                                            <label>Venta por :&nbsp;</label>
                                            <input type="text" name="totalsumadb1" id="totalsumadb1" value="<?Php echo doubleval($t); ?>" disabled="" />
                                        </td>
                                        <?Php
                                        $con = new mysqli("localhost", $_SESSION['user'], $_SESSION['pass'], 'cove_veh');
                                        $sqlsuma = "SELECT ROUND(SUM(`mnt`), 2) as suma FROM gen_ass_temp;";
                                        $ej = mysqli_query($con, $sqlsuma) or trigger_error("Query Failed! SQL: $sqlsuma - Error: " . mysqli_error($con), E_USER_ERROR);
                                        while ($row = mysqli_fetch_array($ej)) {
                                            $row['suma'];
                                            $vl = $row['suma'];
                                            $ajustar = $t - $row['suma'];
                                            ?>    
                                            <td>
                                                <label>Justificados :&nbsp;</label><input type="text" name="totalsumadb2" id="totalsumadb2" value="<?Php echo doubleval($vl); ?>" disabled="" />
                                                <td>
                                                    <label>Faltan  :&nbsp;</label><input type="text" name="poraj" value="<?Php echo doubleval($ajustar); ?>" disabled="" />
                                                    <?Php
                                                }
                                                $con->close();
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </p>
                            </div>  
                        </fieldset>
                        <br><br>
                        <div class="btn-group btn-group-xs" role="group" aria-label="...">
                            <input type="submit" name="insertar_transac" onclick="return cvereficarvalores(this)" value="GRABA TRANSACCION" class="btn btn-success btn-sm">
                            &nbsp;&nbsp;
                            <input type="submit" name="resettemp" value="CANCELAR" class="btn btn-primary btn-sm">
                            &nbsp;&nbsp;
                            <input type="submit" name="transac" value="SALIR" class="btn btn-default btn-sm">
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</center>
</div>


<!-- jQuery -->
<script src="js/jquery-1.11.0.js"></script>
<script src="js/jquery-1.11.3.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

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


<!-- Modal Credito-->
<div class="modal fade" id="CREDITO" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">VISUALIZAR CR&Eacute;DITO</h4>
            </div>
            <div class="modal-body" id="cajacredito">
            </div>
        </div>
    </div>
</div>
<!-- Modal Adiional-->
<div class="modal fade" id="ADICIONAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">VISUALIZAR ADICIONAL</h4>
            </div>
            <div class="modal-body" id="cajaadicional">
            </div>
        </div>
    </div>
</div>
<!-- Modal Adiional-->
<div class="modal fade" id="ENTRADA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">VISUALIZAR ENTRADA</h4>
            </div>
            <div class="modal-body" id="cajaentrada">
            </div>
        </div>
    </div>
</div>


</div>

</div>
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
