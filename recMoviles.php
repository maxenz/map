<?php

require_once('php/getGpsId.php');
require_once('php/fechas.php');

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn)
  {
	  exit("Connection Failed: " . $conn);
  }
  
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecActual = date("Y-m-d");
$fecFormat = date("Ymd");
$fecTimeStamp = date("Y-m-d H:i:s");
$strRecorrido = "";
$vecMoviles = explode("$",$_GET["moviles"]);
$fecConsulta = restarMinutosFecha($fecTimeStamp, 8);

for ($i = 0; $i < sizeof($vecMoviles); $i++) {
	
	$dataMov = getGpsId($vecMoviles[$i],0,$fecActual,$fecFormat);
	


$queryRecorrido = "SELECT Latitude, Longitude FROM CompuMap.gpsHistorico WHERE VehicleId ='".$dataMov."' AND FecHorTransmision >= '" . $fecConsulta . "' ORDER BY FecHorTransmision";

$result = odbc_exec($conn,$queryRecorrido);

$strPosicion = "";

while (odbc_fetch_row($result)) {
	
	$lat = odbc_result($result,'Latitude');
	$lng = odbc_result($result,'Longitude');
	$strConcat = $lat."$".$lng;
	if ($strPosicion == "") {
		
		$strPosicion = $strConcat;	
		
	} else {
		
		$strPosicion = $strPosicion . "^" . $strConcat;	
	}
		
  }	
  
  if ($strRecorrido == "") {
	  
		$strRecorrido = $strPosicion;
		
  } else {
	  
	   	$strRecorrido = $strRecorrido . "&" . $strPosicion;
  }
	
}

echo $strRecorrido;

?>