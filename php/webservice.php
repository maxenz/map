<?php

	function GeoGetOperativa($pUsr,$pPrf,$pCto) {

	$client = new SoapClient("http://paramedicapps.com.ar:57772/csp/shaman/WebServices.Incidentes.cls?WSDL");
 
	$result = $client->GeoGetOperativa(array(
		"pUsr" => $pUsr,
		"pPrf" => $pPrf,
		"pCto" => $pCto
	));
 
	$response_arr = objectToArray($result);
	
	$respuesta = str_replace(";", "", $response_arr["GeoGetOperativaResult"]);
	
	return $respuesta;
 
	}
	
	
	
	function GeoGetMovilesOperativos($pUsr,$pPrf,$pCto) {

	$client = new SoapClient("http://paramedicapps.com.ar:57772/csp/shaman/WebServices.Incidentes.cls?WSDL");
 
	$result = $client->GeoGetMovilesOperativos(array(
		"pUsr" => $pUsr,
		"pPrf" => $pPrf,
		"pCto" => $pCto
	));
 
	$response_arr = objectToArray($result);
	
	$respuesta = str_replace(";", "", $response_arr["GeoGetMovilesOperativosResult"]);
	
	return $respuesta;
 
	}
	
	
 
	function objectToArray($d)
	{
		if (is_object($d))
		{
			$d = get_object_vars($d);
		}
 
		if (is_array($d))
		{
			return array_map(__FUNCTION__, $d);
		}
		else
		{
			return $d;
		}
	}


?>