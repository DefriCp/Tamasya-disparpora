

// Deklarasikan variabel 'map' di luar event listener
// agar bisa diakses secara global dalam scope ini.
window.map = null;
window.kecamatanLayer = null;
window.desaLayer = null;

document.addEventListener("DOMContentLoaded", function () {

    // 1. Cek apakah variabel 'map' sudah berisi instance Leaflet
    // Jika iya, hapus peta tersebut dari kontainer.
    if (map != undefined) {
        map.remove();
    }

    // 2. Sekarang buat instance peta yang baru.
    // Pastikan untuk menetapkan hasilnya ke variabel 'map' yang sama.
    map = L.map('map', { // Hapus 'var' agar tidak membuat variabel lokal baru
        attributionControl: false,
        zoomControl: false,
        maxZoom: 20,
        minZoom: 9,
    }).setView([-7.4505, 108.2172], 10);

    // function styleKecamatan(feature) {
    //     return {
    //         fillColor: '#39bc00',
    //         weight: 1,
    //         opacity: 1,
    //         color: 'white',
    //         fillOpacity: 0.7
    //     };
    // }

    // Buat daftar 39 warna (bisa di-generate atau ditentukan manual)
    var warnaList = [
        "#e6194b", "#3cb44b", "#ffe119", "#4363d8", "#f58231",
        "#911eb4", "#46f0f0", "#f032e6", "#bcf60c", "#fabebe",
        "#008080", "#e6beff", "#9a6324", "#fffac8", "#800000",
        "#aaffc3", "#808000", "#ffd8b1", "#000075", "#808080",
        "#ffffff", "#000000", "#ff7f0e", "#1f77b4", "#2ca02c",
        "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f",
        "#bcbd22", "#17becf", "#a6cee3", "#b2df8a", "#fb9a99",
        "#fdbf6f", "#cab2d6", "#6a3d9a", "#ffff99"
    ];

    // Fungsi styling
    function styleKecamatan(feature) {
        // Ambil nama kecamatan atau id (sesuai field di geojson)
        var nama = feature.properties.WADMKC; // ganti sesuai atribut geojson kamu

        // Bikin index konsisten dari nama (hash sederhana)
        var index = 0;
        for (var i = 0; i < nama.length; i++) {
            index += nama.charCodeAt(i);
        }
        index = index % warnaList.length; // hasil index antara 0-38

        return {
            fillColor: warnaList[index],
            weight: 1,
            opacity: 1,
            color: 'white',
            fillOpacity: 0.7
        };
    }

    // Fungsi ambil data API
    fetch("http://172.16.2.111/api/tamasyawisata")
        .then(response => response.json())
        .then(result => {
            if (result.data && result.data.length > 0) {
                result.data.forEach(item => {
                    // Ambil koordinat
                    let lat = parseFloat(item.latitude);
                    let lng = parseFloat(item.longitude);

                    if (!isNaN(lat) && !isNaN(lng)) {
                        // Buat marker
                        var marker = L.marker([lat, lng]).addTo(map);

                        // Isi popup
                        var popupContent = `
                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-sm">
                                <!-- Header dengan gradient cerah -->
                                <div class="bg-gradient-to-r from-sky-200 to-emerald-200 text-gray-800 p-4">
                                    <h3 class="text-lg font-bold mb-1">${item.nama}</h3>
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Desa ${item.desa}, Kec. ${item.kecamatan}
                                    </div>
                                </div>

                                <!-- Gambar utama -->
                                ${item.photo && item.photo.length > 0 ?
                                `<img src="${item.photo[0].photo}" alt="${item.nama}" class="w-full h-48 object-cover">`
                                : '<div class="w-full h-48 bg-gray-100 flex items-center justify-center"><span class="text-gray-400 text-sm">Tidak ada foto</span></div>'
                            }

                                <!-- Konten bawah -->
                                <div class="p-4">
                                    <p class="text-gray-600 text-sm leading-relaxed mb-3">
                                        ${item.daya_tarik_wisata ?? ''}
                                    </p>
                                    
                                    <div class="flex flex-wrap gap-2 items-center justify-center">
                                        ${Array.isArray(item.jenis) ?
                                item.jenis.map(jenis =>
                                    `<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">${jenis}</span>`
                                ).join('')
                                :
                                `<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">${item.jenis || 'Umum'}</span>`
                            }
                                    </div>
                                </div>
                                <a href="/tamasya-wisata/${item.slug}" 
                                    target="_blank"
                                    class="block text-center bg-gradient-to-r from-sky-400 to-emerald-400 text-white font-semibold py-2 px-4 rounded-b-2xl hover:from-sky-500 hover:to-emerald-500 transition duration-300">
                                    Lihat Detail →
                                </a>
                            </div>
                        `;

                        marker.bindPopup(popupContent);
                    }
                });
            }
        })
        .catch(error => {
            console.error("Gagal ambil data wisata:", error);
        });



    var kecamatan = new L.GeoJSON.AJAX("/assets/geojson/kecamatan.geojson", {
        style: styleKecamatan,
    }).addTo(map);




    var openstreetMap = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var overlays = {
        "Open Street Map": openstreetMap,
    };

    L.control.layers(null, overlays).addTo(map);
});

