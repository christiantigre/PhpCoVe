<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'class/registro.php';
$objreg = new Registro();

//PANTALLA PRINCIPAL
if(isset($_REQUEST['variable'])){
    $entorno = $_REQUEST['variable'];
    if($entorno == "inicio"){
        $variable = 0;
    }
// MANTENIMIENTOS 
    //VEHICULOS
    if($entorno == "vehiculo"){
        $mensaje = $_SESSION['user'] . " /entro en mantenimiento de vehiculos";
        $objreg->registrar($mensaje);        
        $variable = 11;
    }
    if($entorno == "modifica_vehiculo"){
        $verplaca = $_REQUEST['verplaca'];
        $mensaje = $_SESSION['user'] . " /entro a modificar el vehiculo $verplaca";
        $objreg->registrar($mensaje);        
        $variable = 112;
    }
    //CLIENTES
    if($entorno == "cliente"){
        $mensaje = $_SESSION['user'] . " /entro en mantenimiento de clientes";
        $objreg->registrar($mensaje);        
        $variable = 12;
    }
    if($entorno == "modifica_cliente"){
        $vercedula = $_REQUEST['vercedula'];
        $mensaje = $_SESSION['user'] . " /entro a modificar el cliente $vercedula";
        $objreg->registrar($mensaje);        
        $variable = 122; 
    }
// TRANSACCIONES    
    if($entorno == "transaccion"){
        $mensaje = $_SESSION['user'] . " /entro a visualizar transacciones";
        $objreg->registrar($mensaje);        
        $variable = 21;
    }
    //editar transaccion
    if($entorno == "edit_transaccion"){
        $mensaje = $_SESSION['user'] . " /entro a editar transaccion";
        $objreg->registrar($mensaje);        
        $variable = 213;
    }
    if($entorno == "ver_transaccion"){
        $codigo = $_REQUEST['vertrans'];
        $mensaje = $_SESSION['user'] . " /entro a visualizar transacción  $codigo";
        $objreg->registrar($mensaje);        
        $variable = 212;
    }
        if($entorno == "nueva_trs"){
            $mensaje = $_SESSION['user'] . " /entro a nueva transacción";
            $objreg->registrar($mensaje);            
            $variable = 211;
        }
        if($entorno == "buscar_veh_trs"){
            $variable = 211;
        }
        if($entorno == "buscar_cli_com"){
            $variable = 211;
        }
    if($entorno == "amortizacion"){
        $mensaje = $_SESSION['user'] . " /entro a tabla de amortización";
        $objreg->registrar($mensaje);        
        $variable = 22;
    }
    if($entorno == "cobro"){
        $mensaje = $_SESSION['user'] . " /entro a ver créditos";
        $objreg->registrar($mensaje);        
        $variable = 23;
    }
    if($entorno == "paga_credito"){
        $numcre = strstr($_REQUEST['pagacre'], '-', true);
        $numsec = substr(strstr($_REQUEST['pagacre'], '-'), 1);
        $variable = 232;
    }
    if ($entorno == "abono_credito") {
        $numcre = strstr($_REQUEST['abonocre'], '-', true);
        $numsec = substr(strstr($_REQUEST['abonocre'], '-'), 1);

        $variable = 243;
    }    
    if ($entorno == "ver_abonos") {
        $numcre = strstr($_REQUEST['verabono'], '-', true);
        $numsec = substr(strstr($_REQUEST['verabono'], '-'), 1);
        $mensaje = $_SESSION['user'] . " /Ingreso a ver abono";
        $objreg->registrar($mensaje);
        $variable = 244;
    }    
    
    if($entorno == "gastos"){
        $variable = 24;
    }
    if($entorno == "documento"){
        $variable = 25;
    } 
    if($entorno == "ver_transaccion"){
        $variable = 26;
    }
    if($entorno == "cartera"){
        $mensaje = $_SESSION['user'] . " /entro a ver cartera";
        $objreg->registrar($mensaje);        
        $variable = 27;
    }    
// ADMINISTRACION
    if($entorno == "empresa"){
        $variable = 31;
    }
    if($entorno == "nuevo_usuario"){
        $variable = 32;
    }
    if($entorno == "cambio_clave"){
        $variable = 33;
    }
    if($entorno == "cambio_permisos"){
        $variable = 34;
    }
    if($entorno == "registro"){
        $variable = 35;
    }
// PARAMETROS   
    if($entorno == "marcas"){
        $variable = 41;
    }
    if($entorno == "modelos"){
        $variable = 42;
    }
    if($entorno == "tipos"){
        $variable = 43;
    } 
    if($entorno == "lugares"){
        $variable = 44;
    }  
    if($entorno == "financiamiento"){
        $variable = 45;
    }    
// SALIR    
    if($entorno == "cierre_sesion"){
        include_once 'class/sesion.php';
        $objcerrar = new Sesion('*', '*');
        $objcerrar->cerrar_sesion();
        header("location:index.php");
    }
}else{
    $entorno = '';
    $variable = 0;    
}

