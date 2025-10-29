function validarnu(e){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	patron = /\d/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarle(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron =/[A-Za-z\sñ á é í ó ú Á É Í Ó Ú Ñ]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarNumLet(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron = /([0-9\A-Za-z\sñ Ñ])/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarRZ(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron = /[0-9\A-Za-z\sñ á é í ó ú Á É Í Ó Ú Ñ\.]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarPagWeb(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron = /[0-9\A-Za-z\sñ á é í ó ú Á É Í Ó Ú Ñ\/\:\.]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarKeyEmail(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron = /([0-9\A-Za-z\sñ Ñ\@\_\-\.])/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarDirecc(e,no_space=false){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	if (no_space) {
		if (tecla==32) return false;
	}
	patron = /([0-9\°\/\-\.\,\(\)\A-Za-z\sñ Ñ])/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validateMail(idinput,idspan){
	object = document.getElementById(idinput);
	valueForm = object.value;
	var patron = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
	var correo = $('#'+idinput).val();
	var pos = correo.indexOf("@");
	var dominio = correo.substring(pos);
	if (valueForm.search(patron) == 0) {
		$('#'+idspan).html('');
		$('#'+idspan).attr('style', 'color:green; font-family:Seravek; padding-left: 6px');
		return;
	} else {
		$('#'+idspan).html('Correo inválido. Ej: ejemplo@dominio.com');
		$('#'+idspan).attr('style', 'color:red; font-family:Seravek; padding-left: 6px');
		return;
	}
}

function OpenCloseModal(idmodal,accion){
	switch(accion){
		case 'o':
		case 'O':
			$('#'+idmodal).modal('show');
		break;
		case 'c':
		case 'C':
			$('#'+idmodal).modal('hide');
		break;
	}
}

function SendAjax(url,param,tipo,callback){
	switch(tipo){
		case 1:
			$.ajax({
				url: url,
				type: 'post',
				data: param,
				dataType: 'json',
				beforeSend: function() {
					ShowLoad();
				}
			}).done(callback).fail(errorFunction);
		break;
		case 2:
			$.ajax({
				url: url,
				type: 'post',
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				data: param,
				dataType: 'json',
				beforeSend: function(e){
					$('#load').addClass('load');
				}
			}).done(callback).fail(errorFunction);
		break;
	}
}

function errorFunction(e){
	$('#load').removeClass('load');
	alert('Error -> '+e.status+' '+e.statusText);
}

function ShowLoad(){
	$('#load').addClass('load');
}

function HideLoad(){
	$('#load').removeClass('load');
}

var pagina_actual = 1;
function Paginador(pag,Tam_datos,n_grupo,div_pag,funcion){
	tmp = Tam_datos % n_grupo;

	if (tmp == 0) {
		nPag = Tam_datos/n_grupo;
	} else {
		tmp2 = Tam_datos-tmp;
		nPag = (tmp2 / n_grupo)+1;
	}

	$('#'+div_pag+' ul').remove();
	$('#'+div_pag).append('<ul class="pagination">');
	var a4 = pag-4;
	var a3 = pag-3;
	var a2 = pag-2;
	var a1 = pag-1;
	var d1 = pag+1;
	var d2 = pag+2;
	var d3 = pag+3;
	var d4 = pag+4;
	var ant = pag-6;
	var sig = pag+6;
	var anterior = (pag-1);
	var siguiente = (pag+1);

	pagina_actual = pag;
	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_ant" type="button" onclick="'+funcion+'('+anterior+');"><i class="fas fa-backward"></i></a></li>');
	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_1" type="button" hidden onclick="'+funcion+'(1);">1</a></li>');
	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_ant_mas" class="sinEfecto" hidden disabled>...</a></li>');

	for (var i = 2; i < nPag ; i++) {
		$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_'+i+'" type="button" hidden onclick="'+funcion+'('+i+');">'+i+'</a></li>');
	}

	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_sig_mas" class="sinEfecto" disabled>...</a></li>');
	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_'+nPag+'" type="button" hidden onclick="'+funcion+'('+nPag+');">'+nPag+'</a></li>');
	$('#'+div_pag+' ul').append('<li><a href="javascript: void(0)" id="btn_pag_sig" type="button" onclick="'+funcion+'('+siguiente+');"><i class="fas fa-forward"></i></a></li>');

	$("#btn_pag_"+pag).attr('class','pag_select');
	$("#btn_pag_"+pag).removeAttr('hidden');
	$("#btn_pag_1").removeAttr('hidden');
	$("#btn_pag_"+nPag).removeAttr('hidden');

	if (ant > 0) {
		$("#btn_pag_ant_mas").removeAttr('hidden');
	}

	if (sig > nPag) {
		$("#btn_pag_sig_mas").attr('hidden','hidden');
	}

	if (anterior < 1) {
		$("#btn_pag_ant").attr('hidden','hidden');
	}

	if (siguiente > nPag) {
		$("#btn_pag_sig").attr('hidden','hidden');
	}

	$("#btn_pag_"+a4).removeAttr('hidden');
	$("#btn_pag_"+a3).removeAttr('hidden');
	$("#btn_pag_"+a2).removeAttr('hidden');
	$("#btn_pag_"+a1).removeAttr('hidden');
	$("#btn_pag_"+d1).removeAttr('hidden');
	$("#btn_pag_"+d2).removeAttr('hidden');
	$("#btn_pag_"+d3).removeAttr('hidden');
	$("#btn_pag_"+d4).removeAttr('hidden');
	$('#'+div_pag).append('</ul>');
}

function ListarProvincias(id_select_dpto, id_select_prov, text_empty, return_callback=false, callback) {
	let param = {
		sub_modulo : 'Provincias',
		cod_dpto : $('#'+id_select_dpto).val()
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		$('#'+id_select_prov+' option').remove();
		$('#'+id_select_prov).append('<option value="">'+text_empty+'</option>');
		$('#'+id_select_prov).val('').trigger('change');
		if (data.success) {
			$.each(data.data,function(i,item){
				$('#'+id_select_prov).append('<option value="'+item.id+'">'+item.name+'</option>');
			});
		}
		if (return_callback) { callback(); }
	});
}

function ListarDistritos(id_select_prov, id_select_dist, text_empty, return_callback=false, callback) {
	let param = {
		sub_modulo : 'Distritos',
		cod_prov : $('#'+id_select_prov).val()
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		$('#'+id_select_dist+' option').remove();
		$('#'+id_select_dist).append('<option value="">'+text_empty+'</option>');
		$('#'+id_select_dist).val('').trigger('change');
		if (data.success) {
			$.each(data.data,function(i,item){
				$('#'+id_select_dist).append('<option value="'+item.id+'">'+item.name+'</option>');
			});
		}
		if (return_callback) { callback(); }
	});
}

function SedesPorCliente_ForSelect(id_select_cliente, id_select_sede, text_empty, return_callback=false, callback) {
	let param = {
		sub_modulo : 'Sedes por Cliente',
		cod_cliente : $('#'+id_select_cliente).val(),
		for_select : true
	};
	SendAjax('config/listar-datos.php',param,1,function(data){
		HideLoad();
		$('#'+id_select_sede+' option').remove();
		$('#'+id_select_sede).append('<option value="">'+text_empty+'</option>');
		$('#'+id_select_sede).val('').trigger('change');
		if (data.success) {
			$.each(data.data,function(i,item){
				$('#'+id_select_sede).append('<option value="'+item.cod_sede+'">'+item.direccion+'</option>');
			});
		}
		if (return_callback) { callback(); }
	});
}