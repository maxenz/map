<?php

$latDesde = $_GET["latDesde"];
$lngDesde = $_GET["lngDesde"];
$latHasta = $_GET["latHasta"];
$lngHasta = $_GET["lngHasta"];
$kmDesde = $_GET["kmDesde"];
$kmHasta = $_GET["kmHasta"];
$idPoligonal = $_GET["idPoligonal"];

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn) {exit("Connection Failed: " . $conn); }

// $query = "SELECT Max(AlturaHasta) as kmMaximo FROM CompuMap.PoligonalesAlturas WHERE PoligonalId =".$idPoligonal ;
    
// $result = odbc_exec($conn,$query);

// if(odbc_fetch_row($result)) {

// $kmMaximo = odbc_result($result,'kmMaximo'); 
	
// }

//if (($kmDesde > $kmMaximo) and ($kmDesde < $kmHasta)) {
	
	
$query = "INSERT INTO CompuMap.PoligonalesAlturas (AlturaDesde,AlturaHasta,LatitudDesde,LatitudHasta,LongitudDesde,LongitudHasta,PoligonalId) VALUES (".$kmDesde.",".$kmHasta.",".$latDesde.",".$latHasta.",".$lngDesde.",".$lngHasta.",".$idPoligonal.")";

//try {
    odbc_exec($conn,$query);   

//}


// catch (Exception $e)

// {
    // echo 0;
// }

	
// }   else

// {
	// echo 0;
	
// }








odbc_close_all();



?>