// ACCIONES VARIAS
    //MANTENIMIENTO
    if(isset($_POST['guarda_vehiculo'])){
        include_once 'class/vehiculo.php';
        $objnueveh = new Vehiculo();
        $objnueveh->conec_base();
        $objnueveh->insertar_vehiculo($_POST['idveh_placa'], $_POST['veh_vehiculo'], $_POST['veh_anio'], 
                $_POST['veh_color1'], $_POST['veh_color2'], $_POST['veh_motor'], $_POST['veh_chasis'], 
                $_POST['veh_km'], $_POST['veh_mat_lugar'], $_POST['veh_mat_anio'], $_POST['veh_estado']);

        $mensaje = $_SESSION['user'] . " /creo el vehiculo " . $_POST['idveh_placa']. $_POST['veh_estado'];
        $objreg->registrar($mensaje);
        include_once 'class/modelo.php';
        $objmod = new Modelo();
        $objmod->conec_base();
        $modelo = $objmod->modelo_cuenta($_POST['idveh_placa']);

        include_once 'class/contabilidad.php';
        $objcont = new contabilidad();
        $objcont->conec_base();
        $datovehiculo = $_POST['veh_vehiculo'];
        $objcont->crear_cta_veh($modelo, $_POST['idveh_placa']);
        $mensaje = $_SESSION['user'] . " /creo cuenta contable del vehiculo " . $_POST['idveh_placa'];
        $objreg->registrar($mensaje);            
        $variable = 11; 
    }
    if(isset($_POST['modificar_vehiculo'])){
        include_once 'class/vehiculo.php';
        $objmodveh = new Vehiculo();
        $objmodveh->conec_base();
        $objmodveh->modifica_vehiculo($_POST['idveh_placa'], $_POST['veh_km'], $_POST['veh_cod_lugar'],
                $_POST['veh_mat_anio'], $_POST['veh_anio'],$_POST['veh_chasis'], $_POST['veh_motor'], 
                $_POST['veh_color1'],$_POST['veh_color2'], 
                $_POST['estado_a'], $_POST['estado1'], $_POST['estado2'], $_POST['estado3'], 
                $_POST['estado4'], $_POST['estado5'], $_POST['estado6'], $_POST['estado7'], $_POST['estado8'], 
                $_POST['estado9'], $_POST['estado10'], $_POST['estado11'], $_POST['estado12'], $_POST['estado13']);
        $mensaje = $_SESSION['user'] . " /modifico el vehiculo " . $_POST['idveh_placa'];
        $objreg->registrar($mensaje);        
        $variable = 11;
    } 
    if(isset($_POST['guarda_cliente'])){
        include_once 'class/cliente.php';
        $objcli = new Cliente();
        $objcli->conec_base();
        $objcli->insertar_cliente($_POST['idcli_ident'], $_POST['cli_nombre'], $_POST['cli_apellido'], 
                $_POST['cli_dir_casa'], $_POST['cli_dir_tra'], $_POST['cli_tel_fijos'], $_POST['cli_tel_cel'], 
                $_POST['cli_correo'], $_POST['cli_ciudad'], $_POST['cli_nom_ref'], $_POST['cli_dir_ref'], 
                $_POST['cli_tel_ref'], $_POST['cli_est_civ'], $_POST['cli_conyuge'], $_POST('ced_cliente'));
        $mensaje = $_SESSION['user'] . " /creo el cliente " . $_POST['idcli_ident'];
        $objreg->registrar($mensaje);
        include_once 'class/contabilidad.php';
        $objcont = new contabilidad();
        $objcont->conec_base();
        $datocliente = $_POST['cli_apellido'] . " " . $_POST['cli_nombre'];
        $objcont->crear_cta_clte($datocliente, $_POST['idcli_ident']);
        $mensaje = $_SESSION['user'] . " /creo cuenta contable del cliente " . $_POST['idcli_ident'];
        $objreg->registrar($mensaje);        
        $variable = 12;
    }
    if(isset($_POST['modificar_cliente'])){        
        include_once 'class/cliente.php';
        $objmodclt = new Cliente();
        $objmodclt->conec_base();
        $objmodclt->modifica_cliente($_POST['idcli_ident'], $_POST['cli_nombre'], $_POST['cli_apellidos'],
                $_POST['cli_dir_casa'], $_POST['cli_dir_tra'],
                $_POST['cli_tel_fijos'], $_POST['cli_tel_cel'], $_POST['cli_correo'], $_POST['cod_ciudad'], 
                $_POST['cli_nom_ref'], $_POST['cli_dir_ref'], $_POST['cli_tel_ref'], $_POST['cli_est_civ'], 
                $_POST['cli_conyuge'], $_POST['ced_conyuge']);
        $mensaje = $_SESSION['user'] . " /modifico el cliente " . $_POST['idcli_ident'];
        $objreg->registrar($mensaje);        
        $variable = 12;
    }
