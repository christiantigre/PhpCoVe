<?php
if(!isset($_SESSION)){
  session_start();
}
if(isset($_REQUEST['vertrans'])){
  $codigo = $_REQUEST['vertrans'];
}else{
  $idtran_cab=$_POST['codigo'];
  $codigo = $idtran_cab;
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
  <title>Control Parqueadero - </title>
</head>
<body>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          EDITAR TRANSACCION
        </div>        
        <div class="panel-body" style="font-size: 9px">
          <div class="table-responsive">
            <form method="POST" id="form" name="form" action="inicio.php">
              <input type="hidden" name="codigo" id="codigo" value="<?Php echo $codigo; ?>">
              <div class="panel-body">
                <center>
                  <div class="col-lg-12">
                    <div class="col-lg-12">
                      <?php
                      include_once 'class/transacc.php';
                      $objtrs = new Transacc();
                      $objtrs->conec_base();
                      $objtrs->ver_trans($codigo);

                      if(($GLOBALS['trans'])=='INGRESO'){
                        ?>
                        <!--            <a href='../../PhpCoVe/documentos/compras/1_cont_comis.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE COMISION" /></a>-->
                        <a href='../../PhpCoVe/documentos/compras/ven_comi.php?numtrs=<?php echo $codigo; ?>&benef=<?php ?>' target="_blank"><input type="button" value="COMISION" /></a>                        
                        &nbsp; &nbsp;
                        <a href='../../PhpCoVe/documentos/compras/ven_cons.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONSIGNACION" /></a>                        
                        &nbsp; &nbsp;
                        <a href='../../PhpCoVe/documentos/compras/2_con_com_ven.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE COMPRA" /></a>
                        &nbsp;&nbsp;
                        <a href='../../PhpCoVe/documentos/compras/3_ing_veh.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="INGRESO DE VEHICULO" /></a>
                        &nbsp;&nbsp;
                        <a href='../../PhpCoVe/documentos/compras/4_rec_impr.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="RECEPCION DE IMPRONTAS" /></a>
                        &nbsp;&nbsp;                           
                        <hr><br>  

                        <?php
                      }
                      if(($GLOBALS['trans'])=='EGRESO'){
                        ?>

                        <a href='../../PhpCoVe/documentos/ventas/1_con_ven.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="CONTRATO DE VENTA" /></a>
                        &nbsp;&nbsp;
                        <a href='../../PhpCoVe/documentos/ventas/2_egr_veh.php?numtrs=<?php echo $codigo; ?>' target="_blank"><input type="button" value="EGRESO DE VEHICULO" /></a>
                        &nbsp;&nbsp;               
                        <hr><br> 

                      </div>  
                      <div class="col-lg-12">   
                       <?php
                     }        
                     include_once 'class/vehiculo.php';
                     $objveh = new Vehiculo();
                     $objveh->conec_base();
                     $objveh->buscar_veh_com($GLOBALS['placa']);
                     ?>
                     <hr><br>
                     <?php
                     include_once 'class/cliente.php';
                     $objcli = new Cliente();
                     $objcli->conec_base();
                     $objcli->buscar_cliente_com($GLOBALS['cliente']);
                     ?>  
                   </div>
                   <div class="col-lg-12" id="divtrs">
                     <?Php
                     /*if (isset($_POST['delete_pay'])) {
                      include_once('cont_tabs.php');
                    }else{ 
                    }*/
                    include_once('cont_tabs.php'); 
                    ?> 

                  </div>
                  <!--<input type="reset" value="CANCELAR">-->
                  <input type="submit" name="transac" value="REGRESAR"> 
                </div>
              </center>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
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

<!--Valida si es numerico-->
<script type="text/javascript" src="js/validanumericos/jquery.numeric.js"></script>
<script type="text/javascript">
  function confirma_delet(carpeta,monto,pago,tipodelete,mensaje){
    var answer = confirm(mensaje);                    
    if (answer) {
      $.post("./script/trsdlt_pay.php", {"carpeta": carpeta,"monto": monto,"pago": pago,"tipodelete":tipodelete},
        function (respuestag) {
         alert(respuestag);
         window.location.reload();
       });
    } 
  }
</script>
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
  
  function send_data(){
    var pago = $('#pago').val();
    var forma = $('#forma').val();
    var dcto = $('#dcto').val();
    var valor = $('#valor').val();
    var fecha_det = $('#fecha_det').val();
    var interes = $('#interes').val();
    var plazo = $('#plazo').val();
    var lststd = $('#lststd').val();        
    var observacion = $('#observacion').val();
    var tipotrs = $('#tipotrs').val();
    var trs = $('#trs').val();
    if(pago=='0'){
      alert('Porfavor seleccione el tipo de pago');
      $('#pago').focus();
    }else{
      if(forma=='0'){
        alert('Porfavor seleccione la forma de pago');
        $('#forma').focus();
      }else{
        if(valor==""){
          alert('Porfavor ingrese  un valor'); 
          $('#valor').focus();                         
        }else{
         if(lststd==""){
          alert('Porfavor seleccione un estado'); 
          $('#lststd').focus();                         
        }else{
          $.post("./script/edit_trs.php", {"pago": pago,"forma": forma,"dcto":dcto,"valor":valor,"fecha_det":fecha_det,"interes":interes,"plazo":plazo,"lststd":lststd,"observacion":observacion,"tipotrs":tipotrs,"trs":trs},
            function (respuestag) {
              alert(respuestag);
            });                    
          window.location.reload();
        }
      }
    }
  }
}

$(document).ready(function(){
  $('#valor').numeric(","); 
  $('#plazo').numeric(","); 
});
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <form action="inicio.php" name="formu" id="formu" method="POST" role="form-inline">
      
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Nuevo Pago</h4>
      </div>
      <div class="modal-body">
       <div class="container-fluid bd-example-row">
         <div class="row">
          <div class="col-md-12 col-md-offset-8">
           <label>Transacci&oacute;n tipo :</label>
           <input type="hidden" id="tipotrs" name="tipotrs" value="<?php echo $GLOBALS['trans']; ?>"/>
           <input type="hidden" id="trs" name="trs" value="<?php echo $codigo ?>"/>
           
           <?php
           echo $GLOBALS['trans'];
           ?>
         </div>
       </div>
       <div class="col-md-12">
        <div class="col-md-4">
          <label>Pago :</label>
          <select name="pago" id="pago" class="form-control input-sm">     
           <option value="0">Selecci&oacute;ne </option>
           <option value="ENTRADA">ENTRADA</option>
           <option value="ADICIONAL">ADICIONAL</option>
           <option value="CREDITO">CREDITO</option>   
         </select>
       </div>
       <div class="col-md-4">
        <label>Forma :</label>
        <select name="forma" id="forma" class="form-control input-sm">    
          <option value="EFECTIVO">Selecci&oacute;ne</option>
        </select>
      </div>
      <div class="col-md-4">
        <label>Documento :</label>
        <input type="text" id="dcto" name="dcto" onchange="contts();" list="cta" autocomplete="off" class="form-control input-sm"/>
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
                <optgroup label="ingresos" >
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
                <optgroup label="cajas">
                  <?php
                  $c = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass'], 'condata');
                  $query = "select * from t_plan_de_cuentas where cod_cuenta='1.1.1.1.'";
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
              </div>

              <div class="col-md-3">
                <label>Valor :</label>
                <input type="text" id="valor" name="valor" placeholder="0,00" class="form-control input-sm">
              </div>
              <div class="col-md-4">
                <label>Fecha transacci&oacute;n :</label>
                <input type="text" id="fecha_det" name="fecha_det" value="<?Php echo date("Y-m-d"); ?>" readonly="readonly" class="form-control input-sm">
              </div>
              <div class="col-md-3">
                <label>Interes :</label>
                <select name="interes" id="interes" size="0" class="form-control input-sm">
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
                </div>
                <div class="col-md-3">
                  <label>Plazo dias :</label>
                  <input type="text" id="plazo" name="plazo" placeholder="0" class="form-control input-sm">
                </div> 
                <div class="col-md-4">
                  <label>Estado :</label>
                  <select id="lststd" id="lststd" name="lststd" width="60" class="form-control input-sm">
                    <option value=""></option>
                    <option value="PENDIENTE">PENDIENTE</option>
                    <option value="PAGADO">PAGADO</option>
                  </select>
                </div>        
                <div class="col-md-4">
                  <label>Observaci&oacute;n :</label>
                  <textarea class="form-control input-sm" id="observacion" name="observacion" rows="5" id="comment" maxlength="200"></textarea>
                </div>        
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary" onclick="send_data();">Guardar</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</body>
</html>
