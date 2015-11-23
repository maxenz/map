<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<style>

    body {
		
	background-color:#E6E6E6;	
	}

    .ui-combobox {
        position: relative;
        display: inline-block;
		text-align:center;
		
	}
	.ui-comboboxitem {
		
		background-color:#F00;			
			
		}
    
    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
		
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
		
    }
    </style>
   
    <script>
	
        
		
		
   
	
	
    $(function() {
        var kmDesde = $( "#kmDesde" ),
            kmHasta = $( "#kmHasta" ),
            allFields = $( [] ).add( kmDesde ).add( kmHasta ),
            tips = $( ".validateTips" );
 
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
 
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }
 
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
		
		
 
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Guardar": function() {
                 
				 
				 
				 
				 var latDesde = markers[0].getPosition().lat();
				 var lngDesde = markers[0].getPosition().lng();
				 var latHasta = markers[1].getPosition().lat();
				 var lngHasta = markers[1].getPosition().lng();
                
				 
				 var kmDesde = $('#kmDesde').val();
				 var kmHasta = $('#kmHasta').val();
				 var idPoligonal = $('#combobox').val();
				 
				
                 $.ajax({
        		 type: "GET",
      			 url: "procesoTramo.php",
        		 data: "latDesde="+latDesde+"&lngDesde="+lngDesde+"&latHasta="+latHasta+"&lngHasta="+lngHasta+"&kmDesde="+kmDesde+"&kmHasta="+kmHasta+"&idPoligonal="+idPoligonal,
       			 success: function(respuesta){
					
				
      			 if (respuesta == 0) {
					 $('#dialog-form').dialog("close");
					alert('Vuelva a ingresar los datos correctamente'); 
				 } else {
					 $('#dialog-form').dialog("close");
					 $('#dialog-message').css("visibility","visible");
					 $(function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
					 setTimeout(function() { $('#dialog-message').dialog("close"); }, 1000);
					
				 }
     			   }
			    });
				
				
				
				 
                    
                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
 
        $( "#create-user" )
            .button()
            .click(function() {
				
				if (markers.length == 2) {
					
					$( "#dialog-form" ).dialog( "open" );	
				} else {
				
					alert('Debe seleccionar los 2 puntos del tramo');	
				}
				
				
				
                
				
            });
    });
    </script>
    <script>
	$(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });
				
    (function( $ ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var input,
                    that = this,
                    select = this.element.hide(),
                    selected = select.children( ":selected" ),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $( "<span>" )
                        .addClass( "ui-combobox" )
                        .insertAfter( select );
 
                function removeIfInvalid(element) {
                    var value = $( element ).val(),
                        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                        valid = false;
                    select.children( "option" ).each(function() {
                        if ( $( this ).text().match( matcher ) ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) {
                        // remove invalid value, as it didn't match anything
                        $( element )
                            .val( "" )
                            .attr( "title", value + " didn't match any item" )
                            .tooltip( "open" );
                        select.val( "" );
                        setTimeout(function() {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }
 
                input = $( "<input>" )
                    .appendTo( wrapper )
                    .val( value )
                    .attr( "title", "" )
                    .addClass( "ui-state-default ui-combobox-input" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: function( request, response ) {
                            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                            response( select.children( "option" ).map(function() {
                                var text = $( this ).text();
                                if ( this.value && ( !request.term || matcher.test(text) ) )
                                    return {
                                        label: text.replace(
                                            new RegExp(
                                                "(?![^&;]+;)(?!<[^<>]*)(" +
                                                $.ui.autocomplete.escapeRegex(request.term) +
                                                ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                            ), "<strong>$1</strong>" ),
                                        value: text,
                                        option: this
                                    };
                            }) );
                        },
                        select: function( event, ui ) {
                            ui.item.option.selected = true;
                            that._trigger( "selected", event, {
                                item: ui.item.option
                            });
                        },
                        change: function( event, ui ) {
                            if ( !ui.item )
                                return removeIfInvalid( this );
                        }
                    })
                    .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + item.label + "</a>" )
                        .appendTo( ul );
                };
 
                $( "<a>" )
                    .attr( "tabIndex", -1 )
                    .attr( "title", "Ver todas las rutas" )
                    .tooltip()
                    .appendTo( wrapper )
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass( "ui-corner-all" )
                    .addClass( "ui-corner-right ui-combobox-toggle" )
                    .click(function() {
                        // close if already visible
                        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                            input.autocomplete( "close" );
                            removeIfInvalid( input );
                            return;
                        }
 
                        // work around a bug (likely same cause as #5265)
                        $( this ).blur();
 
                        // pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                        input.focus();
                    });
 
                    input
                        .tooltip({
                            position: {
                                of: this.button
                            },
                            tooltipClass: "ui-state-highlight"
                        });
            },
 
            destroy: function() {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );
 
    $(function() {
        $( "#combobox" ).combobox();
        $( "#toggle" ).click(function() {
            $( "#combobox" ).toggle();
        });
    });
    </script>
<script type="text/javascript">
var map;
var markers = [];
$(document).ready(function(e) {
    

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
<br>
<div id="botones">
<table hspace="300px">
<tr>
<td>
<div class="ui-widget">
    
    <select id="combobox">
    
    
    <?php 
	 $conn=odbc_connect('phpODBC','_SYSTEM','sys');

     if (!$conn) {exit("Connection Failed: " . $conn); }
   
    $query = "SELECT ID,Nombre FROM CompuMap.Poligonales WHERE MapaId = 99" ;
    
    $result = odbc_exec($conn,$query);
    
    while (odbc_fetch_row($result)){
		
		
        
        $idPoligonal = odbc_result($result,'ID');
		$nomPoligonal = odbc_result($result,'Nombre');
		
		
		?>
        <option value="<?php echo $idPoligonal ; ?>"><?php echo $nomPoligonal ; ?></option>
        
        
        <?php
    }
    
 
	?>
      
    </select>
</div></td>
<td><input id="create-user" value="Guardar Tramo" style="margin-left:43px"></td>
<td><input type="submit" value="Deshacer Selección" onClick="deleteMarkers()"/></td>
</tr>
</table>
</div>

<br>
<div id="map" style="width:100%; height:70%"></div>

<div id="dialog-form" title="Datos del Tramo">
    
    <form>
    <fieldset>
        <label for="kmDesde">Km Desde:</label>
        <input type="text" name="kmDesde" id="kmDesde" class="text ui-widget-content ui-corner-all" maxlength="4" /><br>
        <label for="kmHasta">Km Hasta:</label>
        <input type="text" name="kmHasta" id="kmHasta" value="" class="text ui-widget-content ui-corner-all" maxlength="4" />
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