//TRANSACCIONES
    
if(isset($_POST['ver_reg'])){
    $entorno = 'ver_reg';
    $variable = 35;
}    
    
if(isset($_POST['buscar_veh'])){
    $entorno = 'buscar_veh';
    $variable = 11;
}

if (isset($_POST['buscar_pagcar']) or isset($_POST['txt_carpetapag'])) {
    $variable = 24;
}
if (isset($_POST['buscar_pagcli']) or isset($_POST['txt_idclipag'])) {
    $variable = 24;
}
if (isset($_POST['buscar_pagveh']) or isset($_POST['txt_idvehpag'])) {
    $variable = 24;
}
if (isset($_POST['otrospag'])) {
    $variable = 241;
}
if (isset($_POST['verptpag'])) {
    global $cuentatxt;
    $cuentatxt = $_REQUEST['cuentatxt'];
    $variable = 241;
}
if (isset($_REQUEST['verpagos'])) {
    $variable = 24;
}
if (isset($_POST['bpago'])) {
    $bpagot = $_POST['bpagot'];
    $bmonto = $_POST['bmonto'];
    $variable = 241;
}
if (isset($_POST['impcomprobantepagotros'])) {
    $idhei = $_POST['idhei'];
    echo '<script>window.open("imp/impcomppagotr.php?s/&slide=1&show=09&load=555&data=8&idhei=' . $idhei . '&file=3&&datatipdata=09end=79&datpag=4534&obv=97&prm=xt4&new=65")</script>';
    $menu = 242;
}
if (isset($_POST['realiz_pag'])) {
    global $cuentatxt;
    $fech_reg = $_POST['datepag'];
    $tipde_pag = $_POST['cuentatxt'];
    $monto_pag = $_POST['monto_pag'];
    $valiva = $_POST['valiva'];
    $subtotal = $_POST['subtotal'];
    $porcentaje = $_POST['iva'];
    $pag_por = $_POST['pag_por'];
    $observ = $_POST['observ'];
    $cli = $_POST['pag_cli'];
    $veh = $_POST['pag_veh'];
    $dcto = $_POST['dcto'];
    include_once 'class/otrospagos.php';
    $objotpag = new Otrospag();
    $objotpag->conec_base();
    //echo "<script>alert('".$dcto."')</script>";
    $objotpag->realizarpago($fech_reg, $tipde_pag, $monto_pag, $pag_por, $observ, $cli, $veh, $valiva, $subtotal, $porcentaje, $dcto);
    $menu = 242;
}

//registra abono

//ver abonos


