// JavaScript Document


var flgPerfil = "";

	function createMarkerRec(point,hora,vel,flag) {
	  			
				
			
			    var horario = hora.substring(11,19);
			
				var myLatLng = point;
				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					title: horario,
					zIndex: 1
				});
				
				if (flag == 1) {
					iconFile = 'http://www.google.com/mapfiles/kml/paddle/go.png'; 
					marker.setIcon(iconFile)
				}
				
				if (flag == 2) {
					iconFile = 'http://www.google.com/mapfiles/kml/paddle/stop.png'; 
					marker.setIcon(iconFile)
				}
				
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

				
				
					
		function procesoRecorrido(fecDesde,fecHasta,nroMovil) {
		
			fecDesde = fecDesde.toString();
			fecHasta = fecHasta.toString();
		
			
			fecDesde = fecDesde.split('/').join('-');
			fecHasta = fecHasta.split('/').join('-');
			
			fecDesde = fecDesde+":00";
			fecHasta = fecHasta+":59";
			
			
			
			$.ajax({
					type: "GET",
					dataType: "json",
					url:  "recorridoMovil/getPosiciones.php?fecDesde="+fecDesde+"&fecHasta="+fecHasta+"&mov="+nroMovil,
					success: function(datos){
					
						var vecInicio = [];
						var vecFinal = [];
						var puntoAnt;
						alert(datos.length);
							for (var i = 0; i < datos.length ; i++) {
								
								var vecPunto = datos[i].split("/");
								var lat = vecPunto[0];
								var lng = vecPunto[1];
								var hora = vecPunto[2];
								var vel = vecPunto[3];
								var punto = new google.maps.LatLng(lat,lng);
								alert(punto);
								if (!punto.equals(puntoAnt)) {
									vecPuntos.push(punto); 	
								}
								
								puntoAnt = punto;
								
								
								if (i == 0) {
									
									vecInicio[0] = punto;
									vecInicio[1] = hora;
									vecInicio[2] = vel;	
									
								}
								
								 else if (i == (datos.length - 1)) {
									 
									vecFinal[0] = punto;
									vecFinal[1] = hora;
									vecFinal[2] = vel;
									
								}
								
								 else if (i%3 == 0) {
									
									createMarkerRec(punto,hora,vel,0);
									
								}
												
							}
						
						createMarkerRec(vecInicio[0],vecInicio[1],vecInicio[2],1);
						createMarkerRec(vecFinal[0],vecFinal[1],vecFinal[2],2);
						
						repoPuntos.setPath(vecPuntos);
	  					repoPuntos.setMap(map);	
													
			$('#dialog').dialog("close");
							 
					}
						
				});	
		
		}
		
		
		
			
	