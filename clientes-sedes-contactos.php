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
								<h4 class="mb-sm-0">Administrar Contactos</h4>
								<!-- **************************************** -->
								<div class="page-title-right">
									<div class="button-items">
										<?php
										if ($can_insert) {
										?>
											<button type="button" class="btn btn-primary waves-effect waves-light" onclick="LimpiarCampos_NuevoContacto(); OpenCloseModal('mNuevoContacto','o');">
												Nuevo Contacto <i class="ri-folder-add-fill align-middle ms-2"></i>
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
												<select class="form-select" name="cod_cliente_buscar" id="cod_cliente_buscar" onchange="SedesPorCliente_ForSelect('cod_cliente_buscar','cod_sede_buscar','Todos');">
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
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Sede (Dirección)</label>
												<select class="form-select" name="cod_sede_buscar" id="cod_sede_buscar" onchange="ListarContactos(1);"></select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Tipo de Contacto</label>
												<select class="form-select" name="cod_tipo_contacto_buscar" id="cod_tipo_contacto_buscar" onchange="ListarContactos(1);">
													<option value="">Todos</option>
													<?php
														$sqlTipoContacto = mysqli_query($conexion , "SELECT * FROM tipo_contactos WHERE estado = 'A'");
														while ($item = mysqli_fetch_array($sqlTipoContacto)) {
															$cod_tipo_contacto = $item['id_tipo_contacto'];
															$tipo_contacto = $item['tipo_contacto'];
															echo "<option value='$cod_tipo_contacto'>$tipo_contacto</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Contacto</label>
												<input class="form-control" type="text" name="nombre_contacto_buscar" id="nombre_contacto_buscar" maxlength="255" onkeypress="Enter(event); return validarle(event);">
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Teléfono</label>
												<input class="form-control" type="text" name="telefono_buscar" id="telefono_buscar" maxlength="9" onkeypress="Enter(event); return validarnu(event);">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">Email</label>
												<input class="form-control" type="text" name="email_buscar" id="email_buscar" maxlength="100" onkeypress="Enter(event); return validarKeyEmail(event);">
											</div>
										</div>
										<div class="col-md-2">
											<label class="control-label">Estado</label>
											<select class="form-select" name="estado_buscar" id="estado_buscar" onchange="ListarContactos(1);">
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
									<table id="tbl_contactos_x_sedes" class="table table-striped table-bordered dt-responsive wrap table-brtz">
										<caption>
											<button class="btn btn-primary waves-effect waves-light" title="Refrescar Tabla" onclick="ListarContactos(1);"><i class="ri-refresh-line align-middle"></i></button>&nbsp;
											<button class="btn btn-primary waves-effect waves-light" title="Generar Excel" onclick="GenerarExcel();"><i class="ri-file-excel-2-fill align-middle"></i></button>
										</caption>
										<thead>
											<tr>
												<th><center>N°</center></th>
												<th><center>Cliente</center></th>
												<th><center>Sede (Dirección)</center></th>
												<th><center>Tipo Contacto</center></th>
												<th><center>Contacto</center></th>
												<th><center>Teléfonos</center></th>
												<th><center>Email</center></th>
												<th><center>Estado</center></th>
												<th width="8%"><center>Acción</center></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<div id="paginador_tbl_contactos_x_sedes" style="text-align: center;"></div>
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
	<div class="modal fade bs-example-modal-xl" id="mNuevoContacto" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myExtraLargeModalLabel">Registrar Contacto</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mNuevoContacto','c');"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Cliente</label>
						<div class="col-md-10 contain-select2">
							<select class="form-select" name="cod_cliente_nuevo" id="cod_cliente_nuevo" onchange="SedesPorCliente_ForSelect('cod_cliente_nuevo','cod_sede_nuevo','Seleccionar Sede (Dirección)');">
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
						<label class="col-md-2 col-form-label">Sede (Dirección)</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_sede_nuevo" id="cod_sede_nuevo"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Tipo de Contacto</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipo_contacto_nuevo" id="cod_tipo_contacto_nuevo">
								<option value="">Seleccionar Tipo de Contacto</option>
								<?php
									$sqlTipoContacto = mysqli_query($conexion , "SELECT * FROM tipo_contactos WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlTipoContacto)) {
										$cod_tipo_contacto = $item['id_tipo_contacto'];
										$tipo_contacto = $item['tipo_contacto'];
										echo "<option value='$cod_tipo_contacto'>$tipo_contacto</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Nombres y Apellidos</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="nombre_contacto_nuevo" id="nombre_contacto_nuevo" maxlength="255" onkeypress="return validarle(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Teléfono 1</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="telefono1_nuevo" id="telefono1_nuevo" maxlength="9" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Teléfono 2</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="telefono2_nuevo" id="telefono2_nuevo" maxlength="9" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Email</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="email_nuevo" id="email_nuevo" maxlength="100" onkeypress="return validateMail('email_nuevo','emailOK_1');">
							<span id="emailOK_1"></span>
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
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarNuevoContacto();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mNuevoContacto','c');">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade bs-example-modal-xl" id="mEditarContacto" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titulo_editar">Editar Sede</h5>
					<button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mEditarContacto','c');"></button>
				</div>
				<div class="modal-body">
					<input type="text" name="cod_contacto_editar" id="cod_contacto_editar" hidden>
					<div class="mb-3 row">
						<label class="col-md-2 col-form-label">Cliente</label>
						<div class="col-md-10 contain-select2">
							<select class="form-select" name="cod_cliente_editar" id="cod_cliente_editar" onchange="SedesPorCliente_ForSelect('cod_cliente_editar','cod_sede_editar','Seleccionar Sede (Dirección)');">
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
						<label class="col-md-2 col-form-label">Sede (Dirección)</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_sede_editar" id="cod_sede_editar"></select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Tipo de Contacto</label>
						<div class="col-md-10">
							<select class="form-select" name="cod_tipo_contacto_editar" id="cod_tipo_contacto_editar">
								<option value="">Seleccionar Tipo de Contacto</option>
								<?php
									$sqlTipoContacto = mysqli_query($conexion , "SELECT * FROM tipo_contactos WHERE estado = 'A'");
									while ($item = mysqli_fetch_array($sqlTipoContacto)) {
										$cod_tipo_contacto = $item['id_tipo_contacto'];
										$tipo_contacto = $item['tipo_contacto'];
										echo "<option value='$cod_tipo_contacto'>$tipo_contacto</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Nombres y Apellidos</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="nombre_contacto_editar" id="nombre_contacto_editar" maxlength="255" onkeypress="return validarle(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Teléfono 1</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="telefono1_editar" id="telefono1_editar" maxlength="9" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Teléfono 2</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="telefono2_editar" id="telefono2_editar" maxlength="9" onkeypress="return validarnu(event);">
						</div>
					</div>
					<div class="mb-3 row">
						<label for="example-text-input" class="col-md-2 col-form-label">Email</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="email_editar" id="email_editar" maxlength="100" onkeypress="return validateMail('email_editar','emailOK_2');">
							<span id="emailOK_2"></span>
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
					<button type="button" class="btn btn-primary waves-effect waves-light" onclick="GuardarEditarContacto();">Guardar</button>
					<button type="button" class="btn btn-danger waves-effect" onclick="OpenCloseModal('mEditarContacto','c');">Cerrar</button>
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
	<script src="assets/js/clientes-sedes-contactos.js"></script>
	<script>
		$(function() {
			$('#cod_cliente_buscar').val('').trigger('change');
		});
	</script>
</body>

</html>