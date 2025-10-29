<?php

/*******************************************/
/*******************************************/
$proceso = $_POST['proceso'];
/*******************************************/
/*******************************************/
switch ($proceso) {
    case 'stockAlmacen':
        $dest_folder = '../img-apps/stockcsv/';
        break;
    case 'stockSalida':
        $dest_folder = '../img-apps/stocksalidacsv/';
        break;
    case 'pfxCertificado':
        $dest_folder = '../api/archivos_xml_sunat/certificados/produccion/';
        break;
    case 'imgPerfil':
        $dest_folder = '../img-apps/personal/';
        break;
    case 'logoApp':
        $dest_folder = '../assets/images/';
        break;
    case 'logoDocument':
        $dest_folder = '../ventas/imagenes/';
        break;
}
/*******************************************/
/*******************************************/
if (!empty($_FILES)) {
    if (!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);
    foreach ($_FILES['file']['tmp_name'] as $key => $value) {
        $tempFile = $_FILES['file']['tmp_name'][$key];
        $targetFile =  $dest_folder . $_FILES['file']['name'][$key];
        move_uploaded_file($tempFile, $targetFile);
    }
    exit();
}
