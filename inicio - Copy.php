<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'class/registro.php';
$objreg = new Registro();
//MENU PRINCIPAL
$menu = 0;
if (isset($_POST['mantenimientos'])) {
    $mensaje = $_SESSION['user'] . " /entro en mantenimientos";
    $objreg->registrar($mensaje);
    $menu = 1;
}
if (isset($_POST['transacciones'])) {
    $mensaje = $_SESSION['user'] . " /entro en transacciones";
    $objreg->registrar($mensaje);
    $menu = 2;
}
if (isset($_POST['administracion'])) {
    $mensaje = $_SESSION['user'] . " /entro en administracion";
    $objreg->registrar($mensaje);
    $menu = 3;
}
if (isset($_POST['parametros'])) {
    $mensaje = $_SESSION['user'] . " /entro en parametros";
    $objreg->registrar($mensaje);
    $menu = 4;
}
If (isset($_POST['cerrar_sesion'])) {
    $mensaje = $_SESSION['user'] . " /cerro sesion correctamente";
    $objreg->registrar($mensaje);
    include_once 'class/sesion.php';
    $objcerrar = new Sesion('*', '*');
    $objcerrar->cerrar_sesion();
    header("location:index.php");
}
//MENU MANTENIMIENTOS
if (isset($_POST['vehiculos'])) {
    $mensaje = $_SESSION['user'] . " /entro en mantenimiento de vehiculos";
    $objreg->registrar($mensaje);
    $menu = 11;
}
if (isset($_POST['clientes'])) {
    $mensaje = $_SESSION['user'] . " /entro en mantenimiento de clientes";
    $objreg->registrar($mensaje);
    $menu = 12;
}
if (isset($_POST['salir_mante'])) {
    $mensaje = $_SESSION['user'] . " /salio de mantenimientos";
    $objreg->registrar($mensaje);
    $menu = 1;
}
//menu transacciones
if (isset($_POST['transac'])) {
    $mensaje = $_SESSION['user'] . " /entro a visualizar transacciones";
    $objreg->registrar($mensaje);
    $menu = 21;
}
if (isset($_POST['btn_val'])) {
    $menu = 211;
}
if (isset($_POST['btn_reg_veh'])) {
    $menu = 211;
}
if (isset($_POST['cont_comis'])) {
    $menu = 25;
}
if (isset($_POST['documentos'])) {
    $mensaje = $_SESSION['user'] . " /entro a documentos";
    $objreg->registrar($mensaje);
    $menu = 24;
}
if (isset($_POST['salir_tran'])) {
    $mensaje = $_SESSION['user'] . " /salio de transacciones";
    $objreg->registrar($mensaje);
    $menu = 2;
}
if (isset($_POST['sal_doc'])) {
    $mensaje = $_SESSION['user'] . " /salio de documentos";
    $objreg->registrar($mensaje);
    $menu = 2;
}
if (isset($_POST['reg_veh'])) {
    $mensaje = $_SESSION['user'] . " /ingreso a registrar vehiculo";
    $objreg->registrar($mensaje);
    $menu = 111;
}
if (isset($_POST['reg_cli'])) {
    $mensaje = $_SESSION['user'] . " /ingreso a registrar cliente";
    $objreg->registrar($mensaje);
    $menu = 121;
}
if (isset($_POST['hstveh'])) {
    $mensaje = $_SESSION['user'] . " /ingreso a detalle de gastos de vehiculo";
    $objreg->registrar($mensaje);
    $key = $_POST['hstveh'];
    $menu = 2212;
}

