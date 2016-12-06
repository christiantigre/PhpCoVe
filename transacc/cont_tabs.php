
<form id="frmpagos" name="frmpagos" method="post" action="edit_transac.php">

 <br/>
 <h1>PAGOS</h1>
 <div class="col-lg-6"> 
   <div class="form-group">
     <div class="btn-group btn-group-xs" role="group" aria-label="...">
      <button type="button" id="btn-trash" name="btn-trash" class="btn btn-warning" onclick='confirma_delet(<?Php echo $codigo; ?>,<?Php echo $monto=0; ?>,<?Php echo $pago=0; ?>,<?Php echo $tipodelete=2; ?>,<?Php echo $mensaje='"Esta seguro que desea eliminar los pagos?"'; ?>);'>Vaciar pagos</button>
      <button type="button" class="btn btn-primary" onclick="javascript:recargar();">Agregar Pago</button>
    </div>
    <br/>
  </div>
</div>
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
    <tr rol="row">
      <th>Carpeta</th>
      <th>Pago</th>
      <th>Forma</th>
      <th>Documento</th>
      <th>Valor</th>
      <th>Interes</th>
      <th>Plazo</th>
      <th>Estado</th>
      <th>Observación</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include_once 'class/trandetalle.php';
    $objtrs = new Trandetalle();
    $objtrs->conec_base();
    $objtrs->edit_detalle_transac($codigo);
    ?>
  </tbody>
</table>        
</div>

<div class="col-lg-12">                             
  <hr/>
  <h1>CREDITOS</h1>
  <input type="button" name="liquidar" id="liquidar" value="LIQUIDAR"/>
  <hr/>
  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
      <tr rol="row">
        <th>Pago</th>
        <th>Fecha Pago</th>
        <th>Pagado el</th>
        <th>Valor</th>
        <th>Interes</th>
        <th>Capital</th>
        <!--<th>Saldo</th>-->
        <th>Abono</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>                                            
      <?php
      include_once 'class/trancredito.php';
      $objcre = new Trancredito();
      $objcre->conec_base();
      $objcre->ver_creditos($codigo);
      ?>
    </tbody>
  </table>             
  <br><br>
</div>

</form>