<!DOCTYPE html>
<html>

<head>
    <title>Définir la Zone de Couverture</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Définir la Zone de Couverture</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div id="map" class="mb-4"></div>

        <form action="{{ route('coverage_zone.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" id="zone_coordinates" name="zone_coordinates">
            <div class="form-group">
                <label for="zone_name">Nom de la Zone de Couverture</label>
                <input type="text" class="form-control" id="zone_name" name="name" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Enregistrer la Zone</button>
            </div>
        </form>

        <div>
            <h2 class="text-center mb-4">Zones de Couverture</h2>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Zone de Couverture</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($zones as $zone)
                    <tr>
                        <td>
                            {{ $zone->name }}
                        </td>
                        <td>
                            <form action="{{ route('coverage_zone.destroy', $zone->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
