<?php
require 'config.php';

$sql = "SELECT * FROM tbl_gps WHERE 1";
$result = $db->query($sql);
if (!$result) {
  echo "Erro: " . $sql . "<br>" . $db->error;
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<html>
<head>
<title>Google Maps</title>
</head>
<style>
body {
	font-family: Arial;
}

#map-layer {
	margin: 20px 0px;
	max-width: 700px;
	min-height: 400;
}
</style>
<body>
	<h1>Google Maps</h1>
	<div id="map-layer"></div>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1yi8sZpqh3qiE7iRlBjqkDb48mG6kbyg&callback=initMap" async defer></script>
		
    <script>
      var map;
      function initMap() {
        
        var mapLayer = document.getElementById("map-layer");
		var centerCoordinates = new google.maps.LatLng(-22.331565, -47.385840);
		var defaultOptions = { center: centerCoordinates, zoom: 10 }

		map = new google.maps.Map(mapLayer, defaultOptions);

        <?php foreach($rows as $location){ ?>
        var location = new google.maps.LatLng(<?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>);
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        <?php } ?>
        
      }
    </script>
</body>
</html>
