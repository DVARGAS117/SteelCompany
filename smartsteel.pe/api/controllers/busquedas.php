<?php
// RUTA para enviar documentos: Tu puedes definir tu propia ruta, en nustro caso la tenemos en la siguiente dirección
$num_documento = $_POST['num_documento'];
$tipo = $_POST['tipo'];
$password = 'Hf526gujsgerd12'; //AQUÍ TU PASSWORD

if($tipo == 'dni') {
	$ruta = "https://sistemadefacturacionelectronicasunat.com/api/persona/".$num_documento.'/'.$password;
} elseif ($tipo == 'ruc') {
	$ruta = "https://sistemadefacturacionelectronicasunat.com/api/empresa/".$num_documento.'/'.$password;
} else {
	$resp['repsuesta'] = 'error';
	echo json_encode();
}

$curl = curl_init();
//cambio

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt ($curl, CURLOPT_SSLVERSION, 3);

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $ruta,
    CURLOPT_USERAGENT => 'Consulta Datos'
));

$resp = curl_exec($curl);
echo $resp;
curl_close($curl);
exit();
?>