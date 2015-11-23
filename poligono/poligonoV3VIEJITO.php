<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    <title>Paramedic - Zonas de Cobertura</title>

    <!-- Bootstrap core CSS -->
    <link href="styles/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">

        <ul class="nav navbar-nav navbar-right">
          <li><a href="javascript:history.go(-1)" class="btn btn-danger" style="color:white" data-toggle="tooltip" data-placement="bottom" title="Volver a GPShaman"><span class="glyphicon glyphicon-arrow-left"></span></a></li>
        </ul>

        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" id="top-header" href="#" ><img src="images/paramedic.png" id="imgTitle" />Zonas de Cobertura</a> 
        </div>

      </div>
    </div>




    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 sidebar">
          <div class="alert alert-danger" style="text-align:center">
            <strong>Listado de Zonas</strong> 
          </div>

          <ul class="nav nav-sidebar" id="listZonas"></ul>

          <div id="page-selection" ></div>

        </div>
        <div class="col-md-9 col-md-offset-3 main">
          <h1 class="page-header">&Aacute;rea de zonificaci&oacute;n</h1>
          <div class="well">
              <div class="row">

              <div class="col-md-3">
               <a href="#" class="btn btn-default btn-primary btnGral"  onclick="savePoligono()">
                <span class="glyphicon glyphicon-circle-arrow-down"></span>
                Guardar Polígono
              </a>
              </div>

              <div class="col-md-3">
               <a href="#" class="btn btn-default btn-danger btnGral" onclick="clearMap()">
                <span class="glyphicon glyphicon-remove"></span>
                Deshacer trazado
              </a>
              </div>

               <div class="col-md-6">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Buscar dirección..." id="iptDireccion">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button"  onclick="showAddress()"><span class="glyphicon glyphicon-search"></span></button>
                  </span>
                </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->

              </div>


          </div>
          <div class="row">
            <div class="col-md-12">
          <div id="map" style="height:350px"></div>
            </div>
          </div>
    
        </div>
      </div>
    </div>

