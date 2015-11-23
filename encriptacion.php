<?php

include('php/funcionesEncriptacion.php');

$usuario = $_GET["usrId"];
$cOpId = $_GET["cOp"];
$pId = $_GET["pId"];


$usuarioEnc = encrypt($usuario,"maxo");
$cOpIdEnc = encrypt($cOpId,"maxo");
$pIdEnc = encrypt($pId,"maxo");

$url = 'visor.php?usrId='.$usuarioEnc.'&cOp='.$cOpIdEnc.'&pId='.$pIdEnc;


if (isset($_GET["opc"])) {
	
	$opc = $_GET["opc"];
	$opcEnc = encrypt($opc,"maxo");
	$url = $url.'&opc='.$opcEnc;	
}


if (isset($_GET["refId"])) {
	
	$refId = $_GET["refId"];
	//$refIdEnc = encrypt($refId,"maxo");
	$url = $url.'&refId='.$refId;	
}


if (isset($_GET["fecHoraDesde"])) {
	
	$fecHoraDesde = $_GET["fecHoraDesde"];
	$fecHoraDesdeEnc = encrypt($fecHoraDesde,"maxo");
	$url = $url.'&fecHoraDesde='.$fecHoraDesdeEnc;	
}


if (isset($_GET["fecHoraHasta"])) {
	
	$fecHoraHasta = $_GET["fecHoraHasta"];
	$fecHoraHastaEnc = encrypt($fecHoraHasta,"maxo");
	$url = $url.'&fecHoraHasta='.$fecHoraHastaEnc;	
}


if (isset($_GET["mov"])) {
	
	$mov = $_GET["mov"];
	$movEnc = encrypt($mov,"maxo");
	$url = $url.'&mov='.$movEnc;
		
}

header('Location: '.$url);

?>