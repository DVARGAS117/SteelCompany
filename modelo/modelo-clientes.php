<?php
class ModeloClientes {
	
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
		if (array_key_exists('cod_cliente',$data)) {
			$cod_cliente = intval($helper->Reservado($data['cod_cliente']));
			if ($cod_cliente != 0) {
				$where .= ' AND c.cod_cliente = '.$cod_cliente;
			}
		}
		if (array_key_exists('cod_personal',$data)) {
			$cod_personal = intval($helper->Reservado($data['cod_personal']));
			if ($cod_personal != 0) {
				$where .= ' AND c.cod_personal = '.$cod_personal;
			}
		}
		if (array_key_exists('cod_puntoventa',$data)) {
			$cod_puntoventa = intval($helper->Reservado($data['cod_puntoventa']));
			if ($cod_puntoventa != 0) {
				$where .= ' AND c.cod_puntoventa = '.$cod_puntoventa;
			}
		}
		if (array_key_exists('num_documento',$data)) {
			$num_documento = $helper->Reservado($data['num_documento']);
			if ($num_documento != '') {
				$where .= ' AND c.num_documento LIKE "%'.$num_documento.'%"';
			}
		}
		if (array_key_exists('razon_social',$data)) {
			$razon_social = $helper->Reservado($data['razon_social']);
			if ($razon_social != '') {
				$where .= ' AND c.nombres LIKE "%'.$razon_social.'%"';
			}
		}
		if (array_key_exists('nombre_comercial',$data)) {
			$nombre_comercial = $helper->Reservado($data['nombre_comercial']);
			if ($nombre_comercial != '') {
				$where .= ' AND c.nombre_comercial LIKE "%'.$nombre_comercial.'%"';
			}
		}
		if (array_key_exists('giro_negocio',$data)) {
			$giro_negocio = intval($helper->Reservado($data['giro_negocio']));
			if ($giro_negocio != 0) {
				$where .= ' AND c.id_giro_negocio = '.$giro_negocio;
			}
		}
		if (array_key_exists('estado',$data)) {
			$estado = $helper->Reservado($data['estado']);
			if ($estado == 'A' or $estado == 'I') {
				$where .= ' AND c.estado = "'.$estado.'"';
			}
		}
		$select .= 'SELECT ';
		$select .= 'c.cod_cliente, ';
		$select .= 'c.cod_personal, ';
		$select .= 'c.cod_puntoventa, ';
		$select .= 'pv.nombre_puntoventa, ';
		$select .= 'c.cod_tipodoc, ';
		$select .= 'tpdoc.descripcion as nom_tipo_doc, ';
		$select .= 'c.num_documento, ';
		$select .= 'c.nombres as nom_cliente, ';
		$select .= 'c.nombre_comercial, ';
		$select .= 'c.id_giro_negocio, ';
		$select .= 'tgn.nombre_giro, ';
		$select .= 'c.website, ';
		$select .= 'c.estado ';
		$select .= 'FROM clientes c ';
		$joins .= 'LEFT JOIN puntos_ventas pv ON pv.cod_puntoventa = c.cod_puntoventa ';
		$joins .= 'LEFT JOIN tipos_documentos_identidad tpdoc ON tpdoc.cod_tipodoc = c.cod_tipodoc ';
		$joins .= 'LEFT JOIN tipo_giro_negocios tgn ON tgn.id_giro_negocio = c.id_giro_negocio ';
		$select .= $joins;
		$select .= 'WHERE 1=1'.$where;
		$select .= ' ORDER BY cod_cliente '.($for_select ? 'ASC' : 'DESC');
		$select_count .= 'SELECT COUNT(1) as total FROM clientes c ';
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