if (isset($_POST['pagacrepag'])) {
    $numcre = strstr($_POST['pagacrepag'], '-', true);
    $numsec = substr(strstr($_POST['pagacrepag'], '-'), 1);
    $menu = 233;
}
if (isset($_POST['pagacredito'])) {
    global $numcre, $numsec;
    include_once 'class/trancredito.php';
    $objcredito = new Trancredito();
    $varcre = $_POST['numcretxt'];
    $varsec = $_POST['numsectxt'];
    $objcredito->pagodecredito($_POST['numcretxt'], $_POST['numsectxt'], $_POST['observ']);
    $variable = 231;
}
//guardar abono
if (isset($_POST['abonocredito'])) {
    global $numcre, $numsec;
    include_once 'class/trancredito.php';
    $objcredito = new Trancredito();
    $varcre = $_POST['numcretxt'];
    $varsec = $_POST['numsectxt'];
    $fechaabono = $_POST['fechaabono'];
    $valorabono = $_POST['valorabono'];
    $detallabono = $_POST['detallabono'];
    $objcredito->guarda_abono($varcre, $varsec, $fechaabono, $valorabono, $detallabono);
    $mensaje = $_SESSION['user'] . " /registro un abono de " . $valorabono . " en la carpeta " . $varcre . " cuota " . $varsec;
    $objreg->registrar($mensaje);
    $codigo = $varcre;
    $menu = 244;
}

if (isset($_POST['cobrarcredito'])) {
    global $numcre, $numsec;
    include_once 'class/trancredito.php';
    $objcredito = new Trancredito();
    $varcre = $_POST['numcretxtcob'];
    $varsec = $_POST['numsectxtcob'];
    $objcredito->pagodecreditopag($_POST['numcretxtcob'], $_POST['numsectxtcob'], $_POST['observ']);
    $menu = 2331;
}
if (isset($_POST['impcomprobante'])) {
    $varcre = $_POST['numcretxt'];
    $varsec = $_POST['numsectxt'];
    echo '<script>window.open("imp/impcomp.php?s/&slide=1&show=09&load=555&data=8&file=3&datashowfilepaginastart=' . $varcre . '&datashowfilepaginaend=' . $varsec . '&end=97&prm=xt4&new=65")</script>';
    $variable = 231;
}
if (isset($_POST['impcomprobantepag'])) {
    $varcre = $_POST['numcretxtcob'];
    $varsec = $_POST['numsectxtcob'];
    echo '<script>window.open("imp/impcomppag.php?s/&slide=1&show=09&load=555&data=8&file=3&datashowfilepaginastart=' . $varcre . '&datashowfilepaginaend=' . $varsec . '&end=97&prm=xt4&new=65")</script>';
    $menu = 2331;
}
if (isset($_POST['detcobro'])) {
    global $varcre, $varsec;
    $varcre = strstr($_POST['detcobro'], '-', true);
    $varsec = substr(strstr($_POST['detcobro'], '-'), 1);
    $menu = 2333;
}

if(isset($_POST['nueva_trs'])){
    include_once 'class/trandetalle.php';
    $objdetalle = new Trandetalle();
    $objdetalle->limpia_detalles();
    include_once 'class/contabilidad.php';
    $objcont = new contabilidad();
    $objcont->vaciar_tab();    
    $entorno = 'nueva_trs';
    $variable = 211;
}
if(isset($_POST['buscar_veh_trs']) or isset($_POST['buscar_cli_com'])){
    $entorno = 'nueva_trs';
    $variable = 211;
}
if(isset($_POST['agregar_en'])){
    include_once 'class/trandetalle.php';
    include_once 'class/contabilidad.php';
    $objdetalle = new Trandetalle();
    $objcont = new contabilidad();
    if ($_POST['tipo'] == "") {
        echo '<script>alert("SELECCIONE INGRESO / EGRESO")</script>';
    } else {
        if ($_POST['pago'] == "" || $_POST['forma'] == "") {
            echo '<script>alert("SELECCIONE FORMA DE PAGO / FORMA")</script>';
        } else {
            $interes = $_POST['interes'];
//            echo '<script>alert('.$interes.')</script>';
            $objdetalle->inserta_detalle($_POST['idtran_cab'], $_POST['pago'], $_POST['forma'], $_POST['dcto'], $_POST['valor'], $_POST['fecha_det'], $_POST['interes'], $_POST['plazo'], $_POST['lststd'], $_POST['observacion']);
            $objcont->gen_ass_temp(array($_POST['pago'], $_POST['forma'], $_POST['dcto'], $_POST['valor'], $_POST['fecha_det'], $_POST['interes'],
                $_POST['plazo'], $_POST['lststd'], $_SESSION['user'], $_REQUEST['tipo'], $_POST['idtran_cab'], $_POST['tran_cli_ident'], $_POST['tran_veh_placas'], $_POST['total']));
        }
    }
    $variable = 211;    
}

