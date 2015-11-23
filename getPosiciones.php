<?php

	require_once("class.shaman.php");
	require_once('php/fechas.php');
	require_once('funciones.php');
	require_once('php/getGpsId.php');
	require_once('php/webservice.php');
	date_default_timezone_set('America/Argentina/Buenos_Aires');


	if (isset($_GET["opt"])) {

		$opt = $_GET["opt"];

		switch ($opt) {

			case 'INCIDENTES':
				$SQL = "SELECT inc.ID, inc.NroIncidente as NroInc, gdo.Grid AS Grado, dom.domicilio,inc.ClienteId as Cliente,";
				$SQL = $SQL . "REPLACE(ISNULL(dom.dm_Latitud,0), '.', ',') AS latitud,";
				$SQL = $SQL . "REPLACE(ISNULL(dom.dm_Longitud,0), '.', ',') AS longitud,";
				$SQL = $SQL . "ico.imagen, ico.shadow, ico.iconSizeW, ico.iconSizeH,";
				$SQL = $SQL . "ico.shadowSizeW, ico.shadowSizeH, ico.iconAnchorX, ico.iconAnchorY, ico.infoWindowAnchorX,";
				$SQL = $SQL . "ico.infoWindowAnchorY FROM Emergency.IncPendientesPropios pen ";
				$SQL = $SQL . "INNER JOIN Emergency.Incidentes inc ON (pen.IncidenteId = inc.ID) ";
				$SQL = $SQL . "INNER JOIN Emergency.IncidentesDomicilios dom ON (pen.IncidenteId = dom.IncidenteId) ";
				$SQL = $SQL . "INNER JOIN Emergency.GradosServicios gdo ON (pen.GradoServicioId = gdo.ID) ";
				$SQL = $SQL . "INNER JOIN CompuMap.GoogleIconosRelaciones rel ON (pen.GradoServicioId = rel.GradoServicioId) ";
				$SQL = $SQL . "INNER JOIN CompuMap.GoogleIconos ico ON (rel.GoogleIconoId = ico.ID) WHERE (dom.flgScreen = 1) ";
				if (isset($_GET["pTipo"])) {

					$pTipo = $_GET["pTipo"];
					$SQL = $SQL . "AND gdo.GradoOperativoId = $pTipo ";
				}

				$SQL = $SQL . "ORDER BY gdo.OrdenId";
				$objConsulta = getResultSet($SQL);
				echo getIncidentes($objConsulta);
			break;

			case 'MOVILES':
				$SQL = "SELECT mov.MovilId, estMov.Descripcion AS estado, tmv.Descripcion AS TipoMovil, ISNULL(ico.imagen, '0') as imagen,";
				$SQL = $SQL . "ISNULL(ico.shadow,'0') as shadow FROM Emergency.MovilesActuales mov ";
				$SQL = $SQL . "INNER JOIN Emergency.EstadosMoviles estMov ON (mov.EstadoId = estMov.ID) ";
				$SQL = $SQL . "INNER JOIN Emergency.Moviles mst ON (mov.MovilId = mst.MovilId) ";
				$SQL = $SQL . "INNER JOIN Emergency.TiposMoviles tmv ON (mst.TipoMovilOpeId = tmv.ID) ";
				$SQL = $SQL . "LEFT JOIN CompuMap.GoogleIconosRelaciones rel ON (mst.TipoMovilOpeId = rel.TipoMovilId) ";
				$SQL = $SQL . "LEFT JOIN CompuMap.GoogleIconos ico ON (rel.GoogleIconoId = ico.ID) ";
				if (isset($_GET["pTipo"])) {

					$pTipo = $_GET["pTipo"];
					$SQL = $SQL . "WHERE tmv.ID = $pTipo ";
				}

				$SQL = $SQL . " ORDER BY CASE TO_NUMBER(ISNULL(mov.MovilId, 'ZZZ')) WHEN 0 THEN 999999 ELSE TO_NUMBER(mov.MovilId) END";
				$objConsulta = getResultSet($SQL);
				$fecTimeStamp = date("Y-m-d H:i:s");
				$fecConsulta = restarMinutosFecha($fecTimeStamp, 8);
				$fecActual = date("Y-m-d");
				$fecFormat = date("Ymd");
				$vecRecorrido = array(2);
				echo getMoviles($objConsulta,$fecTimeStamp,$fecConsulta,$fecActual,$fecFormat,$vecRecorrido);
			break;

			case 'BASES OPERATIVAS':
				$SQL = "SELECT bas.AbreviaturaId AS Codigo, bas.Descripcion AS Nombre, ISNULL(ico.imagen, '0') as imagen, ISNULL(ico.shadow,'0') as shadow,";
				$SQL = $SQL . "REPLACE(ISNULL(bas.dm_Latitud,0), '.', ',') AS latitud,";
				$SQL = $SQL . "REPLACE(ISNULL(bas.dm_Longitud,0), '.', ',') AS longitud,";
				$SQL = $SQL . "ref.Descripcion AS TipoBase FROM Emergency.BasesOperativas bas ";
				$SQL = $SQL . "INNER JOIN CompuMap.TiposReferencias ref ON (bas.TipoReferenciaId = ref.ID) ";
				$SQL = $SQL . "LEFT JOIN CompuMap.GoogleIconosRelaciones rel ON (bas.TipoReferenciaId = rel.TipoReferenciaId) ";
				$SQL = $SQL . "LEFT JOIN CompuMap.GoogleIconos ico ON (rel.GoogleIconoId = ico.ID) WHERE bas.Situacion = 1";
				if (isset($_GET["pTipo"])) {

					$pTipo = $_GET["pTipo"];
					$SQL = $SQL . "AND ref.ID = $pTipo ";

				}
				$objConsulta = getResultSet($SQL);
				echo getBasesOperativas($objConsulta);
			break;

			case 'OTROS':
				$pTipo = $_GET["pTipo"];
				switch ($pTipo) {

					case 'pNosoc':
						$SQL = "SELECT AbreviaturaId AS Codigo, Descripcion AS Nombre, REPLACE(ISNULL(dm_Latitud,0), '.', ',') AS latitud,";
						$SQL = $SQL . "REPLACE(ISNULL(dm_Longitud,0), '.', ',') AS longitud ";
						$SQL = $SQL . "FROM Emergency.Instituciones WHERE Situacion = 1 ORDER BY Descripcion";
						$objConsulta = getResultSet($SQL);
						echo getDefault($objConsulta,'nosocomio.png','shadow.png');
					break;

					case 'pEmpresas':
						$SQL = "SELECT AbreviaturaId AS Codigo, RazonSocial AS Nombre,REPLACE(ISNULL(dm_Latitud,0), '.', ',') AS latitud,";
						$SQL = $SQL . "REPLACE(ISNULL(dm_Longitud,0), '.', ',') AS longitud ";
						$SQL = $SQL . "FROM Emergency.PrestadoresLocales WHERE Situacion = 1 ORDER BY RazonSocial";
						$objConsulta = getResultSet($SQL);
						echo getDefault($objConsulta,'empresa.png','shadow.png');
					break;

					case 'pCartilla':
						$SQL = "SELECT RazonSocial AS Nombre,REPLACE(ISNULL(dm_Latitud,0), '.', ',') AS latitud,";
						$SQL = $SQL . "REPLACE(ISNULL(dm_Longitud,0), '.', ',') AS longitud ";
						$SQL = $SQL . "FROM Emergency.CentrosAtencion WHERE Situacion = 1 ORDER BY RazonSocial";
						$objConsulta = getResultSet($SQL);
						echo getDefault($objConsulta,'cartilla.png','shadow.png');
					break;


				}
				break;

			case 'PERFILES':
				$pPrf = $_GET["pTipo"];
				$pUsr = 'JAVIER';
				$cOpId = 1;
				$incidentes = GeoGetOperativa($pUsr,$pPrf,$cOpId);
				$vIncidentes = array();
				$vIncidentes = explode("$",$incidentes);
				$moviles = GeoGetMovilesOperativos($pUsr,$pPrf,$cOpId);
				$vMoviles = array();
				$vMoviles = explode("$",$moviles);
				$vMovPerf = getMovilesPerfiles($vMoviles);
				$vIncPerf = getIncidentesPerfiles($vIncidentes);
				$vTotalPerfil =  array_merge($vMovPerf,$vIncPerf);
				echo json_encode($vTotalPerfil);
			break;
		}
	}

	function getIncidentesPerfiles($vIncidentes) {

		$totalReg = sizeOf($vIncidentes);

		for ($i = 0; $i < $totalReg; $i++) {

			$vInc = explode("^",$vIncidentes[$i]);
			$latitud = $vInc[2];
			$longitud = $vInc[3];
			$nroInc = $vInc[4];
			$cliente = $vInc[7];
			$grado = $vInc[6];
			$imagen = $vInc[1];
			$htmlInfo = '<p style="margin-bottom:5px">Nro. Incidente &raquo; '.$nroInc;
			$htmlInfo = $htmlInfo . '</p><p style="margin-bottom:5px">Grado &raquo; '.$grado;
			$htmlInfo = $htmlInfo . '</p><p>Cliente &raquo; '.$cliente.'</p>';

			$datos[] = array(
				'Latitud' => $latitud,
				'Longitud' => $longitud,
				'Imagen' => $imagen,
				'Shadow' => 'shadow.png',
				'HtmlInfo' => $htmlInfo
			);

		  }

		 return $datos;

	}

	function getMovilesPerfiles($vMoviles) {

		for ($i = 0; $i < sizeOf($vMoviles); $i++) {

			$vMov = explode('^',$vMoviles[$i]);
			$latitud = $vMov[1];
			$longitud = $vMov[2];
			$nroMov = $vMov[0];
			$tipoMov = $vMov[4];
			$imagen = $vMov[3];
			$estado = $vMov[6];
			$htmlInfo = '<p style="margin-bottom:5px">Nro. M&oacute;vil &raquo; '. $nroMov;
			$htmlInfo = $htmlInfo . '</p><p style="margin-bottom:5px">Tipo de M&oacute;vil &raquo; '. $tipoMov;
			$htmlInfo = $htmlInfo . '</p><p>Estado &raquo; '.$estado.'</p>';

			$datos[] = array(
				'Latitud' => $latitud,
				'Longitud' => $longitud,
				'Imagen' => 'ambulance.png',
				'Shadow' => 'shadow.png',
				'HtmlInfo' => $htmlInfo
			);

		}

		return $datos;


	}

	function getResultSet($SQL){

		$db = new cDB();
		$db->Connect();

		$db->Query($SQL);

		return $db;

	}

	function getIncidentes($db) {

		while ($fila = $db->Next()) {

			$domicilio = utf8_encode(odbc_result($fila,'domicilio'));
			$nroInc = odbc_result($fila,'NroInc');
			$cliente = odbc_result($fila,'Cliente');
			$grado = odbc_result($fila,'Grado');
			$htmlInfo = '<p style="margin-bottom:5px">Nro. Incidente &raquo; '.$nroInc;
			$htmlInfo = $htmlInfo . '</p><p style="margin-bottom:5px">Grado &raquo; '.$grado;
			$htmlInfo = $htmlInfo . '</p><p>Cliente &raquo; '.$cliente.'</p>';

			$datos[] = array(
				'Latitud' => odbc_result($fila,'latitud'),
				'Longitud' => odbc_result($fila,'longitud'),
				'Grado' => $grado,
				'Domicilio' => $domicilio,
				'Imagen' => odbc_result($fila,'imagen'),
				'Shadow' => odbc_result($fila,'shadow'),
				'HtmlInfo' => $htmlInfo

			);
		}

		return json_encode($datos);
	}

	function getBasesOperativas($db) {

		while ($fila = $db->Next()) {

			$nombre = utf8_encode(odbc_result($fila,'Nombre'));
			$htmlInfo = '<p style="margin-bottom:5px">Nombre &raquo; '.$nombre.'</p>';

			$datos[] = array(
				'Latitud' => odbc_result($fila,'latitud'),
				'Longitud' => odbc_result($fila,'longitud'),
				'Imagen' => odbc_result($fila,'imagen'),
				'Shadow' => 'shadow.png',
				'HtmlInfo' => $htmlInfo
			);
		}

		return json_encode($datos);
	}

	function getDefault($db,$imagen,$shadow) {

		while ($fila = $db->Next()) {

			$nombre = utf8_encode(odbc_result($fila,'Nombre'));
			$htmlInfo = '<p style="margin-bottom:5px">Nombre &raquo; '.$nombre.'</p>';

			$datos[] = array(
				'Latitud' => odbc_result($fila,'latitud'),
				'Longitud' => odbc_result($fila,'longitud'),
				'Imagen' => $imagen,
				'Shadow' => $shadow,
				'HtmlInfo' => $htmlInfo
			);
		}

		return json_encode($datos);
	}

	function getMoviles($db,$fecTimeStamp,$fecConsulta,$fecActual,$fecFormat,$vecRecorrido) {

		while ($fila = $db->Next()) {

			$idMov = odbc_result($fila,'MovilId');
			$estado = utf8_encode(odbc_result($fila,'estado'));
			$tipoMov = utf8_encode(odbc_result($fila,'TipoMovil'));
			$imagen = odbc_result($fila,'imagen');
			$shadow = odbc_result($fila,'shadow');
			$htmlInfo = '<p style="margin-bottom:5px">Nro. M&oacute;vil &raquo; '. $idMov;
			$htmlInfo = $htmlInfo . '</p><p style="margin-bottom:5px">Tipo de M&oacute;vil &raquo; '. $tipoMov;
			$htmlInfo = $htmlInfo . '</p><p>Estado &raquo; '.$estado.'</p>';

			$dataMov = getGpsId($idMov,0,$fecActual,$fecFormat);

			if (strlen($dataMov) > 1) {

				$vecRecorrido[0] = 0;
				$vecRecorrido[1] = 0;

				$queryRecorrido = "SELECT TOP 1 Latitude, Longitude, FecHorTransmision FROM CompuMap.gpsHistorico ";
				$queryRecorrido = $queryRecorrido . "WHERE VehicleId ='".$dataMov."' AND FecHorTransmision >= '" . $fecConsulta . "' ";
				$queryRecorrido = $queryRecorrido . "ORDER BY FecHorTransmision ";

				$objConsultaRecorrido = getResultSet($queryRecorrido);

				if ($fila = $objConsultaRecorrido->Next()) {

					$latR = odbc_result($fila,'Latitude');
					$lngR = odbc_result($fila,'Longitude');

					$vecRecorrido[0] = $latR;
					$vecRecorrido[1] = $lngR;

				}

				$queryPosicion = "SELECT Latitude, Longitude FROM CompuMap.GpsActual WHERE VehicleId ='".$dataMov."'";
				$objConsultaPosicion = getResultSet($queryPosicion);

				if ($fila = $objConsultaPosicion->Next()) {

					$latMovil = odbc_result($fila,'Latitude');
					$lngMovil = odbc_result($fila,'Longitude');

				}

				if (odbc_result($fila,'Latitude') <> 0) {

					$datos[] = array(
						'Latitud' => $latMovil,
						'Longitud' => $lngMovil,
						'LatitudRed' => $vecRecorrido[0],
						'LongitudRec' => $vecRecorrido[1],
						'Imagen' => 'ambulance.png',
						'Shadow' => 'shadow.png',
						'HtmlInfo' => $htmlInfo
					);
				}
			}
		}

		return json_encode($datos);
	}


?>