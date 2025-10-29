let _SUB_MODULO = 'Clientes';
// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function Enter(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla == 13){
		ListarClientes(1);
	}
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function ListarClientes(page=1) {
	let param = {
		page : page,
		sub_modulo : _SUB_MODULO,
		cod_puntoventa : $('#cod_puntoventa_buscar').val(),
		num_documento : $('#num_documento_buscar').val(),
		razon_social : $('#razon_social_buscar').val(),
		nombre_comercial : $('#nombre_comercial_buscar').val(),
		giro_negocio : $('#giro_negocio_buscar').val(),
		estado : $('#estado_buscar').val(),
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		let tabla = 'tbl_clientes';
		let paginador = 'paginador_'+tabla;
		$('#'+tabla+' tbody').remove();
		$('#'+tabla).append('<tbody>');
		if (data.success) {
			$.each(data.data,function(i,item){
				let index = ((page-1)*data.n_grupo)+(i+1);
				let acciones = '';
				if (data.can_update) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-success btn-sm" title="Editar Cliente" onClick="EditarCliente(\''+item.cod_cliente+'\');">'+
									'<i class="ri-edit-fill align-middle"></i>'+
								'</a>&nbsp;';
				}
				if (data.can_delete) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" title="Eliminar Cliente" onClick="EliminarCliente(\''+item.cod_cliente+'\');">'+
									'<i class="ri-delete-bin-fill align-middle"></i>'+
								'</a>&nbsp;';
				}
				let estado = '';
				if (item.estado == 'A') {
					estado = '<span class="badge rounded-pill bg-success">Activo</span>';
				} else {
					estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
				}
				$('#'+tabla).append(
					"<tr>"+
						"<td align='center'>"+index+"</td>"+
						"<td align='center'>"+(item.nombre_puntoventa ?? '-')+"</td>"+
						"<td align='center'>"+(item.nom_cliente ?? '-')+"</td>"+
						"<td align='center'>"+(item.nombre_comercial ?? '-')+"</td>"+
						"<td align='center'>"+(item.nom_tipo_doc ?? '-')+"</td>"+
						"<td align='center'>"+(item.num_documento ?? '-')+"</td>"+
						"<td align='center'>"+(item.nombre_giro ?? '-')+"</td>"+
						"<td align='center'>"+estado+"</td>"+
						"<td align='center'>"+acciones+"</td>"+
					"</tr>"
				);
			});
			Paginador(page,data.Tam_datos,data.n_grupo,paginador,'ListarClientes');
		} else {
			$('#'+tabla).append("<tr><td colspan='9'><center>"+data.mensaje+"</center></td></tr>");
			$('#'+paginador+' ul').remove();
		}
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function LimpiarCampos_NuevoCliente(){
	$('#cod_puntoventa_nuevo').val('').trigger('change');
	$('#cod_tipodoc_nuevo').val('').trigger('change');
	$('#num_documento_nuevo').val('');
	$('#razon_social_nuevo').val('');
	$('#nombre_comercial_nuevo').val('');
	$('#giro_negocio_nuevo').val('').trigger('change');
	$('#website_nuevo').val('');
	$('input[name=estado_nuevo][value="A"]').prop('checked',true);
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function GuardarNuevoCliente() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'RegistrarCliente',
		cod_puntoventa : $('#cod_puntoventa_nuevo').val(),
		cod_tipodoc : $('#cod_tipodoc_nuevo').val(),
		num_documento : $('#num_documento_nuevo').val(),
		razon_social : $('#razon_social_nuevo').val(),
		nombre_comercial : $('#nombre_comercial_nuevo').val(),
		giro_negocio : $('#giro_negocio_nuevo').val(),
		website : $('#website_nuevo').val(),
		estado : $('input[name=estado_nuevo]:checked').val(),
	};
	SendAjax('config/proceso-guardar.php',param,1,function(data){
		HideLoad();
		Swal.fire({
			title: data.success ? 'Correcto' : 'Algo no salió bien!',
			html: data.mensaje,
			icon: data.tipo,
			showCancelButton: false,
			confirmButtonText: 'Aceptar',
			footer: data.foot,
			allowOutsideClick: false
		}).then((result) => {
			if (result.isConfirmed && data.success) {
				ListarClientes(1);
				OpenCloseModal('mNuevoCliente','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EditarCliente(cod_cliente) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_cliente : cod_cliente,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		if (data.success) {
			var data_reg = data.data;
			$('#cod_cliente_editar').val(data_reg.cod_cliente).trigger('change');
			$('#cod_puntoventa_editar').val(data_reg.cod_puntoventa).trigger('change');
			$('#cod_tipodoc_editar').val(data_reg.cod_tipodoc).trigger('change');
			$('#num_documento_editar').val(data_reg.num_documento);
			$('#razon_social_editar').val(data_reg.nom_cliente);
			$('#nombre_comercial_editar').val(data_reg.nombre_comercial);
			$('#giro_negocio_editar').val(data_reg.id_giro_negocio).trigger('change');
			$('#website_editar').val(data_reg.website);
			$('input[name=estado_editar][value="'+data_reg.estado+'"]').prop('checked',true);
			OpenCloseModal('mEditarCliente','o');
		}
	});
}

function GuardarEditarCliente() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'ActualizarCliente',
		cod_cliente : $('#cod_cliente_editar').val(),
		cod_puntoventa : $('#cod_puntoventa_editar').val(),
		cod_tipodoc : $('#cod_tipodoc_editar').val(),
		num_documento : $('#num_documento_editar').val(),
		razon_social : $('#razon_social_editar').val(),
		nombre_comercial : $('#nombre_comercial_editar').val(),
		giro_negocio : $('#giro_negocio_editar').val(),
		website : $('#website_editar').val(),
		estado : $('input[name=estado_editar]:checked').val(),
	};
	SendAjax('config/proceso-guardar.php',param,1,function(data){
		HideLoad();
		Swal.fire({
			title: data.success ? 'Correcto' : 'Algo no salió bien!',
			html: data.mensaje,
			icon: data.tipo,
			showCancelButton: false,
			confirmButtonText: 'Aceptar',
			footer: data.foot,
			allowOutsideClick: false
		}).then((result) => {
			if (result.isConfirmed && data.success) {
				ListarClientes(pagina_actual);
				OpenCloseModal('mEditarCliente','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EliminarCliente(cod_cliente) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_cliente : cod_cliente,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		Swal.fire({
			html: '<b>¿Estás seguro(a) que quieres eliminar al Cliente: <font color="red">'+data.data.nom_cliente+'</font></b>?',
			icon: 'info',
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: 'Aceptar',
			denyButtonText: 'Cancelar',
			footer: '<font size="3" color="#A133F7"><b><i>Recuerda que esta acción no se puede revertir</i></b></font>',
			allowOutsideClick: false
		}).then((result) => {
			if (result.isConfirmed && data.success) {
				let param_2 = {
					modulo : param.sub_modulo,
					sub_modulo : param.sub_modulo,
					proceso : 'EliminarCliente',
					cod_cliente : data.data.cod_cliente
				};
				SendAjax('config/proceso-guardar.php',param_2,1,function(data){
					HideLoad();
					Swal.fire({
						title: data.success ? 'Correcto' : 'Algo no salió bien!',
						html: data.mensaje,
						icon: data.tipo,
						showCancelButton: false,
						confirmButtonText: 'Aceptar',
						footer: data.foot,
						allowOutsideClick: false
					}).then((result) => {
						if (result.isConfirmed && data.success) {
							ListarClientes(pagina_actual);
						}
					});
				});
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function GenerarExcel() {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_puntoventa : $('#cod_puntoventa_buscar').val(),
		num_documento : $('#num_documento_buscar').val(),
		razon_social : $('#razon_social_buscar').val(),
		nombre_comercial : $('#nombre_comercial_buscar').val(),
		giro_negocio : $('#giro_negocio_buscar').val(),
		estado : $('#estado_buscar').val(),
	};
	SendAjax('config/generar-excel.php',param,1,function(data){
		HideLoad();
		if (data.success) {
			window.open(data.achivoxls,'_blank');
		} else {
			Swal.fire({
				title: data.success ? 'Correcto' : 'Algo no salió bien!',
				html: data.mensaje,
				icon: data.tipo,
				showCancelButton: false,
				confirmButtonText: 'Aceptar',
				footer: data.foot,
				allowOutsideClick: false
			});
		}
	});
}