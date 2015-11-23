<?php

	require_once("class.shaman.php");
	
	if (isset($_GET["opt"])) {
	
		$opt = $_GET["opt"];
		
		switch($opt) {
		
			case 0:
			
				$qZonas = "SELECT ID,Descripcion FROM Emergency.ZonasGeograficas";
				$qGradosOp = "SELECT ID,Descripcion FROM Emergency.GradosOperativos";
				$qLocalidades = "SELECT ID,Descripcion FROM Emergency.Localidades WHERE tmpSituacion = 1 and flgInterior = 0";
				$qClientes = "SELECT ID,ClienteId as Descripcion FROM Ventas.Entidades WHERE virSituacion = 1";
				
				$zonas = getJSON($qZonas);
				$grados = getJSON($qGradosOp);
				$localidades = getJSON($qLocalidades);
				$clientes = getJSON($qClientes);
				
				echo json_encode(array('zonas'=>$zonas,'grados'=>$grados,'localidades'=>$localidades,'clientes'=>$clientes));
				
			break;
			
			case 1:
				
			 echo getServicios();
				
			break;

		}	
	}

	function getJSON($SQL) {

		$db = new cDB();
		$db->Connect();
		
		$db->Query($SQL);
		
		while ($fila = $db->Next()) {
			
			$descripcion = odbc_result($fila,'Descripcion');			//Dejo los campos en UTF8 POR EL TEMA DE LAS Ñ Y LOS ACENTOS
			$descUTF = utf8_encode($descripcion);
			
			$datos[] = array(
				'ID' => odbc_result($fila,'ID'),
				'Descripcion' => $descUTF
			);		
		}
		
		return json_encode($datos);

	}

	function getServicios() {
	
		$db = new cDB();
		$db->Connect();
		
		$fDesde = $_GET["fDesde"];
		$fHasta = $_GET["fHasta"];
		$hDesde = $_GET["hDesde"].":00";
		$hHasta = $_GET["hHasta"].":00";
		
		$SQL = "SELECT ico.imagen as Imagen, inc.NroIncidente as NroInc, cli.ClienteId as Cliente,REPLACE(ISNULL(dom.dm_Latitud,0), '.', ',') AS Latitud,";
		$SQL = $SQL . "REPLACE(ISNULL(dom.dm_Longitud,0), '.', ',') AS Longitud,ico.Shadow as Shadow,gsv.Grid as Grado,";
		$SQL = $SQL . "SUBSTR(inc.HorLlamada, 12, 15) AS Hora FROM Emergency.Incidentes inc ";
		$SQL = $SQL . "INNER JOIN Ventas.Clientes cli ON (inc.ClienteId = cli.ID) ";
		$SQL = $SQL . "INNER JOIN Emergency.IncidentesDomicilios dom ON (inc.ID = dom.IncidenteId) ";
		$SQL = $SQL . "INNER JOIN Emergency.Localidades loc ON (dom.LocalidadId = loc.ID) ";
		$SQL = $SQL . "INNER JOIN Emergency.GradosServicios gsv ON (inc.virGradoServicioId = gsv.ID) ";
		$SQL = $SQL . "INNER JOIN CompuMap.GoogleIconosRelaciones rel ON (gsv.ID= rel.GradoServicioId) ";
		$SQL = $SQL . "INNER JOIN CompuMap.GoogleIconos ico ON (rel.GoogleIconoId = ico.ID) ";
		$SQL = $SQL . "WHERE (inc.FecIncidente BETWEEN $fDesde AND $fHasta) ";
		$SQL = $SQL . "AND inc.flgStatus <> 3 AND dom.ViajeId <> 'DER' ";
		$SQL = $SQL . "AND dom.dm_Latitud <> 0 ";
		
		if (isset($_GET["cliId"])) {
		
			$cliId = $_GET["cliId"];
			$SQL = $SQL . "AND inc.ClienteId = $cliId ";
		}
		
		if (isset($_GET["locId"])) {
		
			$locId = $_GET["locId"];
			$SQL = $SQL . "AND dom.LocalidadId = $locId ";
		}
		
		if (isset($_GET["zonaId"])) {
		
			$zonaId = $_GET["zonaId"];
			$SQL = $SQL . "AND loc.ZonaGeograficaId = $zonaId " ;
		}
		
		if (isset($_GET["gradoId"])) {
		
			$gradoId = $_GET["gradoId"];
			$SQL = $SQL . "AND inc.GradoOperativoId = $gradoId ";
		
		}
		
		if (esRangoNormal($hDesde,$hHasta)) {
		
			$SQL = $SQL . "AND (SUBSTR(inc.HorLlamada, 12, 15)) BETWEEN '$hDesde' AND '$hHasta' ";
		
		} else {
						
			$SQL = $SQL . "AND ( ((SUBSTR(inc.HorLlamada, 12, 15)) >= '$hHasta') OR ((SUBSTR(inc.HorLlamada, 12, 15)) <= '$hDesde') ) ";
		
		}

		
		$db->Query($SQL);
	
		while ($fila = $db->Next()) {
			
			$nroInc = odbc_result($fila,'NroInc');
			$grado = odbc_result($fila,'Grado');
			$cliente = odbc_result($fila,'Cliente');
			$htmlInfo = '<p style="margin-bottom:5px">Nro. Incidente &raquo; '.$nroInc;
			$htmlInfo = $htmlInfo . '</p><p style="margin-bottom:5px">Grado &raquo; '.$grado;
			$htmlInfo = $htmlInfo . '</p><p>Cliente &raquo; '.$cliente.'</p>';
			
			$datos[] = array(
				'Latitud' => odbc_result($fila,'Latitud'),
				'Longitud' => odbc_result($fila,'Longitud'),
				'Imagen' => odbc_result($fila,'Imagen'),
				'Shadow' => odbc_result($fila,'Shadow'),
				'HtmlInfo' => $htmlInfo
			);		
		}
		
		return json_encode($datos);
	
	}
	
	function esRangoNormal($horDesde,$horHasta) {
		
		$vBool = false;
		$vDesde = explode(":",$horDesde);
		$vHasta = explode(":",$horHasta);
		
		$minDesde = (intval($vDesde[0])*60) + $vDesde[1];
		$minHasta = (intval($vHasta[0])*60) + $vHasta[1];
		
		if ($minDesde <= $minHasta) $vBool = true;
		
		return $vBool;
		
	}

	
?>