<?php
class helper {
	
	function DomainSite() {
		return 'https://smartsteel.pe/'; // PROD
		// return 'http://local.smartsteel/'; // LOCAL
	}

	function EjecutarCURL($url,$param) {
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_HEADER,false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			var_dump($server_output);exit;
			curl_close($ch);
			$datin['data'] = $server_output;
			$mensaje = 'CURL ejecutado correctamente.';
			$estado = true;
		} catch (ErrorException $e) {
			$mensaje = 'Hubo un error al consumir el API: '.$e;
			$estado = false;
		}
		$datin['success'] = $estado;
		$datin['mensaje'] = $mensaje;
		return $datin;
	}

	function ValidarFormatoCorreo($email) {
		if (preg_match("/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i", $email)) {
			$estado = true;
		} else {
			$estado = false;
		}
		return $estado;
	}

	function Reservado($palabra) {
		$palabra = trim($palabra);
		$palabra = str_ireplace('"','', ($palabra));
		$palabra = str_ireplace("'",'', ($palabra));
		$palabra = str_ireplace(';','', ($palabra));
		$palabra = str_ireplace('#','', ($palabra));
		$palabra = str_ireplace('TABLE ','', ($palabra));
		$palabra = str_ireplace('DROP ','', ($palabra));
		$palabra = str_ireplace('CREATE','', ($palabra));
		$palabra = str_ireplace('DATABASE','', ($palabra));
		$palabra = str_ireplace('SELECT ','', ($palabra));
		$palabra = str_ireplace('UPDATE ','', ($palabra));
		$palabra = str_ireplace('DELETE ','', ($palabra));
		$palabra = str_ireplace('GRANT','', ($palabra));
		$palabra = str_ireplace('FROM','', ($palabra));
		$palabra = str_ireplace('WHERE','', ($palabra));
		$palabra = str_ireplace('INNER','', ($palabra));
		$palabra = str_ireplace('LEFT','', ($palabra));
		$palabra = str_ireplace('JOIN ','', ($palabra));
		$palabra = str_ireplace('TRUNCATE','', ($palabra));
		$palabra = str_ireplace('USER ','', ($palabra));
		$palabra = str_ireplace('GROUP','', ($palabra));
		$palabra = str_ireplace('ORDER ','', ($palabra));
		$palabra = str_ireplace('COLLATE','', ($palabra));
		$palabra = str_ireplace('CONNECTION','', ($palabra));
		$palabra = str_ireplace('WRITE','', ($palabra));
		$palabra = str_ireplace('|','', ($palabra));
		$palabra = str_ireplace('CMD','', ($palabra));
		$palabra = str_ireplace('WHOAMI','', ($palabra));
		$palabra = str_ireplace('PWD','', ($palabra));
		$palabra = str_ireplace('CLEAR','', ($palabra));
		$palabra = str_ireplace('HISTORY','', ($palabra));
		$palabra = str_ireplace('MKDIR','', ($palabra));
		$palabra = str_ireplace('SUDO','', ($palabra));
		$palabra = str_ireplace('CHMOD','', ($palabra));
		$palabra = str_ireplace('ZEROFILL','', ($palabra));
		return $palabra;
	}

	function PrettyMessage($data){
		if (array_key_exists('success', $data) && array_key_exists('mensaje', $data)) {
			$data['mensaje'] = $data['success'] ? '<span style="color:green"><b>'.$data['mensaje'].'</b></span>' : '<span style="color:red"><b>'.$data['mensaje'].'</b></span>';
		}
		if (array_key_exists('foot', $data)) {
			$data['foot'] = '<font size="2" color="#A133F7"><b><i><center>'.$data['foot'].'</center></i></b></font>';
		}
		return $data;
	}

	function Validar_DatosCliente($datos) {
		include 'conexion.php';
		$next = 0;
		$proceso = array_key_exists('proceso', $datos) ? $this->Reservado($datos['proceso']) : '';
		switch ($proceso) {
			case 'RegistrarCliente':
				$cod_puntoventa = array_key_exists('cod_puntoventa', $datos) ? intval($this->Reservado($datos['cod_puntoventa'])) : 0;
				$cod_tipodoc = array_key_exists('cod_tipodoc', $datos) ? intval($this->Reservado($datos['cod_tipodoc'])) : 0;
				$num_documento = array_key_exists('num_documento', $datos) ? $this->Reservado($datos['num_documento']) : '';
				$razon_social = array_key_exists('razon_social', $datos) ? $this->Reservado($datos['razon_social']) : '';
				$nombre_comercial = array_key_exists('nombre_comercial', $datos) ? $this->Reservado($datos['nombre_comercial']) : '';
				$giro_negocio = array_key_exists('giro_negocio', $datos) ? intval($this->Reservado($datos['giro_negocio'])) : 0;
				$website = array_key_exists('website', $datos) ? $this->Reservado($datos['website']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_puntoventa == 0) {
					$next = 0;
					$mensaje = 'Selecciona el Punto de Venta';
				} else {
					if ($cod_tipodoc == 0) {
						$next = 0;
						$mensaje = 'Selecciona el Tipo de Documento'; 
					} else {
						if ($num_documento == '') {
							$next = 0;
							$mensaje = 'Ingresa el N° de Documento';
						} else {
							if ($razon_social == '') {
								$next = 0;
								$mensaje = 'Ingresa la Razón Social';
							} else {
								$next = 1;
							}
						}
					}
				}
				if ($next == 1) {
					$sql = mysqli_query($conexion, 'SELECT * FROM clientes WHERE num_documento = "'.$num_documento.'"');
					$rst = mysqli_num_rows($sql);
					if ($rst > 0) {
						$next = 0;
						$mensaje = 'El N° de Documento ya está registrado para otro Cliente';
						$foot = 'Ingresa un N° de Documento diferente';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_puntoventa' => $cod_puntoventa,
						'cod_tipodoc' => $cod_tipodoc,
						'num_documento' => $num_documento,
						'nombres' => $razon_social,
						'nombre_comercial' => $nombre_comercial == '' ? null : $nombre_comercial,
						'id_giro_negocio' => $giro_negocio == 0 ? null : $giro_negocio,
						'website' => $website == '' ? null : $website,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'ActualizarCliente':
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				$cod_puntoventa = array_key_exists('cod_puntoventa', $datos) ? intval($this->Reservado($datos['cod_puntoventa'])) : 0;
				$cod_tipodoc = array_key_exists('cod_tipodoc', $datos) ? intval($this->Reservado($datos['cod_tipodoc'])) : 0;
				$num_documento = array_key_exists('num_documento', $datos) ? $this->Reservado($datos['num_documento']) : '';
				$razon_social = array_key_exists('razon_social', $datos) ? $this->Reservado($datos['razon_social']) : '';
				$nombre_comercial = array_key_exists('nombre_comercial', $datos) ? $this->Reservado($datos['nombre_comercial']) : '';
				$giro_negocio = array_key_exists('giro_negocio', $datos) ? intval($this->Reservado($datos['giro_negocio'])) : 0;
				$website = array_key_exists('website', $datos) ? $this->Reservado($datos['website']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_cliente == 0) {
					$next = 0;
					$mensaje = 'Cliente no identificado (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					if ($cod_puntoventa == 0) {
						$next = 0;
						$mensaje = 'Selecciona el Punto de Venta';
					} else {
						if ($cod_tipodoc == 0) {
							$next = 0;
							$mensaje = 'Selecciona el Tipo de Documento'; 
						} else {
							if ($num_documento == '') {
								$next = 0;
								$mensaje = 'Ingresa el N° de Documento';
							} else {
								if ($razon_social == '') {
									$next = 0;
									$mensaje = 'Ingresa la Razón Social';
								} else {
									$next = 1;
								}
							}
						}
					}
				}
				if ($next == 1) {
					$sql_1 = mysqli_query($conexion, 'SELECT * FROM clientes WHERE cod_cliente = '.$cod_cliente);
					$rst_1 = mysqli_num_rows($sql_1);
					if ($rst_1 == 0) {
						$next = 0;
						$mensaje = 'Cliente no identificado (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$data_reg = mysqli_fetch_array($sql_1, MYSQLI_ASSOC);
						if ($num_documento != $data_reg['num_documento']) {
							$sql_2 = mysqli_query($conexion, 'SELECT * FROM clientes WHERE num_documento = "'.$num_documento.'"');
							$rst_2 = mysqli_num_rows($sql_2);
							if ($rst_2 > 0) {
								$next = 0;
								$mensaje = 'El N° de Documento ya está registrado para otro Cliente';
								$foot = 'Ingresa un N° de Documento diferente';
							} else {
								$next = 2;
							}
						} else {
							$next = 2;
						}
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_cliente' => $cod_cliente,
						'cod_puntoventa' => $cod_puntoventa,
						'cod_tipodoc' => $cod_tipodoc,
						'num_documento' => $num_documento,
						'nombres' => $razon_social,
						'nombre_comercial' => $nombre_comercial == '' ? null : $nombre_comercial,
						'id_giro_negocio' => $giro_negocio == 0 ? null : $giro_negocio,
						'website' => $website == '' ? null : $website,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'EliminarCliente':
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				if ($cod_cliente == 0) {
					$next = 0;
					$mensaje = 'Cliente no identificado (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					$next = 1;
				}
				if ($next == 1) {
					$sql = mysqli_query($conexion, 'SELECT * FROM clientes WHERE cod_cliente = '.$cod_cliente);
					$rst = mysqli_num_rows($sql);
					if ($rst == 0) {
						$next = 0;
						$mensaje = 'Cliente no identificado (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_cliente' => $cod_cliente
					];
					$success = true;
				}
			break;
			default:
				$next = 0;
				$mensaje = 'Proceso no identificado (2)';
			break;
		}
		$data_out['success'] = $success ?? false;
		$data_out['mensaje'] = $data_out['success'] ? 'Datos validados correctamente' : $mensaje;
		$data_out['tipo'] = $data_out['success'] ? 'success' : ($tipo ?? 'warning');
		$data_out['foot'] = $foot ?? '';
		return $data_out;
	}

	function Validar_DatosSede($datos) {
		include 'conexion.php';
		$next = 0;
		$proceso = array_key_exists('proceso', $datos) ? $this->Reservado($datos['proceso']) : '';
		switch ($proceso) {
			case 'RegistrarSede':
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				$cod_tipo_direcc = array_key_exists('cod_tipo_direcc', $datos) ? intval($this->Reservado($datos['cod_tipo_direcc'])) : 0;
				$direccion = array_key_exists('direccion', $datos) ? $this->Reservado($datos['direccion']) : '';
				$referencia = array_key_exists('referencia', $datos) ? $this->Reservado($datos['referencia']) : '';
				$cod_dpto = array_key_exists('cod_dpto', $datos) ? $this->Reservado($datos['cod_dpto']) : '';
				$cod_prov = array_key_exists('cod_prov', $datos) ? $this->Reservado($datos['cod_prov']) : '';
				$cod_dist = array_key_exists('cod_dist', $datos) ? $this->Reservado($datos['cod_dist']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_cliente == 0) {
					$next = 0;
					$mensaje = 'Selecciona el Cliente';
				} else {
					if ($cod_tipo_direcc == 0) {
						$next = 0;
						$mensaje = 'Selecciona el Tipo de Dirección'; 
					} else {
						if ($direccion == '') {
							$next = 0;
							$mensaje = 'Ingresa la Dirección';
						} else {
							if ($cod_dpto == '') {
								$next = 0;
								$mensaje = 'Selecciona el Departamento';
							} else {
								if ($cod_prov == '') {
									$next = 0;
									$mensaje = 'Selecciona la Provincia';
								} else {
									if ($cod_dist == '') {
										$next = 0;
										$mensaje = 'Selecciona el Distrito';
									} else {
										$next = 1;
									}
								}
							}
						}
					}
				}
				if ($next == 1) {
					$sql = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_cliente = '.$cod_cliente.' AND direccion = "'.$direccion.'"');
					$rst = mysqli_num_rows($sql);
					if ($rst > 0) {
						$next = 0;
						$mensaje = 'La Dirección ingresada ya está registrada para el Cliente seleccionado';
						$foot = 'Ingresa una Dirección diferente, o selecciona un Cliente diferente';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_cliente' => $cod_cliente,
						'id_tipo_direccion' => $cod_tipo_direcc,
						'direccion' => $direccion,
						'referencia' => $referencia == '' ? null : $referencia,
						'IdDepartamento' => $cod_dpto,
						'IdProvincia' => $cod_prov,
						'IdDistrito' => $cod_dist,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'ActualizarSede':
				$cod_sede = array_key_exists('cod_sede', $datos) ? intval($this->Reservado($datos['cod_sede'])) : 0;
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				$cod_tipo_direcc = array_key_exists('cod_tipo_direcc', $datos) ? intval($this->Reservado($datos['cod_tipo_direcc'])) : 0;
				$direccion = array_key_exists('direccion', $datos) ? $this->Reservado($datos['direccion']) : '';
				$referencia = array_key_exists('referencia', $datos) ? $this->Reservado($datos['referencia']) : '';
				$cod_dpto = array_key_exists('cod_dpto', $datos) ? $this->Reservado($datos['cod_dpto']) : '';
				$cod_prov = array_key_exists('cod_prov', $datos) ? $this->Reservado($datos['cod_prov']) : '';
				$cod_dist = array_key_exists('cod_dist', $datos) ? $this->Reservado($datos['cod_dist']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_sede == 0) {
					$next = 0;
					$mensaje = 'Sede no identificada (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					if ($cod_cliente == 0) {
						$next = 0;
						$mensaje = 'Selecciona el Cliente';
					} else {
						if ($cod_tipo_direcc == 0) {
							$next = 0;
							$mensaje = 'Selecciona el Tipo de Dirección'; 
						} else {
							if ($direccion == '') {
								$next = 0;
								$mensaje = 'Ingresa la Dirección';
							} else {
								if ($cod_dpto == '') {
									$next = 0;
									$mensaje = 'Selecciona el Departamento';
								} else {
									if ($cod_prov == '') {
										$next = 0;
										$mensaje = 'Selecciona la Provincia';
									} else {
										if ($cod_dist == '') {
											$next = 0;
											$mensaje = 'Selecciona el Distrito';
										} else {
											$next = 1;
										}
									}
								}
							}
						}
					}
				}
				if ($next == 1) {
					$sql_1 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_sede = '.$cod_sede);
					$rst_1 = mysqli_num_rows($sql_1);
					if ($rst_1 == 0) {
						$next = 0;
						$mensaje = 'Sede no identificada (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$data_reg = mysqli_fetch_array($sql_1, MYSQLI_ASSOC);
						if ($cod_cliente != $data_reg['cod_cliente'] or $direccion != $data_reg['direccion']) {
							$sql_2 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_cliente = '.$cod_cliente.' AND direccion = "'.$direccion.'"');
							$rst_2 = mysqli_num_rows($sql_2);
							if ($rst_2 > 0) {
								$next = 0;
								$mensaje = 'La Dirección ingresada ya está registrada para el Cliente seleccionado';
								$foot = 'Ingresa una Dirección diferente, o selecciona un Cliente diferente';
							} else {
								$next = 2;
							}
						} else {
							$next = 2;
						}
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_sede' => $cod_sede,
						'cod_cliente' => $cod_cliente,
						'id_tipo_direccion' => $cod_tipo_direcc,
						'direccion' => $direccion,
						'referencia' => $referencia == '' ? null : $referencia,
						'IdDepartamento' => $cod_dpto,
						'IdProvincia' => $cod_prov,
						'IdDistrito' => $cod_dist,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'EliminarSede':
				$cod_sede = array_key_exists('cod_sede', $datos) ? intval($this->Reservado($datos['cod_sede'])) : 0;
				if ($cod_sede == 0) {
					$next = 0;
					$mensaje = 'Sede no identificada (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					$next = 1;
				}
				if ($next == 1) {
					$sql = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_sede = '.$cod_sede);
					$rst = mysqli_num_rows($sql);
					if ($rst == 0) {
						$next = 0;
						$mensaje = 'Sede no identificada (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_sede' => $cod_sede
					];
					$success = true;
				}
			break;
			default:
				$next = 0;
				$mensaje = 'Proceso no identificado (2)';
			break;
		}
		$data_out['success'] = $success ?? false;
		$data_out['mensaje'] = $data_out['success'] ? 'Datos validados correctamente' : $mensaje;
		$data_out['tipo'] = $data_out['success'] ? 'success' : ($tipo ?? 'warning');
		$data_out['foot'] = $foot ?? '';
		return $data_out;
	}

	function Validar_DatosContacto($datos) {
		include 'conexion.php';
		$next = 0;
		$proceso = array_key_exists('proceso', $datos) ? $this->Reservado($datos['proceso']) : '';
		switch ($proceso) {
			case 'RegistrarContacto':
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				$cod_sede = array_key_exists('cod_sede', $datos) ? intval($this->Reservado($datos['cod_sede'])) : 0;
				$cod_tipo_contacto = array_key_exists('cod_tipo_contacto', $datos) ? intval($this->Reservado($datos['cod_tipo_contacto'])) : 0;
				$nombre_contacto = array_key_exists('nombre_contacto', $datos) ? $this->Reservado($datos['nombre_contacto']) : '';
				$telefono1 = array_key_exists('telefono1', $datos) ? $this->Reservado($datos['telefono1']) : '';
				$telefono2 = array_key_exists('telefono2', $datos) ? $this->Reservado($datos['telefono2']) : '';
				$email = array_key_exists('email', $datos) ? $this->Reservado($datos['email']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_cliente == 0) {
					$next = 0;
					$mensaje = 'Selecciona el Cliente';
				} else {
					if ($cod_sede == 0) {
						$next = 0;
						$mensaje = 'Selecciona la Sede (Dirección)'; 
					} else {
						if ($cod_tipo_contacto == 0) {
							$next = 0;
							$mensaje = 'Selecciona el Tipo de Contacto';
						} else {
							if ($nombre_contacto == '') {
								$next = 0;
								$mensaje = 'Ingresa los Nombres y Apellidos del Contacto';
							} else {
								if ($email != '') {
									if (!$this->ValidarFormatoCorreo($email)) {
										$next = 0;
										$mensaje = 'Ingresa un formato de correo válido';
										$foot = 'Ejemplo de formato correcto: ejemplo@dominio.com';
									} else {
										$next = 1;
									}
								} else {
									$next = 1;
								}
							}
						}
					}
				}
				if ($next == 1) {
					$sql_1 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_cliente = '.$cod_cliente.' AND cod_sede = '.$cod_sede);
					$rst_1 = mysqli_num_rows($sql_1);
					if ($rst_1 == 0) {
						$next = 0;
						$mensaje = 'Selecciona una Sede (Dirección) que si pertenezca al Cliente seleccionado';
						$foot = 'Selecciona un Cliente y/o Dirección diferente';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$sql_2 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes_contactos WHERE cod_sede = '.$cod_sede.' AND persona_contacto = "'.$nombre_contacto.'"');
					$rst_2 = mysqli_num_rows($sql_2);
					if ($rst_2 > 0) {
						$next = 0;
						$mensaje = 'El Contacto ingresado ya está registrado para la Sede (Dirección) seleccionada';
						$foot = 'Ingresa un Contacto diferente o selecciona una Sede (Dirección) diferente';
					} else {
						$next = 3;
					}
				}
				if ($next == 3) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_sede' => $cod_sede,
						'id_tipo_contacto' => $cod_tipo_contacto,
						'persona_contacto' => $nombre_contacto,
						'telefono_1' => $telefono1 == '' ? null : $telefono1,
						'telefono_2' => $telefono2 == '' ? null : $telefono2,
						'email' => $email == '' ? null : $email,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'ActualizarContacto':
				$cod_contacto = array_key_exists('cod_contacto', $datos) ? intval($this->Reservado($datos['cod_contacto'])) : 0;
				$cod_cliente = array_key_exists('cod_cliente', $datos) ? intval($this->Reservado($datos['cod_cliente'])) : 0;
				$cod_sede = array_key_exists('cod_sede', $datos) ? intval($this->Reservado($datos['cod_sede'])) : 0;
				$cod_tipo_contacto = array_key_exists('cod_tipo_contacto', $datos) ? intval($this->Reservado($datos['cod_tipo_contacto'])) : 0;
				$nombre_contacto = array_key_exists('nombre_contacto', $datos) ? $this->Reservado($datos['nombre_contacto']) : '';
				$telefono1 = array_key_exists('telefono1', $datos) ? $this->Reservado($datos['telefono1']) : '';
				$telefono2 = array_key_exists('telefono2', $datos) ? $this->Reservado($datos['telefono2']) : '';
				$email = array_key_exists('email', $datos) ? $this->Reservado($datos['email']) : '';
				$estado = array_key_exists('estado', $datos) ? $this->Reservado($datos['estado']) : '';
				if ($cod_contacto == 0) {
					$next = 0;
					$mensaje = 'Contacto no identificado (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					if ($cod_cliente == 0) {
						$next = 0;
						$mensaje = 'Selecciona el Cliente';
					} else {
						if ($cod_sede == 0) {
							$next = 0;
							$mensaje = 'Selecciona la Sede (Dirección)';
						} else {
							if ($cod_tipo_contacto == 0) {
								$next = 0;
								$mensaje = 'Selecciona el Tipo de Contacto'; 
							} else {
								if ($nombre_contacto == '') {
									$next = 0;
									$mensaje = 'Ingresa los Nombres y Apellidos del Contacto';
								} else {
									if ($email != '') {
										if (!$this->ValidarFormatoCorreo($email)) {
											$next = 0;
											$mensaje = 'Ingresa un formato de correo válido';
											$foot = 'Ejemplo de formato correcto: ejemplo@dominio.com';
										} else {
											$next = 1;
										}
									} else {
										$next = 1;
									}
								}
							}
						}
					}
				}
				if ($next == 1) {
					$sql_1 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes WHERE cod_cliente = '.$cod_cliente.' AND cod_sede = '.$cod_sede);
					$rst_1 = mysqli_num_rows($sql_1);
					if ($rst_1 == 0) {
						$next = 0;
						$mensaje = 'Selecciona una Sede (Dirección) que si pertenezca al Cliente seleccionado';
						$foot = 'Selecciona un Cliente y/o Dirección diferente';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$sql_2 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes_contactos WHERE cod_contacto = '.$cod_contacto);
					$rst_2 = mysqli_num_rows($sql_2);
					if ($rst_2 == 0) {
						$next = 0;
						$mensaje = 'Contacto no identificado (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$data_reg = mysqli_fetch_array($sql_2, MYSQLI_ASSOC);
						if ($cod_sede != $data_reg['cod_sede'] or $nombre_contacto != $data_reg['persona_contacto']) {
							$sql_3 = mysqli_query($conexion, 'SELECT * FROM clientes_sedes_contactos WHERE cod_sede = '.$cod_sede.' AND persona_contacto = "'.$nombre_contacto.'"');
							$rst_3 = mysqli_num_rows($sql_3);
							if ($rst_3 > 0) {
								$next = 0;
								$mensaje = 'El Contacto ingresado ya está registrado para la Sede (Dirección) seleccionada';
								$foot = 'Ingresa un Contacto diferente o selecciona una Sede (Dirección) diferente';
							} else {
								$next = 3;
							}
						} else {
							$next = 3;
						}
					}
				}
				if ($next == 3) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_contacto' => $cod_contacto,
						'cod_sede' => $cod_sede,
						'id_tipo_contacto' => $cod_tipo_contacto,
						'persona_contacto' => $nombre_contacto,
						'telefono_1' => $telefono1 == '' ? null : $telefono1,
						'telefono_2' => $telefono2 == '' ? null : $telefono2,
						'email' => $email == '' ? null : $email,
						'estado' => $estado == '' ? 'A' : $estado
					];
					$success = true;
				}
			break;
			case 'EliminarContacto':
				$cod_contacto = array_key_exists('cod_contacto', $datos) ? intval($this->Reservado($datos['cod_contacto'])) : 0;
				if ($cod_contacto == 0) {
					$next = 0;
					$mensaje = 'Contacto no identificado (1)';
					$foot = 'Cierra y vuelve a abrir este ventana';
				} else {
					$next = 1;
				}
				if ($next == 1) {
					$sql = mysqli_query($conexion, 'SELECT * FROM clientes_sedes_contactos WHERE cod_contacto = '.$cod_contacto);
					$rst = mysqli_num_rows($sql);
					if ($rst == 0) {
						$next = 0;
						$mensaje = 'Contacto no identificado (2)';
						$foot = 'Cierra y vuelve a abrir este ventana';
					} else {
						$next = 2;
					}
				}
				if ($next == 2) {
					$data_out['data'] = [
						'proceso' => $proceso,
						'cod_contacto' => $cod_contacto
					];
					$success = true;
				}
			break;
			default:
				$next = 0;
				$mensaje = 'Proceso no identificado (2)';
			break;
		}
		$data_out['success'] = $success ?? false;
		$data_out['mensaje'] = $data_out['success'] ? 'Datos validados correctamente' : $mensaje;
		$data_out['tipo'] = $data_out['success'] ? 'success' : ($tipo ?? 'warning');
		$data_out['foot'] = $foot ?? '';
		return $data_out;
	}
}	