if (isset($_POST['refresh'])) {
    $variable=211;
}

if (isset($_POST['inserta_empresa'])) {
    include_once 'class/datempre.php';
    $objempre = new Empresa();
    $objempre->regempresa($_POST['razon'], $_POST['propietario'], $_POST['gerente'], $_POST['direccion'], $_POST['telefono'], $_POST['email'], $_POST['webpage']);
    $variable = 31;
}
if(isset($_POST['insertar_marca'])){
    if (isset($_POST['marca']) !== "") {
        include_once 'class/marca.php';
        $objmarca = new Marca();
        $objmarca->conec_base();
        $objmarca->guardar_marca($_POST['marca']);
        $mensaje = $_SESSION['user'] . " /creo la marca " . $_POST['marca'];
        $objreg->registrar($mensaje);         
    } else {
        echo"<script> alert('Debe llenar el campo') </script>";
    }
    $variable = 41;    
}
if(isset($_POST['insertar_modelo'])){
    include_once 'class/modelo.php';
    $objmarca = new Modelo();
    $objmarca->conec_base();
    $objmarca->guardar_modelo($_POST['veh_marca'], $_POST['veh_modelo'], $_POST['veh_tipo']);
    $mensaje = $_SESSION['user'] . " /creo el vehiculo " . $_POST['veh_marca'] .' - '. $_POST['veh_modelo'] .' - '. $_POST['veh_tipo'];
    $objreg->registrar($mensaje);     
    $variable = 42;    
}
if (isset($_POST['inserta_tipo'])) {
    include_once 'class/tipo.php';
    $objtipo = new Tipo($_POST['veh_tipo_des']);
    $objtipo->conec_base();
    $objtipo->insertar_tipo();
    $mensaje = $_SESSION['user'] . " /creo el tipo " . $_POST['veh_tipo_des'];
    $objreg->registrar($mensaje);    
    $variable = 43;
}
if(isset($_POST['inserta_interes'])){
    include_once 'class/soft_prm.php';
    $objinteres = new Interes($_POST['interes']);
    $objinteres->conec_base();
    $objinteres->insertar_interes();
    $mensaje = $_SESSION['user'] . " /creo el interes " . $_POST['interes'];
    $objreg->registrar($mensaje);      
    $variable = 45;
}
if (isset($_POST['agrega_docu'])) {
    include_once 'class/vehiculo.php';
    $objveh = new Vehiculo();
    $objveh->conec_base();
    $objveh->agrega_dcto($_POST['idveh_placa'], $_POST['nue_dcto']);
    $variable = 112;
}
if(isset($_POST['cal_credito'])){
    $variable = 22;
} 

