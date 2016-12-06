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
                     if (isset($_POST['delete_pay'])) {
                      echo "<script>alert('boton')</script>";
                    }
                    ?>

                    <?Php include_once('cont_tabs.php'); ?> 

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
<script type="text/javascript">
  function confirma_delet(carpeta,monto,pago,tipodelete,mensaje){
    var answer = confirm(mensaje);                    
    if (answer) {
      $.post("./script/trsdlt_pay.php", {"carpeta": carpeta,"monto": monto,"pago": pago,"tipodelete":tipodelete},
        function (respuestag) {
         alert(respuestag);
       });
    } 
  }
</script>

</body>
</html>
