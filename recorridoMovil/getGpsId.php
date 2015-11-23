<?php

function getGpsId($idMov,$pPrfAut,$fecActual,$fecFormat) {

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn)
  {exit("Connection Failed: " . $conn);}

$idVeh = getVehiculoId($idMov,$fecActual,$fecFormat);

$SQL = "SELECT TOP 1 GpsId GPS FROM Emergency.Tecnologias tec";
$SQL = $SQL . " INNER JOIN Panel.Perifericos perif ON (perif.TipoPeriferico = tec.PerifericoId) ";
if ($pPrfAut > 0) $SQL = $SQL . " INNER JOIN Panel.Perifericos perif ON (perif.NroAutomatizacion = tec.PerifericoId)";
$SQL = $SQL . " WHERE ((MovilId = '" .$idMov. "') OR (VehiculoId = '" .$idVeh. "')) ";
$SQL = $SQL . " AND (GpsId <> '') ";
if ($pPrfAut > 0) $SQL = $SQL . " ORDER BY perif.NroAutomatizacion";

$result = odbc_exec($conn,$SQL);
if (odbc_fetch_row($result)) {

		$GPS = odbc_result($result,'GPS');
		return $GPS;

}

}

function getVehiculoId($idMov,$fecActual,$fecFormat) {

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn)
  {exit("Connection Failed: " . $conn);}

$SQL = "SELECT TOP 1 VehiculoId VEH From Emergency.MovilesIngresos mov";
$SQL = $SQL . " INNER JOIN Emergency.Vehiculos vehics ON (mov.VehiculoId = vehics.ID)";
$SQL = $SQL . " WHERE ((mov.MovilId = '" .$idMov. "')" ;
$SQL = $SQL . " AND (SUBSTR(FecHorInicio, 1, 10) = '".$fecActual."')) ORDER BY FecHorInicio DESC";

$result = odbc_exec($conn,$SQL);

if (odbc_fetch_row($result)) {

	$idVeh = odbc_result($result,'VEH');
    
	return $idVeh;

} else {

$SQL = "SELECT VehiculoId VEH FROM Emergency.MovilesSituaciones mov";
$SQL = $SQL . " INNER JOIN Emergency.CentrosOperativos co ON (co.flgSistema = mov.CentroOperativoId) ";
$SQL = $SQL . " WHERE ((mov.MovilId = '".$idMov."') AND (FecInicio <= " .$fecFormat. " ) AND (FecFinalizacion >= ".$fecFormat.")";
$SQL = $SQL . " AND (mov.CentroOperativoId = 1))";

$result = odbc_exec($conn,$SQL);

if (odbc_fetch_row($result)) {

					$idVeh = odbc_result($result,'VEH');

					return $idVeh;

			}

		}

	}






?>