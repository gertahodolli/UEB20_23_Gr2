<!DOCTYPE html>
<html>
<head>
    <title>Interactive Route Finder</title>
    <link rel="stylesheet" type="text/css" href="resources/css/direction.css">
    <style>
        .center-text {
            text-align: center;
        }
        .map {
            height: 605px;
            width: 100%;
        }
    </style>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0AHxBCS9tPfSoqIJ9JtS0njZnTmXdbr8&callback=initMap&libraries=places"></script>
    <script>
        var map, directionsService, directionsRenderer;

        function initMap() {
            map = new google.maps.Map(document.querySelector('.map'), {
                zoom: 8,
                center: { lat: 42.602636, lng: 20.902977 }// Center map around Prishtina initially
            });
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
        }
        function calculateAndDisplayRoute() {
            var start = document.getElementById('start').value;
            var end = 'M564+CMP, Luan Haradinaj, Prishtine'; // Fixed destination

            directionsService.route({
                origin: start,
                destination: end,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>
</head>
<body>
<div class="center-text">
<!--    <h2>Route Finder</h2>-->
    <div>
        <b>Start Location:</b>
        <input type="text" id="start" placeholder="Enter your starting location">
        <button onclick="calculateAndDisplayRoute();">Show Route</button>
    </div>
    <div class="map"></div>
</div>
</body>
</html>