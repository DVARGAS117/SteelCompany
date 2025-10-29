<?php
class ModeloClientesSedesContactos {
	
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
		if (array_key_exists('cod_contacto',$data)) {
			$cod_contacto = intval($helper->Reservado($data['cod_contacto']));
			if ($cod_contacto != 0) {
				$where .= ' AND contacto.cod_contacto = '.$cod_contacto;
			}
		}
		if (array_key_exists('cod_cliente',$data)) {
			$cod_cliente = intval($helper->Reservado($data['cod_cliente']));
			if ($cod_cliente != 0) {
				$where .= ' AND c.cod_cliente = '.$cod_cliente;
			} else {
				if ($for_select) {
					$where .= ' AND c.cod_cliente is null ';
				}
			}
		}
		if (array_key_exists('cod_sede',$data)) {
			$cod_sede = intval($helper->Reservado($data['cod_sede']));
			if ($cod_sede != 0) {
				$where .= ' AND contacto.cod_sede = '.$cod_sede;
			} else {
				if ($for_select) {
					$where .= ' AND contacto.cod_sede is null ';
				}
			}
		}
		if (array_key_exists('cod_tipo_contacto',$data)) {
			$cod_tipo_contacto = intval($helper->Reservado($data['cod_tipo_contacto']));
			if ($cod_tipo_contacto != 0) {
				$where .= ' AND contacto.id_tipo_contacto = '.$cod_tipo_contacto;
			}
		}
		if (array_key_exists('nombre_contacto',$data)) {
			$nombre_contacto = $helper->Reservado($data['nombre_contacto']);
			if ($nombre_contacto != '') {
				$where .= ' AND contacto.persona_contacto LIKE "%'.$nombre_contacto.'%"';
			}
		}
		if (array_key_exists('telefono',$data)) {
			$telefono = $helper->Reservado($data['telefono']);
			if ($telefono != '') {
				$where .= ' AND (contacto.telefono_1 LIKE "%'.$telefono.'%" OR contacto.telefono_2 LIKE "%'.$telefono.'%")';
			}
		}
		if (array_key_exists('email',$data)) {
			$email = $helper->Reservado($data['email']);
			if ($email != '') {
				$where .= ' AND contacto.email LIKE "%'.$email.'%"';
			}
		}
		if (array_key_exists('estado',$data)) {
			$estado = $helper->Reservado($data['estado']);
			if ($estado == 'A' or $estado == 'I') {
				$where .= ' AND contacto.estado = "'.$estado.'"';
			}
		}
		$select .= 'SELECT ';
		$select .= 'contacto.cod_contacto, ';
		$select .= 'c.cod_cliente, ';
		$select .= 'c.num_documento, ';
		$select .= 'c.nombres as nom_cliente, ';
		$select .= 'contacto.cod_sede, ';
		$select .= 'sede.direccion, ';
		$select .= 'contacto.id_tipo_contacto, ';
		$select .= 'tpcontacto.tipo_contacto, ';
		$select .= 'contacto.persona_contacto, ';
		$select .= 'contacto.telefono_1, ';
		$select .= 'contacto.telefono_2, ';
		$select .= 'contacto.email, ';
		$select .= 'contacto.estado ';
		$select .= 'FROM clientes_sedes_contactos contacto ';
		$joins .= 'LEFT JOIN clientes_sedes sede ON sede.cod_sede = contacto.cod_sede ';
		$joins .= 'LEFT JOIN clientes c ON c.cod_cliente = sede.cod_cliente ';
		$joins .= 'LEFT JOIN tipo_contactos tpcontacto ON tpcontacto.id_tipo_contacto = contacto.id_tipo_contacto ';
		$select .= $joins;
		$select .= 'WHERE 1=1'.$where;
		$select .= ' ORDER BY cod_contacto '.($for_select ? 'ASC' : 'DESC');
		$select_count .= 'SELECT COUNT(1) as total FROM clientes_sedes_contactos contacto ';
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