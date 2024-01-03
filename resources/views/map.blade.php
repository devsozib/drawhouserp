<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Example</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMjnpdDDFwpmOXAyq&callback=initMap" async defer></script>
    <script>
        let map;

        function initMap() {
            // Specify the coordinates where you want to center the map
            const center = { lat: 37.7749, lng: -122.4194 }; // San Francisco, CA

            // Create a new Google Map object
            map = new google.maps.Map(document.getElementById("map"), {
                center: center,
                zoom: 12 // Adjust the zoom level as needed
            });

            // You can add markers, polygons, or other features to the map here
        }
    </script>
</head>
<body>
    <div id="map" style="height: 400px; width: 100%;"></div>
</body>
</html>
