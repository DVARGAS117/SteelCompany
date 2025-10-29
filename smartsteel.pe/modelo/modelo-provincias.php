<?php
class ModeloProvincias {
	
	function ListarDatos($data) {
		include '../config/conexion.php';
		$helper = new helper();
		$page = array_key_exists('page', $data) ? intval($helper->Reservado($data['page'])) : 0;
		$multiple_result = array_key_exists('multiple_result', $data) ? json_decode($helper->Reservado($data['multiple_result']),true) : true;
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
		$success = false;
		$mensaje = '';
		if (array_key_exists('cod_prov',$data)) {
			$cod_prov = $helper->Reservado($data['cod_prov']);
			if ($cod_prov != '') {
				$where .= ' AND prov.id = "'.$cod_prov.'"';
			}
		}
		if (array_key_exists('nom_prov',$data)) {
			$nom_prov = $helper->Reservado($data['nom_prov']);
			if ($nom_prov != '') {
				$where .= ' AND prov.name LIKE "%'.$nom_prov.'%"';
			}
		}
		if (array_key_exists('cod_dpto',$data)) {
			$cod_dpto = $helper->Reservado($data['cod_dpto']);
			if ($cod_dpto != '') {
				$where .= ' AND prov.department_id = "'.$cod_dpto.'"';
			} else {
				$where .= ' AND prov.department_id is null';
			}
		}
		$select .= 'SELECT ';
		$select .= 'prov.id, ';
		$select .= 'prov.name, ';
		$select .= 'prov.department_id ';
		$select .= 'FROM ubigeo_provincias prov ';
		$joins .= 'LEFT JOIN ubigeo_departamentos dpto ON dpto.id = prov.department_id ';
		$select .= $joins;
		$select .= 'WHERE 1=1'.$where;
		$select .= ' ORDER BY prov.id ASC';
		$select_count .= 'SELECT COUNT(1) as total FROM ubigeo_provincias prov ';
		$select_count .= $joins;
		$select_count .= 'WHERE 1=1'.$where;
		if ($paginar) {
			$offset = ($page-1)*$limit_per_page;
			if ($select != '') {
				$select .= ' LIMIT '.$limit_per_page.' OFFSET '.$offset;
			}
		}
		$sql = mysqli_query($conexion, $select);
		$numrow = mysqli_num_rows($sql);
		if ($numrow == 0) {
			$data_out['Tam_datos'] = 0;
			$success = false;
			$mensaje = 'No hay registros';
		} else {
			$data = [];
			$count = mysqli_query($conexion, $select_count);
			$tmp = mysqli_fetch_array($count, MYSQLI_ASSOC);
			if ($multiple_result) {
				while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
					array_push($data, $row);
				}
			} else {
				$data = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			}
			$data_out['data'] = $data;
			$data_out['Tam_datos'] = intval($tmp['total']);
			$success = true;
			$mensaje = 'Datos listados correctamente';
		}
		$data_out['n_grupo'] = $limit_per_page;
		$data_out['success'] = $success;
		$data_out['mensaje'] = $mensaje;
		return $data_out;
	}
}