//menu cobros
if (isset($_POST['cobros'])) {
    $mensaje = $_SESSION['user'] . " /ingreso a cobros";
    $objreg->registrar($mensaje);
    $menu = 221;
}
if (isset($_POST['transac_cob'])) {
    $mensaje = $_SESSION['user'] . " /salio de cobros";
    $objreg->registrar($mensaje);
    $menu = 2;
}
if (isset($_POST['buscar_cobcar']) or isset($_POST['txt_carpeta'])) {
    $menu = 221;
}
if (isset($_POST['buscar_cobcli']) or isset($_POST['txt_idcli'])) {
    $menu = 221;
}
if (isset($_POST['buscar_cobveh']) or isset($_POST['txt_idveh'])) {
    $menu = 221;
}
if (isset($_POST['buscar_pagcar']) or isset($_POST['txt_carpetapag'])) {
    $menu = 232;
}
if (isset($_POST['buscar_pagcli']) or isset($_POST['txt_idclipag'])) {
    $menu = 232;
}
if (isset($_POST['buscar_pagveh']) or isset($_POST['txt_idvehpag'])) {
    $menu = 232;
}
//para cobros
if (isset($_POST['pagacre'])) {
    $numcre = strstr($_POST['pagacre'], '-', true);
    $numsec = substr(strstr($_POST['pagacre'], '-'), 1);
    $menu = 23;
}
//registra abono
if (isset($_POST['abonocre'])) {
    $numcre = strstr($_POST['abonocre'], '-', true);
    $numsec = substr(strstr($_POST['abonocre'], '-'), 1);
    $menu = 244;
}
//ver abonos
if (isset($_POST['verabono'])) {
    $numcre = strstr($_POST['verabono'], '-', true);
    $numsec = substr(strstr($_POST['verabono'], '-'), 1);
    $mensaje = $_SESSION['user'] . " /Ingreso a ver abono";
    $objreg->registrar($mensaje);
    $menu = 245;
}

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
    $menu = 231;
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
    $menu = 22;
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
    $menu = 231;
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
if (isset($_POST['transacvolver'])) {
    $menu = 2;
}
if (isset($_POST['regresarapag'])) {
    $menu = 2334;
}
if (isset($_POST['regresarapagos'])) {
    $menu = 232;
}
if (isset($_POST['verpagootros'])) {
    $verpagootros = $_POST['verpagootros'];
    $menu = 2335;
}
if (isset($_POST['otrospag'])) {
    $menu = 2334;
}
if (isset($_POST['verptpag'])) {
    global $cuentatxt;
    $cuentatxt = $_REQUEST['cuentatxt'];
    $menu = 2334;
}
if (isset($_REQUEST['verpagos'])) {
    $menu = 2334;
}
if (isset($_POST['bpago'])) {
    $bpagot = $_POST['bpagot'];
    $bmonto = $_POST['bmonto'];
    $menu = 2334;
}
if (isset($_POST['impcomprobantepagotros'])) {
    $idhei = $_POST['idhei'];
    echo '<script>window.open("imp/impcomppagotr.php?s/&slide=1&show=09&load=555&data=8&idhei=' . $idhei . '&file=3&&datatipdata=09end=79&datpag=4534&obv=97&prm=xt4&new=65")</script>';
    $menu = 2335;
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
    $menu = 2335;
}
//para pagos
if (isset($_POST['pagos'])) {
    $mensaje = $_SESSION['user'] . " /ingreso a pagos";
    $objreg->registrar($mensaje);
//    $numcre = strstr($_POST['pagacre'], '-', true);
//    $numsec = substr(strstr($_POST['pagacre'], '-'), 1);
    $menu = 232;
}
if (isset($_POST['vertrspag'])) {
    $codigo = $_POST['vertrspag'];
    $menu = 2332;
}
if (isset($_POST['detpag'])) {
    $numcre = strstr($_POST['detpag'], '-', true);
    $numsec = substr(strstr($_POST['detpag'], '-'), 1);
    $menu = 2331;
}
//MENU ADMINISTRACION
if (isset($_POST['empresa'])) {
    $mensaje = $_SESSION['user'] . " /entro en mantenimiento de empresa";
    $objreg->registrar($mensaje);
    $menu = 31;
}
if (isset($_POST['usuario'])) {
    $mensaje = $_SESSION['user'] . " /entro mantenimiento de usuarios";
    $objreg->registrar($mensaje);
    $menu = 32;
}
if (isset($_POST['nuevo_usuario'])) {
    $menu = 321;
}
if (isset($_POST['inserta_usuario'])) {
    if (($_POST['clave']) == ($_POST['reclave'])) {
        include_once 'class/usuario.php';
        $objuser = new Usuario();
        $objuser->conec_base();
        $objuser->inserta_usua($_POST['usuario'], $_POST['clave']);
        $mensaje = $_SESSION['user'] . " /creo el usuario" . $_POST['usuario'];
        $objreg->registrar($mensaje);
        $menu = 32;
    } else {
        echo "<script> alert('Valores mal ingresados') </script>";
        $menu = 321;
    }
}
if (isset($_POST['veruser'])) {

    $menu = 321;
}
if (isset($_POST['salir_usuario'])) {
    $mensaje = $_SESSION['user'] . " /salio de mantenimiento de usuarios";
    $objreg->registrar($mensaje);
    $menu = 32;
}
if (isset($_POST['registro'])) {
    $mensaje = $_SESSION['user'] . " /entro a visualizar el historial";
    $objreg->registrar($mensaje);
    $menu = 33;
}
if (isset($_POST['salir_admin'])) {
    $mensaje = $_SESSION['user'] . " /salio de administracion";
    $objreg->registrar($mensaje);
    $menu = 3;
}
if (isset($_POST['ver_reg'])) {
    $menu = 33;
}
//MENU PARAMETROS
if (isset($_POST['nuevo_vehiculo'])) {
    $menu = 41;
}
if (isset($_POST['nueva_marca'])) {
    $menu = 41;
}
if (isset($_POST['nuevo_modelo'])) {
    $menu = 42;
}
if (isset($_POST['nuevo_tipo'])) {
    $menu = 43;
}
if (isset($_POST['nuevo_lugar'])) {
    $menu = 44;
}
if (isset($_POST['salir_para'])) {
    $menu = 4;
}
if (isset($_POST['transac_cob'])) {
    $menu = 21;
}
if (isset($_POST['prm_fn'])) {
    $menu = 2222;
}
if (isset($_POST['prm_iva'])) {
//    echo "<script>alert('iva')</script>";
    $menu = 2223;
}
//MANTENIMIENTOS ACCIONES
if (isset($_POST['nuevo_veh'])) {
    $menu = 111;
}
if (isset($_POST['nuevo_cli'])) {
    $menu = 121;
}
if (isset($_POST['nuevo_trs'])) {
    $menu = 211;
}
if (isset($_POST['inserta_veh'])) {
    include_once 'class/vehiculo.php';
    $objveh = new Vehiculo();
    $objveh->conec_base();
//    $objveh->insertar_vehiculo($_POST['idveh_placa'], $_POST['veh_vehiculo'], $_POST['veh_anio'], $_POST['veh_color1'], $_POST['veh_color2'], $_POST['veh_motor'], $_POST['veh_chasis'], $_POST['veh_km'], $_POST['veh_mat_lugar'], $_POST['veh_mat_anio'], $_POST['veh_estado']);
    if ($objveh->insertar_vehiculo($_POST['idveh_placa'], $_POST['veh_vehiculo'], $_POST['veh_anio'], $_POST['veh_color1'], $_POST['veh_color2'], $_POST['veh_motor'], $_POST['veh_chasis'], $_POST['veh_km'], $_POST['veh_mat_lugar'], $_POST['veh_mat_anio'], $_POST['veh_estado']) == true) {
        $mensaje = $_SESSION['user'] . " /creo el vehiculo " . $_POST['idveh_placa'];
        $objreg->registrar($mensaje);
        include_once 'class/modelo.php';
        $objmod = new Modelo();
        $objmod->conec_base();
        $modelo = $objmod->modelo_cuenta($_POST['idveh_placa']);
        include_once 'class/contabilidad.php';
        $objcont = new contabilidad();
        $objcont->conec_base();
//    $datovehiculo = $_POST['veh_vehiculo'];
        $objcont->crear_cta_veh($modelo, $_POST['idveh_placa']);
        $mensaje = $_SESSION['user'] . " /creo cuenta contable del vehiculo " . $_POST['idveh_placa'];
        $objreg->registrar($mensaje);
        $menu = 111;
        echo "<script>alert('Nuevo vehiculo registrado')</script>";
    } else {
        echo "<script>alert('No se pudo registrar el vehiculo')</script>";
        $menu = 111;
    }
}
if (isset($_REQUEST['inserta_veh_reg'])) {
    include_once 'class/vehiculo.php';
    $objveh = new Vehiculo();
    $objveh->conec_base();
    if ($objveh->insertar_vehiculo($_REQUEST['idveh_placa'], $_REQUEST['veh_vehiculo'], $_REQUEST['veh_anio'], $_REQUEST['veh_color1'], $_REQUEST['veh_color2'], $_REQUEST['veh_motor'], $_REQUEST['veh_chasis'], $_REQUEST['veh_km'], $_REQUEST['veh_mat_lugar'], $_REQUEST['veh_mat_anio'], $_REQUEST['veh_estado']) == true) {
        $mensaje = $_SESSION['user'] . " /creo el vehiculo " . $_REQUEST['idveh_placa'];
        $objreg->registrar($mensaje);
        include_once 'class/modelo.php';
        $objmod = new Modelo();
        $objmod->conec_base();
        $modelo = $objmod->modelo_cuenta($_REQUEST['idveh_placa']);

        include_once 'class/contabilidad.php';
        $objcont = new contabilidad();
        $objcont->conec_base();
        $objcont->crear_cta_veh($modelo, $_REQUEST['idveh_placa']);
        $mensaje = $_SESSION['user'] . " /creo cuenta contable del vehiculo " . $_REQUEST['idveh_placa'];
        $objreg->registrar($mensaje);
        echo "<script>alert('Nuevo vehiculo registrado')</script>";
        $menu = 21;
    } else {
        echo "<script>alert('No se pudo registrar el vehiculo')</script>";
        $menu = 21;
    }
}

