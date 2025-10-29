<?php
class ModeloClientesSedes {
	
	function ListarDatos($data) {
		include '../config/conexion.php';
		$helper = new helper();
		$page = array_key_exists('page', $data) ? intval($helper->Reservado($data['page'])) : 0;
		$multiple_result = array_key_exists('multiple_result', $data) ? json_decode($helper->Reservado($data['multiple_result']),true) : true;
		$for_select = array_key_exists('for_select', $data) ? json_decode($helper->Reservado($data['for_select']),true) : false;
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
		if (array_key_exists('cod_sede',$data)) {
			$cod_sede = intval($helper->Reservado($data['cod_sede']));
			if ($cod_sede != 0) {
				$where .= ' AND sede.cod_sede = '.$cod_sede;
			}
		}
		if (array_key_exists('cod_cliente',$data)) {
			$cod_cliente = intval($helper->Reservado($data['cod_cliente']));
			if ($cod_cliente != 0) {
				$where .= ' AND sede.cod_cliente = '.$cod_cliente;
			} else {
				if ($for_select) {
					$where .= ' AND sede.cod_cliente is null ';
				}
			}
		}
		if (array_key_exists('cod_tipo_direcc',$data)) {
			$cod_tipo_direcc = intval($helper->Reservado($data['cod_tipo_direcc']));
			if ($cod_tipo_direcc != 0) {
				$where .= ' AND sede.id_tipo_direccion = '.$cod_tipo_direcc;
			}
		}
		if (array_key_exists('direccion',$data)) {
			$direccion = $helper->Reservado($data['direccion']);
			if ($direccion != '') {
				$where .= ' AND sede.direccion LIKE "%'.$direccion.'%"';
			}
		}
		if (array_key_exists('referencia',$data)) {
			$referencia = $helper->Reservado($data['referencia']);
			if ($referencia != '') {
				$where .= ' AND sede.referencia LIKE "%'.$referencia.'%"';
			}
		}
		if (array_key_exists('cod_dpto',$data)) {
			$cod_dpto = $helper->Reservado($data['cod_dpto']);
			if ($cod_dpto != '') {
				$where .= ' AND sede.IdDepartamento = "'.$cod_dpto.'"';
			}
		}
		if (array_key_exists('cod_prov',$data)) {
			$cod_prov = $helper->Reservado($data['cod_prov']);
			if ($cod_prov != '') {
				$where .= ' AND sede.IdProvincia = "'.$cod_prov.'"';
			}
		}
		if (array_key_exists('cod_dist',$data)) {
			$cod_dist = $helper->Reservado($data['cod_dist']);
			if ($cod_dist != '') {
				$where .= ' AND sede.IdDistrito = "'.$cod_dist.'"';
			}
		}
		if (array_key_exists('estado',$data)) {
			$estado = $helper->Reservado($data['estado']);
			if ($estado == 'A' or $estado == 'I') {
				$where .= ' AND sede.estado = "'.$estado.'"';
			}
		}
		$select .= 'SELECT ';
		$select .= 'sede.cod_sede, ';
		$select .= 'sede.cod_cliente, ';
		$select .= 'c.num_documento, ';
		$select .= 'c.nombres as nom_cliente, ';
		$select .= 'sede.id_tipo_direccion, ';
		$select .= 'tpdirecc.tipo_direccion, ';
		$select .= 'sede.direccion, ';
		$select .= 'sede.referencia, ';
		$select .= 'sede.IdDepartamento, ';
		$select .= 'dpto.name as nom_dpto, ';
		$select .= 'sede.IdProvincia, ';
		$select .= 'prov.name as nom_prov, ';
		$select .= 'sede.IdDistrito, ';
		$select .= 'dist.name as nom_dist, ';
		$select .= 'sede.estado ';
		$select .= 'FROM clientes_sedes sede ';
		$joins .= 'LEFT JOIN clientes c ON c.cod_cliente = sede.cod_cliente ';
		$joins .= 'LEFT JOIN tipo_direccion tpdirecc ON tpdirecc.id_tipo_direccion = sede.id_tipo_direccion ';
		$joins .= 'LEFT JOIN ubigeo_departamentos dpto ON dpto.id = sede.IdDepartamento ';
		$joins .= 'LEFT JOIN ubigeo_provincias prov ON prov.id = sede.IdProvincia ';
		$joins .= 'LEFT JOIN ubigeo_distritos dist ON dist.id = sede.IdDistrito ';
		$select .= $joins;
		$select .= 'WHERE 1=1'.$where;
		$select .= ' ORDER BY cod_sede '.($for_select ? 'ASC' : 'DESC');
		$select_count .= 'SELECT COUNT(1) as total FROM clientes_sedes sede ';
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