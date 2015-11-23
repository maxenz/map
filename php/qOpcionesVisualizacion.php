<?php

	require_once("../class.shaman.php");

	if (isset($_GET["opt"])) {
	
		$opt = $_GET["opt"];
		
		switch($opt) {
	
			case 'o1':
				$SQL = "SELECT ID,Descripcion FROM Emergency.TiposMoviles WHERE flgDespachable = 1 AND Situacion = 1 ORDER BY Descripcion ";
				echo getDatos($SQL);
			break;
			
			case 'o2':
				$SQL = "SELECT DISTINCT GradoOperativoId as ID,Descripcion from Emergency.GradosServicios ORDER BY Descripcion";
				echo getDatos($SQL);
			break;
			
			case 'o3':
				$SQL = "SELECT ID,Descripcion FROM CompuMap.TiposReferencias WHERE ClasificacionFijaId = 1 ORDER BY Descripcion";
				echo getDatos($SQL);
			break;
			
			case 'o4':
				echo getHerramientas();
			break;
			
			case 'o5':
				$SQL = "SELECT ID,Descripcion FROM Panel.Perfiles WHERE Situacion = 1 AND Despacha = 1 ORDER BY Descripcion";
				echo getDatos($SQL);
			break;
			
			case 'o6':
				echo getOtros();
			break;
			
		}
		
	}
	
	function getDatos($SQL) {
	
		$db = new cDB();
		$db->Connect();
		
		$db->Query($SQL);
		
		while ($fila = $db->Next()) {
			
			$descripcion = utf8_encode(odbc_result($fila,'Descripcion'));
			
			$datos[] = array(
				'ID' => odbc_result($fila,'ID'),
				'Descripcion' => $descripcion
			);		
		}
		
		return json_encode($datos);
	
	}
	
	function getHerramientas() {
		
		$herr = array(
			array(
				"ID" => "cServ",
				"Descripcion" => "CONSULTA DE SERVICIOS"
			),
			array(
				"ID" => "geoRef",
				"Descripcion" => "GEOREFERENCIAR RUTAS"
			),
			array(
				"ID" => "recMoviles",
				"Descripcion" => "RECORRIDO DE MOVILES"
			),
			array(
				"ID" => "geoPol",
				"Descripcion" => "ZONAS DE COBERTURA"
			)
		);
		
		return json_encode($herr);	
		
	}
	
	function getOtros() {
		
		$herr = array(
			array(
				"ID" => "pNosoc",
				"Descripcion" => "NOSOCOMIOS"
			),
			array(
				"ID" => "pEmpresas",
				"Descripcion" => "EMPRESAS"
			),
			array(
				"ID" => "pCartilla",
				"Descripcion" => "CARTILLA"
			)
		);
		
		return json_encode($herr);	
		
	}
	
?>