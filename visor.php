<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
    <title>Grupo Paramedic</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/bootmetro.css" />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/bootmetro-tiles.css" />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/bootmetro-charms.css" />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/icomoon.css" />
    <link rel="stylesheet" type="text/css" href="bootmetro-0.6.0/content/css/metro-ui-light.css" />
    <link rel="stylesheet" href="styles/lib/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="styles/lib/styles.css" />
    <link rel="stylesheet" href="styles/lib/datepicker.css" />
    <link rel="stylesheet" href="recorridoMovil/estilo.css" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/blitzer/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="recorridoMovil/jquery-ui-timepicker-addon.css" />
    <link rel="stylesheet" type="text/css" href="sidebar/css/default.css" />
    <link rel="stylesheet" type="text/css" href="sidebar/css/component.css" />


    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.5/src/infobox.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.rightClick.js"></script>
    <script src="js/dropdown.js"></script>
    <script type="text/javascript" src="js/jquery.timer.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="recorridoMovil/jquery-ui-timepicker-addon.js"></script>
    <script src="js/underscore-min.js"></script>
    <script src="bootmetro-0.6.0/scripts/modernizr-2.6.1.min.js"></script>

    <?php

    include('php/funcionesEncriptacion.php');
    include('php/seguridad.php');

    $usuario = existeUsuarioEnBD();
    $pIdEnc = $_GET["pId"];
    $pId = decrypt($pIdEnc,"maxo");
    $cOpIdEnc = $_GET["cOp"];
    $cOpId = decrypt($cOpIdEnc,"maxo");

    $vecPermisosNodos = array();

    for ($i = 0; $i <= 7; $i++) {

        $vecPermisosNodos[$i] =	seguridadNodos($i,$usuario);

    }

    $permPoligono = $vecPermisosNodos[5];
    $perm_encriptado = encrypt($permPoligono,"maxo");

    ?>

</head>

