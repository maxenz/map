<?php

function getZonificacionId($tipo,$nombre) {
    $conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn) {exit("Connection Failed: " . $conn); }
    $retVal = 0;
    $query2 = "SELECT ID FROM CompuMap.Zonificaciones where TipoZonificacion='".$tipo."' and Nombre='".$nombre."'";
    
    $result2 = odbc_exec($conn,$query2);
    
    if (odbc_fetch_row($result2)){
        
        $retVal = odbc_result($result2,'ID');
    }
    
    return $retVal;
 }
 

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn) {exit("Connection Failed: " . $conn); }

$pFun = $_GET["fun"];

if ($pFun == 1) {

    $pTip = $_GET["tip"];    
    $pNom = $_GET["nom"];    
    $pObs = $_GET["obs"];
    $msgErr = "";
    $id = 0;
     $query ="DELETE from CompuMap.Zonificaciones WHERE Nombre='nombreTemporal'";
     odbc_exec($conn,$query);
    if (getZonificacionId($pTip,$pNom)>0)
    {
        $msgErr = 'Tipo y nombre existentes.';
    }
    
    else {
       
        $query = "INSERT INTO CompuMap.Zonificaciones (TipoZonificacion,Nombre,Observaciones,flgTemporal) values ('".$pTip."','".$pNom."','".$pObs."',1)";
        

        try 
            {
            
            odbc_exec($conn,$query);
            $id = getZonificacionId($pTip,$pNom);
        
        }
         catch (Exception $e)   {
            $msgErr = $e;
        }
    }
    
    echo $pFun."^".$id."^".$msgErr;
    
} 


if ($pFun == 2) {
    

    $id = $_GET["id"];    
    $pPoints = $_GET["vPoints"];
    
    $splitPoints = preg_split("/z/", $pPoints);
    
    for ($i = 0; $i<count($splitPoints) ; $i++)
    
    {
        
        $idxPoint = preg_split("/x/", $splitPoints[$i]);    
      
        $idxPoint[0] = substr($idxPoint[0], 0, 9);
		    $idxPoint[1] = substr($idxPoint[1], 0, 9);
        $query = "INSERT INTO CompuMap.ZonificacionesCoordenadas (ZonificacionId,Latitud,Longitud) values (".$id.",".$idxPoint[0].",".$idxPoint[1].")";
        
        odbc_exec($conn,$query);
    
    }
    
    echo $pFun."^".$id."^OK"; 

}

if ($pFun == 3) {

    $idPol = $_GET["id"];
    $strPol = "";
    
    $conn=odbc_connect('phpODBC','_SYSTEM','sys');

   if (!$conn)
  {
    exit("Connection Failed: " . $conn);
    }
     
  try {
    
  $query = "SELECT REPLACE(ISNULL(Latitud,0), '.', ',') AS latitud,
REPLACE(ISNULL(Longitud,0), '.', ',') AS longitud from CompuMap.ZonificacionesCoordenadas  where ZonificacionId=".$idPol." order by childsub";
 
       $result = odbc_exec($conn,$query);
      
       while (odbc_fetch_row($result))
       
       {
        
            $lat =	odbc_result($result,'latitud');
            $lng =  odbc_result($result,'longitud');
         
            if ($strPol == "") 
            {
                
               $strPol = $lat."$".$lng;
           }
            else {
                
               $strPol = $strPol."|".$lat."$".$lng;
           }
        }

        $query = "SELECT MovilId FROM Emergency.MovilesZonificaciones WHERE ZonificacionId = ".$idPol;
        $result = odbc_exec($conn,$query);
        $strMoviles = "";

        while (odbc_fetch_row($result))   
        {
          $movId =  odbc_result($result,'MovilId');
         
          if ($strMoviles == "") 
            {
                
              $strMoviles = $movId;
            }  
            else {
                
              $strMoviles = $strMoviles."$".$movId;
           }
        }

        $nomZona = "";
        $query = "SELECT Nombre FROM CompuMap.Zonificaciones WHERE ID = ".$idPol;
        $result = odbc_exec($conn,$query);
        if (odbc_fetch_row($result)) {
          $nomZona = odbc_result($result,'Nombre');
        }

       echo $pFun."^".$strPol."^".$strMoviles."^".$nomZona;
   
      }
      catch (Exception $e)
      
      {
        echo $e;
      }
   
}

if ($pFun == 5) {

    $idMov = $_GET["id"];
    $tipCob = (int)$_GET["tipCob"];
    $conn=odbc_connect('phpODBC','_SYSTEM','sys');

    if (!$conn)
    {
      exit("Connection Failed: " . $conn);
    }

      $query = "SELECT ZonificacionId,TipoCobertura FROM Emergency.MovilesZonificaciones WHERE MovilId = " . $idMov;

      if ($tipCob == 0) {
        $query = $query . " AND TipoCobertura = 0";
      } elseif($tipCob == 1) {
        $query = $query . " AND TipoCobertura = 1";
      }
      $result = odbc_exec($conn,$query);

      while (odbc_fetch_row($result)) {

        $zonificaciones[] = array(
          'ZonificacionId' => odbc_result($result,"ZonificacionId"),
          'TipoCobertura' => odbc_result($result,'TipoCobertura')
        );
      }

      $strPol = "";

      for ($i = 0; $i < sizeOf($zonificaciones); $i++) {

        $strItemPol = "";

        $zonId = $zonificaciones[$i]["ZonificacionId"];
        $tipCob = $zonificaciones[$i]["TipoCobertura"];

        $query = "SELECT REPLACE(ISNULL(Latitud,0), '.', ',') AS latitud,
    REPLACE(ISNULL(Longitud,0), '.', ',') AS longitud from CompuMap.ZonificacionesCoordenadas  where ZonificacionId=".$zonId." order by childsub";

       $result = odbc_exec($conn,$query);
      
       while (odbc_fetch_row($result))
       
       {    
            $lat =  odbc_result($result,'latitud');
            $lng =  odbc_result($result,'longitud');

      if ($strItemPol == "") 
            {
                
               $strItemPol = $tipCob."/".$lat."$".$lng;
           }
            else {
                
               $strItemPol = $strItemPol."|".$lat."$".$lng;
           }
        }

        $strPol = $strPol . $strItemPol . "#";

      }

     echo $pFun."^".$strPol;

    }
?>