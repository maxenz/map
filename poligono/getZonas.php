<?php

    $tipVista = (int)$_GET["tipVista"];

    if ($tipVista == 1) {

        $conn=odbc_connect('phpODBC','_SYSTEM','sys');

        if (!$conn)
        {
          exit("Connection Failed: " . $conn);
        }
        
        $page = $_GET["page"];
        $int_page = (int)$page;

        $limit_inf = ($int_page - 1) * 10;

        $qryPol = "SELECT ID, Nombre, Observaciones from CompuMap.Zonificaciones WHERE flgTemporal=0 ";
        $result = odbc_exec($conn,$qryPol);

        while (odbc_fetch_row($result)) {

            $datos[] = array(
                'ID' => odbc_result($result,"ID"),
                'Loc' => utf8_encode(odbc_result($result,"Nombre")),
                'Descripcion' => odbc_result($result,"Observaciones")
            );
        }

        $datos = array_splice($datos,$limit_inf, 10);

        echo json_encode($datos);

    } else {

        $conn=odbc_connect('phpODBC','_SYSTEM','sys');

        if (!$conn)
        {
          exit("Connection Failed: " . $conn);
        }
        
        $page = $_GET["page"];
        $int_page = (int)$page;

        $limit_inf = ($int_page - 1) * 10;

        $qryPol = "SELECT ID, MovilId, TipoCobertura, ZonificacionId from Emergency.MovilesZonificaciones";
        $qryPol .= " GROUP BY MovilId";
        $result = odbc_exec($conn,$qryPol);

        while (odbc_fetch_row($result)) {

            $datos[] = array(
                'ID' => odbc_result($result,"ID"),
                'MovilId' => odbc_result($result,"MovilId"),
                'TipoCobertura' => odbc_result($result,"TipoCobertura"),
                'ZonificacionId' => odbc_result($result,"ZonificacionId")
            );
        }

        $datos = array_splice($datos,$limit_inf, 10);

        echo json_encode($datos);

    }

    odbc_close($conn);

 	
         
?>

