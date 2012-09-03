<?php
require_once("gMaps.php");
// Instancia a classe
$gmaps = new gMaps();
$endereco = $_GET['endereco'];
$cidade = $_GET['cidade'];
$uf = $_GET['uf'];
$cep = $_GET['cep'];
$bairro = $_GET['bairro']!="" ? ' - '.$_GET['bairro'] : '';
// Pega os dados (latitude, longitude e zoom) do endereço:
$endereco = $endereco.$bairro.', '.$cidade.', '.$uf;
$dados = $gmaps->geolocal($endereco);
if($dados['lat']==""){ echo '<BR/><BR/><BR/><div align=center>Endereço inexistente.</div>'; }
else {
// Exibe os dados encontrados:
//print_r($dados);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API v3 Example: Directions Draggable</title>
<link href="https://google-developers.appspot.com/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&language=pt-br&region=BR"></script>
<script type="text/javascript">

  var rendererOptions = {
    draggable: true
  };
  var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
  var directionsService = new google.maps.DirectionsService();
  var map;

  var australia = new google.maps.LatLng(<?php echo $dados['lat']; ?>, <?php echo $dados['lon']; ?>);

  function initialize() {

    var myOptions = {
      zoom: 7,
      mapTypeId: google.maps.MapTypeId.HYBRID,
      center: australia
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));

    google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
      computeTotalDistance(directionsDisplay.directions);
    });
    
    calcRoute();
  }

  function calcRoute() {

    var request = {
      origin: "Comercial de Tecidos Pauluk - Avenida Dom Pedro II, Ponta Grossa - Parana, Brasil",
      destination: "<?php echo $endereco ?>",
      waypoints:[{location: "Comercial de Tecidos Pauluk - Avenida Dom Pedro II, Ponta Grossa - Parana, Brasil"}, {location: "<?php echo $endereco ?>"}],
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }

  function computeTotalDistance(result) {
    var total = 0;
    var myroute = result.routes[0];
    for (i = 0; i < myroute.legs.length; i++) {
      total += myroute.legs[i].distance.value;
    }
    total = total / 1000.
    document.getElementById("total").innerHTML = total + " km";
  }   
</script>
</head>
<body onload="initialize()">
<div id="map_canvas" style="float:left;width:70%; height:100%"></div>
<div id="directionsPanel" style="float:right;width:30%;height 100%">
<p>Distancia Total: <span id="total"></span></p>
</div>
</body>
</html>

<?php } ?>