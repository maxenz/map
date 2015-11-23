<?php

function restarMinutosFecha($FechaStr, $MinASumar) {

	$FechaStr = str_replace("-", " ", $FechaStr);
	$FechaStr = str_replace(":", " ", $FechaStr);

	$FechaOrigen = explode(" ", $FechaStr);

	$Dia = $FechaOrigen[2];
	$Mes = $FechaOrigen[1];
	$Ano = $FechaOrigen[0];

	$Horas = $FechaOrigen[3];
	$Minutos = $FechaOrigen[4];
	$Segundos = $FechaOrigen[5];

	// Sumo los minutos
	$Minutos = ((int)$Minutos) - ((int)$MinASumar);

	// Asigno la fecha modificada a una nueva variable
	$FechaNueva = date("Y-m-d H:i:s",mktime($Horas,$Minutos,$Segundos,$Mes,$Dia,$Ano));

	return $FechaNueva;
}

?>