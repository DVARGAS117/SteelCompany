<?php
require("conexion.php");
require("inicializar-datos.php");
$proceso    = $_POST['proceso'];
/*************************************************************/
/************ CANCELAR SESION SALIDA STOCK *******************/
/*************************************************************/
if ($proceso == 'CancelarSesionSalida') {
    session_start();
    $sesssion_id = session_id();
    $sqlEliminar = mysqli_query($conexion, "DELETE FROM tmp_salidastock WHERE session_id='$sesssion_id'");
    unset($sesssion_id);
    $sesssion_id = '';
}
/*************************************************************/
/************   ASIGNAR PRODUCTOS A TIENDAS ******************/
/*************************************************************/
if ($proceso == 'asignarStockTiendas') {
    session_start();
    $sesssion_id    = session_id();
    $fecha_salida   = date('Y-m-d');
    $fecha_entrada  = date('Y-m-d');
    $cod_puntoventa_origen = $_POST['cod_puntoventa_origen'];
    $cod_puntoventa_destino = $_POST['cod_puntoventa_destino'];
    /**********************************************************/
    /**********************************************************/
    $sqlConsultaTmp = mysqli_query($conexion, "SELECT * FROM tmp_salidastock WHERE session_id='$sesssion_id'");
    while ($ftmp     = mysqli_fetch_array($sqlConsultaTmp)) {
        $xCod_producto  = $ftmp['cod_producto'];
        $xCantidad      = $ftmp['cantidad_tmp'];
        /******************************************************/
        /******************************************************/
        $sqlProductos   = mysqli_query($conexion, "SELECT nombre_producto, codigo FROM productos WHERE cod_producto='$xCod_producto'");
        $fprod          = mysqli_fetch_array($sqlProductos);
        $nombre_producto = $fprod['nombre_producto'];
        $codigo         = $fprod['codigo'];
        /******************************************************/
        /******************************************************/
        $sqlVerificar   = mysqli_query($conexion, "SELECT cod_producto FROM stock_locales WHERE cod_producto='$xCod_producto' AND cod_puntoventa='$cod_puntoventa_destino'");
        $numres         = mysqli_num_rows($sqlVerificar);
        if ($numres == 0) {
            $sqlInsertarStock = mysqli_query($conexion, "INSERT INTO stock_locales (
            cod_puntoventa,
            fecha_entrada,
            cod_producto,
            codigo,
            nombre_producto,
            stock_ingresado,
            stock_actual
            )VALUES(
            '$cod_puntoventa_destino',
            '$fecha_entrada',
            '$xCod_producto',
            '$codigo',
            '$nombre_producto',
            '$xCantidad',
            '$xCantidad')");
            /***********************************************/
            $sqlSalida          = mysqli_query($conexion, "INSERT INTO salida_stock (
            cod_puntoventa,
            fecha_salida,
            codigo,
            nombre_producto,
            stock_salida
            )VALUES(
            '$cod_puntoventa_destino',
            '$fecha_salida',
            '$codigo',
            '$nombre_producto',
            '$xCantidad')");
            /***********************************************/
            $sqlActualizarProducto = mysqli_query($conexion, "UPDATE productos SET stock_actual=(stock_actual-$xCantidad) WHERE cod_producto='$xCod_producto'");
            /***********************************************/
        } else {
            $sqlActualizarStock = mysqli_query($conexion, "UPDATE stock_locales SET
            stock_ingresado     = (stock_ingresado+$xCantidad),
            stock_actual        = (sctock_actual+$xCantidad) WHERE cod_producto='$xCod_producto' AND cod_puntoventa='$cod_puntoventa_destino'");
            /***********************************************/
            $sqlSalida          = mysqli_query($conexion, "INSERT INTO salida_stock (
                cod_puntoventa,
                fecha_salida,
                codigo,
                nombre_producto,
                stock_salida
                )VALUES(
                '$cod_puntoventa_destino',
                '$fecha_salida',
                '$codigo',
                '$nombre_producto',
                '$xCantidad')");
            /***********************************************/
            $sqlActualizarProducto = mysqli_query($conexion, "UPDATE productos SET stock_actual=(stock_actual-$xCantidad) WHERE cod_producto='$xCod_producto'");
            /***********************************************/
        }
    }
    $respuesta      = "SI";
    /***********************************************/
    $sqlLimpiar     = mysqli_query($conexion, "DELETE FROM tmp_salidastock WHERE session_id='$sesssion_id'");
    unset($sesssion_id);
    $sesssion_id    = '';
    /***********************************************/
    $salidaJson     = array("respuesta" => $respuesta);
    echo json_encode($salidaJson);
}
/*************************************************************/
/************        CANCELAR VENTA PRODUCTOS  ***************/
/*************************************************************/
if ($proceso == 'CancelarSesionVentas') {
    session_start();
    $session_id         = session_id();
    $sqlDelete          = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE session_id='$session_id'");
    unset($sesssion_id);
    $sesssion_id        = "";
}
/*************************************************************/
/************    BUSCAR SERIE Y NUM DOCUMENTO  ***************/
/*************************************************************/
if ($proceso == 'BuscarSeriesNum') {
    $codigo_compro  = $_POST['codigo_compro'];
    $sqlConsulta    = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE codigo_compro='$codigo_compro' AND cod_puntoventa='$xTienda' AND estado='A'");
    $numser         = mysqli_num_rows($sqlConsulta);
    if ($numser > 0) {
        while ($fser = mysqli_fetch_array($sqlConsulta)) {
            $codigo_compro  = $fser['codigo_compro'];
            $serie          = $fser['serie'];
            $num_actual     = $fser['num_actual'];
            $num_compro     = ($num_actual + 1);
            $resultado     .= "<option value='$serie'>$serie</option>";
        }
    } else {
        $resultado     = "<option value='0'>No existen series</option>";
    }
    /***********************************************/
    /***********************************************/
    $salidaJson     = array(
        "resultado" => $resultado,
        "num_compro" => $num_compro
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/*******   BUSCAR CLIENTES EN BD, SUNAT Y RENIEC  ************/
/*************************************************************/
if ($proceso == 'BuscarCliente') {
    $tipo_doc       = $_POST['tipo_doc'];
    $num_doc        = $_POST['num_doc'];
    $sqlConsulta    = mysqli_query($conexion, "SELECT * FROM clientes WHERE num_documento='$num_doc'");
    $numRer         = mysqli_num_rows($sqlConsulta);
    if ($numRer > 0) {
        $fclientes          = mysqli_fetch_array($sqlConsulta);
        $nombre_cliente     = $fclientes['nombres'];
        $direcion_cliente   = $fclientes['direccion'];
        $email_cliente      = $fclientes['email'];
        $ubigeo             = $fclientes['ubigeo'];
    } else {
        if ($tipo_doc == '06') {
            // Datos
            $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
            $ruc = $num_doc;
            // Iniciar llamada a API
            $curl = curl_init();
            // Buscar ruc sunat
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: http://apis.net.pe/api-ruc',
                    'Authorization: Bearer ' . $token
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // Datos de empresas según padron reducido
            $empresa = json_decode($response, true);
            $nombre_cliente     = $empresa['nombre'];
            $direcion_cliente   = $empresa['direccion'];
            $ubigeo             = $empresa['ubigeo'];
            $email_cliente      = "";
        } else {
            $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
            $dni = $num_doc;
            // Iniciar llamada a API
            $curl = curl_init();
            // Buscar dni
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: https://apis.net.pe/consulta-dni-api',
                    'Authorization: Bearer ' . $token
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // Datos de empresas según padron reducido
            $empresa = json_decode($response, true);
            $nombre_cliente     = $empresa['nombre'];
            $direcion_cliente   = "";
            $ubigeo             = "";
            $email_cliente      = "";
        }
    }
    /***********************************************/
    /***********************************************/
    $salidaJson     = array(
        "nombre_cliente" => $nombre_cliente,
        "direcion_cliente" => $direcion_cliente,
        "email_cliente" => $email_cliente,
        "ubigeo" => $ubigeo
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/*********    BUSCAR DATOS PARA NOTA DE CREDITO   ************/
/*************************************************************/
if ($proceso == 'BuscarDocumentoNC') {
    $id_factura         = $_POST['documento'];
    $xcodigo_compro     = $_POST['codigo_compro'];
    $sqlConsulta        = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
    $totalDatos         = mysqli_num_rows($sqlConsulta);
    if ($totalDatos > 0) {
        $ffact              = mysqli_fetch_array($sqlConsulta);
        $codigo_compro      = $ffact['codigo_compro'];
        $razon_social       = $ffact['razon_social'];
        $direccion_empresa  = $ffact['direccion_empresa'];
        $numero_documento   = $ffact['numero_documento'];
        $email_cliente      = $ffact['email_cliente'];
        $serie              = $ffact['serie'];
        $num_comprobante    = $ffact['num_comprobante'];
        $num_doc_modi       = $serie . '-' . $num_comprobante;
        if ($codigo_compro == '01') {
            $tipo_documento = "FACTURA";
        }
        if ($codigo_compro == '03') {
            $tipo_documento = "BOLETA";
        }
        /*****************************************************/
        /*****************************************************/
        $sqlConsulNumSeria  = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE codigo_compro='$xcodigo_compro' AND serie='$serie'");
        $numSerie           = mysqli_num_rows($sqlConsulNumSeria);
        if ($numSerie > 0) {
            while ($fser    = mysqli_fetch_array($sqlConsulNumSeria)) {
                $cod_serie  = $fser['cod_serie'];
                $serie      = $fser['serie'];
                $num_actual = $fser['num_actual'];
                $num_compro = ($num_actual + 1);
                $resserie   = "<option value='$serie'>$serie</option>";
            }
        } else {
            $resserie       = "<option value='0'>No hay series registrados</option>";
        }
        $encontro           = "SI";
        /*****************************************************/
        /*****************************************************/
    } else {
        $encontro           = "NO";
    }
    /***********************************************/
    /***********************************************/
    $salidaJson             = array(
        "encontro"          => $encontro,
        "razon_social"      => $razon_social,
        "numero_documento"  => $numero_documento,
        "direccion_empresa" => $direccion_empresa,
        "email_cliente"     => $email_cliente,
        "tipo_documento"    => $tipo_documento,
        "num_doc_modi"      => $num_doc_modi,
        "resserie"          => $resserie,
        "num_compro"        => $num_compro,
        "consulta"          => $consulta
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/************    PROVINCIAS SEGUN DEPARTAMENTO  **************/
/*************************************************************/
if ($proceso == 'Provincia') {
    $id             = $_POST['id'];
    $sqlConsulta    = mysqli_query($conexion, "SELECT * FROM ubigeo_provincias WHERE department_id='$id'");
    $numser         = mysqli_num_rows($sqlConsulta);
    $resultado = '';
    if ($numser > 0) {
        $resultado     .= "<option value='0'>Seleccionar Provincia</option>";
        while ($fser = mysqli_fetch_array($sqlConsulta)) {
            $id         = $fser['id'];
            $name       = $fser['name'];
            $resultado .= "<option value='$id'>$name</option>";
        }
    } else {
        $resultado     = "<option value='0'>No hay provincias</option>";
    }
    /***********************************************/
    /***********************************************/
    $salidaJson     = array(
        "resultado" => $resultado
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/************    DISTRITOS SEGUN PROVINCIAS     **************/
/*************************************************************/
if ($proceso == 'Distrito') {
    $id             = $_POST['id'];
    $sqlConsulta    = mysqli_query($conexion, "SELECT * FROM ubigeo_distritos WHERE province_id='$id'");
    $numser         = mysqli_num_rows($sqlConsulta);
    $resultado = '';
    if ($numser > 0) {
        $resultado     .= "<option value='0'>Seleccionar Distrito</option>";
        while ($fser = mysqli_fetch_array($sqlConsulta)) {
            $id         = $fser['id'];
            $name       = $fser['name'];
            $resultado .= "<option value='$id'>$name</option>";
        }
    } else {
        $resultado     = "<option value='0'>No hay distritos</option>";
    }
    /***********************************************/
    /***********************************************/
    $salidaJson     = array(
        "resultado" => $resultado
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/*********    BUSCAR DATOS PARA GUIA DE REMISION   ***********/
/*************************************************************/
if ($proceso == 'BuscarDocumentoGR') {
    $id_factura         = $_POST['documento'];
    $codigoBuscar       = explode("-", $_POST['codigo_compro']);
    $xcodigo_compro     = $codigoBuscar[0];
    $xserie             = $codigoBuscar[1];
    $sqlConsulta        = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
    $totalDatos         = mysqli_num_rows($sqlConsulta);
    if ($totalDatos > 0) {
        $ffact              = mysqli_fetch_array($sqlConsulta);
        $codigo_compro      = $ffact['codigo_compro'];
        $razon_social       = $ffact['razon_social'];
        $direccion_empresa  = $ffact['direccion_empresa'];
        $numero_documento   = $ffact['numero_documento'];
        $email_cliente      = $ffact['email_cliente'];
        $serie              = $ffact['serie'];
        $num_comprobante    = $ffact['num_comprobante'];
        if ($codigo_compro == '01') {
            $tipo_documento = "FACTURA";
        }
        if ($codigo_compro == '03') {
            $tipo_documento = "BOLETA";
        }
        /*****************************************************/
        /*****************************************************/
        $sqlConsulNumSeria  = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE codigo_compro='$xcodigo_compro' AND serie='$xserie' AND cod_puntoventa='$xTienda'");
        $numSerie           = mysqli_num_rows($sqlConsulNumSeria);
        if ($numSerie > 0) {
            while ($fser    = mysqli_fetch_array($sqlConsulNumSeria)) {
                $cod_serie  = $fser['cod_serie'];
                $serie      = $fser['serie'];
                $num_actual = $fser['num_actual'];
                $num_compro = ($num_actual + 1);
                $resserie   = "<option value='$serie'>$serie</option>";
            }
        } else {
            $resserie       = "<option value='0'>No hay series registrados</option>";
        }
        $encontro           = "SI";
        /*****************************************************/
        /*****************************************************/
    } else {
        $encontro           = "NO";
    }
    /***********************************************/
    /***********************************************/
    $salidaJson             = array(
        "encontro"          => $encontro,
        "razon_social"      => $razon_social,
        "numero_documento"  => $numero_documento,
        "direccion_empresa" => $direccion_empresa,
        "email_cliente"     => $email_cliente,
        "tipo_documento"    => $tipo_documento,
        "resserie"          => $resserie,
        "num_compro"        => $num_compro
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/**********  ENVIAR FACTURA PDF Y XML AL CLIENTE *************/
/*************************************************************/
if ($proceso == 'EnviarPDFXMLemail') {
    $id_factura     = $_POST['id_factura'];
    $email_cleinte  = $_POST['email_cliente'];
    $razon_social   = $_POST['razon_social'];
    $pdf            = $_POST['pdf'];
    $ruta_xml       = $_POST['ruta_xml'];
    /***********************************************/
    /***********************************************/
    $cuerpoEmail    = "
    <div style='border: 1px solid #555555; padding: 20px'>
        <h2 style='font-family: Arial; font-size: 24px'>Comprobantes Electronicos CWP</h2>
        <p>---------------------------------------------------------------------------------------</p>
        <p style='font-family: Arial; font-size: 15px'>Estimado(a) " . $razon_social . "</p>
        <p style='font-family: Arial; font-size: 15px'>A continuacion adjuntamos su comprobante de pago PDF y XML por la compra de productos</p>
        <p style='font-family: Arial; font-size: 15px'>NOTA: Si en caso no pudiera descargar los archivos por favor comuniquese con nosotros contacto@cursos-paginas-web.com</p>
        <p>---------------------------------------------------------------------------------------</p>
        <p style='font-family: Arial; font-size: 15px'>PD: No responder a este email autogenerado, pues no recibirá respuesta alguna..</p>
    </div>";
    require("../assets/libs/phpmailer/class.phpmailer.php");
    $mail           = new PHPMailer();
    $mail->CharSet  = 'UTF-8';
    $mail->From     = ("customerclient@cursos-paginas-web.com");
    $mail->FromName = "CPW Facturas Electronicas";
    $mail->AddAddress($email_cleinte);
    $mail->WordWrap = 150;
    $mail->IsHTML(true);
    $mail->Subject  = "Comprobantes Electronicos CPW";
    $mail->Body     = $cuerpoEmail;
    $mail->IsSMTP();
    $mail->Host     = "mail.cursos-paginas-web.com";
    $mail->SMTPAuth = true;
    $mail->Username = "customerclient@cursos-paginas-web.com";
    $mail->Password = "JX8IIRQKTG02";
    $archivoPDF     = '../img-apps/pdf/' . $pdf;
    $archivoXML     = '../api/' . $ruta_xml;
    $mail->AddAttachment($archivoPDF, $archivoPDF);
    $mail->AddAttachment($archivoXML, $archivoXML);
    $mail->Send();
    /***********************************************/
    /***********************************************/
    $respuesta = "SI";
    $salidaJson     = array(
        "respuesta" => $respuesta
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/**********  ENVIAR GUUIA PDF Y XML AL CLIENTE   *************/
/*************************************************************/
if ($proceso == 'EnviarPDFXMLGuiaEmail') {
    $id_guia        = $_POST['id_guia'];
    $email_cleinte  = $_POST['email_cliente'];
    $razon_social   = $_POST['razon_social'];
    $pdf            = $_POST['pdf'];
    $ruta_xml       = $_POST['ruta_xml'];
    /***********************************************/
    /***********************************************/
    $cuerpoEmail    = "
    <div style='border: 1px solid #555555; padding: 20px'>
        <h2 style='font-family: Arial; font-size: 24px'>Comprobantes Electronicos CWP</h2>
        <p>---------------------------------------------------------------------------------------</p>
        <p style='font-family: Arial; font-size: 15px'>Estimado(a) " . $razon_social . "</p>
        <p style='font-family: Arial; font-size: 15px'>A continuacion adjuntamos su comprobante de pago PDF y XML por la compra de productos</p>
        <p style='font-family: Arial; font-size: 15px'>NOTA: Si en caso no pudiera descargar los archivos por favor comuniquese con nosotros contacto@cursos-paginas-web.com</p>
        <p>---------------------------------------------------------------------------------------</p>
        <p style='font-family: Arial; font-size: 15px'>PD: No responder a este email autogenerado, pues no recibirá respuesta alguna..</p>
    </div>";
    require("../assets/libs/phpmailer/class.phpmailer.php");
    $mail           = new PHPMailer();
    $mail->CharSet  = 'UTF-8';
    $mail->From     = ("customerclient@cursos-paginas-web.com");
    $mail->FromName = "CPW Facturas Electronicas";
    $mail->AddAddress($email_cleinte);
    $mail->WordWrap = 150;
    $mail->IsHTML(true);
    $mail->Subject  = "Comprobantes Electronicos CPW";
    $mail->Body     = $cuerpoEmail;
    $mail->IsSMTP();
    $mail->Host     = "mail.cursos-paginas-web.com";
    $mail->SMTPAuth = true;
    $mail->Username = "customerclient@cursos-paginas-web.com";
    $mail->Password = "JX8IIRQKTG02";
    $archivoPDF     = '../img-apps/pdf/' . $pdf;
    $archivoXML     = '../api/' . $ruta_xml;
    $mail->AddAttachment($archivoPDF, $archivoPDF);
    $mail->AddAttachment($archivoXML, $archivoXML);
    $mail->Send();
    /***********************************************/
    /***********************************************/
    $respuesta = "SI";
    $salidaJson     = array(
        "respuesta" => $respuesta
    );
    echo json_encode($salidaJson);
}
/*************************************************************/
/********    BUSCAR BOLETAS PARA ENVIO DE RESUMEN    *********/
/*************************************************************/
if ($proceso == 'buscarBoletasVenta') {
    $fecha_registro = $_POST['fecha'];
    $serie          = $_POST['serie'];
    $sqlConsulta    = mysqli_query($conexion, "SELECT id_factura FROM factura WHERE fecha_registro='$fecha_registro' AND serie='$serie' AND (codigo_compro='03' OR codigo_compro='07') AND estado='Por Enviar'");
    $totalBoletas   = mysqli_num_rows($sqlConsulta);
    if ($totalBoletas > 0) {
        $encontro   = "SI";
        $resultado  = '
        <i class="mdi mdi-emoticon-happy" style="color:#4DD765; font-size:24px"></i> Econtro ' . $totalBoletas . ' Boletas con estado <strong>POR ENVIAR</strong>';
    } else {
        $encontro   = "NO";
        $resultado  = '
        <i class="mdi mdi-network-off-outline" style="color:#e35454; font-size:24px"></i> No Encontró Boletas para esta Fecha';
    }
    /***********************************************/
    /***********************************************/
    $salidaJson     = array(
        "encontro" => $encontro,
        "resultado" => $resultado,
    );
    echo json_encode($salidaJson);
}