if (isset($_POST['modif_veh'])) {
    include_once 'class/vehiculo.php';
    $objveh = new Vehiculo();
    $objveh->conec_base();

    $objveh->modifica_vehiculo($_POST['idveh_placa'], $_POST['veh_km'], $_POST['veh_mat_lugar'], $_POST['veh_mat_anio'], $_POST['veh_anio'], $_POST['veh_chasis'], $_POST['veh_motor'], $_POST['veh_color1'], $_POST['veh_color2'], $_POST['estado_a'], $_POST['estado1'], $_POST['estado2'], $_POST['estado3'], $_POST['estado4'], $_POST['estado5'], $_POST['estado6'], $_POST['estado7'], $_POST['estado8'], $_POST['estado9'], $_POST['estado10'], $_POST['estado11'], $_POST['estado12'], $_POST['estado13']);
    print "<script>alert('Actualizado correctamente')</script>";
    $mensaje = $_SESSION['user'] . " /actualizó datos vehículo " . $_POST['idveh_placa'];
    $objreg->registrar($mensaje);
    $menu = 11;
}
if (isset($_POST['agrega_docu'])) {
    include_once 'class/vehiculo.php';
    $objveh = new Vehiculo();
    $objveh->conec_base();
    $objveh->agrega_dcto($_POST['idveh_placa'], $_POST['nue_dcto']);
    $menu = 11;
}
if (isset($_POST['insertar_cliente'])) {
    include_once 'class/cliente.php';
    $objcli = new Cliente();
    $objcli->conec_base();
//    $objcli->insertar_cliente($_POST['idcli_ident'], $_POST['cli_nombre'], $_POST['cli_apellido'], $_POST['cli_dir_casa'], $_POST['cli_dir_tra'], $_POST['cli_tel_fijos'], $_POST['cli_tel_cel'], $_POST['cli_correo'], $_POST['cli_ciudad'], $_POST['cli_nom_ref'], $_POST['cli_dir_ref'], $_POST['cli_tel_ref'], $_POST['cli_est_civ'], $_POST['cli_conyuge']);
    if ($objcli->insertar_cliente($_POST['idcli_ident'], $_POST['cli_nombre'], $_POST['cli_apellido'],
            $_POST['cli_dir_casa'], $_POST['cli_dir_tra'], $_POST['cli_tel_fijos'], $_POST['cli_tel_cel'], $_POST['cli_correo'],
            $_POST['cli_ciudad'], $_POST['cli_nom_ref'], $_POST['cli_dir_ref'], $_POST['cli_tel_ref'], $_POST['cli_est_civ'],
            $_POST['cli_conyuge'],$_POST['ced_conyuge']) == true) {
        $mensaje = $_SESSION['user'] . " /creo el cliente " . $_POST['idcli_ident'];
        $objreg->registrar($mensaje);
        include_once 'class/contabilidad.php';
        $objcont = new contabilidad();
        $objcont->conec_base();
        $datocliente = $_POST['cli_apellido'] . " " . $_POST['cli_nombre'];
        $objcont->crear_cta_clte($datocliente, $_POST['idcli_ident']);
        $mensaje = $_SESSION['user'] . " /creo cuenta contable del cliente " . $_POST['idcli_ident'];
        $objreg->registrar($mensaje);
        echo "<script>alert('Nuevo cliente registrado con exito')</script>";
        $menu = 121;
    } else {
        echo "<script>alert('No se pudo registrar el cliente')</script>";
        $menu = 121;
    }
}
if (isset($_POST['mod_cliente'])) {
    include_once 'class/cliente.php';
    $objcli = new Cliente();
    $objcli->conec_base();
    $objcli->modifica_cliente($_POST['cli_nombre'], $_POST['cli_apellidos'], $_POST['idcli_ident'], 
            $_POST['cli_dir_casa'], $_POST['cli_dir_tra'], $_POST['cli_tel_fijos'], $_POST['cli_tel_cel'],
            $_POST['cli_correo'], $_POST['cli_nom_ref'], $_POST['cli_dir_ref'], $_POST['cli_tel_ref'], 
            $_POST['cli_est_civ'], $_POST['cli_conyuge'],$_POST['ced_conyuge']);
    $mensaje = $_SESSION['user'] . " /editó datos cliente " . $_REQUEST['idcli_ident'];
        $objreg->registrar($mensaje);
    $menu = 12;    
}
//TRANSACCIONES ACCIONES
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
    $menu = 21;
}


