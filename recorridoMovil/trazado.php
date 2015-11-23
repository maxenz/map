<html>
<head>
<title>Grupo Paramedic</title>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/blitzer/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.5/src/infobox.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script type="text/javascript" src="label.js"></script>
<script src="jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" type="text/css" href="estilo.css" />
<script type="text/javascript">

var directionDisplay;
var map;
var ib;
var i = 0;
var gmarkers = [];
var directionsService = new google.maps.DirectionsService();  
var directionsService1 = new google.maps.DirectionsService();  
var latlng1 = new google.maps.LatLng(-34.62664,-58.522972);
var latlng2 = new google.maps.LatLng(-34.622031,-58.513273);
var latlng3 = new google.maps.LatLng(-34.614615,-58.511749);

var rendererOptions = {
  map: map,
  suppressMarkers: true,
  preventViewport : true
}

 var myOptions = {
      zoom: 11,
      center: latlng1,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
         
	$(document).ready(function(e) {

	$('body').css("overflow","hidden");

				$( "#dialog" ).dialog({
				
					width:300,
					resizable : false,
					autoOpen : false,
					modal: true,
					show : "slow",
					position : 'top',
					height : 'auto',

					});
					
			
			
	
	$('#fecHorDesde, #fecHorHasta').datetimepicker({
		
		hourText : 'Hora',
		minuteText : 'Min.',
		timeText : '',
		currentText : 'Ahora',
		closeText : 'Listo',
		dateFormat : 'yy/mm/dd',
		dayNamesMin : ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
		monthNames : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
		
	
	});
	
	

  $(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
                
            });
   		 });
		
	
		$('#btnProcesoRecPolyline')
		.css({
			
			'width' : '40',
			'height' : '40',
			'background-image' : 'url(flag.png)',
			'background-color' : '#FFF'
		});
		
		

		$('#mostrarInput').click(function(e) {
			
			$("#fecHorDesde, #fecHorHasta").datepicker("disable");
			$('#dialog').css('overflow', 'hidden');
			$('#dialog').dialog("open");
			$("#fecHorDesde, #fecHorHasta").datepicker("enable");


			
			//$('#labelDatos').hide('slow');
    		//$('#datosIngreso').show('slow');
		});


    	$('input:text, input:password')
  			.button()
  			.css({
	          'font' : 'inherit',
    	      'color' : 'inherit',
	    	  'text-align' : 'left',
    	   	  'outline' : 'none',
	          'cursor' : 'text'
  			});
			
		$('#btnProcesoRecPolyline').click(function(e) {
			var vecPuntos = [];
			var fecDesde = $('#fecHorDesde').val();
			var fecHasta = $('#fecHorHasta').val();
			var nroMovil = $('#nroMovil').val();
			
			fecDesde = fecDesde.split('/').join('-');
			fecHasta = fecHasta.split('/').join('-');
			
			fecDesde = fecDesde+":00";
			fecHasta = fecHasta+":59";
			
			
			
			$.ajax({
					type: "GET",
					dataType: "json",
					url:  "getPosiciones.php",
					data: "fecDesde="+fecDesde+"&fecHasta="+fecHasta+"&mov="+nroMovil,
					success: function(datos){
						 
						//datos = eliminateDuplicates(datos); 
						
							for (var i = 0; i < datos.length - 1; i++) {
								
								var vecPunto = datos[i].split("/");
								var lat = vecPunto[0];
								var lng = vecPunto[1];
								var hora = vecPunto[2];
								var vel = vecPunto[3];
								var punto = new google.maps.LatLng(lat,lng);
								vecPuntos.push(punto);
								
								if (i%7 == 0)  {

									createMarker(punto,hora,vel);
								
						}
							}
						
						var repoPuntos = new google.maps.Polyline({
   							 path: vecPuntos,
    						 strokeColor: "#FF0000",
   							 strokeOpacity: 1.0,
   							 strokeWeight: 3
 						 });

	  					repoPuntos.setMap(map);		
						 
					}
			});	
			
			$('#dialog').dialog("close");	
			//map.setCenter(-34.625174,-58.517432);
			
	});
			
   		 map = new google.maps.Map(document.getElementById("map"),myOptions);
   		 $('#map').css("width","100%").css("height","100%");

 }); 
 
 function eliminateDuplicates(arr) {
  		var i,
      	len=arr.length,
      	out=[],
      	obj={};

	  for (i=0;i<len;i++) {
    		obj[arr[i]]=0;
  			}
  	  for (i in obj) {
    	out.push(i);
  		}
  	  return out;
	}
 
   	
    function requestDirections(start, end) {
     	 directionsService.route({
      		  origin: start,
       		  destination: end,
        	  travelMode: google.maps.DirectionsTravelMode.DRIVING
     	 }, function(result) {
		 		 if (result != null) {
        			renderDirections(result);
				  }
     		 });
   		 }
	
				function createMarker(point,hora,vel) {
	  
	  		   // alert(map.getZoom());
			   var horario = hora.substring(11,19);
				var myLatLng = point;
				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					title: horario,
					zIndex: 1
				});
	
				var boxText = document.createElement("div");
				boxText.style.cssText = "border: 2px solid black; margin-top: 8px; background: white; text-align:center ;font-weight:bold; 						height:40px; padding: 1px;";
				boxText.innerHTML = "Hora:<font color=red> " + horario + "</font><br> Velocidad: <font color=red> " + vel + " km/h </font>";
		
				var myOptions = {
					content: boxText
					,disableAutoPan: false
					,maxWidth: 0
					,pixelOffset: new google.maps.Size(-140, 0)
					,zIndex: null
					,boxStyle: { 
					opacity: 0.75
					,width: "200px"
				}
					,closeBoxMargin: "10px 2px 2px 2px"
					,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
					,infoBoxClearance: new google.maps.Size(1, 1)
					,isHidden: false
					,pane: "floatPane"
					,enableEventPropagation: false
				};

					google.maps.event.addListener(marker, "click", function(event) {
            
						if (ib == undefined) {
				
							ib = new InfoBox(myOptions);
							ib.open(map,this);
				
							} else {
				
								ib.close();
								ib = new InfoBox(myOptions);
								ib.open(map,this);
								
							}
						
						});
			
				gmarkers[i] = marker;
        
				i++;
        
			}
</script>
</head>
<body>

<br/>
<div id="map" style="margin-top:-25px"></div>
<div id="titulo">
<input type="submit" value="Mostrar" id="mostrarInput"></input>
</div>
<div id="dialog" title="Ruta de M&oacute;vil">

<form>
<fieldset>
<label for="fecHorDesde" id="lblHorDesde">Fecha/Hora Desde:</label>
<input type="text" id="fecHorDesde" class="text ui-widget-content ui-corner-all" />

<label for="fecHorHasta" id="lblHorHasta">Fecha/Hora Hasta:</label>
<input type="text" id="fecHorHasta"  class="text ui-widget-content ui-corner-all" />

<label for="nroMovil" id="lblMovil">Nro. de M&oacute;vil:</label>
<input type="text" value="" id="nroMovil" class="text ui-widget-content ui-corner-all" />

<input type="submit" value="" id="btnProcesoRec">
<input type="submit" value="" id="btnProcesoRecPolyline">
</fieldset>
</form>

</div>
</body>
</html>