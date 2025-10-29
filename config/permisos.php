<?php
$modulo     = $_REQUEST['sub_modulo'];
$sqlAccesos = mysqli_query($conexion, "SELECT * FROM accesos_usuarios WHERE cod_personal='$xCodPer' AND modulo='$modulo'");
$faccess    = mysqli_fetch_array($sqlAccesos);
$accesoInsert     = $faccess['insertar'] == 'SI' ? 'SI' : 'NO';
$accesoEdit       = $faccess['editar'] == 'SI' ? 'SI' : 'NO';
$accesoElim       = $faccess['eliminar'] == 'SI' ? 'SI' : 'NO';
$accesoConsultar  = $faccess['consultar'] == 'SI' ? 'SI' : 'NO';
/******************************************************/
/******************************************************/
$can_insert = $accesoInsert == 'SI' ? true : false;
$can_update = $accesoEdit == 'SI' ? true : false;
$can_delete = $accesoElim == 'SI' ? true : false;
$can_select = $accesoConsultar == 'SI' ? true : false;