if (isset($_POST['elidat'])) {
    $numeli = strstr($_POST['elidat'], '-', true);
    $numelides = substr(strstr($_POST['elidat'], '-'), 1);
    include_once 'class/contabilidad.php';
    $objcont = new contabilidad();
    $objcont->eliminarfila($numeli);
    $menu = 211;
}
if (isset($_POST['inserta_empresa'])) {
    include_once 'class/datempre.php';
    $objempre = new Empresa();
    $objempre->regempresa($_POST['razon'], $_POST['propietario'], $_POST['gerente'], $_POST['direccion'], $_POST['telefono'], $_POST['email'], $_POST['webpage']);
    $menu = 31;
}
if (isset($_POST['vertrs'])) {
    $codigo = $_POST['vertrs'];
    $menu = 22;
}
if (isset($_POST['verveh'])) {
    $placa = $_POST['verveh'];
    $menu = 1111;
}
if (isset($_POST['vercli'])) {
    $cedula = $_POST['vercli'];
    $menu = 122;
}
//PARAMETROS ACCIONES
if (isset($_POST['insertar_marca'])) {
    if (isset($_POST['marca']) !== "") {
        include_once 'class/marca.php';
        $objmarca = new Marca();
        $objmarca->conec_base();
        $objmarca->guardar_marca($_POST['marca']);
    } else {
        echo"<script> alert('Debe llenar el campo') </script>";
    }
    $menu = 41;
}
if (isset($_POST['insertar_modelo'])) {
    include_once 'class/modelo.php';
    $objmarca = new Modelo();
    $objmarca->conec_base();
    $objmarca->guardar_modelo($_POST['veh_marca'], $_POST['veh_modelo'], $_POST['veh_tipo']);
    $menu = 42;
}
if (isset($_POST['inserta_tipo'])) {
    include_once 'class/tipo.php';
    $objtipo = new Tipo($_POST['veh_tipo_des']);
    $objtipo->conec_base();
    $objtipo->insertar_tipo();
    $menu = 43;
}
if (isset($_POST['inserta_interes'])) {
    include_once 'class/soft_prm.php';
    $objtipo = new Interes($_POST['interes']);
    $objtipo->conec_base();
    $objtipo->insertar_interes();
    $menu = 2222;
}
if (isset($_POST['inserta_iva'])) {
    include_once 'class/ivaclass.php';
    $objtipo = new Iva($_POST['iva']);
    $objtipo->conec_base();
    $objtipo->insertar_iva();
    $menu = 2223;
}
if (isset($_POST['inserta_lugar'])) {
    include_once 'class/lugar.php';
    $objlugar = new Lugar($_POST['mat_lugar']);
    $objlugar->conec_base();
    $objlugar->insertar_lugar();
    $menu = 44;
}
if (isset($_POST['agregar_en'])) {
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
//            $pago = $_POST['forma'];
//            echo "<script>alert('.$pago.')</script>";
            $interes = $_POST['interes'];
            $objdetalle->inserta_detalle($_POST['idtran_cab'], $_POST['pago'], $_POST['forma'], $_POST['dcto'], $_POST['valor'], $_POST['fecha_det'], $_POST['interes'], $_POST['plazo'], $_POST['lststd'], $_POST['observacion']);
            $objcont->gen_ass_temp(array($_POST['pago'], $_POST['forma'], $_POST['dcto'], $_POST['valor'], $_POST['fecha_det'], $_POST['interes'],
                $_POST['plazo'], $_POST['lststd'], $_SESSION['user'], $_REQUEST['tipo'], $_POST['idtran_cab'], $_POST['tran_cli_ident'], $_POST['tran_veh_placas'], $_POST['total']));
        }
    }
    $menu = 211;
}
if (isset($_POST['resettemp'])) {
    include_once 'class/contabilidad.php';
    $objcont = new contabilidad();
    $objcont->vaciar_tab();
    $menu = 211;
}
//BUSQUEDAS
if (isset($_POST['buscar_veh']) or isset($_POST['listar_veh']) or isset($_POST['modifica_veh'])) {
    $menu = 11;
}
if (isset($_POST['buscar_veh_trs']) or isset($_POST['buscar_cli_com'])) {
    $menu = 211;
}
if (isset($_POST['buscar_cli']) or isset($_POST['listar_cli'])) {
    $menu = 12;
}
if (isset($_POST['buscar_com_trs']) or isset($_POST['listar_com_trs'])) {
    $menu = 21;
}
if (isset($_POST['buscar_ven_trs']) or isset($_POST['listar_ven_trs'])) {
    $menu = 22;
}
if (isset($_POST['buscar_doc_trs']) or isset($_POST['listar_doc_trs'])) {
    $menu = 24;
}
if (isset($_POST['nuevo_com_trs'])) {
    include_once 'class/trandetalle.php';
    $objdetalle = new Trandetalle();
    $objdetalle->limpia_detalles();
    include_once 'class/contabilidad.php';
    $objcont = new contabilidad();
    $objcont->vaciar_tab();
    $menu = 211;
}
//MODIFICACIONES
if (isset($_POST['modveh'])) {
    include_once 'class/vehiculo.php';
    $objvehiculo = new Vehiculo();
    $objvehiculo->conec_base();
    $objvehiculo->modifica_veh($_POST['idveh_placa']);
    $menu = 51;
}
?>
<!-- PAGINA PRINCIPAL DE APLICACION -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title> Compra / Venta </title>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <link rel="stylesheet" type="text/javascript" href="js/jquery-1.11.3.js">
    </head>
    <body>
        <header>
