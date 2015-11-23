<?php

 	$conn=odbc_connect('phpODBC','_SYSTEM','sys');

    if (!$conn)
    {
      exit("Connection Failed: " . $conn);
    }

    $tipVista = (int)$_GET["tipVista"];

    if ($tipVista == 1) {

    	$qry = "SELECT COUNT(*) as cantidad from CompuMap.Zonificaciones WHERE flgTemporal=0 ";
	   
    } else {

    	$qry = "SELECT COUNT(DISTINCT MovilId) as cantidad from Emergency.MovilesZonificaciones ";
	   
    }

     $result = odbc_exec($conn,$qry);

	if (odbc_fetch_row($result)) {

	    echo odbc_result($result,'cantidad');
	}

	odbc_close($conn);
         
?>