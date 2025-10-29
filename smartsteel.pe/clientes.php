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
								<h4 class="mb-sm-0">Administrar Clientes</h4>
								<!-- **************************************** -->
								<div class="page-title-right">
									<div class="button-items">
										<?php
										if ($can_insert) {
										?>
											<button type="button" class="btn btn-primary waves-effect waves-light" onclick="LimpiarCampos_NuevoCliente(); OpenCloseModal('mNuevoCliente','o');">
												Nuevo Cliente <i class="ri-folder-add-fill align-middle ms-2"></i>
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
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Punto de Venta</label>
												<select class="form-select" name="cod_puntoventa_buscar" id="cod_puntoventa_buscar" onchange="ListarClientes(1);">
													<option value="">Todos</option>
													<?php
														$sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado = 'A'");
														while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
															$cod_puntoventa = $pventa['cod_puntoventa'];
															$nombre_puntoventa = $pventa['nombre_puntoventa'];
															echo "<option value='$cod_puntoventa'>$nombre_puntoventa</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Numero Documento</label>
												<input class="form-control" type="text" name="num_documento_buscar" id="num_documento_buscar" maxlength="11" onkeypress="Enter(event); return validarnu(event);">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Razon Social</label>
												<input class="form-control" type="text" name="razon_social_buscar" id="razon_social_buscar" maxlength="100" onkeypress="Enter(event); return validarRZ(event);">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Nombre Comercial</label>
												<input class="form-control" type="text" name="nombre_comercial_buscar" id="nombre_comercial_buscar" maxlength="100" onkeypress="Enter(event); return validarRZ(event);">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Giro de Negocio</label>
												<select class="form-select select2" name="giro_negocio_buscar" id="giro_negocio_buscar" onchange="ListarClientes(1);">
													<option value="">Todos</option>
													<?php
														$sqlTipoGiro = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios WHERE estado = 'A'");
														while ($tgiro = mysqli_fetch_array($sqlTipoGiro)) {
															$id_giro_negocio = $tgiro['id_giro_negocio'];
															$nombre_giro = $tgiro['nombre_giro'];
															echo "<option value='$id_giro_negocio'>$nombre_giro</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<label class="control-label">Estado</label>
											<select class="form-select" name="estado_buscar" id="estado_buscar" onchange="ListarClientes(1);">
												<option value="">Todos</option>
												<option value="A">Activo</option>
												<option value="I">Inactivo</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end filtros -->

						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive">
									<table id="tbl_clientes" class="table table-striped table-bordered dt-responsive wrap table-brtz">
										<caption>
											<button class="btn btn-primary waves-effect waves-light" title="Recargar" onclick="ListarClientes(1);"><i class="ri-refresh-line align-middle"></i></button>&nbsp;
											<button class="btn btn-primary waves-effect waves-light" title="Generar Excel" onclick="GenerarExcel();"><i class="ri-file-excel-2-fill align-middle"></i></button>
										</caption>
										<thead>
											<tr>
												<th><center>N°</center></th>
												<th><center>Punto Venta</center></th>
												<th><center>Cliente</center></th>
												<th><center>Nombre Comercial</center></th>
												<th><center>Tipo Documento</center></th>
												<th><center>N° Documento</center></th>
												<th><center>Giro de Negocio</center></th>
												<th><center>Estado</center></th>
												<th width="8%"><center>Acción</center></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<div id="paginador_tbl_clientes" style="text-align: center;"></div>
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
	<div class="modal fade bs-example-modal-xl" id="mNuevoCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myExtraLargeModalLabel">Registrar Cliente</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mNuevoCliente','c');"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Punto de Venta</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_puntoventa_nuevo" id="cod_puntoventa_nuevo">
								<option value="">Seleccionar Punto de Venta</option>
								<?php
									$sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
									while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
										$cod_puntoventa = $pventa['cod_puntoventa'];
										$nombre_puntoventa = $pventa['nombre_puntoventa'];
										echo "<option value='$cod_puntoventa'>$nombre_puntoventa</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Tipo de Documento</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipodoc_nuevo" id="cod_tipodoc_nuevo">
								<option value="">Seleccionar Tipo de Documento</option>
								<?php
									$sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE estado = 'A'");
									while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
										$cod_tipodoc = $tdoc['cod_tipodoc'];
										$descripcion = $tdoc['descripcion'];
										echo "<option value='$cod_tipodoc'>$descripcion</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Numero Documento</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="num_documento_nuevo" id="num_documento_nuevo" maxlength="11" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Razon Social</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="razon_social_nuevo" id="razon_social_nuevo" maxlength="100" onkeypress="return validarRZ(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Nombre Comercial</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="nombre_comercial_nuevo" id="nombre_comercial_nuevo" maxlength="100" onkeypress="return validarRZ(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Giro de Negocio</label>
						<div class="col-md-10">
							<select class="form-select" name="giro_negocio_nuevo" id="giro_negocio_nuevo">
								<option value="">Seleccionar Giro del Negocio</option>
								<?php
									$sqlTipoGiro = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios");
									while ($tgiro = mysqli_fetch_array($sqlTipoGiro)) {
										$id_giro_negocio = $tgiro['id_giro_negocio'];
										$nombre_giro = $tgiro['nombre_giro'];
										echo "<option value='$id_giro_negocio'>$nombre_giro</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Web Site</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="website_nuevo" id="website_nuevo" maxlength="150" onkeypress="return validarPagWeb(event,true);">
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
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarNuevoCliente();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mNuevoCliente','c');">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade bs-example-modal-xl" id="mEditarCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titulo_editar">Editar Cliente</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mEditarCliente','c');"></button>
				</div>
				<div class="modal-body">
					<input type="text" name="cod_cliente_editar" id="cod_cliente_editar" hidden>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Punto de Venta</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_puntoventa_editar" id="cod_puntoventa_editar">
								<option value="">Seleccionar Punto de Venta</option>
								<?php
									$sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
									while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
										$cod_puntoventa = $pventa['cod_puntoventa'];
										$nombre_puntoventa = $pventa['nombre_puntoventa'];
										echo "<option value='$cod_puntoventa'>$nombre_puntoventa</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Tipo de Documento</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipodoc_editar" id="cod_tipodoc_editar">
								<option value="">Seleccionar Tipo de Documento</option>
								<?php
									$sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE estado = 'A'");
									while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
										$cod_tipodoc = $tdoc['cod_tipodoc'];
										$descripcion = $tdoc['descripcion'];
										echo "<option value='$cod_tipodoc'>$descripcion</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Numero Documento</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="num_documento_editar" id="num_documento_editar" maxlength="11" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Razon Social</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="razon_social_editar" id="razon_social_editar" maxlength="100" onkeypress="return validarRZ(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Nombre Comercial</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="nombre_comercial_editar" id="nombre_comercial_editar" maxlength="100" onkeypress="return validarRZ(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Giro de Negocio</label>
						<div class="col-md-10">
							<select class="form-select" name="giro_negocio_editar" id="giro_negocio_editar">
								<option value="">Seleccionar Giro del Negocio</option>
								<?php
									$sqlTipoGiro = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios");
									while ($tgiro = mysqli_fetch_array($sqlTipoGiro)) {
										$id_giro_negocio = $tgiro['id_giro_negocio'];
										$nombre_giro = $tgiro['nombre_giro'];
										echo "<option value='$id_giro_negocio'>$nombre_giro</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Web Site</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="website_editar" id="website_editar" maxlength="150" onkeypress="return validarPagWeb(event,true);">
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
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarEditarCliente();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mEditarCliente','c');">Cerrar</button>
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
	<script src="assets/js/clientes.js"></script>
	<script>
		$(function() {
			ListarClientes(1);
		});
	</script>
</body>

</html>