<html>
<head>
<title></title>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.5/src/infobox.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript">
var directionDisplay;
var map;
var directionsService = new google.maps.DirectionsService();  
var directionsService1 = new google.maps.DirectionsService();  
var latlng1 = new google.maps.LatLng(-34.626428,-58.522242);
var latlng2 = new google.maps.LatLng(-34.618923,-58.508874);
var latlng3 = new google.maps.LatLng(-34.62053,-58.475614);
var latlng4 = new google.maps.LatLng(-34.631001,-58.457054);
var rendererOptions = {
  map: map,
}
directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
directionsDisplay1 = new google.maps.DirectionsRenderer(rendererOptions);
 var myOptions = {
      zoom: 13,
      center: latlng1,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
      
      
$(document).ready(function(e) {
 map = new google.maps.Map(document.getElementById("map"),myOptions);
$('#map').css("width","500px").css("height","500px");


requestDirections(latlng1,latlng2);
requestDirections(latlng3,latlng4);

 }); 
 
 

    function renderDirections(result) {
      var directionsRenderer = new google.maps.DirectionsRenderer;
      directionsRenderer.setMap(map);
      directionsRenderer.setDirections(result);
    }


    function requestDirections(start, end) {
      directionsService.route({
        origin: start,
        destination: end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
      }, function(result) {
        renderDirections(result);
      });
    }
    






</script>
</head>
<body>


<div id="map"></div>



</body>
</html>