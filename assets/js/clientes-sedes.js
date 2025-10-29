let _SUB_MODULO = 'Sedes por Cliente';
$('#cod_cliente_buscar').select2();
$('#cod_cliente_nuevo').select2();
$('#cod_cliente_editar').select2();
$('.select2-container').css({'width':'100%'});
// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function Enter(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla == 13){
		ListarSedes(1);
	}
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function ListarSedes(page=1) {
	let param = {
		page : page,
		sub_modulo : _SUB_MODULO,
		cod_cliente : $('#cod_cliente_buscar').val(),
		cod_tipo_direcc : $('#cod_tipo_direcc_buscar').val(),
		direccion : $('#direccion_buscar').val(),
		cod_dpto : $('#cod_dpto_buscar').val(),
		cod_prov : $('#cod_prov_buscar').val(),
		cod_dist : $('#cod_dist_buscar').val(),
		estado : $('#estado_buscar').val(),
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		let tabla = 'tbl_sedes_x_clientes';
		let paginador = 'paginador_'+tabla;
		$('#'+tabla+' tbody').remove();
		$('#'+tabla).append('<tbody>');
		if (data.success) {
			$.each(data.data,function(i,item){
				let index = ((page-1)*data.n_grupo)+(i+1);
				let acciones = '';
				if (data.can_update) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-success btn-sm" title="Editar Sede" onClick="EditarSede(\''+item.cod_sede+'\');">'+
									'<i class="ri-edit-fill align-middle"></i>'+
								'</a>&nbsp;';
				}
				if (data.can_delete) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" title="Eliminar Sede" onClick="EliminarSede(\''+item.cod_sede+'\');">'+
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
						"<td align='center'>"+(item.cod_cliente == '' || item.cod_cliente == null ? '-' : (item.num_documento+' | '+item.nom_cliente))+"</td>"+
						"<td align='center'>"+(item.tipo_direccion ?? '-')+"</td>"+
						"<td align='center'>"+(item.direccion ?? '-')+"</td>"+
						"<td align='center'>"+(item.referencia ?? '-')+"</td>"+
						"<td align='center'>"+(item.nom_dpto ?? '-')+"</td>"+
						"<td align='center'>"+(item.nom_prov ?? '-')+"</td>"+
						"<td align='center'>"+(item.nom_dist ?? '-')+"</td>"+
						"<td align='center'>"+estado+"</td>"+
						"<td align='center'>"+acciones+"</td>"+
					"</tr>"
				);
			});
			Paginador(page,data.Tam_datos,data.n_grupo,paginador,'ListarSedes');
		} else {
			$('#'+tabla).append("<tr><td colspan='10'><center>"+data.mensaje+"</center></td></tr>");
			$('#'+paginador+' ul').remove();
		}
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function LimpiarCampos_NuevaSede(){
	$('#cod_cliente_nuevo').val('').trigger('change');
	$('#cod_tipo_direcc_nuevo').val('').trigger('change');
	$('#direccion_nuevo').val('');
	$('#referencia_nuevo').val('');
	$('#cod_dpto_nuevo').val('').trigger('change');
	$('input[name=estado_nuevo][value="A"]').prop('checked',true);
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function GuardarNuevaSede() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'RegistrarSede',
		cod_cliente : $('#cod_cliente_nuevo').val(),
		cod_tipo_direcc : $('#cod_tipo_direcc_nuevo').val(),
		direccion : $('#direccion_nuevo').val(),
		referencia : $('#referencia_nuevo').val(),
		cod_dpto : $('#cod_dpto_nuevo').val(),
		cod_prov : $('#cod_prov_nuevo').val(),
		cod_dist : $('#cod_dist_nuevo').val(),
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
				ListarSedes(1);
				OpenCloseModal('mNuevaSede','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EditarSede(cod_sede) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_sede : cod_sede,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		if (data.success) {
			var data_reg = data.data;
			$('#cod_sede_editar').val(data_reg.cod_sede);
			$('#cod_cliente_editar').val(data_reg.cod_cliente).trigger('change');
			$('#cod_tipo_direcc_editar').val(data_reg.id_tipo_direccion).trigger('change');
			$('#direccion_editar').val(data_reg.direccion);
			$('#referencia_editar').val(data_reg.referencia);
			$('#cod_dpto_editar').val(data_reg.IdDepartamento).trigger('change');
			setTimeout(function(){
				$('#cod_prov_editar').val(data_reg.IdProvincia).trigger('change');
				setTimeout(function(){
					$('#cod_dist_editar').val(data_reg.IdDistrito).trigger('change');
				},500);
			},500);
			$('input[name=estado_editar][value="'+data_reg.estado+'"]').prop('checked',true);
			OpenCloseModal('mEditarSede','o');
		}
	});
}

function GuardarEditarSede() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'ActualizarSede',
		cod_sede : $('#cod_sede_editar').val(),
		cod_cliente : $('#cod_cliente_editar').val(),
		cod_tipo_direcc : $('#cod_tipo_direcc_editar').val(),
		direccion : $('#direccion_editar').val(),
		referencia : $('#referencia_editar').val(),
		cod_dpto : $('#cod_dpto_editar').val(),
		cod_prov : $('#cod_prov_editar').val(),
		cod_dist : $('#cod_dist_editar').val(),
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
				ListarSedes(pagina_actual);
				OpenCloseModal('mEditarSede','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EliminarSede(cod_sede) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_sede : cod_sede,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		Swal.fire({
			html: '<b>¿Estás seguro(a) que quieres eliminar la Sede: <font color="red">'+data.data.direccion+'</font><br>Perteneciente al Cliente: <font color="red">'+data.data.num_documento+' | '+data.data.nom_cliente+'</font></b>?',
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
					proceso : 'EliminarSede',
					cod_sede : data.data.cod_sede
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
							ListarSedes(pagina_actual);
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
		cod_cliente : $('#cod_cliente_buscar').val(),
		cod_tipo_direcc : $('#cod_tipo_direcc_buscar').val(),
		direccion : $('#direccion_buscar').val(),
		cod_dpto : $('#cod_dpto_buscar').val(),
		cod_prov : $('#cod_prov_buscar').val(),
		cod_dist : $('#cod_dist_buscar').val(),
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