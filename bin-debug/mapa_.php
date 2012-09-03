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
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>BONSUCESSO - MAPA</title>
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
  function initialize() {
    var latlng = new google.maps.LatLng(<?php echo $dados['lat']; ?>, <?php echo $dados['lon']; ?>);
    var myOptions = {
      zoom: 12,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
	
	var marker = new google.maps.Marker({
        position: latlng, 
        map: map,
        title:"Hello World!"
    }); 
  }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
<?php } ?>