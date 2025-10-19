<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Scrolling Nav - Start Bootstrap Template</title>
    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            width: 570px;
            height: 350px;
        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 10px;
            opacity: 0.7;
        }
    </style>

</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand navbar-light bg-gradient-edit topbar mb-1 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 ">
            <h5 class="text-white">Sistem Informasi Rawan Kebakaran</h5>
        </div>

    </nav>

    <!-- map -->
    <div id="map" style="width: 100%; height: 90vh;"></div>
    <script>
        // Ambil data dari PHP ke JavaScript
        const data = <?= json_encode($data); ?>;

        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        const map = L.map('map', {
            center: [-7.28, 110.34],
            zoom: 11,
            layers: [peta3]
        });

        // control that shows state info on hover
        const info = L.control({
            position: 'topleft'
        });

        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function(props) {
            const contents = props ? `<b>${props.nm_kecamatan}</b><br />${data[props.nm_kecamatan]} Laporan` : 'Arahkan pada Kecamatan';
            this._div.innerHTML = `<h4>Data Kebakaran</h4>${contents}`;
        };

        info.addTo(map);


        let geojsonLayer = [
            '33.22_kecamatan_kabsemarang.geojson',
            '33.73_kecamatan_salatiga.geojson',
            '33.23_kecamatan_temanggung.geojson'
        ];

        let geojson;


        // get color depending on population density value
        function getColor(d) {
            return d > 1000 ? '#800026' :
                d > 500 ? '#BD0026' :
                d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                d > 20 ? '#FEB24C' :
                d > 10 ? '#FED976' : '#FFEDA0';
        }

        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(data[feature.properties.nm_kecamatan])
            };
        }


        function highlightFeature(e) {
            const layer = e.target;

            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            layer.bringToFront();

            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            if (feature.properties && feature.properties.nm_kecamatan) {
                layer.bindPopup(feature.properties.nm_kecamatan);

            }
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                // click: zoomToFeature
            });
        }

        map.attributionControl.addAttribution('Provinsi Jateng; <a>Data Kebakaran</a>');

        getGeojson = async () => {
            for (i in geojsonLayer) {
                try {
                    let url = `geokecamatan/${geojsonLayer[i]}`;
                    let get = await fetch(url);
                    let json = await get.json();

                    geojson = L.geoJson(json, {
                        style: style,
                        onEachFeature: onEachFeature

                    }).addTo(map);

                } catch (error) {
                    console.error("Gagal load GeoJSON:", error);
                }
            }
        }

        getGeojson();

        const legend = L.control({
            position: 'bottomleft'
        });
        legend.onAdd = function(map) {

            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
            const labels = [];
            let from, to;

            for (let i = 0; i < grades.length; i++) {
                from = grades[i];
                to = grades[i + 1];

                labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
            }

            div.innerHTML = '<strong>Range Data</strong><br>' + labels.join('<br>');
            return div;
        };

        legend.addTo(map);
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>/js/sb-admin-2.min.js"></script>
</body>

</html>