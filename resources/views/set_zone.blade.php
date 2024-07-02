<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Définir la Zone de Couverture</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Définir la Zone de Couverture</h1>
        <div id="map" style="height: 500px;"></div>
        <form action="{{ route('coverage_zone.store') }}" method="POST">
            @csrf
            <input type="hidden" id="zone_coordinates" name="zone_coordinates">
            <button type="submit" class="btn btn-primary mt-3">Enregistrer la Zone</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            var drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: {
                    polygon: true,
                    marker: false,
                    polyline: false,
                    circle: false,
                    rectangle: false,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);

            map.on(L.Draw.Event.CREATED, function (event) {
                var layer = event.layer;
                drawnItems.addLayer(layer);
                var coordinates = layer.toGeoJSON().geometry.coordinates;
                document.getElementById('zone_coordinates').value = JSON.stringify(coordinates);
            });
        });
    </script>
</body>

</html>