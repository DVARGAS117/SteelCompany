<?php
require('conexion.php');
require('inicializar-datos.php');
require('permisos.php');
require('helper.php');
require('../phpspreadsheet/PhpOffice/autoload.php');
require('../modelo/modelo-clientes.php');
require('../modelo/modelo-clientes-sedes.php');
require('../modelo/modelo-clientes-sedes-contactos.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
/******************************************************/
/******************************************************/
$helper = new helper();
$sub_modulo = $_POST['sub_modulo'] ?? '';
$data_out = [];
$success = false;
$mensaje = '';
$url = '';
$param = $_POST;
$name_xls = '';
/******************************************************/
/******************************************************/
if ($can_select) {
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	switch ($sub_modulo) {
		case 'Clientes':
			$modelo = new ModeloClientes();
			$rs = $modelo->ListarDatos($_POST);
			if ($rs['success']) {
				set_time_limit(20*count($rs['data']));
				$sheet->setTitle('Clientes');
				$sheet->setCellValue('A1','PUNTO DE VENTA');
				$sheet->setCellValue('B1','CLIENTE');
				$sheet->setCellValue('C1','NOMBRE COMERCIAL');
				$sheet->setCellValue('D1','TIPO DE DOCUMENTO');
				$sheet->setCellValue('E1','N° DE DOCUMENTO');
				$sheet->setCellValue('F1','GIRO DE NEGOCIO');
				$sheet->setCellValue('G1','WEBSITE');
				$sheet->setCellValue('H1','ESTADO');
				$i = 2;
				foreach($rs['data'] as $datos){
					$sheet->setCellValue('A'.$i,$datos['nombre_puntoventa']);
					$sheet->setCellValue('B'.$i,$datos['nom_cliente']);
					$sheet->setCellValue('C'.$i,($datos['nombre_comercial'] ?? ''));
					$sheet->setCellValue('D'.$i,$datos['nom_tipo_doc']);
					$sheet->setCellValue('E'.$i,$datos['num_documento']);
					$sheet->setCellValue('F'.$i,($datos['nombre_giro'] ?? ''));
					$sheet->setCellValue('G'.$i,($datos['website'] ?? ''));
					$sheet->setCellValue('H'.$i,($datos['estado'] == 'A' ? 'Activo' : 'Inactivo'));
					$i++;
				}
				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$name_xls = 'clientes.xlsx';
			}
		break;
		case 'Sedes por Cliente':
			$modelo = new ModeloClientesSedes();
			$rs = $modelo->ListarDatos($_POST);
			if ($rs['success']) {
				set_time_limit(20*count($rs['data']));
				$sheet->setTitle('Sedes por Cliente');
				$sheet->setCellValue('A1','CLIENTE');
				$sheet->setCellValue('B1','TIPO DE DIRECCIÓN');
				$sheet->setCellValue('C1','DIRECCIÓN');
				$sheet->setCellValue('D1','REFERENCIA');
				$sheet->setCellValue('E1','DEPARTAMENTO');
				$sheet->setCellValue('F1','PROVINCIA');
				$sheet->setCellValue('G1','DISTRITO');
				$sheet->setCellValue('H1','ESTADO');
				$i = 2;
				foreach($rs['data'] as $datos){
					$sheet->setCellValue('A'.$i,($datos['num_documento'].' | '.$datos['nom_cliente']));
					$sheet->setCellValue('B'.$i,$datos['tipo_direccion']);
					$sheet->setCellValue('C'.$i,$datos['direccion']);
					$sheet->setCellValue('D'.$i,($datos['referencia']  ?? ''));
					$sheet->setCellValue('E'.$i,$datos['nom_dpto']);
					$sheet->setCellValue('F'.$i,$datos['nom_prov']);
					$sheet->setCellValue('G'.$i,$datos['nom_dist']);
					$sheet->setCellValue('H'.$i,($datos['estado'] == 'A' ? 'Activo' : 'Inactivo'));
					$i++;
				}
				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$name_xls = 'sedes_x_clientes.xlsx';
			}
		break;
		case 'Contactos por Sede':
			$modelo = new ModeloClientesSedesContactos();
			$rs = $modelo->ListarDatos($_POST);
			if ($rs['success']) {
				set_time_limit(20*count($rs['data']));
				$sheet->setTitle('Contactos x Sedes x Clientes');
				$sheet->setCellValue('A1','CLIENTE');
				$sheet->setCellValue('B1','SEDE (DIRECCIÓN)');
				$sheet->setCellValue('C1','TIPO DE CONTACTO');
				$sheet->setCellValue('D1','CONTACTO');
				$sheet->setCellValue('E1','TELÉFONOS');
				$sheet->setCellValue('F1','EMAIL');
				$sheet->setCellValue('G1','ESTADO');
				$i = 2;
				foreach($rs['data'] as $datos){
					$telefono_1 = $datos['telefono_1'] ?? '';
					$telefono_2 = $datos['telefono_2'] ?? '';
					$telefonos = '-';
					if ($telefono_1 == '' && $telefono_2 != '') {
						$telefonos = $telefono_2;
					}
					if ($telefono_1 != '' && $telefono_2 == '') {
						$telefonos = $telefono_1;
					}
					if ($telefono_1 != '' && $telefono_2 != '') {
						$telefonos = $telefono_1.' - '.$telefono_2;
					}
					$sheet->setCellValue('A'.$i,($datos['num_documento'].' | '.$datos['nom_cliente']));
					$sheet->setCellValue('B'.$i,$datos['direccion']);
					$sheet->setCellValue('C'.$i,($datos['tipo_contacto'] ?? ''));
					$sheet->setCellValue('D'.$i,($datos['persona_contacto']  ?? ''));
					$sheet->setCellValue('E'.$i,$telefonos);
					$sheet->setCellValue('F'.$i,($datos['email'] ?? ''));
					$sheet->setCellValue('G'.$i,($datos['estado'] == 'A' ? 'Activo' : 'Inactivo'));
					$i++;
				}
				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$name_xls = 'contactos_x_sedes_x_clientes.xlsx';
			}
		break;
		default:
		break;
	}
} else {
	$mensaje = 'No tiene permisos para Generar Excel';
}
if ($name_xls != '') {
	$ruta = '../reportes/';
	$writer = new Xlsx($spreadsheet);
	$writer->setPreCalculateFormulas(true); 
	$writer->save($ruta.$name_xls);
	$data_out['achivoxls'] = $helper->DomainSite().'reportes/'.$name_xls;
	$success = true;
	$mensaje = 'Excel Generado Correctamente';
}
$data_out['success'] = $success;
$data_out['mensaje'] = $mensaje;
$data_out['tipo'] = $success ? 'success' : ($tipo ?? 'warning');
$data_out['foot'] = $foot ?? '';
/******************************************************/
/******************************************************/
echo json_encode($helper->PrettyMessage($data_out));