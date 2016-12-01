<?php
session_start();
$carpeta = $_GET['carpeta'];
$monto = $_GET['monto'];
$id = $_GET['id'];
$tipo = $_GET['tipo'];
if ($tipo=="ENTRADA") {
	?>
	<fieldset>
		<h3></h3>
		<div class="row">
			<form role="form" method="POST" name="add_veh_form" id="add_veh_form">
				<div class="col-lg-12">
					<?Php
					include_once '../class/trandetalle.php';
					$conn = new Trandetalle();
					$conn->conec_base();
					$conn->entrada_temporal_where($carpeta,$monto,$id);
					?>
				</div>
				<div class="col-lg-8">
					<div class="form-group">
						<br><br>
						<input type="button" onclick="excel(this.id);" class="btn btn-success" name="ex_morti_exc" id="ex_morti_exc"  value="EXCEL">&nbsp;
						<input type="button" onclick="pdf(this.id);" class="btn btn-danger" name="ex_morti_pdf" id="ex_morti_pdf"  value="PDF">&nbsp;
					</div>
				</div>
			</form>
		</div>
	</fieldset>
	<?PHP
}elseif($tipo=="ADICIONAL"){
	?>
	<fieldset>
		<h3></h3>
		<div class="row">
			<form role="form" method="POST" name="add_veh_form" id="add_veh_form">
				<div class="col-lg-12">
					<?Php
					include_once '../class/trandetalle.php';
					$conn = new Trandetalle();
					$conn->conec_base();
					$conn->adicional_temporal_where($carpeta,$monto,$id);
					?>
				</div>
				<div class="col-lg-8">
					<div class="form-group">
						<br><br>
						<input type="button" onclick="excel(this.id);" class="btn btn-success" name="ex_morti_exc" id="ex_morti_exc"  value="EXCEL">&nbsp;
						<input type="button" onclick="pdf(this.id);" class="btn btn-danger" name="ex_morti_pdf" id="ex_morti_pdf"  value="PDF">&nbsp;
					</div>
				</div>
			</form>
		</div>
	</fieldset>
	<?Php
}elseif($tipo=="CREDITO"){
	?>
	<fieldset>
		<h3></h3>
		<div class="row">
			<form role="form" method="POST" name="add_veh_form" id="add_veh_form">
				<div class="col-lg-12">
					<?Php
					include_once '../class/trandetalle.php';
					$conn = new Trandetalle();
					$conn->conec_base();
					$conn->credit_temporal_where($carpeta,$monto,$id);
					?>
				</div>
				<div class="col-lg-8">
					<div class="form-group">
						<br><br>
						<input type="button" onclick="excel(this.id);" class="btn btn-success" name="ex_morti_exc" id="ex_morti_exc"  value="EXCEL">&nbsp;
						<input type="button" onclick="pdf(this.id);" class="btn btn-danger" name="ex_morti_pdf" id="ex_morti_pdf"  value="PDF">&nbsp;
					</div>
				</div>
			</form>
		</div>
	</fieldset>
	<?Php
}
?>
