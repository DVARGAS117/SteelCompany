<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	error_reporting(E_ALL ^ E_NOTICE);

	try {

		//===================ENVIO FACTURACION=====================
		$soapUrl = "https://e-beta.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl"; 
		$soapUser = "";  
		$soapPassword = ""; 
		// xml post structure
		$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
		xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
		xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			<soapenv:Header>
				<wsse:Security>
					<wsse:UsernameToken>
						<wsse:Username>20100066603MODDATOS</wsse:Username>
						<wsse:Password>moddatos</wsse:Password>
					</wsse:UsernameToken>
				</wsse:Security>
			</soapenv:Header>
			<soapenv:Body>
				<ser:getStatus>
					<rucComprobante>1028308796</rucComprobante>
					<tipoComprobante>01</tipoComprobante>
					<serieComprobante>f213</serieComprobante>
					<numeroComprobante>12345</numeroComprobante>
				</ser:getStatus>
			</soapenv:Body>
		</soapenv:Envelope>';
	
		$headers = array(
			"Content-type: text/xml;charset=\"utf-8\"",
			"Accept: text/xml",
			"Cache-Control: no-cache",
			"Pragma: no-cache",
			"SOAPAction: ",
			"Content-length: " . strlen($xml_post_string),
		); //SOAPAction: your op URL
	
		$url = $soapUrl;
	
		// PHP cURL  for https connection with auth
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
		// converting
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		var_dump($response);
		exit();

	} catch (Exception $e) {
		$mensaje['respuesta'] = 'error';
		$mensaje['cod_sunat']="0000";
		$mensaje['mensaje']="SUNAT ESTA FUERA SERVICIO: ".$e->getMessage();
		$mensaje['hash_cdr'] = "";
	}
?>