if (isset($_POST['insertar_transac'])) {
    include_once 'class/transacc.php';
    include_once 'class/vehiculo.php';
    include_once 'class/contabilidad.php';
    $objtrs = new Transacc();
    $objcont = new contabilidad();
    $objVeh = new Vehiculo();
    $objtrs->conec_base();
    $objtrs->insertar_cabecera($_POST['idtran_cab'], $_POST['tipo'], $_POST['fecha'], $_POST['tran_veh_placas'], $_POST['tran_cli_ident'], $_POST['tran_cab_precio'], $_POST['tran_cab_seguro'], $_POST['tran_cab_gastos']);
    $objcont->conec_base();
    $objcont->crear_cta_interes($_POST['tran_cli_ident']);
    $objtrs->insertar_detalle();
    $objtrs->ver_creditos($_POST['tran_veh_placas']);
    $objtrs->ver_adicional();
//    $objtrs->insert_adicional();
    $a = $_POST['tran_cab_precio'];
    $b = $_POST['tran_cab_seguro'];
    $c = $_POST['tran_cab_gastos'];
    $estado = $_POST['estado'];
    $tipo_estado = $objVeh->ver_tipoEstado($_POST['tran_veh_placas']);

    if ($tipo_estado == "0") {
        $mensaje = $_SESSION['user'] . " /creo la transaccion de consignacion " . $_POST['idtran_cab'];
    } else {

        $d = $a + $b + $c;
        $ganancia = $_POST['ganancia'];
        if ($_POST['tipo'] == "INGRESO") {
            $vartipo = "INGRESO";
            $var_valor = $_POST['tran_cab_precio'];
        } else {
            $vartipo = "EGRESO";
            $var_valor = $_POST['prec_compra'];
        }
        $pres_compra = $_POST['prec_compra'];
        $var_tot = $pres_compra - $ganancia;
        $objcont->gen_ass_temp(array($vartipo, 'VALOR TOTAL', $_POST['dcto'],
            $var_valor, $_POST['fecha_det'], $_POST['interes'], //d  total
            $_POST['plazo'], $_POST['lststd'], $_SESSION['user'], $vartipo, $_POST['idtran_cab'],
            $_POST['tran_cli_ident'], $_POST['tran_veh_placas'], $var_tot)); //prec_compra $var_tot
//        $objcont->gen_ass_temp_ganancia(array($vartipo, 'GANANCIA', $_POST['tran_veh_placas'], $ganancia,$_POST['idtran_cab']) );
        $objcont->insert_ass($vartipo, $_POST['tran_veh_placas'], $_POST['tran_cli_ident'], $ganancia, $_POST['idtran_cab']);

        $mensaje = $_SESSION['user'] . " /creo la transaccion " . $_POST['idtran_cab'];
    }
    $objreg->registrar($mensaje);
    $variable = 21;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Control Parqueadero</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; height: 90px;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
<!--                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>-->
                    </button>
                    <a class="navbar-brand" href="inicio.php"><img src="images/logo_pag1.png" height="65" width="250"></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown" style="font-size: 11px">
                        <?php
                            $usuario = $_SESSION['user'];
                            echo 'Sesión iniciada: '. $usuario;
                        ?>                    
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="inicio.php?variable=cierre_sesion"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>                        
                </ul>
                <div class="navbar-default sidebar" role="navigation" style="top: 40px">
                    <div class="sidebar-nav navbar-collapse" style="font-size: 12px">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="inicio.php?variable=inicio"><i class="fa fa-home fa-fw"></i> Menú Principal</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-edit fa-fw"></i> Mantenimientos<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="inicio.php?variable=vehiculo" >Vehiculos</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=cliente">Clientes</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-car fa-fw"></i> Transacciones<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="inicio.php?variable=transaccion" >Transacci&oacute;n</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=cartera" >Ver Cartera</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=amortizacion" >Amortizaci&oacute;n</a>
                                    </li>
<!--                                    <li>
                                        <a href="#">Cr&eacute;dito <span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">-->
                                            <li>
                                                <a href="inicio.php?variable=cobro" >Cobro Cr&eacute;dito</a>
                                            </li>
<!--                                            <li>
                                                <a href="inicio.php?variable=abono">Abono Cr&eacute;dito</a>
                                            </li>
                                        </ul>-->
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=gastos" >Gastos</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=documento" >Documentos</a>
                                    </li>
                                </ul>                                
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-adjust fa-fw"></i> Administraci&oacute;n<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="inicio.php?variable=empresa" >Empresa</a>
                                    </li>
<!--                                    <li>
                                        <a href="#">Usuarios <span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="inicio.php?variable=nuevo_usuario">Nuevo Usuario</a>
                                            </li>
                                            <li>
                                                <a href="inicio.php?variable=cambio_clave">Cambio Clave</a>
                                            </li>
                                            <li>
                                                <a href="inicio.php?variable=cambio_permiso">Cambio Permisos</a>
                                            </li>
                                        </ul>
                                    </li>  -->
                                    <li>
                                        <a href="inicio.php?variable=registro">Registro</a>
                                    </li>                                    
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-archive fa-fw"></i> Parametros<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="inicio.php?variable=marcas" >Marcas</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=modelos">Modelos</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=tipos" >Tipos</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=lugares" >Lugares</a>
                                    </li>
                                    <li>
                                        <a href="inicio.php?variable=financiamiento" >Financiamiento</a>
                                    </li>                                    
                                </ul>                                
                            </li>                            
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper">
<!--                <div class="row">
                    <h1 class="page-header"><?php echo $entorno ?></h1>
                </div> -->
                <div class="row">
                    <div class="panel-body">
                        <div class="row">
                            <?php
                                switch ($variable) {
                                    case 0:
                                        include 'blank.php';
                                        break;
                                    case 11:
                                        include_once 'data/manveh.php';
                                        break;
                                    case 111:
                                        include_once 'data/addveh.php';
                                        break;
                                    case 112:
                                        include_once 'data/ver_veh.php';
                                        break;
                                    case 12:
                                        include_once 'data/mancli.php';
                                        break;
                                    case 121:
                                        include_once 'data/addcli.php';
                                        break;
                                    case 122:
                                        include_once 'data/ver_cli.php';
                                        break;
                                    case 21:
                                        include_once 'transacc/transac.php';
                                        break;
                                    case 211:
                                        include_once 'transacc/nueva_transac.php';
                                        break;                                    
                                    case 212:
                                        include_once 'transacc/ver_trans.php';
                                        break;
                                    case 213:
                                        include_once 'transacc/edit_transac.php';
                                        break;
                                    case 22:
                                        include_once 'data/credito_prv.php';
                                        break;
                                    case 23:
                                        include_once 'cobros/cobros.php'; 
                                        break;
                                    case 231:
                                        include_once 'cobros/detall.php';
                                        break;
                                    case 232:
                                        include_once 'transacc/pagacre.php';
                                        break;
                                    case 233:
                                        include_once 'transacc/abonocre.php';
                                        break;
                                    case 24:
                                        include_once 'pagos/otrospagos.php';
                                        break;
                                    case 242:
                                        include_once 'pagos/detallotrospagos.php';
                                        break; 
                                    case 243:
                                        include_once 'transacc/abonocre.php';
                                        break; 
                                    case 244:
                                        include_once 'transacc/verabono.php';
                                        break;
                                    case 25:
                                        include_once 'transacc/list_docum.php';  
                                        break; 
                                    case 26:
                                        include_once 'transacc/ver_trans.php';
                                        break;
                                    case 27:
                                        include_once 'data/cartera.php';
                                        break;
                                    case 31:
                                        include_once 'data/manempre.php';
                                        break;
                                    case 35:
                                        include_once 'data/manreg.php';
                                        break;
                                    case 41:
                                        include_once 'data/manmar.php';
                                        break;
                                    case 42:
                                        include_once 'data/manmod.php';
                                        break;
                                    case 43:
                                        include_once 'data/mantipo.php';
                                        break;
                                    case 44:
                                        include_once 'data/manlugar.php';
                                        break;
                                    case 45:
                                        include_once 'data/manint.php';
                                    default:
                                        break;                                    
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <!--<script src="js/jquery-1.11.0.js"></script>-->
        <!-- Bootstrap Core JavaScript -->
        <!--<script src="js/bootstrap.min.js"></script>-->
        <!-- Metis Menu Plugin JavaScript -->
        <!--<script src="js/plugins/metisMenu/metisMenu.min.js"></script>-->
        <!-- Morris Charts JavaScript -->
        <!--<script src="js/plugins/morris/raphael.min.js"></script>-->
        <!--<script src="js/plugins/morris/morris.min.js"></script>-->
<!--        <script src="js/plugins/morris/morris-data.js"></script>-->
        <!-- Custom Theme JavaScript -->
        <!--<script src="js/sb-admin-2.js"></script>-->
        <!--<script src="js/js.js"></script>-->
        <!-- Modal -->
<!--        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
                <div class="modal-body" id="caja">

              </div>
            </div>
          </div>
        </div>-->
    </body>

</html>