<div class="modal fade" id="mdlPoligono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Creaci&oacute;n de Zona</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h3>Nombre</h3>
          </div>
          <div class="col-md-6">
            <h3>Observaciones</h3>
          </div>
        </div>
        <div class="row">
          <input type="hidden" id="hidIdPol" value=""></input>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtNombre">
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtObservaciones">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="updateSavePol()">Guardar</button>
      </div>
    </div>
  </div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/jquery.bootpag.min.js"></script>    
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">

        //DECLARACION VARIABLES DE USO GENERAL
        var pPerm = 3;      
        var region;
        var polyPoints = new google.maps.MVCArray;
        var markers = [];
        var id;
        var polyVec;
        var map;
        var polyShape;
        var polygonMode;
        var polygonDepth = "20";
        var polyPoints2 = [];
        var marker;
        var geocoder = null;
        var fillColor = "#0000FF"; // blue fill
        var lineColor = "#000000"; // black line
        var opacity = .5;
        var lineWeight = 2;
        var kmlFillColor = "7dff0000"; // half-opaque blue fill

        var latlng = new google.maps.LatLng(-34.603365,-58.379416);
        
        var myOptions = {
          zoom: 13,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

      $(document).ready(function(){
   
        map = new google.maps.Map(document.getElementById("map"),myOptions);

        poly = new google.maps.Polygon({
          strokeWeight: 3,
          fillColor: '#5555FF'
        });

        poly.setMap(map);
        poly.setPaths(new google.maps.MVCArray([polyPoints]));

        google.maps.event.addListener(map, 'click', addPoint);

        //OBTENGO LA ZONAS ZONAS DE LA PAGE 1
        getZonas(1);
        //OBTENGO EL PAGINADOR SEGUN LA CANTIDAD DE ZONAS
        getCountZonas();

      });

      function updateSavePol() {

        var id = $('#hidIdPol').val();
        var nombre = $('#txtNombre').val();
        var obs = $('#txtObservaciones').val();

        $.ajax({
          url : 'procesoPol.php?nombre='+nombre+'&obs='+obs+'&id='+id,
          type: 'POST',
          success : function(data){
            alert('La zona se ha creado correctamente');
            $('#mdlPoligono').hide();
          }
        });
      }

      function getCountZonas() {

        //SETEO LA CANTIDAD DE ELEMENTOS DEL PAGINADOR SEGUN LA CANTIDAD DE ZONAS

        $.ajax({
          url: 'getCountZonas.php',
          success: function(cant) {
            var iCant = parseInt(cant);
            iCant = (iCant / 10) + 1;

            $('#page-selection').bootpag({

              total: iCant,
              maxVisible:5

            }).on("page", function(event,num){

              getZonas(num);

            });
          }
        });
      }

      function getZonas(num) {

        //OBTENGO TODAS LAS ZONAS DE LA BASE DE DATOS

        $.ajax({
          url: 'getZonas.php?page=' + num,
          dataType: 'json',
          success: function(data) {
            setZonas(data);
          }
        });
      }

      function setZonas(z) {

        //CREO EL STRING CON LOS ELEMENTOS DE LA LISTA Y LOS AGREGO AL SIDEBAR
        var len = z.length;
        var str_lista_zonas = "";
        for(var i = 0; i < len; i++) {
          var id = z[i].ID;
          var loc = z[i].Loc;
          var desc = z[i].Descripcion;

          if (desc == undefined) 
          {
            desc = "";
          } else {
            desc = " - " + desc; 
          }

          str_lista_zonas += "<li><a href='javascript:mostrarPoligono("+id+")'>"+ loc + desc+"</a></li>";
        }

        $('#listZonas').empty().append(str_lista_zonas);
      }


      //****************************************************
      //TODO ESTO ES DE LA VIEJA VERSION PERO FUNCIONAL, CUANDO TENGA TIEMPO CAMBIARLO



    function addPoint(event) {
  
      polyPoints.insertAt(polyPoints.length, event.latLng);

      var marker = new google.maps.Marker({
        position: event.latLng,
        map: map,
        draggable: true
      });
      markers.push(marker);
      marker.setTitle("#" + polyPoints.length);
      google.maps.event.addListener(marker, 'click', function() {
        marker.setMap(null);
        for (var i = 0, I = markers.length; i < I && markers[i] != marker; ++i);
        markers.splice(i, 1);
        polyPoints.removeAt(i);
        }
      );

      google.maps.event.addListener(marker, 'dragend', function() {
        for (var i = 0, I = markers.length; i < I && markers[i] != marker; ++i);
        polyPoints.setAt(i, marker.getPosition());
        }
      );
  }
 
    function clearOverlays() {
     
      for (var i = 0; i < markers.length  ; i++) {
        markers[i].setMap(null);  
      }
    }

    function removeFig(closedFig) {

      if (closedFig != null) {

        closedFig.setMap(null);
      }
    }

    function clearMap(){
          
      removeFig(region);
      polyPoints.clear();
      clearOverlays();
      markers = [];
      polyPoints2 = [];
  
    }

    function createMarker(point,isShowAddress) {
      
      var shape = {
        coord: [1, 1, 1, 20, 18, 20, 18 , 1],
        type: 'poly'
      };
     
      var myLatLng = point;
      var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          shape: shape
      });

      if (isShowAddress == 1) {
        markers.push(marker);
      }
    }
  
