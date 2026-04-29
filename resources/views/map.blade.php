@extends('layouts.template')

@section('styles')
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        body,
        html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: calc(100vh - 56px);
            width: 100%
        }
    </style>
@endsection


@section('content')
    <div id="map"></div>

    {{-- Modal Form Input Point --}}
    <div class="modal fade" id="modalInputPoint" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('point.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name here...">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geometry_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-point').src=window.URL.createObjectURL(this.files[0])">
                            <img src=""alt="" id="preview-image-point" class="img-thumbnail" width="400">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Modal Form Input Polyline --}}
    <div class="modal fade" id="modalInputPolyline" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polyline.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name here...">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geometry_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-polyline').src=window.URL.createObjectURL(this.files[0])">
                            <img src=""alt="" id="preview-image-polyline" class="img-thumbnail" width="400">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Modal Form Input Polygon --}}
    <div class="modal fade" id="modalInputPolygon" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name here...">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geometry_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-polygon').src=window.URL.createObjectURL(this.files[0])">
                            <img src=""alt="" id="preview-image-polygon" class="img-thumbnail" width="400">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!--Leaflet JS-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--Leaflet Draw-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <!--Terraformer-->
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        var map = L.map('map').setView([-7.7956, 110.3695], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);


        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({

            position: 'topleft',

            draw: {
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },

            edit: {
                featureGroup: drawnItems
            }

        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            console.log(objectGeometry);

            if (type === 'polyline') {
                console.log("Create " + type);
                //Set value geometry to geometry point textarea
                $('#geometry_polyline').val(objectGeometry);
                //Show Modal Input Point
                $('#modalInputPolyline').modal('show');
                //Modal dissmiss reload page
                $('#modalInputPolyline').on('hidden.bs.modal', function(e) {
                    location.reload();
                });

            } else if (type === 'polygon' || type === 'rectangle') {
                console.log("Create " + type);
                //Set value geometry to geometry point textarea
                $('#geometry_polygon').val(objectGeometry);
                //Show Modal Input Point
                $('#modalInputPolygon').modal('show');
                //Modal dissmiss reload page
                $('#modalInputPolygon').on('hidden.bs.modal', function(e) {
                    location.reload();
                });

            } else if (type === 'marker') {
                console.log("Create " + type);
                //Set value geometry to geometry point textarea
                $('#geometry_point').val(objectGeometry);
                //Show Modal Input Point
                $('#modalInputPoint').modal('show');
                //Modal dissmiss reload page
                $('#modalInputPoint').on('hidden.bs.modal', function(e) {
                    location.reload();
                });


            } else {
                console.log('undefined');
            }

            drawnItems.addLayer(layer);
        });

        // GeoJSON Point
        var points = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                // variable popup content
                var popup_content = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='' class='img-thumbnail' width='400'>";

                layer.on({
                    click: function(e) {
                        points.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson.points') }}",
            function(data) {
                points.addData(data); // Menambahkan data ke dalam GeoJSON Point
                map.addLayer(points); // Menambahkan GeoJSON Point ke dalam peta
            });

        // GeoJSON Polylines
        var polylines = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                // variable popup content
                var popup_content = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='' class='img-thumbnail' width='400'>";

                layer.on({
                    click: function(e) {
                        polylines.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson.polylines') }}",
            function(data) {
                polylines.addData(data); // Menambahkan data ke dalam GeoJSON polylines
                map.addLayer(polylines); // Menambahkan GeoJSON polylines ke dalam peta
            });


        // GeoJSON Polygon
        var polygons = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                // variable popup content
                var popup_content = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='' class='img-thumbnail' width='400'>";

                layer.on({
                    click: function(e) {
                        polygons.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson.polygons') }}",
            function(data) {
                polygons.addData(data); // Menambahkan data ke dalam GeoJSON polygons
                map.addLayer(polygons); // Menambahkan GeoJSON polygons ke dalam peta
            });

        // Control Layer
        var baseMaps = {

        };

        var overlayMaps = {
            "Points": points,
            "Polyline": polylines,
            "Polygon": polygons,
        };

        var controllayer = L.control.layers(baseMaps, overlayMaps);
        controllayer.addTo(map);
    </script>
@endsection
