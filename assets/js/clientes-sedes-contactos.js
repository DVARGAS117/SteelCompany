let _SUB_MODULO = 'Contactos por Sede';
$('#cod_cliente_buscar').select2();
$('#cod_cliente_nuevo').select2();
$('#cod_cliente_editar').select2();
$('#cod_sede_buscar').select2();
$('#cod_sede_nuevo').select2();
$('#cod_sede_editar').select2();
$('.select2-container').css({'width':'100%'});
// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function Enter(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla == 13){
		ListarContactos(1);
	}
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function ListarContactos(page=1) {
	let param = {
		page : page,
		sub_modulo : _SUB_MODULO,
		cod_cliente : $('#cod_cliente_buscar').val(),
		cod_sede : $('#cod_sede_buscar').val(),
		cod_tipo_contacto : $('#cod_tipo_contacto_buscar').val(),
		nombre_contacto : $('#nombre_contacto_buscar').val(),
		telefono : $('#telefono_buscar').val(),
		email : $('#email_buscar').val(),
		estado : $('#estado_buscar').val(),
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		let tabla = 'tbl_contactos_x_sedes';
		let paginador = 'paginador_'+tabla;
		$('#'+tabla+' tbody').remove();
		$('#'+tabla).append('<tbody>');
		if (data.success) {
			$.each(data.data,function(i,item){
				let index = ((page-1)*data.n_grupo)+(i+1);
				let telefono_1 = item.telefono_1 ?? '';
				let telefono_2 = item.telefono_2 ?? '';
				let telefonos = '-';
				if (telefono_1 == '' && telefono_2 != '') {
					telefonos = telefono_2;
				}
				if (telefono_1 != '' && telefono_2 == '') {
					telefonos = telefono_1;
				}
				if (telefono_1 != '' && telefono_2 != '') {
					telefonos = telefono_1+' - '+telefono_2;
				}
				let acciones = '';
				if (data.can_update) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-success btn-sm" title="Editar Contacto" onClick="EditarContacto(\''+item.cod_contacto+'\');">'+
									'<i class="ri-edit-fill align-middle"></i>'+
								'</a>&nbsp;';
				}
				if (data.can_delete) {
					acciones +=	'<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" title="Eliminar Contacto" onClick="EliminarContacto(\''+item.cod_contacto+'\');">'+
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
						"<td align='center'>"+(item.cod_cliente == 0 || item.cod_cliente == null ? '-' : (item.num_documento+' | '+item.nom_cliente))+"</td>"+
						"<td align='center'>"+(item.cod_sede == 0 || item.cod_sede == null ? '-' : item.direccion)+"</td>"+
						"<td align='center'>"+(item.tipo_contacto ?? '-')+"</td>"+
						"<td align='center'>"+(item.persona_contacto ?? '-')+"</td>"+
						"<td align='center'>"+telefonos+"</td>"+
						"<td align='center'>"+(item.email ?? '-')+"</td>"+
						"<td align='center'>"+estado+"</td>"+
						"<td align='center'>"+acciones+"</td>"+
					"</tr>"
				);
			});
			Paginador(page,data.Tam_datos,data.n_grupo,paginador,'ListarContactos');
		} else {
			$('#'+tabla).append("<tr><td colspan='9'><center>"+data.mensaje+"</center></td></tr>");
			$('#'+paginador+' ul').remove();
		}
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function LimpiarCampos_NuevoContacto(){
	$('#cod_cliente_nuevo').val('').trigger('change');
	$('#cod_tipo_contacto_nuevo').val('').trigger('change');
	$('#nombre_contacto_nuevo').val('');
	$('#telefono1_nuevo').val('');
	$('#telefono2_nuevo').val('');
	$('#email_nuevo').val('');
	$('#emailOK_1').html('');
	$('input[name=estado_nuevo][value="A"]').prop('checked',true);
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function GuardarNuevoContacto() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'RegistrarContacto',
		cod_cliente : $('#cod_cliente_nuevo').val(),
		cod_sede : $('#cod_sede_nuevo').val(),
		cod_tipo_contacto : $('#cod_tipo_contacto_nuevo').val(),
		nombre_contacto : $('#nombre_contacto_nuevo').val(),
		telefono1 : $('#telefono1_nuevo').val(),
		telefono2 : $('#telefono2_nuevo').val(),
		email : $('#email_nuevo').val(),
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
				ListarContactos(1);
				OpenCloseModal('mNuevoContacto','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EditarContacto(cod_contacto) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_contacto : cod_contacto,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		if (data.success) {
			var data_reg = data.data;
			$('#cod_contacto_editar').val(data_reg.cod_contacto);
			$('#cod_cliente_editar').val(data_reg.cod_cliente).trigger('change');
			setTimeout(function(){
				$('#cod_sede_editar').val(data_reg.cod_sede).trigger('change');
			},500);
			$('#cod_tipo_contacto_editar').val(data_reg.id_tipo_contacto).trigger('change');
			$('#nombre_contacto_editar').val(data_reg.persona_contacto);
			$('#telefono1_editar').val(data_reg.telefono_1);
			$('#telefono2_editar').val(data_reg.telefono_2);
			$('#email_editar').val(data_reg.email);
			$('#emailOK_2').html('');
			$('input[name=estado_editar][value="'+data_reg.estado+'"]').prop('checked',true);
			OpenCloseModal('mEditarContacto','o');
		}
	});
}

function GuardarEditarContacto() {
	let param = {
		modulo : _SUB_MODULO,
		sub_modulo : _SUB_MODULO,
		proceso : 'ActualizarContacto',
		cod_contacto : $('#cod_contacto_editar').val(),
		cod_cliente : $('#cod_cliente_editar').val(),
		cod_sede : $('#cod_sede_editar').val(),
		cod_tipo_contacto : $('#cod_tipo_contacto_editar').val(),
		nombre_contacto : $('#nombre_contacto_editar').val(),
		telefono1 : $('#telefono1_editar').val(),
		telefono2 : $('#telefono2_editar').val(),
		email : $('#email_editar').val(),
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
				ListarContactos(pagina_actual);
				OpenCloseModal('mEditarContacto','c');
			}
		});
	});
}

// *************************************************************************************************************************************************************************************************
// *************************************************************************************************************************************************************************************************
function EliminarContacto(cod_contacto) {
	let param = {
		sub_modulo : _SUB_MODULO,
		cod_contacto : cod_contacto,
		multiple_result : false
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		Swal.fire({
			html: '<b>¿Estás seguro(a) que quieres eliminar el Contacto: <font color="red">'+data.data.persona_contacto+'</font><br>De la Sede: <font color="red">'+data.data.direccion+'</font><br>Perteneciente al Cliente: <font color="red">'+data.data.num_documento+' | '+data.data.nom_cliente+'</font></b>?',
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
					proceso : 'EliminarContacto',
					cod_contacto : data.data.cod_contacto
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
							ListarContactos(pagina_actual);
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
		cod_sede : $('#cod_sede_buscar').val(),
		cod_tipo_contacto : $('#cod_tipo_contacto_buscar').val(),
		nombre_contacto : $('#nombre_contacto_buscar').val(),
		telefono : $('#telefono_buscar').val(),
		email : $('#email_buscar').val(),
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