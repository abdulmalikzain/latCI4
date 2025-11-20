<!DOCTYPE html>
<html lang="en">

<head>
    <title>Siranah | Satpol PP Jateng</title>
    <link href="<?= base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-light topbar static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 " style="color: #fc4e2a;">
            <h5>Sistem Informasi Rawan Kebakaran</h5>
        </div>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link " href="<?= base_url('login') ?>"
                    aria-haspopup="true" aria-expanded="false">
                    <button class="btn btn-outline-danger w-100" type="submit"><i class="fas fa-fw fa-user"></i> Login</button>
                </a>
            </li>
        </ul>

    </nav>

    <!-- map -->
    <div id="map" style="width: 100%; height: 90vh;"></div>
    <!-- Spinner overlay -->
    <div id="loading-spinner">
        <div class="spinner-border text-light" role="status" style="margin-right: 10px;"></div>
        Memuat data...
    </div>

    <script>
        // Ambil data dari PHP ke JavaScript
        // Ubah array PHP ke JSON agar bisa dibaca JavaScript
        let jumlahKotaKecamatan = <?= json_encode($jumlahKotaKecamatan) ?>;

        const spinner = document.getElementById('loading-spinner');

        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        const map = L.map('map', {
            center: [-7.28, 110.34],
            zoom: 9,
            layers: [peta3]
        });

        ///////////filter tanggal
        const DateControl = L.Control.extend({
            options: {
                position: 'topright' // posisi bawaan Leaflet
            },

            onAdd: function(map) {
                const div = L.DomUtil.create('div', 'date-filter-card');
                div.innerHTML = `
                    <label>Pilih Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                    `;

                // Pastikan event click/touch tidak mengganggu interaksi peta
                L.DomEvent.disableClickPropagation(div);

                return div;
            }
        });

        // Tambahkan ke map
        map.addControl(new DateControl());

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
            let contents = 'Arahkan pada Kabupaten/Kota'; // default

            if (props) {
                const kota = props.nm_dati2;

                if (jumlahKotaKecamatan[kota]) {
                    // Ambil semua kecamatan dan jumlah laporan
                    const dataKecamatan = jumlahKotaKecamatan[kota];
                    let list = '';

                    for (const kec in dataKecamatan) {
                        list += `<li>${kec}: ${dataKecamatan[kec]} laporan</li>`;
                    }

                    contents = `
                <b>${kota}</b><br />
                <ul style="margin:0; padding-left:16px;">
                    ${list}
                </ul>
            `;
                } else {
                    // Jika data kota tidak ditemukan
                    contents = `<b>${kota}</b><br />Data Kosong`;
                }
            }

            this._div.innerHTML = `<h4>Data Kebakaran</h4>${contents}`;
        };

        info.addTo(map);

        // Daftar file GeoJSON
        const geojsonFiles = [
            '33.01_Cilacap.geojson',
            '33.02_Banyumas.geojson',
            '33.03_Purbalingga.geojson',
            '33.04_Banjarnegara.geojson',
            '33.05_Kebumen.geojson',
            '33.06_.geojson',
            '33.07_Wonosobo.geojson',
            '33.08_Magelang.geojson',
            '33.09_Boyolali.geojson',
            '33.10_Klaten.geojson',
            '33.11_Sukoharjo.geojson',
            '33.12_Wonogiri.geojson',
            '33.13_Karanganyar.geojson',
            '33.14_Sragen.geojson',
            '33.15_Grobogan.geojson',
            '33.16_Blora.geojson',
            '33.17_Rembang.geojson',
            '33.18_Pati.geojson',
            '33.19_Kudus.geojson',
            '33.20_Jepara.geojson',
            '33.21_Demak.geojson',
            '33.22_Semarang.geojson',
            '33.23_Temanggung.geojson',
            '33.24_Kendal.geojson',
            '33.25_Batang.geojson',
            '33.26_Pekalongan.geojson',
            '33.27_Pemalang.geojson',
            '33.28_Tegal.geojson',
            '33.29_Brebes.geojson',
            '33.71_Kota_Magelang.geojson',
            '33.72_Kota_Surakarta.geojson',
            '33.75_Kota_Pekalongan.geojson',
            '33.74_Kota_Semarang.geojson',
            '33.73_Kota_Salatiga.geojson',
            '33.76_Kota_Tegal.geojson',
        ];

        // Simpan semua layer GeoJSON di sini
        let geojsonLayers = []; // 🟢 ganti nama agar tidak bentrok
        let tanggalDipilih = document.getElementById('tanggal').value;

        // Fungsi warna berdasarkan data
        function getColor(d) {
            return d > 500 ? '#800026' :
                // d > 500 ? '#BD0026' :
                d > 100 ? '#E31A1C' :
                // d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                // d > 20 ? '#FEB24C' :
                d > 10 ? '#FED976' : '#fff7d3ff';
        }

        function style(feature) {
            return {
                weight: 3,
                opacity: 1,
                color: '#666',
                // dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(jumlahKotaKecamatan[feature.properties.nm_dati2])
            };
        }

        function highlightFeature(e) {
            const layer = e.target;
            layer.setStyle({
                weight: 5,
                color: 'white',
                dashArray: '',
                fillOpacity: 0.7
            });
            layer.bringToFront();
            info.update(layer.feature.properties);
            // Tambahkan efek "glow" halus
            layer._path.style.filter = "drop-shadow(0 0 5px #FC4E2A)";
        }

        function resetHighlight(e) {
            geojsonLayers.forEach(layer => layer.resetStyle(e.target)); // 🟢 semua layer reset
            info.update();

            // Hapus efek glow
            e.target._path.style.filter = "";
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            const kota = feature.properties.nm_dati2;

            function getPopupContent() {
                let popupContent = `<h4>${kota}</h4>`;
                popupContent += `<small>Data Laporan Kebakaran</small><br>`;
                popupContent += `<small><i>Tanggal: ${tanggalDipilih}</i></small><br>`;

                if (jumlahKotaKecamatan[kota]) {
                    const dataKecamatan = jumlahKotaKecamatan[kota];
                    popupContent += "<ul style='margin:0; padding-left:16px;'>";
                    for (const kec in dataKecamatan) {
                        popupContent += `<li>${kec}: ${dataKecamatan[kec]} laporan</li>`;
                    }
                    popupContent += "</ul>";
                } else if (jumlahKotaKecamatan.status === "kosong") {
                    popupContent += "<i>Tidak ada data </i>";
                } else {
                    popupContent += "<i>Data tidak tersedia untuk kota ini</i>";
                }

                return popupContent;
            }

            // 🟢 Update popup setiap mouseover
            layer.on({
                mouseover: function(e) {
                    const updatedContent = getPopupContent();
                    layer.bindPopup(updatedContent);
                    highlightFeature(e);
                },
                mouseout: resetHighlight,
            });
        }

        // 🔹 Tambahkan semua file GeoJSON ke peta
        async function getGeojson() {
            for (const file of geojsonFiles) {
                try {
                    const res = await fetch(`geokabKota/${file}`);
                    const json = await res.json();

                    const layer = L.geoJson(json, {
                        style: style,
                        onEachFeature: onEachFeature
                    }).addTo(map);

                    geojsonLayers.push(layer); // 🟢 simpan ke array
                } catch (error) {
                    console.error("Gagal load GeoJSON:", error);
                }
            }
        }

        getGeojson();

        document.getElementById('tanggal').addEventListener('change', function() {
            const tanggal = this.value;
            tanggalDipilih = tanggal;
            spinner.style.display = 'block';

            fetch(`/getDataKebakaran?tanggal=${tanggal}`)
                .then(res => res.json())
                .then(data => {
                    jumlahKotaKecamatan = data;
                    console.log("Data baru:", data);

                    info.update();

                    // 🟢 Update semua layer GeoJSON dengan style baru
                    geojsonLayers.forEach(layer => layer.setStyle(style));
                })
                .catch(err => console.error("Fetch error:", err))
                .finally(() => spinner.style.display = 'none');
        });

        const legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {

            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 10, 50, 100, 500];
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

    <!-- jQuery -->
    <script src="<?= base_url(); ?>vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="<?= base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="<?= base_url(); ?>js/sb-admin-2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
</body>



</html>