<body class="cbp-spmenu-push">

    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <h3>GPShaman</h3>
            <a href="#" id="MOVILES" class="o1">M&oacute;viles</a>
            <a href="#" id="INCIDENTES" class="o2">Incidentes</a>
            <a href="#" id="BASES OPERATIVAS" class="o3">Bases Operativas</a>
            <a href="#" id="PERFILES" class="o5">Perfiles</a>
            <a href="#" id="OTROS" class="o6">Otros</a>
            <a href="#" id="HERRAMIENTAS" class="o4">Herramientas</a>
        </nav>

    <div id="map"></div>

    <div id="loader"></div>
                    

    <div id="modalConsultaServicios" class="modal hide fade span6" style="width:510px;border:1px solid #da4f49" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <div style="text-align:center">
                <span class="label label-important" style="background:#da4f49;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">Consulta de Servicios</span>
            </div>
        </div>
        <div class="modal-body">
            <input type="hidden" id="hidGradoOperativo" value="0" />
            <input type="hidden" id="hidLocalidad" value="0" />
            <input type="hidden" id="hidZona" value="0" />
            <input type="hidden" id="hidCliente" value="0" />
            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span3">
                            <label>Fecha Desde</label>
                            <input type="text" id="fecDesde" class="datepicker inputVisor" />
                        </div>
                        <div class="span3">
                            <label>Fecha Hasta</label>
                            <input type="text" id="fecHasta" class="datepicker inputVisor" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span3">
                            <label>Hora Desde</label>
                            <div class="input-append bootstrap-timepicker">
                                <input id="tpDesde" type="text" />
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                        </div>
                        <div class="span3">
                            <label>Hora Hasta</label>
                            <div class="input-append bootstrap-timepicker">
                                <input id="tpHasta" type="text" />
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span3">
                            <label>Grado Operativo</label>
                            <input type="text" id="txtGradosOperativos" data-provide="typeahead" class="inputVisor" />
                        </div>
                        <div class="span3">
                            <label>Cliente</label>
                            <input type="text" id="txtClientes" data-provide="typeahead" class="inputVisor" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span3">
                            <label>Zona</label>
                            <input type="text" id="txtZonas" data-provide="typeahead" class="inputVisor" />
                        </div>
                        <div class="span3">
                            <label>Localidad</label>
                            <input type="text" id="txtLocalidades" data-provide="typeahead" class="inputVisor" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <div style="text-align:center">
                <div class="btn-group">
                    <button class="btn btn-danger" style="color:white" onclick="setServicios()">Aceptar</button>
                    <button class="btn btn-danger" style="color:white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalMenu" class="modal hide fade span6" style="width:510px;border:1px solid #da4f49" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <ul class="nav nav-list" id="listModalMenu"></ul>
        </div>
        <div class="modal-footer"></div>
    </div>

    <div id="modalRecorridoMovil" class="modal hide fade span6" style="border:1px solid #da4f49" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <div style="text-align:center">
                <span class="label label-important" style="background:#da4f49;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">Recorrido de m&oacute;vil</span>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span3">
                            <label>Fecha Desde</label>
                            <input type="text" id="fecRecorridoDesde" class="datepicker inputVisor" />
                        </div>
                        <div class="span3">
                            <label>Fecha Hasta</label>
                            <input type="text" id="fecRecorridoHasta" class="datepicker inputVisor" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="span6">
                    <div class="row">
                        <div class="span2">
                            <label>Hora Desde</label>
                            <div class="input-append bootstrap-timepicker">
                                <input id="tpRecorridoDesde" type="text" style="width:130px" />
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                        </div>
                        <div class="span2">
                            <label>Hora Hasta</label>
                            <div class="input-append bootstrap-timepicker">
                                <input id="tpRecorridoHasta" type="text" style="width:130px" />
                                <span class="add-on">
                                    <i class="icon-time"></i>
                                </span>
                            </div>
                        </div>
                        <div class="span2">
                            <label>M&oacute;vil</label>
                            <input type="text" id="txtMovilRecorrido" class="inputVisor" style="width:155px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div style="text-align:center">
                <div class="btn-group">
                    <button class="btn btn-danger" style="color:white" onclick="setRecorridoMovil()">Aceptar</button>
                    <button class="btn btn-danger" style="color:white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="bootmetro-0.6.0/scripts/google-code-prettify/prettify.js"></script>
    <script type="text/javascript" src="bootmetro-0.6.0/scripts/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="bootmetro-0.6.0/scripts/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="bootmetro-0.6.0/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootmetro-0.6.0/scripts/bootmetro.js"></script>
    <script type="text/javascript" src="bootmetro-0.6.0/scripts/bootmetro-charms.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
    <script src="js/spin.min.js"></script>
    <script>


	//SETEO DATOS INICIALES DE LA APLICACION

	var usuario = "<?php echo $usuario ; ?>";
	var usuarioEnc = "<?php echo $_GET["usrId"]; ?>";
	var vecPuntos = []; //vector de puntos para el recorrido del movil

	var repoPuntos = new google.maps.Polyline({
    		strokeColor: "#FF0000",   //creo la polilinea
		strokeOpacity: 1.0,
   		strokeWeight: 3
 	});

	var vecPolylines = [];
	var vecURL = [];
	var vecSecundario = [];
	var directionsService = new google.maps.DirectionsService();
	var vecDirections = [];
	var gmarkers = [];
	idxMarkers = 0;
	var ib;
	var rendererOptions = {
		map: map,
		preserveViewport: true,
		suppressMarkers : true
	}
	var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
	var cLog;
	var latlng = new google.maps.LatLng(-34.607497,-58.381742);
	var myOptions = {
		zoom: 11,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById("map"),myOptions);

	setInitialData();

	/***********************************************************************/


	function setInitialData() {

		setSpinner();

		setAjaxLoader();

		//vector donde guardo todas las opciones seleccionadas . Ej. Moviles UTIM, Incidentes rojos.
		vSeleccion = [];

		setInfoByURL();

		/*****************************************************/

		//Funcion para remover objeto de un array
		Array.prototype.remove = function(from, to) {
			var rest = this.slice((to || from) + 1 || this.length);
			this.length = from < 0 ? this.length + from : from;
			return this.push.apply(this, rest);
		};

		/*****************************************************/
		//Defino que hacer cuando hago click en una opcion de uno de los menus (Incidentes,Moviles,Etc)
		$(document).on("click","ul.nav > li > a",function(e) {
			e.preventDefault();
			var idOpc = $(this).attr("id");
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
				if (elementoNormal()) borroOpcionDelVector(idOpc);
				//hago clearOverlays y vuelvo a generar todos los markers que esten en el vector
			} else {
				$(this).addClass("active");
				if (elementoNormal()) vSeleccion.push({ID: idOpc, Opcion: optSelected});
				getSetPosicionEnMapa(idOpc,optSelected);
				//genero los markers de esta opcion
			}
		});

		/*****************************************************/
		//Defino el evento para el rightclick en el mapa
		google.maps.event.addListener(map, "rightclick", function(event) {

			repoPuntos.setMap(null);

			vecPuntos = [];

			clearOverlays();
			clearSeleccion();

		});

		/*****************************************************/
		//focus txtbox grado cuando abro popup consulta de servicios
		$('#modalConsultaServicios').on('shown',function(e){

			setTimeout(function() {
				$('#txtGradosOperativos').focus();
			}, 10);

		});

		/*****************************************************/
		//focus txtbox numero de movil cuando abro popup recorrido de movil
		$('#modalRecorridoMovil').on('shown',function(e){

			setTimeout(function() {
				$('#txtMovilRecorrido').focus();
			}, 10);

		});

		/*****************************************************/

		$('.metro').metro();

		/*****************************************************/
		//Seteo los controles date/time del popup de consulta de servicios y recorrido de movil

		$('#fecDesde,#fecRecorridoDesde').datepicker({
			format: 'dd/mm/yyyy'
		});

		$('#fecHasta,#fecRecorridoHasta').datepicker({
			format: 'dd/mm/yyyy'
		});

		$('#tpDesde,#tpRecorridoDesde').timepicker({
			showMeridian : false
		});

		$('#tpHasta,#tpRecorridoHasta').timepicker({
			showMeridian : false
		});

		/*****************************************************/

		//Seteo todos los datos de los typeahead, voy a buscarlos a la base de datos.
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: 'ConsultaServicios.php?opt=0',
			success: function(datos){

				var grados = JSON.parse(datos.grados);
				var localidades = JSON.parse(datos.localidades);
				var clientes = JSON.parse(datos.clientes);
				var zonas = JSON.parse(datos.zonas);

				setDataTypeahead('txtGradosOperativos',grados,'hidGradoOperativo');
				setDataTypeahead('txtLocalidades',localidades,'hidLocalidad');
				setDataTypeahead('txtClientes',clientes,'hidCliente');
				setDataTypeahead('txtZonas',zonas,'hidZona');

			}
		});

		/*****************************************************/
		//Si hago click en cada elemento, abro el menu pasandole el id y la opción. Muestro el menu dinamicamente
		$('.cbp-spmenu-left > a').click(function(e){

			var opt = $(this).attr("class");
			optSelected = $(this).attr("id");
			stopOrStartTimer();
			muestroListaMenu(opt,optSelected);

		});

		/*****************************************************/
		//Abro popup de recorrido de movil

		$(document).on('click','#recMoviles',function(e){

			clearModalRecorridoMovil();
			$('#modalMenu').modal('hide');
			$('#modalRecorridoMovil').modal('show');
		});

		/*****************************************************/
		//Abro popup de consulta de servicios

		$(document).on('click','#cServ',function(e){

			clearModalConsultaServicios();
			$('#modalMenu').modal('hide');
			$('#modalConsultaServicios').modal('show');
		});

		/*****************************************************/
		//Abro pagina de georeferenciacion de panamericana, acceso oeste, etc.
		$(document).on('click','#geoRef',function(e){

			var permEncriptado = '<?php echo $perm_encriptado ; ?>' ;

			var url = "georeferencioRutas/index.php?usrId=" + usuarioEnc + "&pPerm=" + permEncriptado ;

            //console.log(<?php echo $permPoligono ; ?>);
			window.location.href = url;

		});

		/*****************************************************/
		//Abro pagina de zonas de cobertura
		$(document).on('click','#geoPol',function(e){

			var permEncriptado = '<?php echo $perm_encriptado ; ?>' ;

			var url = "poligono/poligonoV3.php?usrId=" + usuarioEnc + "&pPerm=" + permEncriptado ;

			window.location.href = url;

		});

		/*****************************************************/
		//Funcion para el array
		if(!Array.indexOf){
			Array.prototype.indexOf = function(obj){
				for(var i=0; i<this.length; i++){
					if(this[i]==obj){
						return i;
					}
				}
			return -1;
			}
		}

		/*****************************************************/
		//Seteo el timer para que vaya actualizando los marcadores en mapa
		timer = $.timer(function() {
			clearOverlays();
			setAllDataOnMap();
		});

		timer.set({ time : 30000, autostart : true });

	}

	function elementoNormal() {

		var vBool = true;
		switch (optSelected) {

			case 'HERRAMIENTAS':
				vBool = false;
			break;

		}

		return vBool;

	}

	function clearModalConsultaServicios() {

		$('#modalConsultaServicios input[type="text"]').each(function(e){

			$(this).val('');

		});

		setInitialConfDateTime();

	}

	function clearModalRecorridoMovil() {

		$('#fecRecorridoDesde,#fecRecorridoHasta').val(getDiaActual());
		$('#tpRecorridoDesde').val('00:00');
		$('#tpRecorridoHasta').val('23:59');

	}

	function setInitialConfDateTime() {

		$('#fecDesde,#fecHasta').val(getDiaActual());
		$('#tpDesde').val('00:00');
		$('#tpHasta').val('23:59');

	}

	function getSetPosicionEnMapa(id,opt) {

		$.ajax({
			type: 'GET',
			dataType : 'json',
			url : 'getPosiciones.php?opt='+opt+'&pTipo='+id,
			success : function(posiciones) {

				setMarkers(posiciones);

			},
            error : function(data) {
                console.log('Error en la llamada ajax. Posible problema para el broken javascript');
            },
		});

	}

	function setMarkers(posiciones) {

		var latitud,longitud,imagen,shadow,htmlInfo,punto;

		for (var i = 0; i < posiciones.length ; i++) {

			latitud = posiciones[i].Latitud;
			latitud = latitud.replace(",",".");
			latitud = parseFloat(latitud);
			longitud = posiciones[i].Longitud;
			longitud = longitud.replace(",",".");
			longitud = parseFloat(longitud);
			imagen = posiciones[i].Imagen;
			shadow = posiciones[i].Shadow;
			htmlInfo = posiciones[i].HtmlInfo;
			punto = new google.maps.LatLng(latitud,longitud);
			createMarker(punto,imagen,shadow,htmlInfo);
		}
	}

	function stopOrStartTimer() {

		if (elementoNormal()) {

			timer.set({ time : 60000, autostart: true });

		} else {

			clearOverlays();
			clearSeleccion();
			timer.stop();
		}

	}

	function setSpinner() {

		spinnerOpciones = {
			  lines: 13, // The number of lines to draw
			  length: 20, // The length of each line
			  width: 10, // The line thickness
			  radius: 30, // The radius of the inner circle
			  corners: 1, // Corner roundness (0..1)
			  rotate: 0, // The rotation offset
			  direction: 1, // 1: clockwise, -1: counterclockwise
			  color: '#da4f49', // #rgb or #rrggbb
			  speed: 1, // Rounds per second
			  trail: 60, // Afterglow percentage
			  shadow: false, // Whether to render a shadow
			  hwaccel: false, // Whether to use hardware acceleration
			  className: 'spinner', // The CSS class to assign to the spinner
			  zIndex: 2e9, // The z-index (defaults to 2000000000)
			  top: '150px', // Top position relative to parent in px
			  left: 'auto' // Left position relative to parent in px
		};

		targetSpinner = document.getElementById('loader');

	}

	function setAjaxLoader() {

		$(document).ajaxStart(function() {
			spinner = new Spinner(spinnerOpciones).spin(targetSpinner);
		});

		$(document).ajaxStop(function() {
			spinner.stop();
		});
	 }

	function muestroListaMenu(opt,title){

		$.ajax({					//Obtengo opt, y asi voy a php y traigo los datos dependiendo de lo que le pase.
			type : 'GET',			//Cargo los menu de las opciones.
			dataType : 'json',
			url: 'php/qOpcionesVisualizacion.php?opt='+opt,
			success: function(datos){

				var htmlLista = '<li class="nav-header" >'+title+'</li><li class="divider"></li>'
				for (var i = 0; i < datos.length ; i++) {
					if (opcionEstaSeleccionada(datos[i].ID)) {
						htmlLista = htmlLista + '<li><a class="active" id="'+datos[i].ID+'" href="#">'+datos[i].Descripcion+'</a></li>';
					} else {
						htmlLista = htmlLista + '<li><a id="'+datos[i].ID+'" href="#">'+datos[i].Descripcion+'</a></li>';
					}
				}

				$('#listModalMenu').html(htmlLista);
				$('#modalMenu').modal('show');

			}
		});
	}

	function borroOpcionDelVector(id) {

		var vBool = false;
		for (var i = 0; i < vSeleccion.length; i++) {

			if ((vSeleccion[i].ID === id) && (vSeleccion[i].Opcion === optSelected) && (!vBool)) {

				vSeleccion.remove(i);
				vBool = true;

			}

		}
		clearOverlays();
		setAllDataOnMap();

	}

	function opcionEstaSeleccionada(id) {

		var vBool = false;
		for (var i = 0; i < vSeleccion.length; i++) {

			if ((vSeleccion[i].ID === id) && (vSeleccion[i].Opcion === optSelected)) vBool = true;

		}

		return vBool;

	}

	function setDataTypeahead(idInput,jsonObject,hiddenInput) {

		//Obtengo el Id y Descripcion de cada json object y lo pongo en el typeahead. Cuando selecciono
		//un campo, me deja el id en el respectivo hidden para despues ir a la consulta final

		$('#'+idInput).typeahead({
			source: function(query, process) {
				objects = [];
				mapObject = {};
				var data =  jsonObject;
				$.each(data, function(i, object) {
					mapObject[object.Descripcion] = object;
					objects.push(object.Descripcion);
				});
				process(objects);
			},
			updater: function(item) {
				$('#'+hiddenInput).val(mapObject[item].ID);
				return item;
			}
		});
	}

	function setServicios() {
																//Dependiendo de los datos y filtros ingresados, voy a la base de datos
		var zonaId = $('#hidZona').val();						//y traigo las lat/long pedidas.
		var clienteId = $('#hidCliente').val();
		var localidadId = $('#hidLocalidad').val();
		var gradosId = $('#hidGradoOperativo').val();
		var fDesde = getFechaSQL($('#fecDesde').val());
		var fHasta = getFechaSQL($('#fecHasta').val());
		var hDesde = $('#tpDesde').val();
		var hHasta = $('#tpHasta').val();

		var url = "ConsultaServicios.php?opt=1";
		if ($('#txtZonas').val() !== '') url = url + '&zonaId=' + zonaId;
		if ($('#txtLocalidades').val() !== '') url = url + '&locId=' + localidadId;
		if ($('#txtClientes').val() !== '') url = url + '&cliId=' + clienteId;
		if ($('#txtGradosOperativos').val() !== '') url = url + '&gradoId=' + gradosId;
		url = url + '&fDesde='+fDesde+'&fHasta='+fHasta+'&hDesde='+hDesde+'&hHasta='+hHasta;

		$.ajax({
			type: 'GET',
			dataType: 'json',
			url : url,
			success: function(servicios){

				creoServiciosEnMapa(servicios);
				$('#modalConsultaServicios').modal('hide');

			}
		});
	}

	function setAllDataOnMap() {

		clearOverlays();

		for (var i = 0; i < vSeleccion.length; i++ ) {

			getSetPosicionEnMapa(vSeleccion[i].ID,vSeleccion[i].Opcion);

		}

	}

	function creoServiciosEnMapa(servicios) {

		var point = "";								//parseo el JSON de las latitudes/longitudes, y creo un marcador para cada una de ellas.
		var latitud = "";
		var longitud = "";
		var grado = "";
		var cliente = "";
		for (var i = 0; i < servicios.length; i++) {

			latitud = servicios[i].Latitud.replace(",",".");
			longitud = servicios[i].Longitud.replace(",",".");
			point = new google.maps.LatLng(latitud,longitud);
			createMarker(point,servicios[i].Imagen,servicios[i].Shadow,servicios[i].HtmlInfo);

		}
	}

	function getFechaSQL(fecha) {

		var vFecha = fecha.split("/");			//Seteo la fecha para guardarla en la base de datos
		var dia = vFecha[0];
		var mes = vFecha[1];
		var anio = vFecha[2];
		var fechaSQL = anio + mes + dia;
		return fechaSQL;

	}

	function getDiaActual() {

		var hoy = new Date();						//Obtengo el dia actual en formato no javascript.
		var mes = hoy.getMonth() + 1;
		var dia = hoy.getDate();
		var anio = hoy.getFullYear();
		if (dia < 10) dia = '0'+dia;
		if (mes < 10) mes = '0'+mes;
		hoy = dia + '/' + mes + '/' + anio;
		return hoy;

	}

	function clearSeleccion() {

		for (var i = 0; i < gmarkers.length ; i++) {

			gmarkers[i].setMap(null);

	 	}

		while (vSeleccion[0]) {

			vSeleccion.pop();

		}

	}

	function clearOverlays() {

      	for (var i = 0; i < gmarkers.length ; i++) {

			gmarkers[i].setMap(null);

	 	}

		for (var i = 0; i < vecDirections.length; i++) {

			vecDirections[i].setMap(null);

		}

		while (vecDirections[0]) {

			vecDirections.pop();

		}

		for (var i = 0; i < vecPolylines.length; i++) {

			vecPolylines[i].setMap(null);
		}

		while (vecPolylines[0]) {

			vecPolylines.pop();
		}

		repoPuntos.setMap(null);

		vecPuntos = [];

	}

	function createMarker(point,imagen,pShadow,datos) {

	   // alert(map.getZoom());
		var myLatLng = point;
		var shadow = new google.maps.MarkerImage(pShadow,
		new google.maps.Size(37, 32),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 32));
		imagen = "images/" + imagen;
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			icon: imagen,
			zIndex: 1
		});

		var boxText = document.createElement("div");
		boxText.style.cssText = "border: 2px solid black; margin-top: 8px; background: white; text-align:center;height:90px; padding: 5px;";
		boxText.innerHTML = datos;

		var myOptions = {
			content: boxText
			,disableAutoPan: false
			,maxWidth: 0
			,pixelOffset: new google.maps.Size(-140, 0)
			,zIndex: null
			,boxStyle: {
			opacity: 0.75
			,width: "280px"
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

		gmarkers[idxMarkers] = marker;

		idxMarkers++;

	}

	function renderDirections(result) {
		var directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);
		directionsRenderer.setMap(map);
		directionsRenderer.setDirections(result);
		vecDirections.push(directionsRenderer);
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

	function setRecorridoMovil(){

		var fDesde = $('#fecRecorridoDesde').val();
		var fHasta = $('#fecRecorridoHasta').val();
		var hDesde = $('#tpRecorridoDesde').val();
		var hHasta = $('#tpRecorridoHasta').val();
		var mov = $('#txtMovilRecorrido').val();
		var anio,mes,dia;
		vDesde = [];
		vDesde = fDesde.split("/");
		anio = vDesde[2];
		mes = vDesde[1];
		dia = vDesde[0];
		var fTotalDesde = anio + '-' + mes + '-' + dia + ' ' + hDesde;
		vHasta = [];
		vHasta = fHasta.split("/");
		anio = vHasta[2];
		mes = vHasta[1];
		dia = vHasta[0];
		var fTotalHasta = anio + '-' + mes + '-' + dia + ' ' + hHasta;

		procesoRecorrido(fTotalDesde,fTotalHasta,mov);


	}

	function procesoRecorrido(fecDesde,fecHasta,nroMovil) {

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

				for (var i = 0; i < datos.length ; i++) {

					var vecPunto = datos[i].split("/");
					var lat = vecPunto[0];
					var lng = vecPunto[1];
					var hora = vecPunto[2];
					var vel = vecPunto[3];
					var punto = new google.maps.LatLng(lat,lng);
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

				$('#modalRecorridoMovil').modal('hide');

			}

		});

	}

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

		gmarkers[idxMarkers] = marker;

		idxMarkers++;

	}

	function setInfoByURL() {

		<?php

        if (isset($_GET["opc"])) {

            $opcEnc = $_GET["opc"];
            $opc = decrypt($opcEnc,"maxo");

            $refId = $_GET["refId"];
            //$refId = decrypt($refIdEnc,"maxo");
            //echo $refId;

				?>
				var opc = <?php echo $opc ; ?>;
				var refId = <?php echo $refId; ?>;

				switch (opc) {

					case 0:
						vSeleccion.push({ID: refId, Opcion: 'MOVILES'});
						getSetPosicionEnMapa(refId,'MOVILES');
					break;

					case 1:
						vSeleccion.push({ID: refId, Opcion: 'INCIDENTES'});
						getSetPosicionEnMapa(refId,'INCIDENTES');
					break;

					case 2:
						vSeleccion.push({ID: refId, Opcion: 'BASES OPERATIVAS'});
						getSetPosicionEnMapa(refId,'BASES OPERATIVAS');
					break;

					case 3:
						vSeleccion.push({ID: refId, Opcion: 'PERFILES' });
						getSetPosicionEnMapa(refId,'PERFILES');
					break;

					case 40:
						vSeleccion.push({ID: 'pNosoc', Opcion: 'OTROS'});
						getSetPosicionEnMapa('pNosoc','OTROS');
					break;

					case 41:
						vSeleccion.push({ID: 'pEmpresas', Opcion: 'OTROS'});
						getSetPosicionEnMapa('pEmpresas','OTROS');
					break;

					case 42:
						vSeleccion.push({ID: 'pCartilla', Opcion: 'OTROS'});
						getSetPosicionEnMapa('pCartilla','OTROS');
					break;

					case 50:
						<?php
            $usrId = '$_GET["usrId"]';
						?>
						var usrId = '<?php echo $usrId ; ?>';
						var perm  = '<?php echo $perm_encriptado ; ?>';
						window.location.href =  "georeferencioRutas/index.php?usrId="+usrId+"&pPerm="+perm;
					break;

					case 51:
						<?php
            $usrId = '$_GET["usrId"]';
						?>
						var usrId = '<?php echo $usrId ; ?>';
						var perm  = '<?php echo $perm_encriptado ; ?>';
						window.location.href =  "poligono/poligonoV3.php?usrId="+usrId+"&pPerm="+perm;
					break;

					case 52:

						<?php


            if (isset($_GET["fecHoraDesde"])) {

                $fecHoraDesdeEnc = $_GET["fecHoraDesde"];
                $fecHoraDesde = decrypt($fecHoraDesdeEnc,"maxo");

                $fecHoraHastaEnc = $_GET["fecHoraHasta"];
                $fecHoraHasta = decrypt($fecHoraHastaEnc,"maxo");

                $movEnc = $_GET["mov"];
                $mov = decrypt($movEnc,"maxo");

                ?>


                        var fecHoraDesde = '<?php echo $fecHoraDesde ?>';
						var fecHoraHasta = '<?php echo $fecHoraHasta ?>';
						var mov = '<?php echo $mov ?>';

						fecHoraDesde = fecHoraDesde.substring(0,16);
						fecHoraHasta = fecHoraHasta.substring(0,16);

						procesoRecorrido(fecHoraDesde,fecHoraHasta,mov);

                         <?php

            }
                           ?>





					break;

					}

				<?php
        }

		?>

	}

    </script>
    <script src="sidebar/js/classie.js"></script>
        <script>

function HomeControl(controlDiv, map) {

  // Set CSS styles for the DIV containing the control
  // Setting padding to 5 px will offset the control
  // from the edge of the map.
  controlDiv.style.padding = '5px';

  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = 'white';
  controlUI.style.borderStyle = 'solid';
  controlUI.style.color = "#da4f49";
  controlUI.style.borderWidth = '2px';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '12px';
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = '<strong>Opciones</strong>';
  controlUI.appendChild(controlText);

  google.maps.event.addDomListener(controlUI, 'click', function() {
    setSideBar();
  });

}

function setSideBar() {
        classie.toggle( body, 'cbp-spmenu-push-toright' );
        classie.toggle( menuLeft, 'cbp-spmenu-open' );
}

var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),          
body = document.body;

setSideBar();

var homeControlDiv = document.createElement('div');
var homeControl = new HomeControl(homeControlDiv, map);

homeControlDiv.index = 1;
map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(homeControlDiv);

</script>
</body>
</html>
