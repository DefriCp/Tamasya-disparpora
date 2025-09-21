// Deklarasikan variabel 'map' di luar event listener
// agar bisa diakses secara global dalam scope ini.
// var map;
// var kecamatanLayer; // simpan layer kecamatan
// var desaLayer; // nanti buat desa kalau ada
window.map = null;
window.kecamatanLayer = null;
window.desaLayer = null;

document.addEventListener("DOMContentLoaded", function () {
    if (map != undefined) {
        map.remove();
    }

    map = L.map("map", {
        attributionControl: false,
        zoomControl: false,
        maxZoom: 20,
        minZoom: 9,
    }).setView([-7.4505, 108.2172], 10);

    var warnaList = [
        "#e6194b", "#3cb44b", "#ffe119", "#4363d8", "#f58231", "#911eb4",
        "#46f0f0", "#f032e6", "#bcf60c", "#fabebe", "#008080", "#e6beff",
        "#9a6324", "#fffac8", "#800000", "#aaffc3", "#808000", "#ffd8b1",
        "#000075", "#808080", "#ffffff", "#000000", "#ff7f0e", "#1f77b4",
        "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f",
        "#bcbd22", "#17becf", "#a6cee3", "#b2df8a", "#fb9a99", "#fdbf6f",
        "#cab2d6", "#6a3d9a", "#ffff99"
    ];

    function styleKecamatan(feature) {
        var nama = feature.properties.WADMKC;
        var index = 0;
        for (var i = 0; i < nama.length; i++) {
            index += nama.charCodeAt(i);
        }
        index = index % warnaList.length;

        return {
            fillColor: warnaList[index],
            weight: 1,
            opacity: 1,
            color: "white",
            fillOpacity: 0.7,
        };
    }

    // === Tambahkan LayerGroup untuk kumpulkan semua marker wisata ===
    // Bersihkan group lama dulu biar gak numpuk
    if (window.wisataMarkers) {
        map.removeLayer(window.wisataMarkers);
    }
    window.wisataMarkers = L.featureGroup().addTo(map);

    fetch("http://127.0.0.1:8000/api/tamasyawisata")
        .then((response) => response.json())
        .then((result) => {
            if (result.data && result.data.length > 0) {
                result.data.forEach((item) => {
                    let lat = parseFloat(item.latitude);
                    let lng = parseFloat(item.longitude);

                    // Debug: cek apakah data koordinat valid
                    console.log("Wisata:", item.nama, lat, lng);

                    if (!isNaN(lat) && !isNaN(lng)) {
                        let marker = L.marker([lat, lng]).addTo(window.wisataMarkers);

                        marker.bindPopup(`
                        <b>${item.nama}</b><br>
                        Desa ${item.desa}, Kec. ${item.kecamatan}<br>
                        <a href="/tamasya-wisata/${item.slug}" target="_blank">Detail</a>
                    `);
                    }
                });

                // Hanya fitBounds kalau ada marker valid
                if (window.wisataMarkers.getLayers().length > 0) {
                    map.fitBounds(window.wisataMarkers.getBounds(), { padding: [50, 50] });
                }
            } else {
                console.warn("Tidak ada data wisata ditemukan");
            }
        })
        .catch((error) => {
            console.error("Gagal ambil data wisata:", error);
        });

    kecamatanLayer = new L.GeoJSON.AJAX("/assets/geojson/kecamatan.geojson", {
        style: styleKecamatan,
    }).addTo(map);

    desaLayer = new L.GeoJSON.AJAX("/assets/geojson/desa.geojson", {
        style: { color: "green", weight: 1 },
    });

    var openstreetMap = L.tileLayer(
        "https://tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }
    );

    var overlays = {
        "Open Street Map": openstreetMap,
    };

    L.control.layers(null, overlays).addTo(map);
});

