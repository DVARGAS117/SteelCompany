<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>*Sistema de Facturación - Codigo PHP - </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/fab.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/touchspin.min.js"></script>
	<!-- /theme JS files -->

	<script src="assets/js/plugins/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
	<script src="assets/js/plugins/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	

	<link rel="stylesheet" type="text/css" media="screen" href="assets/js/plugins/jqgrid/css/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="assets/js/plugins/jqgrid/css/custom.css" />

	<script type="text/javascript" src="js/numeros_a_letras.js?i=<?php echo rand(); ?>"></script>	
	<script type="text/javascript" src="js/documentoelectronico_interaccion.js?i=<?php echo rand(); ?>"></script>	
	<script type="text/javascript" src="js/documentoelectronico_consultas.js?i=<?php echo rand(); ?>"></script>	

	<script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>

	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '179248925778029');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=179248925778029&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->


</head>

<body class="navbar-bottom">
	<!-- Load Facebook SDK for JavaScript -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<!-- Your customer chat code -->
	<div class="fb-customerchat"
	attribution="setup_tool"
	page_id="740404332826448"
	logged_in_greeting="Hola!. ¿Deseas Comprar el Código Fuente?"
	logged_out_greeting="Hola!. ¿Deseas Comprar el Código Fuente?">
	</div>

	<style type="text/css" media="screen">
		.stepy-header {
			margin: 0 auto;
			max-width: 500px;
		}
		.stepy-navigator {
			text-align: center;
		}
		.custom-textarea:focus {
		    /* outline: 0; */
		    /* border-color: transparent; */
		    border-bottom-color: #009688;
		    -webkit-box-shadow: 0 1px 0 #009688;
		    box-shadow: 0 1px 0 #009688;
		    border-color: #ddd;
		    outline: 0;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(221, 221, 221, 0.6);
		    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(221, 221, 221, 0.6);
		}
		.custom-textarea {
		    display: block;
		    width: 100%;
		    padding: 8px 16px;
		    font-size: 13px;
		    line-height: 1.5384616;
		    color: #333333;
		    background-color: transparent;
		    background-image: none;
		    border: 1px solid #ddd;
		    border-radius: 3px;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		}
		.panel-factura {
			margin-bottom: 20px;
		    background-color: #eeeded;
		    border: 1px solid transparent;
		    border-radius: 0px;
		    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
		    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.05);
		}
		.form-control {
		    display: block !important;
		    width: 100% !important;
		    height: 38px !important;
		    padding: 8px 16px !important;
		    font-size: 13px !important;
		    line-height: 1.5384616 !important;
		    color: #333333 !important;
		    background-color: transparent !important;
		    background-image: none !important;
		    border: 1px solid #ddd !important;
		    border-radius: 3px !important;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) !important;
		    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) !important;
		    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
		    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
		    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
		}
	</style>

	<!-- Page header -->
	<?php 
       
        include("layout/page-header.php"); ?>
	<!-- /Page header -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- content -->
				<div class="row">
					
                                        valor
					<!-- Documento Electrónico -->
					<form name="frm_comprobanteelectronico" id="frm_comprobanteelectronico" action="#" method="post" accept-charset="utf-8">
						<div class="row">
			                <div class="col-md-12" style="margin-bottom: 15px;">
			                    <div class="panel" style="max-width: 1100px; margin: 0 auto;">
			                        <div class="panel-body" id="cuerpo_comprobante">
			                        	<fieldset class="content-group">
			                        		<legend class="text-bold">Tipo de Comprobante: </legend>

											<div class="col-md-3">
												<div class="radio">
													<label>
														<input type="radio" value="01" name="tipo_comprobante" class="control-primary" checked="checked">
														Factura
													</label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="radio">
													<label>
														<input type="radio" value="03" name="tipo_comprobante" class="control-success">
														Boleta
													</label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="radio">
													<label>
														<input type="radio" value="07" name="tipo_comprobante" class="control-info">
														Nota de Crédito
													</label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="radio">
													<label>
														<input type="radio" value="08" name="tipo_comprobante" class="control-danger">
														Nota de Débito
													</label>
												</div>
											</div>
			                        	</fieldset>
			                        	
										<fieldset class="content-group">
											<legend class="text-bold">Factura: </legend>

			                                <div class="form-group col-md-3">
			                                    <label><i class="icon-barcode2 position-left"></i> Serie:</label>
			                                    <input type="text" name="serie_comprobante" id="serie_comprobante" value="F001" class="form-control" readonly="readonly">
			                                </div>

			                                <div class="form-group col-md-3">
			                                    <label><i class="icon-file-text2 position-left"></i> Número (6 números):</label>
			                                    <input type="text" name="numero_comprobante" id="numero_comprobante" value="659854" class="form-control">
			                                </div>

			                                <div class="form-group col-md-3">
			                                    <label><i class="icon-calendar2 position-left"></i> Fecha.Doc:</label>
			                                    <input type="text" name="fecha_comprobante" id="fecha_comprobante" placeholder="" class="form-control" readonly="readonly">
			                                </div>
			                                
			                                <div class="form-group col-md-3">
		                                        <div class="form-group has-feedback has-feedback-left">
		                                            <label><i class="icon-cash2 position-left"></i>Moneda <span class="text-danger">*</span></label>
		                                            <select title="Selecciona el Tipo de Moneda" data-placeholder="Selecciona Tu Moneda" class="select codmoneda_comprobante" name="codmoneda_comprobante" id="codmoneda_comprobante" required>
		                                                <option value='PEN'>Soles</option>
		                                                <option value='USD'>Dólares</option>
		                                                <option value='EUR'>Euros</option>
		                                            </select>
		                                        </div>                        
		                                    </div>
											
											<div class="content_debito_credito" style="display: none;">
			                                    <div class="form-group col-md-4">
			                                        <div class="form-group has-feedback has-feedback-left">
			                                            <label><i class="icon-file-text position-left"></i> Documento Modificado <span class="text-danger">*</span></label>
			                                            <select title="Documento Modificado" data-placeholder="Selecciona el Documento" class="select tipo_comprobante_modificado" name="tipo_comprobante_modificado" id="tipo_comprobante_modificado" required>
			                                                <option value='01'>Factura</option>
			                                                <option value='03'>Boleta</option>
			                                            </select>
			                                        </div>                        
			                                    </div>

				                                <div class="form-group col-md-4">
				                                    <label><i class="icon-file-text position-left"></i> N° Doc. Modificado:</label>
				                                    <input type="text" name="num_comprobante_modificado" id="num_comprobante_modificado" placeholder="856887" class="form-control">
				                                </div>

				                                <div class="form-group col-md-4 notadebito_motivo" style="display: none;">
			                                        <div class="form-group has-feedback has-feedback-left">
			                                            <label><i class="icon-profile position-left"></i>Motivo <span class="text-danger">*</span></label>
			                                            <select title="Selecciona el Motivo" data-placeholder="Selecciona el Motivo" class="select notadebito_motivo_id" name="notadebito_motivo_id" id="notadebito_motivo_id" required>
			                                                <option value="01">INTERES POR MORA</option>
			                                                <option value="02">AUMENTO EN EL VALOR</option>
			                                                <option value="03">PENALIDADES</option>
			                                            </select>
			                                        </div>
			                                    </div>

				                                <div class="form-group col-md-4 notacredito_motivo" style="display: none;">
			                                        <div class="form-group has-feedback has-feedback-left">
			                                            <label><i class="icon-profile position-left"></i>Motivo <span class="text-danger">*</span></label>
			                                            <select title="Selecciona el Motivo" data-placeholder="Selecciona el Motivo" class="select notacredito_motivo_id" name="notacredito_motivo_id" id="notacredito_motivo_id" required>
			                                                <option value="01">ANULACION DE LA OPERACION</option>
						                                	<option value="02">ANULACION POR ERROR EN EL RUC</option>
						                                	<option value="03">CORRECION POR ERROR EN LA DESCRIPCION</option>
						                                	<option value="04">DESCUENTO GLOBAL</option>
						                                	<option value="05">DESCUENTO POR ITEM</option>
						                                	<option value="06">DEVOLUCION TOTAL</option>
						                                	<option value="07">DEVOLUCION POR ITEM</option>
						                                	<option value="08">BONIFICACION</option>
						                                	<option value="09">DISMINUCION EN EL VALOR</option>
			                                            </select>
			                                        </div>
			                                    </div>
											</div>

										</fieldset>

										<fieldset class="content-group">
											<legend class="text-bold">Cliente: </legend>

			                                <div class="form-group col-md-2">
		                                        <div class="form-group has-feedback has-feedback-left">
		                                            <label><i class="icon-user position-left"></i> Tipo de Documento: <span class="text-danger">*</span></label>
		                                            <select title="Selecciona el Tipo de Documento" data-placeholder="Tipo de Documento" class="select cliente_tipodocumento" name="cliente_tipodocumento" id="cliente_tipodocumento" required>
		                                                <option value='6'>RUC</option>
		                                            </select>
		                                        </div>                        
		                                    </div>

			                                <div class="form-group col-md-4">
												<button type="button" style="float: right; margin-top: 27px;" class="btn btn-primary btn-icon legitRipple search_document"><i class="icon-search4" id="icon_search_document"></i><i class="icon-spinner10 spinner position-left" style="display: none;" id="icon_searching_document"></i></button>
												<div style="overflow: hidden; padding-right: .5em;">
													<label><i class="icon-pencil position-left"></i> <span id="titulo_numerodocumento">N° de RUC</span>: <span class="text-danger">*</span></label>
												   <input type="text" title="Número de Documento" name="cliente_numerodocumento" id="cliente_numerodocumento" placeholder="Número de Ruc Aquí!" class="form-control cliente_numerodocumento" required>
												</div>​
			                                </div>

			                                <div class="form-group col-md-6">
			                                    <label><i class="icon-vcard position-left"></i> <span id="titulo_nombrecliente">Razón Social</span>: <span class="text-danger">*</span></label>
			                                    <input type="text" title="Ingresa la Razón Social o Nombre" name="cliente_nombre" id="cliente_nombre" placeholder="Razón Social Aquí" class="form-control cliente_nombre"  required>
			                                </div>
			                                
		                                	<div class="col-md-12" style="display: none;">
		                                		<div class="col-md-6">
			                                        <div class="form-group has-feedback has-feedback-left">
			                                            <label><i class="icon-user position-left"></i> País: <span class="text-danger">*</span></label>
			                                            <select title="Selecciona el País" data-placeholder="País" class="select cliente_pais" name="cliente_pais" id="cliente_pais" required>
			                                                <option value='PE'>Perú</option>
			                                            </select>
			                                        </div>                        
			                                    </div>
		                                		<div class="col-md-6">
			                                        <div class="form-group has-feedback has-feedback-left">
			                                            <label><i class="icon-user position-left"></i> Ciudad: <span class="text-danger">*</span></label>
			                                            <select title="Selecciona la Ciudad" data-placeholder="Ciudad" class="select cliente_ciudad" name="cliente_ciudad" id="cliente_ciudad" required>
			                                                <option value='Lima'>Lima</option>
			                                            </select>
			                                        </div>                        
			                                    </div>
		                                	</div>

			                                <div class="form-group col-md-12">
			                                    <label><i class="icon-home2 position-left"></i> Dirección: <span class="text-danger">*</span></label>
			                                    <input type="text" title="Ingresa la dirección completa" name="cliente_direccion" id="cliente_direccion" placeholder="Escribe aquí la dirección completa" class="form-control cliente_direccion" required>
			                                </div>

										</fieldset>


										<fieldset class="content-group">
											<legend class="text-bold">Detalle Documento: </legend>
											<div class="col-md-12" style="text-align: right; padding-bottom: 4px;">
												<button type="button" class="btn btn-success btn-labeled btn-xs legitRipple btn_agregarproducto"><b><i class="icon-plus-circle2"></i></b> Agregar</button>
												<button type="button" class="btn btn-danger btn-labeled btn-xs legitRipple btn_eliminarproducto"><b><i class="icon-minus-circle2"></i></b> Eliminar</button>
											</div>
											<div class="col-md-12">
												<div class="jqGrid">
		                                            <table id='detalle_documento' class='scroll'></table>
		                                        </div>
											</div>
											
											<div class="col-md-12" style="margin-top: 15px;">
												<div class="col-sm-7">
													<div class="content-group">
														<h6><i class="icon-notebook position-left"></i> Observación:</h6>
														<div class="mb-15 mt-15">
															<textarea rows="5" cols="5" name="observacion_documento" class="custom-textarea" placeholder="Escribe aquí una observación"></textarea>
														</div>

														
													</div>
												</div>

												<div class="col-sm-5">
													<div class="content-group">
														<h6>Resumen:</h6>
														<div class="table-responsive no-border">
															<table class="table">
																<tbody>
																	<tr>
																		<th>Subtotal:</th>
																		<td class="text-right">
																			S/. <span id="subtotal_documento">0.0</span>
																			<input type="hidden" name="txt_subtotal_comprobante" id="txt_subtotal_comprobante" value="0">
																		</td>
																	</tr>
																	<tr>
																		<th>IGV: <span class="text-regular">(18%)</span></th>
																		<td class="text-right">
																			S/. <span id="igv_documento">0.0</span>
																			<input type="hidden" name="txt_igv_comprobante" id="txt_igv_comprobante" value="0">
																		</td>
																	</tr>
																	<tr>
																		<th>Total:</th>
																		<td class="text-right text-primary"><h5 class="text-semibold">
																			S/. <span id="total_documento">0.0</span></h5>
																			<input type="hidden" name="txt_total_comprobante" id="txt_total_comprobante" value="0">
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
														<input type="hidden" name="txt_total_letras" id="txt_total_letras" value="" />
													</div>
												</div>
											</div>

											<div class="col-md-12" id="respuesta_proceso">
												
											</div>

											<div class="col-md-12 text-center" style="padding-bottom: 25px;">
												<button id="btn_guardar_doc_electronico" type="button" class="btn btn-primary btn-labeled btn-xs legitRipple"><b><i class="icon-floppy-disk"></i></b> Guardar Documento Electrónico</button>
											</div>

											

											
											<div class="col-md-12" style="padding: 10px;">
												<div class="alert alert-info alert-styled-left alert-bordered" style="max-width: 696px; margin: 0 auto;">
													<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
												Facturacion electronica ubl 2.1 (codigo fuente) Código fuente con conexiones directas a sunat. - Código fuente para enviar boletas, facturas, notas de crédito, notas de débito, guías de remisión, comunicaciones de baja y resúmenes de boletas. - Obtendrás plantillas diseñadas profesionalmente para que puedas imprimir tus facturas, boletas, notas de crédito y débito. - Te entregaremos el código fuente de toda una api desarrollada y lista para que tanto tu o tus clientes puedan conectarse a dicha api y pues tener todo tu negocio centralizado. Comunicarse con Gustavo al 993609943 o al 976248185
                                                                                                
                                                                                                </div>   

												
											</div>
											
										</fieldset>
			                        </div>
			                    </div>
			                </div>
			            </div>
					</form>
					<!-- /Documento Electrónico -->

				</div>
				<!-- /content -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	
	<!-- vm_agregar_articulo -->
	<div id="vm_agregar_articulo" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h6 class="modal-title">Agregar Artículo</h6>
				</div>

				<div class="modal-body">
					<div class="col-md-12">
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered"> 
							Esta pantalla fué creada simplemente a modo de demostración, para que puedas agregar cualquier producto... en tu caso, cuando tu sistema de encuentre en producción, tendrás que mostrar automáticamente tus productos desde tu base de datos!
						</div>
					</div>
					<form action="#" id="frm_producto" method="get" accept-charset="utf-8">
						<div class="row">
							<div class="form-group col-md-6">
		                        <label for="producto_codigo">Codigo</label>
		                        <input type="text" class="form-control" value="" name="producto_codigo" id="producto_codigo">
		                    </div>
		                    <div class="form-group col-md-6">
		                        <label for="producto_unidadmedida">Und/Medida</label>
		                        <select class="form-control valid" name="producto_unidadmedida" id="producto_unidadmedida">
		                            <option value="NIU">KILOGRAMOS</option>
		                            <option value="NIU">LIBRAS</option>
		                            <option value="NIU">TONELADAS LARGAS</option>
		                            <option value="NIU">TONELADAS METRICAS</option>
		                            <option value="NIU">TONELADAS CORTAS</option>
		                            <option value="NIU">GRAMOS</option>
		                            <option value="NIU">UNIDADES</option>
		                            <option value="NIU">LITROS</option>
		                            <option value="NIU">GALONES</option>
		                            <option value="NIU">BARRILES</option>
		                            <option value="NIU">LATAS</option>
		                            <option value="NIU">CAJAS</option>
		                            <option value="NIU">MILLARES</option>
		                            <option value="NIU">METROS CUBICOS</option>
		                            <option value="NIU">METROS</option>
		                        </select>
		                    </div>
		                    <div class="form-group col-md-12">
		                        <label for="producto_descripcion">Descripcion</label>
		                        <input type="text" class="form-control" value="" name="producto_descripcion" id="producto_descripcion">
		                    </div>
		                    <div class="form-group col-md-6">
		                        <label for="producto_preciounidad">Precio/Uni(Inc.IGV)</label>
		                        <input type="text" class="form-control" value="" name="producto_preciounidad" id="producto_preciounidad">
		                    </div>
		                    <div class="form-group col-md-6">
		                        <label for="producto_cantidad">Cantidad</label>
		                        <input type="text" class="form-control" value="" name="producto_cantidad" id="producto_cantidad">
		                    </div>
		                    <div class="form-group col-md-4">
		                        <label for="producto_subtotal">Sub.Total</label>
		                        <input type="text" class="form-control" value="" name="producto_subtotal" id="producto_subtotal" disabled="disabled">
		                    </div>
		                    <div class="form-group col-md-4">
		                        <label for="producto_igv">IGV (18%)</label>
		                        <input type="text" class="form-control" value="" name="producto_igv" id="producto_igv" disabled="disabled">
		                    </div>
		                    <div class="form-group col-md-4">
		                        <label for="producto_total">Total</label>
		                        <input type="text" class="form-control" value="" name="producto_total" id="producto_total" disabled="disabled">
		                    </div>

		                    <div class="form-group col-md-12">
		                    	<button type="button" class="btn btn-success btn_agregarproducto_detalle">Agregar</button>
		                    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		                    </div>
		                </div>
	            	</form>
				</div>

			</div>
		</div>
	</div>
	<!-- /primary modal -->


	<!-- Footer -->
	<div class="navbar navbar-default navbar-fixed-bottom footer">
		<ul class="nav navbar-nav visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#footer"><i class="icon-circle-up2"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="footer">
			<div class="navbar-text">
				&copy; 2017. <a href="#" class="navbar-link">Facturación Electrónica Sunat - Perú</a> by <a href="#" class="navbar-link" target="_blank">Alex Castaneda</a>
			</div>

			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="#">About</a></li>
					<li><a href="#">Terms</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /footer -->

</body>
</html>
