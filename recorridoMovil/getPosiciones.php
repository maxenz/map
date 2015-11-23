<?php

	require_once('getGpsId.php');
	
	$fecActual = date("Y-m-d");
	$fecFormat = date("Ymd");
	$mov = $_GET["mov"];
	$fecDesde = $_GET["fecDesde"];
	$fecHasta = $_GET["fecHasta"];
	$vecDatos = array();
	
	$conn=odbc_connect('phpODBC','_SYSTEM','sys');
	if (!$conn) {exit("Connection Failed: " . $conn); }

	$gpsId = getGpsId($mov,0,$fecActual,$fecFormat);
	
	
	$SQL = "SELECT Latitude,Longitude,FecHorTransmision,Velocidad FROM Compumap.GpsHistorico WHERE VehicleID = '" .$gpsId;
	$SQL = $SQL . "' AND (FecHorTransmision BETWEEN '" .$fecDesde. "' AND '" .$fecHasta. "')"; 
	
	$result = odbc_exec($conn,$SQL);
    
    while (odbc_fetch_row($result)){
        
       	 	$lat = odbc_result($result,'Latitude');
			$lng = odbc_result($result,'Longitude');
			$hor = odbc_result($result,'FecHorTransmision');
			$vel = odbc_result($result,'Velocidad');
			
			$strDatos = $lat."/".$lng."/".$hor."/".$vel;
			array_push($vecDatos,$strDatos);
	}

		echo json_encode($vecDatos);




?>