<?php
include_once 'cabecera.php';
?>
        </header>
        <!-- SECCION DE MENUS -->
<?php
switch ($menu) {
    case 0:
        ?>
                <h1>  MENU PRINCIPAL </h1>
                <?php
                if ($_SESSION['user'] == "root") {
                    ?>
                    <nav>
                        <form action="inicio.php" method="POST">
                            <input type="submit" name="mantenimientos" value="MANTENIMIENTOS">
                            <input type="submit" name="transacciones" value="TRANSACCIONES">
                            <input type="submit" name="administracion" value="ADMINISTRACION">
                            <input type="submit" name="parametros" value="PARAMETROS">
                            <input type="submit" name="cerrar_sesion" value="CERRAR SESION Y SALIR">
                        </form>
                    </nav>
            <?php
            break;
        } else {
            ?>
                    <nav>            
                        <form action="inicio.php" method="POST">
                            <input type="submit" name="mantenimientos" value="MANTENIMIENTOS">
                            <input type="submit" name="transacciones" value="TRANSACCIONES">
                            <input type="submit" name="parametros" value="PARAMETROS">
                            <input type="submit" name="cerrar_sesion" value="CERRAR SESION Y SALIR">
                        </form>
                    </nav>
            <?php
            break;
        }
    case 1:
        ?>
                <h1> MENU MANTENIMIENTOS </h1>
                <nav>
                    <form action="inicio.php" method="POST">
                        <input type="submit" name="vehiculos" value="VEHICULOS">
                        <input type="submit" name="clientes" value="CLIENTES">
                        <input type="submit" name="salir" value="SALIR">
                    </form>
                </nav>
        <?php
        break;
    case 2:
        ?>
                <h1> MENU TRANSACCIONES </h1>
                <nav>
                    <form action="inicio.php" method="POST">
                        <input type="submit" name="transac" value="TRANSACCION">
                        <input type="submit" name="cobros" value="COBROS">
                        <input type="submit" name="pagos" value="PAGOS">
                        <input type="submit" name="documentos" value="DOCUMENTOS">
                        <input type="submit" name="salir" value="SALIR">
                    </form>
                </nav>


                <br/>
            <center>
                <fieldset>
                    <p style="font-size:20px"><b>
                            <legend>COBROS POR VENCER</legend>
                        </b></p>
                    <center>
        <?php
        include_once '/class/trancredito.php';
        $objpago = new Trancredito();
        $objpago->conec_base();
        $objpago->carga_creditos_vencer();
        ?>
                    </center>
                </fieldset>
                <br/>
                <fieldset>
                    <p style="font-size:20px"><b>
                            <legend>COBROS VENCEN HOY</legend>
                        </b></p>
                    <center>
        <?php
        include_once '/class/trancredito.php';
        $objpago = new Trancredito();
        $objpago->conec_base();
        $objpago->carga_creditos_hoy();
        ?>
                    </center>
                </fieldset> 
                <br/>
                <fieldset>
                    <p style="font-size:20px"><b>
                            <legend>COBROS VENCIDOS</legend>
                        </b></p>
                    <center>
        <?php
        include_once '/class/trancredito.php';
        $objpago = new Trancredito();
        $objpago->conec_base();
        $objpago->carga_creditos_vencidos();
        ?>
                    </center>
                </fieldset> 
            </center>

        <?php
        break;
    case 3:
        ?>
            <h1> MENU ADMINISTRACION </h1>
            <nav>
                <form action="inicio.php" method="POST">
                    <input type="submit" name="empresa" value="EMPRESA">
                    <input type="submit" name="usuario" value="USUARIOS">
                    <input type="submit" name="registro" value="REGISTRO">
                    <input type="submit" name="salir" value="SALIR">
                </form>
            </nav>

        <?php
        break;
    case 39:
        ?>
            <h1> MENU USUARIO </h1>
            <nav>
                <form action="inicio.php" method="POST">
                    <input type="submit" name="usr_nuevo" value="NUEVO USUARIO">
                    <input type="submit" name="usr_clave" value="CAMBIO DE CLAVE">
                    <input type="submit" name="usr_permisos" value="CAMBIO DE PERMISOS">
                    <input type="submit" name="salir_usuario" value="SALIR">
                </form>
            </nav>
        <?php
        break;
    case 4:
        ?>
            <h1>  MENU PARAMETROS </h1>
            <nav>
                <form action="inicio.php" method="POST">
                    <input type="submit" name="nuevo_modelo" value="MODELOS">
                    <input type="submit" name="nueva_marca" value="MARCAS">
                    <input type="submit" name="nuevo_tipo" value="TIPOS">
                    <input type="submit" name="nuevo_lugar" value="LUGARES">
                    <input type="submit" name="prm_iva" value="IVA %">
                    <input type="submit" name="prm_fn" value="FINANCIAMIENTO">
                    <input type="submit" name="salir" value="SALIR">
                </form>
            </nav>
        <?php
        break;
//SECCION INTERFACES
    case 11:
        ?>
            <h1> MANTENIMIENTO VEHICULOS </h1>
            <section>
        <?php
        include_once 'data/manveh.php';
        ?>
            </section>
                <?php
                break;
            case 111:
                ?>
            <h1> NUEVO VEHICULO </h1>
            <section>
        <?php
        include_once 'data/addveh.php';
        ?>
            </section>
                <?php
                break;
            case 1111:
                ?>
            <h1> MODIFICAR VEHICULO </h1>
            <section>
        <?php
        include_once 'data/ver_veh.php';
        ?>
            </section>
                <?php
                break;
            case 12:
                ?>
            <h1> MANTENIMIENTO CLIENTE </h1>
            <section>
        <?php
        include_once 'data/mancli.php';
        ?>
            </section>
                <?php
                break;
            case 121:
                ?>
            <h1> NUEVO CLIENTE </h1>
            <section>
        <?php
        include_once 'data/addcli.php';
        ?>
            </section>
                <?php
                break;
            case 122:
                ?>
            <h1> MODIFICAR CLIENTES </h1>
            <section>
        <?php
        include_once 'data/ver_cli.php';
        ?>
            </section>
                <?php
                break;
            case 21:
                ?>
            <h1> TRANSACCIONES </h1>
            <section>
        <?php
        include_once 'transacc/transac.php';
        ?>
            </section>
                <?php
                break;
            case 22:
                ?>
            <h1> VER TRANSACCIONES </h1>
            <section>
        <?php
        include_once 'transacc/ver_trans.php';
        ?>
            </section>
                <?php
                break;
            case 2332:
                ?>
            <h1> VER TRANSACCIONES </h1>
            <section>
        <?php
        include_once 'transacc/ver_transpago.php';
        ?>
            </section>
                <?php
                break;
            case 2333:
                ?>
            <h1> DETALLE DE TRANSACCION</h1>
            <section>
        <?php
        include_once 'transacc/detallmovcob.php';
        ?>
            </section>
                <?php
                break;
            case 2334:
                ?>
            <h1> OTROS GASTOS </h1>
            <section>
        <?php
        include_once 'pagos/otrospagos.php';
        ?>
            </section>
                <?php
                break;
            case 2335:
                ?>

            <h1> DETALLE DE PAGO </h1>
            <section>
        <?php
        include_once 'pagos/detallotrospagos.php';
        ?>
            </section>
                <?php
                break;
            case 23:
                ?>
            <h1> PAGAR CREDITO </h1>
            <section>
        <?php
        include_once 'transacc/pagacre.php';
        ?>
            </section>
                <?php
                break;
            case 244:
                ?>
            <h1> ABONO CREDITO </h1>
            <section>
        <?php
        include_once 'transacc/abonocre.php';
        ?>
            </section>
                <?php
                break;
            case 245:
                ?>
            <h1> VER ABONO </h1>
            <section>
        <?php
        include_once 'transacc/verabono.php';
        ?>
            </section>
                <?php
                break;
            case 231:
                ?>
            <h1> DETALLE DE COBRO </h1>
            <section>
        <?php
        include_once 'cobros/detall.php';
        ?>
            </section>
                <?php
                break;
            case 232:
                ?>
            <h1> PAGOS </h1>
            <section>
        <?php
        include_once 'pagos/pagos.php';
        ?>
            </section>
                <?php
                break;
            case 233:
                ?>
            <h1> PAGOS POR REALIZAR </h1>
            <section>
        <?php
        include_once 'transacc/cobrocre.php';
        ?>
            </section>
                <?php
                break;
            case 2331:
                ?>
            <h1> DETALLE DE PAGO REALIZADO </h1>
            <section>
        <?php
        include_once 'pagos/detallpago.php';
        ?>
            </section>
                <?php
                break;
            case 24:
                ?>
            <h1> DOCUMENTOS </h1>
            <section>
        <?php
        include_once 'transacc/list_docum.php';
        ?>
            </section>
                <?php
                break;
            case 211:
                ?>
            <h2 class="page-header"> NUEVA TRANSACCION </h2>
            <section>
        <?php
        include_once 'transacc/nueva_transac.php';
        ?>
            </section>
                <?php
                break;
            case 31:
                ?>
            <h1> MANTENIMIENTO DE EMPRESA</h1>
            <section>
        <?php
        include_once 'data/manempre.php';
        ?>            
            </section>
                <?php
                break;
            case 32:
                ?>
            <h1> USUARIOS </h1>
            <section>
        <?php
        include_once 'data/manusua.php';
        ?>
            </section>
                <?php
                break;
            case 33:
                ?>
            <h1> REGISTRO </h1>
            <section>
        <?php
        include_once 'data/manreg.php';
        ?>
            </section>
                <?php
                break;
            case 321:
                ?>
            <h1> REGISTRO </h1>
            <section>
        <?php
        include_once 'data/adduser.php';
        ?>
            </section>
                <?php
                break;
            case 41:
                ?>
            <h1> MARCAS VEHICULOS </h1>
            <section>
        <?php
        include_once 'data/manmar.php';
        ?>
            </section>
                <?php
                break;
            case 42:
                ?>
            <h1> MODELOS POR MARCA </h1>
            <section>
        <?php
        include_once 'data/manmod.php';
        ?>
            </section>
                <?php
                break;
            case 43:
                ?>
            <h1> TIPOS DE VEHICULOS </h1>
            <section>
        <?php
        include_once 'data/mantipo.php';
        ?>
            </section>
                <?php
                break;
            case 44:
                ?>
            <h1> CIUDAD PARA MATRICULA </h1>
            <section>
        <?php
        include_once 'data/manlugar.php';
        ?>
            </section>
                <?php
                break;
            case 51:
                ?>
            <h1> MODIFICAR VEHICULO </h1>
            <section>
        <?php
        include_once 'data/modveh.php';
        ?>
            </section>
                <?php
                break;
            case 61:
                ?>
            <h1> COMPRA VEHICULO </h1>
            <section>
        <?php
        include_once 'data/transveh.php';
        ?>
            </section>
                <?php
                break;
            case 221;
                ?>
            <h1>COBROS</h1>
            <section>
        <?Php
        include_once 'cobros/cobros.php';
        ?>
            </section>
                <?php
                break;
//            default:
//                break;
            case 2212;
                ?>
            <h1>DETALLE DE GASTOS POR VEHICULO</h1>
            <section>
        <?Php
        include_once 'hsgastos/hsgastos.php';
        ?>
            </section>
                <?php
                break;
            case 2222;
                ?>
            <h1>FINANCIAMIENTO INTERES</h1>
            <section>
        <?Php
        include_once 'data/manint.php';
        ?>
            </section>
                <?php
                break;
            case 2223;
                ?>
            <h1>MANTENIMIENTO DE IVA %</h1>
            <section>
        <?Php
        include_once 'data/maniva.php';
        ?>
            </section>
                <?php
                break;

            default:
                break;
        }
        ?>
</body>
</html>
