<?php

require('conexion.php');

require('inicializar-datos.php');

require('permisos.php');

require('helper.php');

date_default_timezone_set('America/Lima');

$helper = new helper();

$modulo = $_POST['modulo'];

/*****************************************************************/

/***********************    MI PERFIL    *************************/

/*****************************************************************/

if ($modulo == 'Perfil') {

    $cod_personal       = $_POST['cod_personal'];

    $nombres            = $_POST['nombres'];

    $cod_tipodoc        = $_POST['cod_tipodoc'];

    $num_documento      = $_POST['num_documento'];

    $email              = $_POST['email'];

    $movil              = $_POST['movil'];

    $imagen             = $_POST['imagen'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'ActualizarPerfil') {

        $sqlActualizar  = mysqli_query($conexion, "UPDATE personal SET

        cod_personal    = '$cod_personal',

        nombres         = '$nombres',

        cod_tipodoc     = '$cod_tipodoc',

        num_documento   = '$num_documento',

        email           = '$email',

        movil           = '$movil',

        imagen          = '$imagen' WHERE cod_personal='$cod_personal'");

        $respuesta      = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}



/*****************************************************************/

/******************    CAMBIAR CONTRASEÑA    *********************/

/*****************************************************************/

if ($modulo == 'Clave') {

    $cod_personal       = $_POST['cod_personal'];

    $clave_actual       = sha1($_POST['clave_actual']);

    $clave              = sha1($_POST['clave']);

    $proceso            = $_POST['proceso'];

    if ($proceso == 'ActualizarClave') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_personal FROM personal WHERE clave='$clave_actual' AND cod_personal='$cod_personal'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres > 0) {

            $sqlActualizar  = mysqli_query($conexion, "UPDATE personal SET

            clave           = '$clave' WHERE cod_personal='$cod_personal'");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}



/*****************************************************************/

/******************    ACTUALIZAR EMPRESA    *********************/

/*****************************************************************/

if ($modulo == 'Empresa') {

    $id_empresa         = $_POST['id_empresa'];

    $ruc                = $_POST['ruc'];

    $razon_social       = $_POST['razon_social'];

    $nombre_comercial   = $_POST['nombre_comercial'];

    $icono_web          = $_POST['icono_web'];

    $logo_app           = $_POST['logo_app'];

    $logo_movil         = $_POST['logo_movil'];

    $logo_documentos    = $_POST['logo_documentos'];

    $imagen_fondo       = $_POST['imagen_fondo'];

    $direccion          = $_POST['direccion'];

    $Departamento       = $_POST['Departamento'];

    $Provincia          = $_POST['Provincia'];

    $Distrito           = $_POST['Distrito'];

    $codigoUbigeo       = $_POST['codigoUbigeo'];

    $codigoLocal        = $_POST['codigoLocal'];

    $telefono           = $_POST['telefono'];

    $movil              = $_POST['movil'];

    $email              = $_POST['email'];

    $tipo               = $_POST['tipo'];

    $usuario_sol        = $_POST['usuario_sol'];

    $clave_sol          = $_POST['clave_sol'];

    $certificado        = $_POST['certificado'];

    $clave_certificado  = $_POST['clave_certificado'];

    $clave_borrar       = $_POST['clave_borrar'];

    $ruta_api           = $_POST['ruta_api'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'ActualizarEmpresa') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE empresa SET

        id_empresa          = '$id_empresa',

        ruc                 = '$ruc',

        razon_social        = '$razon_social',

        nombre_comercial    = '$nombre_comercial',

        icono_web           = '$icono_web',

        logo_app            = '$logo_app',

        logo_movil          = '$logo_movil',

        logo_documentos     = '$logo_documentos',

        imagen_fondo        = '$imagen_fondo',

        direccion           = '$direccion',

        Departamento        = '$Departamento',

        Provincia           = '$Provincia',

        Distrito            = '$Distrito',

        codigoUbigeo        = '$codigoUbigeo',

        codigoLocal         = '$codigoLocal',

        telefono            = '$telefono',

        movil               = '$movil',

        email               = '$email',

        tipo                = '$tipo',

        usuario_sol         = '$usuario_sol',

        clave_sol           = '$clave_sol',

        certificado         = '$certificado',

        clave_certificado   = '$clave_certificado',

        ruta_api            = '$ruta_api',

        clave_borrar        = '$clave_borrar' WHERE id_empresa='$id_empresa'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************    PUNTOS DE VENTA   ********************/

/*****************************************************************/

if ($modulo == 'PuntoVenta') {

    $cod_puntoventa     = $_POST['cod_puntoventa'];

    $fecha_creacion     = date('Y-m-d H:i:s');

    $nombre_puntoventa  = $_POST['nombre_puntoventa'];

    $alias              = $_POST['alias'];

    $direccion          = $_POST['direccion'];

    $telefono           = $_POST['telefono'];

    $email              = $_POST['email'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarPuntoVenta') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_puntoventa FROM puntos_ventas WHERE nombre_puntoventa='$nombre_puntoventa'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO puntos_ventas (

            fecha_creacion,

            nombre_puntoventa,

            alias,

            direccion,

            telefono,

            email,

            estado

            )VALUES(

            '$fecha_creacion',

            '$nombre_puntoventa',

            '$alias',

            '$direccion',

            '$telefono',

            '$email',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarPuntoVenta') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE puntos_ventas SET

        cod_puntoventa      = '$cod_puntoventa',

        nombre_puntoventa   = '$nombre_puntoventa',

        alias               = '$alias',

        direccion           = '$direccion',

        telefono            = '$telefono',

        email               = '$email',

        estado              = '$estado' WHERE cod_puntoventa='$cod_puntoventa'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************      PERSONAL        ********************/

/*****************************************************************/

if ($modulo == 'Personal') {

    $cod_personal       = $_POST['cod_personal'];

    $fecha_creacion     = date('Y-m-d H:i:s');

    $fecha_actualizacion = date('Y-m-d H:i:s');

    $cod_puntoventa     = $_POST['cod_puntoventa'];

    $nombres            = $_POST['nombres'];

    $cod_tipodoc        = $_POST['cod_tipodoc'];

    $num_documento      = $_POST['num_documento'];

    $email              = $_POST['email'];

    $movil              = $_POST['movil'];

    $cargo              = $_POST['cargo'];

    $area_trabajo       = $_POST['area_trabajo'];

    $fecha_ingreso      = $_POST['fecha_ingreso'];

    $imagen             = $_POST['imagen'];

    $user               = $_POST['usuario'];

    $pass               = $_POST['clave'];

    $usuario            = sha1($_POST['usuario']);

    $clave              = sha1($_POST['clave']);

    $accesos            = $_POST['accesos'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarPersonal') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_personal FROM personal WHERE num_documento='$num_documento'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO personal (

            fecha_creacion,

            fecha_actualizacion,

            cod_puntoventa,

            nombres,

            cod_tipodoc,

            num_documento,

            email,

            movil,

            cargo,

            area_trabajo,

            fecha_ingreso,

            imagen,

            usuario,

            clave,

            accesos,

            estado

            )VALUES(

            '$fecha_creacion',

            '$fecha_actualizacion',

            '$cod_puntoventa',

            '$nombres',

            '$cod_tipodoc',

            '$num_documento',

            '$email',

            '$movil',

            '$cargo',

            '$area_trabajo',

            '$fecha_ingreso',

            '$imagen',

            '$usuario',

            '$clave',

            '$accesos',

            '$estado')");

            /***********************************************************/

            /***********************************************************/

            $cod_personal   = mysqli_insert_id($conexion);

            /***********************************************************/

            /***********************************************************/

            if ($accesos == 'SI') {

                $sqlSubmodulos  = mysqli_query($conexion, "SELECT * FROM sub_modulos WHERE estado='A'");

                while ($fsmod    = mysqli_fetch_array($sqlSubmodulos)) {

                    $cod_submodulo  = $fsmod['cod_submodulo'];

                    $cod_modulo     = $fsmod['cod_modulo'];

                    $modulo         = $fsmod['sub_modulo'];

                    $sqlInsertAcces = mysqli_query($conexion, "INSERT INTO accesos_usuarios (

                    cod_personal,

                    cod_modulo,

                    cod_submodulo,

                    modulo,

                    insertar,

                    editar,

                    eliminar,

                    consultar 

                    )VALUES(

                    '$cod_personal',

                    '$cod_modulo',

                    '$cod_submodulo',

                    '$modulo',

                    'SI',

                    'SI',

                    'SI',

                    'SI')");
                }
            } else {

                if (!empty($_POST['modulos']) and is_array($_POST['modulos'])) {

                    $modulos        = $_POST['modulos'];

                    for ($i = 0; $i < sizeof($modulos); $i++) {

                        $xModulos       = explode("|", $modulos[$i]);

                        $cod_submodulo  = $xModulos[0];

                        $cod_modulo     = $xModulos[1];

                        $modulo         = $xModulos[2];

                        $sqlInsertAcces = mysqli_query($conexion, "INSERT INTO accesos_usuarios (

                        cod_personal,

                        cod_modulo,

                        cod_submodulo,

                        modulo,

                        insertar,

                        editar,

                        eliminar,

                        consultar 

                        )VALUES(

                        '$cod_personal',

                        '$cod_modulo',

                        '$cod_submodulo',

                        '$modulo',

                        'SI',

                        'SI',

                        'SI',

                        'SI')");
                    }
                }
            }

            /***********************************************************/

            /***********************************************************/

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    /***********************************************************************/

    /***********************************************************************/

    if ($proceso == 'ActualizarPersonal') {

        if ($user != '' and $pass != '') {

            $sqlActualizar      = mysqli_query($conexion, "UPDATE personal SET

            cod_personal        = '$cod_personal',

            fecha_actualizacion = '$fecha_actualizacion',

            cod_puntoventa      = '$cod_puntoventa',

            nombres             = '$nombres',

            cod_tipodoc         = '$cod_tipodoc',

            num_documento       = '$num_documento',

            email               = '$email',

            movil               = '$movil',

            cargo               = '$cargo',

            area_trabajo        = '$area_trabajo',

            fecha_ingreso       = '$fecha_ingreso',

            imagen              = '$imagen',

            usuario             = '$usuario',

            clave               = '$clave',

            accesos             = '$accesos',

            estado              = '$estado' WHERE cod_personal='$cod_personal'");
        }

        if ($user != '' and $pass == '') {

            $sqlActualizar      = mysqli_query($conexion, "UPDATE personal SET

            cod_personal        = '$cod_personal',

            fecha_actualizacion = '$fecha_actualizacion',

            cod_puntoventa      = '$cod_puntoventa',

            nombres             = '$nombres',

            cod_tipodoc         = '$cod_tipodoc',

            num_documento       = '$num_documento',

            email               = '$email',

            movil               = '$movil',

            cargo               = '$cargo',

            area_trabajo        = '$area_trabajo',

            fecha_ingreso       = '$fecha_ingreso',

            imagen              = '$imagen',

            usuario             = '$usuario',

            accesos             = '$accesos',

            estado              = '$estado' WHERE cod_personal='$cod_personal'");
        }

        if ($user == '' and $pass != '') {

            $sqlActualizar      = mysqli_query($conexion, "UPDATE personal SET

            cod_personal        = '$cod_personal',

            fecha_actualizacion = '$fecha_actualizacion',

            cod_puntoventa      = '$cod_puntoventa',

            nombres             = '$nombres',

            cod_tipodoc         = '$cod_tipodoc',

            num_documento       = '$num_documento',

            email               = '$email',

            movil               = '$movil',

            cargo               = '$cargo',

            area_trabajo        = '$area_trabajo',

            fecha_ingreso       = '$fecha_ingreso',

            imagen              = '$imagen',

            clave               = '$clave',

            accesos             = '$accesos',

            estado              = '$estado' WHERE cod_personal='$cod_personal'");
        }

        if ($user == '' and $pass == '') {

            $sqlActualizar      = mysqli_query($conexion, "UPDATE personal SET

            cod_personal        = '$cod_personal',

            fecha_actualizacion = '$fecha_actualizacion',

            cod_puntoventa      = '$cod_puntoventa',

            nombres             = '$nombres',

            cod_tipodoc         = '$cod_tipodoc',

            num_documento       = '$num_documento',

            email               = '$email',

            movil               = '$movil',

            cargo               = '$cargo',

            area_trabajo        = '$area_trabajo',

            fecha_ingreso       = '$fecha_ingreso',

            imagen              = '$imagen',

            accesos             = '$accesos',

            estado              = '$estado' WHERE cod_personal='$cod_personal'");
        }

        /***********************************************************/

        $sqlBorrarAccesos       = mysqli_query($conexion, "DELETE FROM accesos_usuarios WHERE cod_personal='$cod_personal'");

        /***********************************************************/

        if ($accesos == 'SI') {

            $sqlSubmodulos      = mysqli_query($conexion, "SELECT * FROM sub_modulos WHERE estado='A'");

            while ($fsmod       = mysqli_fetch_array($sqlSubmodulos)) {

                $cod_submodulo  = $fsmod['cod_submodulo'];

                $cod_modulo     = $fsmod['cod_modulo'];

                $modulo         = $fsmod['sub_modulo'];

                $sqlInsertAcces = mysqli_query($conexion, "INSERT INTO accesos_usuarios (

                cod_personal,

                cod_modulo,

                cod_submodulo,

                modulo,

                insertar,

                editar,

                eliminar,

                consultar 

                )VALUES(

                '$cod_personal',

                '$cod_modulo',

                '$cod_submodulo',

                '$modulo',

                'SI',

                'SI',

                'SI',

                'SI')");
            }
        }

        if ($accesos == 'NO') {

            if (!empty($_POST['modulos']) and is_array($_POST['modulos'])) {

                $modulos        = $_POST['modulos'];

                for ($i = 0; $i < sizeof($modulos); $i++) {

                    $xModulos       = explode("|", $modulos[$i]);

                    $cod_submodulo  = $xModulos[0];

                    $cod_modulo     = $xModulos[1];

                    $modulo         = $xModulos[2];

                    $sqlInsertAcces = mysqli_query($conexion, "INSERT INTO accesos_usuarios (

                    cod_personal,

                    cod_modulo,

                    cod_submodulo,

                    modulo,

                    insertar,

                    editar,

                    eliminar,

                    consultar 

                    )VALUES(

                    '$cod_personal',

                    '$cod_modulo',

                    '$cod_submodulo',

                    '$modulo',

                    'SI',

                    'SI',

                    'SI',

                    'SI')");
                }
            }
        }

        /***********************************************************/

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************      CATEGORIA       ********************/

/*****************************************************************/

if ($modulo == 'Categorias') {

    $cod_categoria      = $_POST['cod_categoria'];

    $categoria          = $_POST['categoria'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarCategorias') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_categoria FROM categoria_productos WHERE categoria='$categoria'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO categoria_productos (

            categoria,

            estado

            )VALUES(

            '$categoria',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarCategorias') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE categoria_productos SET

        cod_categoria       = '$cod_categoria',

        categoria           = '$categoria',

        estado              = '$estado' WHERE cod_categoria='$cod_categoria'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************      MARCAS          ********************/

/*****************************************************************/

if ($modulo == 'Marcas') {

    $cod_marca          = $_POST['cod_marca'];

    $marca              = $_POST['marca'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarMarcas') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_marca FROM marcas WHERE marca='$marca'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO marcas (

            marca,

            estado

            )VALUES(

            '$marca',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarMarcas') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE marcas SET

        cod_marca           = '$cod_marca',

        marca               = '$marca',

        estado              = '$estado' WHERE cod_marca='$cod_marca'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************      PRODUCTOS       ********************/

/*****************************************************************/

if ($modulo == 'Producto') {

    $cod_producto       = $_POST['cod_producto'];

    $fecha_creacion     = date('Y-m-d H:i:s');

    $fecha_actualizacion = date('Y-m-d H:i:s');

    $cod_categoria      = $_POST['cod_categoria'];

    $cod_marca          = $_POST['cod_marca'];

    $cod_personal       = $xCodPer;

    $codigo             = $_POST['codigo'];

    $nombre_producto    = $_POST['nombre_producto'];

    $unidad_medida      = $_POST['unidad_medida'];

    $stock_actual       = $_POST['stock_actual'];

    $stock_minimo       = $_POST['stock_minimo'];

    $precio_unitario    = $_POST['precio_unitario'];

    $precio_cuarto      = $_POST['precio_cuarto'];

    $precio_mayor       = $_POST['precio_mayor'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarProducto') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_producto FROM productos WHERE codigo='$codigo'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO productos (

            fecha_creacion,

            fecha_actualizacion,

            cod_categoria,

            cod_marca,

            cod_personal,

            codigo,

            nombre_producto,

            unidad_medida,

            stock_actual,

            stock_minimo,

            precio_unitario,

            precio_cuarto,

            precio_mayor,

            estado

            )VALUES(

            '$fecha_creacion',

            '$fecha_actualizacion',

            '$cod_categoria',

            '$cod_marca',

            '$cod_personal',

            '$codigo',

            '$nombre_producto',

            '$unidad_medida',

            '$stock_actual',

            '$stock_minimo',

            '$precio_unitario',

            '$precio_cuarto',

            '$precio_mayor',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarProducto') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE productos SET

        cod_producto        = '$cod_producto',

        fecha_actualizacion = '$fecha_actualizacion',

        cod_categoria       = '$cod_categoria',

        cod_marca           = '$cod_marca',

        cod_personal        = '$cod_personal',

        codigo              = '$codigo',

        nombre_producto     = '$nombre_producto',

        unidad_medida       = '$unidad_medida',

        stock_actual        = '$stock_actual',

        stock_minimo        = '$stock_minimo',

        precio_unitario     = '$precio_unitario',

        precio_cuarto       = '$precio_cuarto',

        precio_mayor        = '$precio_mayor',

        estado              = '$estado' WHERE cod_producto='$cod_producto'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/**************   INGRESAR PRODUCTOS A ALMACEN   *****************/

/*****************************************************************/

if ($modulo == 'productosAlmacen') {

    $cod_puntoventa = $_POST['cod_puntoventa'];

    $archivocsv     = $_POST['archivocsv'];

    /************************************************************/

    $uploadfile     = '../img-apps/stockcsv/' . $archivocsv;

    $xFile          = fopen($uploadfile, "r+");

    rewind($xFile);

    while (!feof($xFile)) {

        $xDatos     = fgets($xFile);

        if ($xDatos != '') {

            $tDatos      = explode(";", $xDatos);

            $fecha_creacion = date('Y-m-d H:i:s');

            $fecha_actualizacion = date('Y-m-d H:i:s');

            /****************************************************/

            $categoria      = str_replace('""', '&#34', trim($tDatos[0]));

            $sqlCategorias  = mysqli_query($conexion, "SELECT cod_categoria FROM categoria_productos WHERE categoria='$categoria'");

            $fcat           = mysqli_fetch_array($sqlCategorias);

            $cod_categoria  = $fcat['cod_categoria'];

            /****************************************************/

            $marca          = str_replace('""', '&#34', trim($tDatos[1]));

            $sqlMarcas      = mysqli_query($conexion, "SELECT cod_marca FROM marcas WHERE marca='$marca'");

            $fmar           = mysqli_fetch_array($sqlMarcas);

            $cod_marca      = $fmar['cod_marca'];

            /****************************************************/

            $cod_personal   = $xCodPer;

            $codigo         = trim($tDatos[2]);

            $nombre_producto = str_replace('""', '&#34', trim($tDatos[3]));

            $unidad_medida   = trim($tDatos[4]);

            $stock_actual    = trim($tDatos[5]);

            $precio_unitario = trim($tDatos[6]);

            $precio_cuarto   = trim($tDatos[7]);

            $precio_mayor    = trim($tDatos[8]);

            $estado          = "A";

            /****************************************************/

            $sqlVerificar    = mysqli_query($conexion, "SELECT cod_producto FROM productos WHERE codigo='$codigo'");

            $numres          = mysqli_num_rows($sqlVerificar);

            if ($numres == 0) {

                $sqlInsertar = mysqli_query($conexion, "INSERT INTO productos (

                fecha_creacion,

                fecha_actualizacion,

                cod_categoria,

                cod_marca,

                cod_personal,

                codigo,

                nombre_producto,

                unidad_medida,

                stock_actual,

                precio_unitario,

                precio_cuarto,

                precio_mayor,

                estado

                )VALUES(

                '$fecha_creacion',

                '$fecha_actualizacion',

                '$cod_categoria',

                '$cod_marca',

                '$cod_personal',

                '$codigo',

                '$nombre_producto',

                '$unidad_medida',

                '$stock_actual',

                '$precio_unitario',

                '$precio_cuarto',

                '$precio_mayor',

                '$estado')");
            } else {

                $sqlActualizar = mysqli_query($conexion, "UPDATE productos SET

                fecha_actualizacion = '$fecha_actualizacion',

                cod_personal        = '$cod_personal',

                stock_actual        = stock_actual+'$stock_actual',

                precio_unitario     = '$precio_unitario',

                precio_cuarto       = '$precio_cuarto',

                precio_mayor        = '$precio_mayor' WHERE codigo='$codigo'");
            }

            /****************************************************/

            $sqlIngresoSctock       = mysqli_query($conexion, "INSERT INTO ingreso_stock (

            fecha_entrada,

            cod_puntoventa,

            codigo,

            nombre_producto,

            stock_ingresado,

            archivo_csv

            )VALUES(

            '$fecha_creacion',

            '$cod_puntoventa',

            '$codigo',

            '$nombre_producto',

            '$stock_actual',

            '$archivocsv')");
        }
    }

    fclose($xFile);

    $respuesta = "SI";

    /************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);

    /************************************************************/
}



/*****************************************************************/

/**************    SALIDA PRODUCTOS A TIENDAS    *****************/

/*****************************************************************/

if ($modulo == 'asignarStockTiendas') {

    $cod_puntoventa_origen  = $_POST['cod_puntoventa_origen'];

    $cod_puntoventa_destino = $_POST['cod_puntoventa_destino'];

    $archivocsv             = $_POST['archivocsv'];

    /************************************************************/

    $uploadfile     = '../img-apps/stocksalidacsv/' . $archivocsv;

    $xFile          = fopen($uploadfile, "r+");

    rewind($xFile);

    while (!feof($xFile)) {

        $xDatos     = fgets($xFile);

        if ($xDatos != '') {

            $tDatos         = explode(";", $xDatos);

            $fecha_salida   = date('Y-m-d H:i:s');

            $codigo         = trim($tDatos[0]);

            $stock_salida   = trim($tDatos[1]);

            /****************************************************/

            $sqlProducto        = mysqli_query($conexion, "SELECT cod_producto, nombre_producto FROM productos WHERE codigo='$codigo'");

            $fprods             = mysqli_fetch_array($sqlProducto);

            $cod_producto       = $fprods['cod_producto'];

            $nombre_producto    = $fprods['nombre_producto'];

            /****************************************************/

            $sqlVerificar       = mysqli_query($conexion, "SELECT cod_stocklocal FROM stock_locales WHERE codigo='$codigo'");

            $numres             = mysqli_num_rows($sqlVerificar);

            if ($numres == 0) {

                $sqlInsertar = mysqli_query($conexion, "INSERT INTO stock_locales (

                cod_puntoventa,

                fecha_entrada,

                cod_producto,

                codigo,

                nombre_producto,

                stock_ingresado,

                stock_actual

                )VALUES(

                '$cod_puntoventa_destino',

                '$fecha_salida',

                '$cod_producto',

                '$codigo',

                '$nombre_producto',

                '$stock_salida',

                '$stock_salida')");
            } else {

                $sqlActualizar = mysqli_query($conexion, "UPDATE stock_locales SET

                stock_ingresado     = stock_ingresado+'$stock_salida',

                stock_actual        = stock_actual+'$stock_salida' WHERE codigo='$codigo'");
            }

            /****************************************************/

            /****************   REGISTRAR SALIDA   **************/

            /****************************************************/

            $sqlSalidaSctock       = mysqli_query($conexion, "INSERT INTO salida_stock (

            cod_puntoventa,    

            fecha_salida,            

            codigo,

            nombre_producto,

            stock_salida,

            archivo_csv

            )VALUES(

            '$cod_puntoventa_destino',    

            '$fecha_salida',            

            '$codigo',

            '$nombre_producto',

            '$stock_salida',

            '$archivocsv')");

            /****************************************************/

            /************   ACTUALIZAR STOCK ALMACEN   **********/

            /****************************************************/

            $sqlActualizarProductos = mysqli_query($conexion, "UPDATE productos SET 

            stock_actual = stock_actual-'$stock_salida' WHERE codigo='$codigo'");
        }
    }

    fclose($xFile);

    $respuesta = "SI";

    /************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);

    /************************************************************/
}

/*****************************************************************/

/****************      SERIES DOCUMENTOS       *******************/

/*****************************************************************/

if ($modulo == 'SeriesDocumentos') {

    $cod_serie          = $_POST['cod_serie'];

    $cod_personal       = $xCodPer;

    $codigo_compro      = $_POST['codigo_compro'];

    $serie              = $_POST['serie'];

    $cod_puntoventa     = $_POST['cod_puntoventa'];

    $num_inicial        = $_POST['num_inicial'];

    $num_actual         = $_POST['num_actual'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarSeries') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_serie FROM serie_documentos WHERE codigo_compro='$codigo_compro' AND serie='$serie'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO serie_documentos (

            cod_personal,    

            codigo_compro,

            serie,

            cod_puntoventa,

            num_inicial,

            num_actual,

            estado

            )VALUES(

            '$cod_personal',    

            '$codigo_compro',

            '$serie',

            '$cod_puntoventa',

            '$num_inicial',

            '$num_actual',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarSeries') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE serie_documentos SET

        cod_serie           = '$cod_serie',

        codigo_compro       = '$codigo_compro',

        serie               = '$serie',

        cod_puntoventa      = '$cod_puntoventa',

        num_inicial         = '$num_inicial',

        num_actual          = '$num_actual',

        estado              = '$estado' WHERE cod_serie='$cod_serie'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      TIPOS DE DOCUMENTOS     *******************/

/*****************************************************************/

if ($modulo == 'TipoDocumento') {

    $cod_tipo_compro    = $_POST['cod_tipo_compro'];

    $codigo_compro      = $_POST['codigo_compro'];

    $descripcion        = $_POST['descripcion'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarTipoDocumento') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_tipo_compro FROM tipo_documento WHERE codigo_compro='$codigo_compro' AND descripcion='$descripcion'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO tipo_documento (    

            codigo_compro,

            descripcion,

            estado

            )VALUES(    

            '$codigo_compro',

            '$descripcion',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarTipoDocumento') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE tipo_documento SET

        cod_tipo_compro     = '$cod_tipo_compro',

        codigo_compro       = '$codigo_compro',

        descripcion         = '$descripcion',

        estado              = '$estado' WHERE cod_tipo_compro='$cod_tipo_compro'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      TIPO NOTA DE CREDITO    *******************/

/*****************************************************************/

if ($modulo == 'NotaCredito') {

    $cod_motivo         = $_POST['cod_motivo'];

    $codigo             = $_POST['codigo'];

    $descripcion        = $_POST['descripcion'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarNotaCredito') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_motivo FROM motivo_nota_credito WHERE codigo='$codigo' AND descripcion='$descripcion'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO motivo_nota_credito (    

            codigo,

            descripcion,

            estado

            )VALUES(    

            '$codigo',

            '$descripcion',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarNotaCredito') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE motivo_nota_credito SET

        cod_motivo          = '$cod_motivo',

        codigo              = '$codigo',

        descripcion         = '$descripcion',

        estado              = '$estado' WHERE cod_motivo='$cod_motivo'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/***********************      CLIENTES        ********************/

/*****************************************************************/

if ($modulo == 'Clientes') {

    $rs = $helper->Validar_DatosCliente($_POST);

    $success = $rs['success'];

    $mensaje = $rs['mensaje'];

    $tipo = $rs['tipo'];

    $foot = $rs['foot'];

    if ($success) {

        switch ($rs['data']['proceso']) {

            case 'RegistrarCliente':

                $insert = 'INSERT INTO clientes (cod_personal, cod_puntoventa, cod_tipodoc, num_documento, nombres, nombre_comercial, id_giro_negocio, website, estado) VALUES (';

                $insert .= $xCodPer . ', ';

                $insert .= $rs['data']['cod_puntoventa'] . ', ';

                $insert .= $rs['data']['cod_tipodoc'] . ', ';

                $insert .= '"' . $rs['data']['num_documento'] . '", ';

                $insert .= '"' . $rs['data']['nombres'] . '", ';

                $insert .= $rs['data']['nombre_comercial'] == null ? 'null, ' : ('"' . $rs['data']['nombre_comercial'] . '", ');

                $insert .= $rs['data']['id_giro_negocio'] == null ? 'null, ' : $rs['data']['id_giro_negocio'] . ', ';

                $insert .= $rs['data']['website'] == null ? 'null, ' : ('"' . $rs['data']['website'] . '", ');

                $insert .= '"' . $rs['data']['estado'] . '"';

                $insert .= ')';

                if ($can_insert) {

                    $success = mysqli_query($conexion, $insert);

                    $mensaje = $success ? 'Cliente Registrado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Registrar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'ActualizarCliente':

                $update = 'UPDATE clientes SET ';

                $update .= 'cod_puntoventa = ' . $rs['data']['cod_puntoventa'] . ', ';

                $update .= 'cod_tipodoc = ' . $rs['data']['cod_tipodoc'] . ', ';

                $update .= 'num_documento = "' . $rs['data']['num_documento'] . '", ';

                $update .= 'nombres = "' . $rs['data']['nombres'] . '", ';

                $update .= 'nombre_comercial = ' . ($rs['data']['nombre_comercial'] == null ? 'null, ' : ('"' . $rs['data']['nombre_comercial'] . '", '));

                $update .= 'id_giro_negocio = ' . ($rs['data']['id_giro_negocio'] == null ? 'null, ' : $rs['data']['id_giro_negocio'] . ', ');

                $update .= 'website = ' . ($rs['data']['website'] == null ? 'null, ' : ('"' . $rs['data']['website'] . '", '));

                $update .= 'estado = "' . $rs['data']['estado'] . '" ';

                $update .= 'WHERE cod_cliente = ' . $rs['data']['cod_cliente'];

                if ($can_update) {

                    $success = mysqli_query($conexion, $update);

                    $mensaje = $success ? 'Cliente Actualizado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Actualizar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'EliminarCliente':

                $delete = 'DELETE FROM clientes WHERE cod_cliente = ' . $rs['data']['cod_cliente'];

                if ($can_delete) {

                    $success = mysqli_query($conexion, $delete);

                    $mensaje = $success ? 'Cliente Eliminado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Eliminar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            default:

                $success = false;

                $mensaje = 'Proceso no identificado (1)';

                break;
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $data_out['success'] = $success;

    $data_out['mensaje'] = $mensaje;

    $data_out['tipo'] = $tipo;

    $data_out['foot'] = $foot;

    echo json_encode($helper->PrettyMessage($data_out));
}

/*****************************************************************/

/***********************  SEDES POR CLIENTE   ********************/

/*****************************************************************/

if ($modulo == 'Sedes por Cliente') {

    $rs = $helper->Validar_DatosSede($_POST);

    $success = $rs['success'];

    $mensaje = $rs['mensaje'];

    $tipo = $rs['tipo'];

    $foot = $rs['foot'];

    if ($success) {

        switch ($rs['data']['proceso']) {

            case 'RegistrarSede':

                $insert = 'INSERT INTO clientes_sedes (cod_cliente, id_tipo_direccion, direccion, referencia, IdDepartamento, IdProvincia, IdDistrito, estado) VALUES (';

                $insert .= $rs['data']['cod_cliente'] . ', ';

                $insert .= $rs['data']['id_tipo_direccion'] . ', ';

                $insert .= '"' . $rs['data']['direccion'] . '", ';

                $insert .= $rs['data']['referencia'] == null ? 'null, ' : ('"' . $rs['data']['referencia'] . '", ');

                $insert .= '"' . $rs['data']['IdDepartamento'] . '", ';

                $insert .= '"' . $rs['data']['IdProvincia'] . '", ';

                $insert .= '"' . $rs['data']['IdDistrito'] . '", ';

                $insert .= '"' . $rs['data']['estado'] . '"';

                $insert .= ')';

                if ($can_insert) {

                    $success = mysqli_query($conexion, $insert);

                    $mensaje = $success ? 'Sede Registrada Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Registrar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'ActualizarSede':

                $update = 'UPDATE clientes_sedes SET ';

                $update .= 'cod_cliente = ' . $rs['data']['cod_cliente'] . ', ';

                $update .= 'id_tipo_direccion = ' . $rs['data']['id_tipo_direccion'] . ', ';

                $update .= 'direccion = "' . $rs['data']['direccion'] . '", ';

                $update .= 'referencia = ' . ($rs['data']['referencia'] == null ? 'null, ' : ('"' . $rs['data']['referencia'] . '", '));

                $update .= 'IdDepartamento = ' . ($rs['data']['IdDepartamento'] == null ? 'null, ' : ('"' . $rs['data']['IdDepartamento'] . '", '));

                $update .= 'IdProvincia = ' . ($rs['data']['IdProvincia'] == null ? 'null, ' : ('"' . $rs['data']['IdProvincia'] . '", '));

                $update .= 'IdDistrito = ' . ($rs['data']['IdDistrito'] == null ? 'null, ' : ('"' . $rs['data']['IdDistrito'] . '", '));

                $update .= 'estado = "' . $rs['data']['estado'] . '" ';

                $update .= 'WHERE cod_sede = ' . $rs['data']['cod_sede'];

                if ($can_update) {

                    $success = mysqli_query($conexion, $update);

                    $mensaje = $success ? 'Sede Actualizada Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Actualizar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'EliminarSede':

                $delete = 'DELETE FROM clientes_sedes WHERE cod_sede = ' . $rs['data']['cod_sede'];

                if ($can_delete) {

                    $success = mysqli_query($conexion, $delete);

                    $mensaje = $success ? 'Sede Eliminada Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Eliminar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            default:

                $success = false;

                $mensaje = 'Proceso no identificado (1)';

                break;
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $data_out['success'] = $success;

    $data_out['mensaje'] = $mensaje;

    $data_out['tipo'] = $tipo;

    $data_out['foot'] = $foot;

    echo json_encode($helper->PrettyMessage($data_out));
}

/*****************************************************************/

/***********************  CONTACTOS POR SEDE  ********************/

/*****************************************************************/

if ($modulo == 'Contactos por Sede') {

    $rs = $helper->Validar_DatosContacto($_POST);

    $success = $rs['success'];

    $mensaje = $rs['mensaje'];

    $tipo = $rs['tipo'];

    $foot = $rs['foot'];

    if ($success) {

        switch ($rs['data']['proceso']) {

            case 'RegistrarContacto':

                $insert = 'INSERT INTO clientes_sedes_contactos (cod_sede, id_tipo_contacto, persona_contacto, telefono_1, telefono_2, email, estado) VALUES (';

                $insert .= $rs['data']['cod_sede'] . ', ';

                $insert .= $rs['data']['id_tipo_contacto'] . ', ';

                $insert .= '"' . $rs['data']['persona_contacto'] . '", ';

                $insert .= $rs['data']['telefono_1'] == null ? 'null, ' : ('"' . $rs['data']['telefono_1'] . '", ');

                $insert .= $rs['data']['telefono_2'] == null ? 'null, ' : ('"' . $rs['data']['telefono_2'] . '", ');

                $insert .= $rs['data']['email'] == null ? 'null, ' : ('"' . $rs['data']['email'] . '", ');

                $insert .= '"' . $rs['data']['estado'] . '"';

                $insert .= ')';

                if ($can_insert) {

                    $success = mysqli_query($conexion, $insert);

                    $mensaje = $success ? 'Contacto Registrado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Registrar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'ActualizarContacto':

                $update = 'UPDATE clientes_sedes_contactos SET ';

                $update .= 'cod_sede = ' . $rs['data']['cod_sede'] . ', ';

                $update .= 'id_tipo_contacto = ' . $rs['data']['id_tipo_contacto'] . ', ';

                $update .= 'persona_contacto = "' . $rs['data']['persona_contacto'] . '", ';

                $update .= 'telefono_1 = ' . ($rs['data']['telefono_1'] == null ? 'null, ' : ('"' . $rs['data']['telefono_1'] . '", '));

                $update .= 'telefono_2 = ' . ($rs['data']['telefono_2'] == null ? 'null, ' : ('"' . $rs['data']['telefono_2'] . '", '));

                $update .= 'email = ' . ($rs['data']['email'] == null ? 'null, ' : ('"' . $rs['data']['email'] . '", '));

                $update .= 'estado = "' . $rs['data']['estado'] . '" ';

                $update .= 'WHERE cod_contacto = ' . $rs['data']['cod_contacto'];

                if ($can_update) {

                    $success = mysqli_query($conexion, $update);

                    $mensaje = $success ? 'Contacto Actualizado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Actualizar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            case 'EliminarContacto':

                $delete = 'DELETE FROM clientes_sedes_contactos WHERE cod_contacto = ' . $rs['data']['cod_contacto'];

                if ($can_delete) {

                    $success = mysqli_query($conexion, $delete);

                    $mensaje = $success ? 'Contacto Eliminado Correctamente' : 'Ocurrió un error inesperado';
                } else {

                    $success = false;

                    $mensaje = 'No tiene permisos para Eliminar ' . $modulo;
                }

                if (!$success) {
                    $tipo = 'error';
                }

                break;

            default:

                $success = false;

                $mensaje = 'Proceso no identificado (1)';

                break;
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $data_out['success'] = $success;

    $data_out['mensaje'] = $mensaje;

    $data_out['tipo'] = $tipo;

    $data_out['foot'] = $foot;

    echo json_encode($helper->PrettyMessage($data_out));
}

/*****************************************************************/

/****************        CARGOS PERSONAL       *******************/

/*****************************************************************/

if ($modulo == 'Cargos') {

    $cod_cargo          = $_POST['cod_cargo'];

    $cargo              = $_POST['cargo'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarCargo') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_cargo FROM cargos_personal WHERE cargo='$cargo'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO cargos_personal (    

            cargo,

            estado

            )VALUES(    

            '$cargo',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarCargo') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE cargos_personal SET

        cod_cargo           = '$cod_cargo',

        cargo               = '$cargo',

        estado              = '$estado' WHERE cod_cargo='$cod_cargo'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************       MODULOS DE SISTEMA     *******************/

/*****************************************************************/

if ($modulo == 'Modulos') {

    $cod_modulo         = $_POST['cod_modulo'];

    $nombre_modulo      = $_POST['nombre_modulo'];

    $icono              = $_POST['icono'];

    $orden              = $_POST['orden'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarModulo') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_modulo FROM modulos WHERE nombre_modulo='$nombre_modulo'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO modulos (    

            nombre_modulo,

            icono,

            orden,

            estado

            )VALUES(    

            '$nombre_modulo',

            '$icono',

            '$orden',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    if ($proceso == 'ActualizarModulo') {

        $sqlActualizar      = mysqli_query($conexion, "UPDATE modulos SET

        cod_modulo          = '$cod_modulo',

        nombre_modulo       = '$nombre_modulo',

        icono               = '$icono',

        orden               = '$orden',

        estado              = '$estado' WHERE cod_modulo='$cod_modulo'");

        $respuesta          = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      SUB MODULOS DE SISTEMA     ****************/

/*****************************************************************/

if ($modulo == 'SubModulo') {

    $cod_modulo         = $_POST['cod_modulo'];

    $sub_modulo         = $_POST['sub_modulo'];

    $enlace             = $_POST['enlace'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarSubModulo') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_submodulo FROM sub_modulos WHERE sub_modulo='$sub_modulo' AND cod_modulo='$cod_modulo'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO sub_modulos (    

            cod_modulo,

            sub_modulo,

            enlace,

            estado

            )VALUES(    

            '$cod_modulo',

            '$sub_modulo',

            '$enlace',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************        APERTURA DE CAJAS        ****************/

/*****************************************************************/

if ($modulo == 'Cajas') {

    $cod_apertura       = $_POST['cod_apertura'];

    $fecha_creacion     = date('Y-m-d');

    $fecha_apertura     = date('Y-m-d H:i:s');

    $cod_personal       = $xCodPer;

    $cod_puntoventa     = $_POST['cod_puntoventa'];

    /************************************************************/

    $sqlAliasTienda     = mysqli_query($conexion, "SELECT alias FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");

    $falias             = mysqli_fetch_array($sqlAliasTienda);

    $alias              = $falias['alias'];

    /************************************************************/

    $nombre_caja        = "Caja-" . $alias;

    $cincuenta_centimos = $_POST['cincuenta_centimos'];

    $un_sol             = $_POST['un_sol'];

    $dos_soles          = $_POST['dos_soles'];

    $cinco_soles        = $_POST['cinco_soles'];

    $diez_soles         = $_POST['diez_soles'];

    $veinte_soles       = $_POST['veinte_soles'];

    $cincuenta_soles    = $_POST['cincuenta_soles'];

    $cien_soles         = $_POST['cien_soles'];

    $totaldinero        = $_POST['totaldinero'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'RegistrarAperturaCaja') {

        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_apertura FROM apertura_cajas WHERE fecha_creacion='$fecha_creacion' AND cod_puntoventa='$cod_puntoventa' AND estado='Aperturado'");

        $numres         = mysqli_num_rows($sqlVerificar);

        if ($numres == 0) {

            $sqlInsertar = mysqli_query($conexion, "INSERT INTO apertura_cajas (    

            fecha_creacion,

            fecha_apertura,

            nombre_caja,

            cod_personal,

            cod_puntoventa,

            cincuenta_centimos,

            un_sol,

            dos_soles,

            cinco_soles,

            diez_soles,

            veinte_soles,

            cincuenta_soles,

            cien_soles,

            total_dinero_apertura,

            estado 

            )VALUES(    

            '$fecha_creacion',

            '$fecha_apertura',

            '$nombre_caja',

            '$cod_personal',

            '$cod_puntoventa',

            '$cincuenta_centimos',

            '$un_sol',

            '$dos_soles',

            '$cinco_soles',

            '$diez_soles',

            '$veinte_soles',

            '$cincuenta_soles',

            '$cien_soles',

            '$totaldinero',

            '$estado')");

            $respuesta      = 'SI';
        } else {

            $respuesta      = 'NO';
        }
    }

    /***************************************************************/

    /***************************************************************/

    if ($proceso == 'CerrarAperturaCaja') {

        $fecha_cierre   = date('Y-m-d H:i:s');

        $sqlFacturas    = mysqli_query($conexion, "SELECT total_monto FROM factura WHERE cod_apertura='$cod_apertura'");

        while ($ffact    = mysqli_fetch_array($sqlFacturas)) {

            $totalVentas = ($totalVentas + $ffact['total_monto']);
        }

        $sqlActualizarCaja = mysqli_query($conexion, "UPDATE apertura_cajas SET

        cod_apertura    = '$cod_apertura',

        fecha_cierre    = '$fecha_cierre',

        total_dinero_cierre = '$totalVentas',

        estado          = '$estado' WHERE cod_apertura='$cod_apertura'");

        $respuesta      = "SI";
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      CAMBIAR ESTADO DOCUMENTO   ****************/

/*****************************************************************/

if ($modulo == 'FacturasElectronicas') {

    $id_factura         = $_POST['id_factura'];

    $fecha_enviosunat   = date('Y-m-d');

    $ruta_xml           = $_POST['ruta_xml'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'ActualizarEstadoFact') {

        $sqlActualizar  = mysqli_query($conexion, "UPDATE factura SET    

        id_factura      = '$id_factura',

        fecha_enviosunat= '$fecha_enviosunat',

        ruta_xml        = '$ruta_xml',

        estado          = '$estado' WHERE id_factura='$id_factura'");

        $respuesta      = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      CAMBIAR ESTADO GUIA        ****************/

/*****************************************************************/

if ($modulo == 'GuiasElectronicas') {

    $id_guia            = $_POST['id_guia'];

    $fecha_enviosunat   = date('Y-m-d');

    $ruta_xml           = $_POST['ruta_xml'];

    $estado             = $_POST['estado'];

    $proceso            = $_POST['proceso'];

    if ($proceso == 'ActualizarEstadoGuia') {

        $sqlActualizar  = mysqli_query($conexion, "UPDATE guias_remision SET    

        id_guia         = '$id_guia',

        fecha_enviosunat= '$fecha_enviosunat',

        ruta_xml        = '$ruta_xml',

        estado          = '$estado' WHERE id_guia='$id_guia'");

        $respuesta      = 'SI';
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson         = array("respuesta" => $respuesta);

    echo json_encode($salidaJson);
}

/*****************************************************************/

/****************      MOVIMIENTOS FINANCIEROS    ****************/

/*****************************************************************/

if ($modulo == 'MovimientosFinancieros') {
    $proceso = $_POST['proceso'];

    if ($proceso == 'RegistrarMovimiento') {
        $tipo = $_POST['tipo'];
        $clasificacion = $_POST['clasificacion'];
        $ruc = $_POST['ruc'];
        $razon_social = $_POST['razon_social'];
        $concepto = $_POST['concepto'];
        $monto_total = $_POST['monto_total'];
        $numero_cuotas = isset($_POST['numero_cuotas']) && $_POST['numero_cuotas'] !== '' ? $_POST['numero_cuotas'] : 1;
        $frecuencia_cuotas = isset($_POST['frecuencia_cuotas']) && $_POST['frecuencia_cuotas'] !== '' ? $_POST['frecuencia_cuotas'] : 'UNICO';
        $fecha_primera_cuota = $_POST['fecha_primera_cuota'];
        $categoria = $_POST['categoria'];
        $numero_resolucion = $_POST['numero_resolucion'];
        $notas = $_POST['notas'];
        $estado = $_POST['estado'];
        $cod_personal = $xCodPer;
        $fecha_creacion = date('Y-m-d H:i:s');

        // Insertar movimiento
        $sqlInsert = "INSERT INTO ingresos_egresos (
            tipo, clasificacion, ruc, razon_social, concepto, monto_total,
            numero_cuotas, frecuencia_cuotas, fecha_primera_cuota, categoria,
            numero_resolucion, notas, fecha_creacion, cod_personal, estado
        ) VALUES (
            '$tipo', '$clasificacion', '$ruc', '$razon_social', '$concepto', '$monto_total',
            '$numero_cuotas', '$frecuencia_cuotas', '$fecha_primera_cuota', '$categoria',
            '$numero_resolucion', '$notas', '$fecha_creacion', '$cod_personal', '$estado'
        )";

        if (mysqli_query($conexion, $sqlInsert)) {
            $id_movimiento = mysqli_insert_id($conexion);

            // Generar cuotas si numero_cuotas > 1
            if ($numero_cuotas > 1) {
                $monto_cuota = $monto_total / $numero_cuotas;
                $fecha_cuota = $fecha_primera_cuota;

                for ($i = 1; $i <= $numero_cuotas; $i++) {
                    $sqlCuota = "INSERT INTO cuotas_movimientos (
                        id_movimiento, numero_cuota, monto_cuota, fecha_vencimiento, estado, fecha_creacion, cod_personal
                    ) VALUES (
                        '$id_movimiento', '$i', '$monto_cuota', '$fecha_cuota', 'PENDIENTE', '$fecha_creacion', '$cod_personal'
                    )";
                    mysqli_query($conexion, $sqlCuota);

                    // Calcular siguiente fecha según frecuencia
                    $fecha_cuota = calcularSiguienteFecha($fecha_cuota, $frecuencia_cuotas);
                }
            } else {
                // Una sola cuota
                $sqlCuota = "INSERT INTO cuotas_movimientos (
                    id_movimiento, numero_cuota, monto_cuota, fecha_vencimiento, estado, fecha_creacion, cod_personal
                ) VALUES (
                    '$id_movimiento', '1', '$monto_total', '$fecha_primera_cuota', 'PENDIENTE', '$fecha_creacion', '$cod_personal'
                )";
                mysqli_query($conexion, $sqlCuota);
            }

            $respuesta = 'SI';
        } else {
            $respuesta = 'NO';
        }
    }

    /***************************************************************/

    /***************** Configurar json de respuesta ****************/

    /***************************************************************/

    $salidaJson = array("respuesta" => $respuesta);
    echo json_encode($salidaJson);
}

// Función auxiliar para calcular fechas de cuotas
function calcularSiguienteFecha($fecha_actual, $frecuencia)
{
    $fecha = new DateTime($fecha_actual);

    switch ($frecuencia) {
        case 'MENSUAL':
            $fecha->modify('+1 month');
            break;
        case 'QUINCENAL':
            $fecha->modify('+15 days');
            break;
        case 'SEMANAL':
            $fecha->modify('+7 days');
            break;
        case 'PERSONALIZADO':
            // Por defecto mensual
            $fecha->modify('+1 month');
            break;
    }

    return $fecha->format('Y-m-d');
}
