<!DOCTYPE html>
<html>

<head>
    <title>Définir la Zone de Couverture</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Définir la Zone de Couverture</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div id="map"></div>

        <form action="{{ route('coverage_zone.store') }}" method="POST">
            @csrf
            <input type="text" id="zone_coordinates" name="zone_coordinates">
            <button type="submit" class="btn btn-primary mt-3">Enregistrer la Zone</button>
        </form>
    </div>

    <div>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>Zone de Couverture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                <tr>
                    <td>
                        {{ $zone->vertices }}
                    </td>
                    <td>
                        <form action="{{ route('coverage_zone.destroy', $zone->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>

                </tr>
                @endforeach
            </tbody>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>



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
