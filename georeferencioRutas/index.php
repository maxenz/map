<?php
include('../php/funcionesEncriptacion.php');

	if (!(isset($_GET["usrId"]))) {
		
		die("Acceso denegado.");	
	}
	
	if (isset($_GET["pPerm"])) {
		
		$pPerm = decrypt($_GET["pPerm"],"maxo");
		
	
	}

?>

<html>
<head>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="jqwidgets/styles/jqx.red.css" type="text/css" />
    <link rel="stylesheet" href="estilo.css" type="text/css" />
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    
    <script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcombobox.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript">
	
	
	var pPerm = <?php echo $pPerm; ?> ;	
    var map;
	var markers = [];
	$(document).ready(function(e) {
		
		
		
	$( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
	}); 
				
      $('#btnProcesoKm').click(function(e){
		
		 var latDesde = markers[0].getPosition().lat();
		 var lngDesde = markers[0].getPosition().lng();
		 var latHasta = markers[1].getPosition().lat();
		 var lngHasta = markers[1].getPosition().lng();

		 var kmDesde = $('#kmDesde').val();
		 var kmHasta = $('#kmHasta').val();
		 var item = $("#comboRutas").jqxComboBox('getSelectedItem'); 
		 var idPoligonal = item.value;	
		 
		$.ajax({
        		type: "GET",
			url: "procesoTramo.php",
        		data: "latDesde="+latDesde+"&lngDesde="+lngDesde+"&latHasta="+latHasta+"&lngHasta="+lngHasta+"&kmDesde="+kmDesde+"&kmHasta="+kmHasta+"&idPoligonal="+idPoligonal,
			success: function(respuesta){

				$('#dialog-form').dialog('close');
			}
		});
		
		});
 
        $( "#btnGuardarTramo" )
            .click(function() {
				
				if (pPerm == 3) {
				
				
				if (markers.length == 2) {
					
					$( "#dialog-form" ).dialog( "open" );	
				} else {
				
					alert('Debe seleccionar los 2 puntos del tramo');	
				}
				
			} else {
				
				alert('No esta autorizado para realizar modificaciones');	
			}
				 
				
            });
   
		var latlng = new google.maps.LatLng(-34.603365,-58.379416);
	  
    	var myOptions = {
     		 zoom: 13,
     		 center: latlng,
     		 mapTypeId: google.maps.MapTypeId.ROADMAP
   		 };
      
      		 map = new google.maps.Map(document.getElementById("map"),myOptions);

	  		 google.maps.event.addListener(map, 'click', addPoint);

		});

	function addPoint(event) {
	
		if (markers.length < 2) {
		
		    var marker = new google.maps.Marker({
     			position: event.latLng,
     			map: map,
     			draggable: true
    		});
	
   	 		markers.push(marker);
	
		} else {
		
			alert('Ya ha seleccionado los puntos del tramo');
		
		}
	 
  	}

  function deleteMarkers() {
	
	for(var i = 0; i < markers.length; i++) {
		
		markers[i].setMap(null);
			
	}
	
	markers = [];
	  
  }

    </script>
</head>
<body>
    <div>
        <script type="text/javascript">
            $(document).ready(function () {
                var source = [
                    "PANAMERICANA",
                    "PANAMERICANA RAMAL PILAR",
                    "PANAMERICANA RAMAL ESCOBAR",
                    "AU. 25 DE MAYO",
                    "ACCESO OESTE",
			"PANAMERICANA RAMAL TIGRE",
		        ];
                // Create a jqxComboBox
                $("#comboRutas").jqxComboBox({ source: source, selectedIndex: 0, width: '250px', height: '25px', theme: 'red', dropDownHeight : 150 });
				$("#btnDeshacer").jqxButton({ width: '150', height: '25', theme: 'red'});
				$('#btnDeshacer').css("cursor","pointer");
				$("#btnGuardarTramo").jqxButton({ width: '150', height: '25', theme: 'red'});
				$('#btnGuardarTramo').css("cursor","pointer");
				$("#btnDeshacer").css("border-width","2px").css("border-color","#F00");
				$("#btnGuardarTramo").css("border-width","2px").css("border-color","#F00");
				var items = $("#comboRutas").jqxComboBox('getItems');
				var id = 31991;
				for (var i = 0; i < 6 ; i++) {
					
						items[i].value = id;
						id++;	
				}
				
            });
        </script>
        <table id="principal">
        <tr>
        <td>
        <div id='comboRutas'>
        </div>
        </td>
        <td>
        <div>
        <input type="button" value="Guardar Tramo" id="btnGuardarTramo">
        </div>
        </td>
        <td>
         <div>
        <input type="button" value="Deshacer Selecci&oacute;n" id="btnDeshacer" onClick="deleteMarkers()">
        </div>
        </td>
        </tr>
        </table>
    </div>
 
 <div id="map" style="width:100%; height:500px; margin-top:20px"></div>

 <div id="dialog-form" title="Datos del Tramo">
    
    <form>
    <fieldset>
        <label for="kmDesde">Km Desde:</label>
        <input type="text" name="kmDesde" id="kmDesde" class="text ui-widget-content ui-corner-all" maxlength="4" /><br>
        <label for="kmHasta">Km Hasta:</label>
        <input type="text" name="kmHasta" id="kmHasta" value="" class="text ui-widget-content ui-corner-all" maxlength="4" />
	<input type="button" id="btnProcesoKm" value="Guardar" />
    </fieldset>
    </form>
</div>

<div id="dialog-message" style="visibility:hidden">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        El tramo se guardó correctamente.
    </p>
    
</div>
 
</body>
</html>