function ajaxFunction(url){
  var ajaxRequest;  // The variable that makes Ajax possible!
  
  try{
    // Opera 8.0+, Firefox, Safari
    ajaxRequest = new XMLHttpRequest();
  } catch (e){
    // Internet Explorer Browsers
    try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e){
        // Something went wrong
        alert("Your browser broke!");
        return false;
      }
    }
  }
  // Create a function that will receive data sent from the server
  ajaxRequest.onreadystatechange = function(){

    if(ajaxRequest.readyState == 4){
      
           var rta = ajaxRequest.responseText.split("^");

       // alert(rta[0]);
           if (rta[0] == 1) {
                if (rta[1] > 0) {
                    
                  var  strPoints = "";
         
          
                    for (var i=0; i<markers.length; i++) 
                    {
            
                        strPoly = polyPoints.getAt(i).toString();
                        strPoly = strPoly.replace("(","");
                        strPoly = strPoly.replace(")","");
                        strPoly = strPoly.replace(",","x");
                        strPoly = strPoly.replace(" ","");
            
                        if (strPoints == "") {
                            strPoints = strPoly;
                        }
                        else {
                            strPoints = strPoints + "z" + strPoly; 
                        }
            
                    }
          
                    ajaxFunction('proceso.php?fun=2&id='+rta[1]+'&vPoints='+strPoints);
                    
                }
                else {
                    alert(rta[2]);
                }
           }
           
           if (rta[0] == 2) {
                
                $('#hidIdPol').val(rta[1]);
                $('#mdlPoligono').modal();
                console.log($('#hidIdPol').val());
                //doWindow(rta[1]);
           
           };
           
           if (rta[0] == 3) {
           
               var vecRegPol = rta[1].split("|");
                
               for (var k = 0; k<vecRegPol.length; k++) 
                
               {
                  var vecCmpPol = vecRegPol[k].split("$");
                  var lat = (vecCmpPol[0]);
                  lat = lat.replace(",",".");
                  lat = parseFloat(lat);
                  var lng = (vecCmpPol[1]);
                  lng = lng.replace(",",".");
                  lng = parseFloat(lng);
                  var point = new google.maps.LatLng(lat,lng);
                  polyPoints2.push(point);
                }
                
                polyPoints2[vecRegPol.length] = polyPoints2[0];
                var polygon = new google.maps.Polygon(polyPoints2, "#f33f00", 5, 1, "#ff0000", 0.2);

                var bounds = new google.maps.LatLngBounds();
        for (i=0;i<polyPoints2.length;i++) {
          bounds.extend(polyPoints2[i]);
        }
            region = new google.maps.Polygon({
                 paths: polyPoints2,
                 strokeColor: "#FF0000",
                 strokeOpacity: 0.8,
                 strokeWeight: 1,
                 fillColor: "#FF0000",
                 fillOpacity: 0.35
 
      });
 
        region.setMap(map);
        map.fitBounds(bounds);
        
            }     
        }                             
   }
    
         ajaxRequest.open("GET", url, true);
         ajaxRequest.send(null);
}   
 
function savePoligono() {

    if (pPerm == 3) {
                   
            tip = "COB";
            nom = "nombreTemporal";
            obs = "obsTemporal"
        
            var url = 'proceso.php?fun=1&tip='+tip+'&nom='+nom+'&obs='+obs;
       
            ajaxFunction(url);
        
    } else {
      
        alert('No esta autorizado para realizar modificaciones.');
           
    }
}

function doWindow(id)
{   
     window.open('guardoPol.php?id='+id, 'popup',
     'width=400,height=300,top=200,left=200,directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=yes');
    
    
}


 function mostrarPoligono(id) {
    
     clearMap();
     ajaxFunction('proceso.php?fun=3&id='+id);
   
 }  
 
    function showAddress() {


   var address = $('#iptDireccion').val();
  
    var geocoder = new google.maps.Geocoder();
    var result = "";
    geocoder.geocode( { 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
      
            result = results[0].geometry.location;
      map.setCenter(result);
      map.setZoom(17);
      createMarker(result,1);
            
        } else {
            result = "Unable to find address: " + status;
        }
    });
   
   }

   //**************************************************************************

    </script>    
  </body>
</html>
