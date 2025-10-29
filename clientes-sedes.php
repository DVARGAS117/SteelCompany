<?php
require('config/conexion.php');
require('config/inicializar-datos.php');
require('config/permisos.php');
?>
<!doctype html>
<html lang="en">

<head>

	<?php require("config/cabecera-web.php"); ?>
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- DataTables -->
	<link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	<!-- Responsive datatable examples -->
	<link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	<!-- Bootstrap Css -->
	<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

	<!-- Select 2 -->
	<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
	<!-- SweetAlert 2 -->
	<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
	<!-- Load -->
	<link href="assets/css/load.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

	<!-- <body data-layout="horizontal" data-topbar="dark"> -->

	<!-- Begin page -->
	<div id="layout-wrapper">
		<!-- ============================================================== -->
		<!-- ===================   CABECERA APP  ========================== -->
		<!-- ============================================================== -->
		<?php require("config/cabecera.php"); ?>
		<!-- ============================================================== -->
		<!-- ===================        MENU APP   ======================== -->
		<!-- ============================================================== -->
		<?php require("config/barra-navegacion.php"); ?>
		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content">
			<div id="load"></div>
			<div class="page-content">
				<div class="container-fluid">
					<!-- start page title -->
					<div class="row">
						<div class="col-12">
							<div class="page-title-box d-sm-flex align-items-center justify-content-between">
								<h4 class="mb-sm-0">Administrar Sedes</h4>
								<!-- **************************************** -->
								<div class="page-title-right">
									<div class="button-items">
										<?php
										if ($can_insert) {
										?>
											<button type="button" class="btn btn-primary waves-effect waves-light" onclick="LimpiarCampos_NuevaSede(); OpenCloseModal('mNuevaSede','o');">
												Nueva Sede <i class="ri-folder-add-fill align-middle ms-2"></i>
											</button>
										<?php
										}
										?>
									</div>
								</div>

							</div>
						</div>
					</div>
					<!-- end page title -->

					<div class="row">
						<!-- filtros -->
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Cliente</label>
												<select class="form-select" name="cod_cliente_buscar" id="cod_cliente_buscar" onchange="ListarSedes(1);">
													<option value="">Todos</option>
													<?php
														$sqlCliente = mysqli_query($conexion, "SELECT * FROM clientes WHERE estado = 'A'");
														while ($item = mysqli_fetch_array($sqlCliente)) {
															$cod_cliente = $item['cod_cliente'];
															$num_doc = $item['num_documento'];
															$razon_social = $item['nombres'];
															echo "<option value='$cod_cliente'>$num_doc | $razon_social</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Tipo de Dirección</label>
												<select class="form-select" name="cod_tipo_direcc_buscar" id="cod_tipo_direcc_buscar" onchange="ListarSedes(1);">
													<option value="">Todos</option>
													<?php
														$sqlTpDirecc = mysqli_query($conexion, "SELECT * FROM tipo_direccion WHERE estado = 'A'");
														while ($item = mysqli_fetch_array($sqlTpDirecc)) {
															$id_tipo_direccion = $item['id_tipo_direccion'];
															$tipo_direccion = $item['tipo_direccion'];
															echo "<option value='$id_tipo_direccion'>$tipo_direccion</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Dirección</label>
												<input class="form-control" type="text" name="direccion_buscar" id="direccion_buscar" maxlength="255" onkeypress="Enter(event); return validarDirecc(event);">
											</div>
										</div>
										<div class="col-md-2">
											<label class="control-label">Estado</label>
											<select class="form-select" name="estado_buscar" id="estado_buscar" onchange="ListarSedes(1);">
												<option value="">Todos</option>
												<option value="A">Activo</option>
												<option value="I">Inactivo</option>
											</select>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Departamento</label>
												<select class="form-select" name="cod_dpto_buscar" id="cod_dpto_buscar" onchange="ListarProvincias('cod_dpto_buscar','cod_prov_buscar','Todos',false);">
													<option value="">Todos</option>
													<?php
														$sqlDpto = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
														while ($item = mysqli_fetch_array($sqlDpto)) {
															$cod_dpto = $item['id'];
															$nom_dpto = $item['name'];
															echo "<option value='$cod_dpto'>$nom_dpto</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Provincia</label>
												<select class="form-select" name="cod_prov_buscar" id="cod_prov_buscar" onchange="ListarDistritos('cod_prov_buscar','cod_dist_buscar','Todos',false);"></select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Distrito</label>
												<select class="form-select" name="cod_dist_buscar" id="cod_dist_buscar" onchange="ListarSedes(1);"></select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end filtros -->

						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive">
									<table id="tbl_sedes_x_clientes" class="table table-striped table-bordered dt-responsive wrap table-brtz">
										<caption>
											<button class="btn btn-primary waves-effect waves-light" title="Refrescar Tabla" onclick="ListarSedes(1);"><i class="ri-refresh-line align-middle"></i></button>&nbsp;
											<button class="btn btn-primary waves-effect waves-light" title="Generar Excel" onclick="GenerarExcel();"><i class="ri-file-excel-2-fill align-middle"></i></button>
										</caption>
										<thead>
											<tr>
												<th><center>N°</center></th>
												<th><center>Cliente</center></th>
												<th><center>Tipo Dirección</center></th>
												<th><center>Dirección</center></th>
												<th><center>Referencia</center></th>
												<th><center>Departamento</center></th>
												<th><center>Provincia</center></th>
												<th><center>Distrito</center></th>
												<th><center>Estado</center></th>
												<th width="8%"><center>Acción</center></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<div id="paginador_tbl_sedes_x_clientes" style="text-align: center;"></div>
								</div>
							</div>
						</div> <!-- end col -->
					</div> <!-- end row -->

				</div> <!-- container-fluid -->
			</div>
			<!-- ============================================================== -->
			<!-- ===================   PIEPAGINA APP ========================== -->
			<!-- ============================================================== -->
			<?php require("config/piepagina.php"); ?>
		</div>
		<!-- end main content-->

	</div>
	<!-- END layout-wrapper -->
	<div class="modal fade bs-example-modal-xl" id="mNuevaSede" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myExtraLargeModalLabel">Registrar Sede</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mNuevaSede','c');"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Cliente</label>
						<div class="col-md-10 contain-select2">
							<select class="form-select" name="cod_cliente_nuevo" id="cod_cliente_nuevo">
								<option value="">Seleccionar Cliente</option>
								<?php
									$sqlCliente = mysqli_query($conexion, "SELECT * FROM clientes WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlCliente)) {
										$cod_cliente = $item['cod_cliente'];
										$num_doc = $item['num_documento'];
										$razon_social = $item['nombres'];
										echo "<option value='$cod_cliente'>$num_doc | $razon_social</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Tipo de Dirección</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipo_direcc_nuevo" id="cod_tipo_direcc_nuevo">
								<option value="">Seleccionar Tipo de Dirección</option>
								<?php
									$sqlTpDirecc = mysqli_query($conexion, "SELECT * FROM tipo_direccion WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlTpDirecc)) {
										$id_tipo_direccion = $item['id_tipo_direccion'];
										$tipo_direccion = $item['tipo_direccion'];
										echo "<option value='$id_tipo_direccion'>$tipo_direccion</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Dirección</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="direccion_nuevo" id="direccion_nuevo" maxlength="255" onkeypress="return validarDirecc(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Referencia</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="referencia_nuevo" id="referencia_nuevo" maxlength="255" onkeypress="return validarDirecc(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Departamento</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_dpto_nuevo" id="cod_dpto_nuevo" onchange="ListarProvincias('cod_dpto_nuevo','cod_prov_nuevo','Seleccionar Provincia');">
								<option value="">Seleccionar Departamento</option>
								<?php
									$sqlDpto = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
									while ($item = mysqli_fetch_array($sqlDpto)) {
										$cod_dpto = $item['id'];
										$nom_dpto = $item['name'];
										echo "<option value='$cod_dpto'>$nom_dpto</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Provincia</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_prov_nuevo" id="cod_prov_nuevo" onchange="ListarDistritos('cod_prov_nuevo','cod_dist_nuevo','Seleccionar Distrito');"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Distrito</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_dist_nuevo" id="cod_dist_nuevo"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Estado</label>
						<div class="col-md-10">
							<input type="radio" name="estado_nuevo" value="A" checked> Activo
							<input type="radio" name="estado_nuevo" value="I"> Inactivo
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarNuevaSede();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mNuevaSede','c');">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade bs-example-modal-xl" id="mEditarSede" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titulo_editar">Editar Sede</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mEditarSede','c');"></button>
				</div>
				<div class="modal-body">
					<input type="text" name="cod_sede_editar" id="cod_sede_editar" hidden>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Cliente</label>
						<div class="col-md-10 contain-select2">
							<select class="form-select" name="cod_cliente_editar" id="cod_cliente_editar">
								<option value="">Seleccionar Cliente</option>
								<?php
									$sqlCliente = mysqli_query($conexion, "SELECT * FROM clientes WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlCliente)) {
										$cod_cliente = $item['cod_cliente'];
										$num_doc = $item['num_documento'];
										$razon_social = $item['nombres'];
										echo "<option value='$cod_cliente'>$num_doc | $razon_social</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Tipo de Dirección</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipo_direcc_editar" id="cod_tipo_direcc_editar">
								<option value="">Seleccionar Tipo de Dirección</option>
								<?php
									$sqlTpDirecc = mysqli_query($conexion, "SELECT * FROM tipo_direccion WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlTpDirecc)) {
										$id_tipo_direccion = $item['id_tipo_direccion'];
										$tipo_direccion = $item['tipo_direccion'];
										echo "<option value='$id_tipo_direccion'>$tipo_direccion</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Dirección</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="direccion_editar" id="direccion_editar" maxlength="255" onkeypress="return validarDirecc(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Referencia</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="referencia_editar" id="referencia_editar" maxlength="255" onkeypress="return validarDirecc(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Departamento</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_dpto_editar" id="cod_dpto_editar" onchange="ListarProvincias('cod_dpto_editar','cod_prov_editar','Seleccionar Provincia');">
								<option value="">Seleccionar Departamento</option>
								<?php
									$sqlDpto = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
									while ($item = mysqli_fetch_array($sqlDpto)) {
										$cod_dpto = $item['id'];
										$nom_dpto = $item['name'];
										echo "<option value='$cod_dpto'>$nom_dpto</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Provincia</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_prov_editar" id="cod_prov_editar" onchange="ListarDistritos('cod_prov_editar','cod_dist_editar','Seleccionar Distrito');"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Distrito</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_dist_editar" id="cod_dist_editar"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Estado</label>
						<div class="col-md-10">
							<input type="radio" name="estado_editar" value="A" checked> Activo
							<input type="radio" name="estado_editar" value="I"> Inactivo
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarEditarSede();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mEditarSede','c');">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Right bar overlay-->
	<div class="rightbar-overlay"></div>

	<!-- JAVASCRIPT -->
	<script src="assets/libs/jquery/jquery.min.js"></script>
	<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/libs/metismenu/metisMenu.min.js"></script>
	<script src="assets/libs/simplebar/simplebar.min.js"></script>
	<script src="assets/libs/node-waves/waves.min.js"></script>

	<!-- Required datatable js -->
	<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<!-- Buttons examples -->
	<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="assets/libs/jszip/jszip.min.js"></script>
	<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
	<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
	<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<!-- Responsive examples -->
	<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

	<!-- Datatable init js -->
	<script src="assets/js/pages/datatables.init.js"></script>

	<script src="assets/js/app.js"></script>

	<!-- Select 2 -->
	<script src="assets/libs/select2/js/select2.min.js"></script>
	<!-- SweetAlert 2 -->
	<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

	<script src="assets/js/general.js"></script>
	<script src="assets/js/clientes-sedes.js"></script>
	<script>
		$(function() {
			$('#cod_dpto_buscar').val('').trigger('change');
		});
	</script>
</body>

</html>