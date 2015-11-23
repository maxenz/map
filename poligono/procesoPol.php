<?php



$id = $_GET["id"];
$nombre = $_GET["nombre"];
$obs = $_GET["obs"];




$conn=odbc_connect('phpODBC','_SYSTEM','sys');

if (!$conn) {exit("Connection Failed: " . $conn); }


$query = "UPDATE CompuMap.Zonificaciones SET Nombre='".$nombre."',Observaciones='".$obs."',flgTemporal=0 WHERE ID=".$id;

try {
    odbc_exec($conn,$query);
    
   echo "OK";
    
  
  
}


catch (Exception $e)

{
    echo $e;
}

odbc_close_all();
 

	
?>

