<?php
require('conexion.php');
require('inicializar-datos.php');
require('permisos.php');
require('helper.php');
require('../modelo/modelo-clientes.php');
require('../modelo/modelo-clientes-sedes.php');
require('../modelo/modelo-clientes-sedes-contactos.php');
require('../modelo/modelo-departamentos.php');
require('../modelo/modelo-provincias.php');
require('../modelo/modelo-distritos.php');
/******************************************************/
/******************************************************/
$helper = new helper();
$page = array_key_exists('page', $_POST) ? intval($helper->Reservado($_POST['page'])) : 0;
$multiple_result = array_key_exists('multiple_result', $_POST) ? json_decode($helper->Reservado($_POST['multiple_result']),true) : true;
$sub_modulo = $_POST['sub_modulo'] ?? '';
$limit_per_page = 10;
$offset = 0;
$paginar = false;
if ($page >= 1) {
	$paginar = true;
}
$select = '';
$select_count = '';
$joins = '';
$where = '';
$data_out = [];
$success = false;
$mensaje = '';
/******************************************************/
/******************************************************/
if ($sub_modulo == 'Departamentos' or $sub_modulo == 'Provincias' or $sub_modulo == 'Distritos') { $can_select = true; }
if ($can_select) {
	switch($sub_modulo){
		case 'Clientes':
			$cliente = new ModeloClientes();
			$rs = $cliente->ListarDatos($_POST);
		break;
		case 'Sedes por Cliente':
			$sede_x_cliente = new ModeloClientesSedes();
			$rs = $sede_x_cliente->ListarDatos($_POST);
		break;
		case 'Contactos por Sede':
			$contacto_x_sede = new ModeloClientesSedesContactos();
			$rs = $contacto_x_sede->ListarDatos($_POST);
		break;
		case 'Departamentos':
			$departamentos = new ModeloDepartamentos();
			$rs = $departamentos->ListarDatos($_POST);
		break;
		case 'Provincias':
			$provincias = new ModeloProvincias();
			$rs = $provincias->ListarDatos($_POST);
		break;
		case 'Distritos':
			$distritos = new ModeloDistritos();
			$rs = $distritos->ListarDatos($_POST);
		break;
		default:
		break;
	}
	$success = $rs['success'] ?? false;
	$mensaje = $rs['mensaje'] ?? '';
	$data_out['data'] = $rs['data'] ?? [];
	$data_out['Tam_datos'] = $rs['Tam_datos'] ?? 0;
	$data_out['can_update'] = $can_update;
	$data_out['can_delete'] = $can_delete;
}
$data_out['n_grupo'] = $limit_per_page;
$data_out['success'] = $success;
$data_out['mensaje'] = $mensaje;
/******************************************************/
/******************************************************/
echo json_encode($data_out);