@extends('fe.layouts.main')

@section('content')
{{-- 1. LOAD CSS LEAFLET (Wajib agar peta tidak berantakan) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    /* Fix z-index agar peta tidak menutupi navbar/dropdown */
    .leaflet-pane { z-index: 10; }
    .leaflet-top, .leaflet-bottom { z-index: 20; }
</style>

<section class="container px-4 py-8 md:py-12 mt-20 md:mt-28 mx-auto max-w-7xl">
    
    {{-- HEADER PAGE --}}
    <div class="mb-8 md:mb-12 text-center max-w-3xl mx-auto animate-fade-in">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4 md:mb-6 leading-tight">
            Peta Sebaran <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">
                Wisata Tasikmalaya
            </span>
        </h1>
        <p class="text-gray-600 text-base md:text-lg leading-relaxed">
            Jelajahi potensi wisata Kabupaten Tasikmalaya melalui peta interaktif. Temukan lokasi wisata unggulan di setiap kecamatan.
        </p>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8 relative overflow-hidden">
        {{-- Removed decorative blob for cleaner look --}}
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end relative z-10">
            {{-- Filter Kecamatan --}}
            <div class="md:col-span-5">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Kecamatan</label>
                <div class="relative">
                    <select id="selectKecamatan" onchange="filterByKecamatan()" class="w-full bg-gray-50 text-gray-700 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 appearance-none cursor-pointer">
                        <option value="">Semua Kecamatan</option>
                        @foreach($dataKecamatan as $kec)
                            {{-- Simpan Lat/Long kecamatan di attribut data agar bisa di zoom --}}
                            {{-- Asumsi: Anda punya kolom lat/long di tabel kecamatan, jika tidak ada, script akan default zoom --}}
                            <option value="{{ $kec->id }}" data-lat="-7.358" data-long="108.225">{{ $kec->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            {{-- Filter Desa (Placeholder / Logic Lanjutan) --}}
            <div class="md:col-span-5">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Desa</label>
                <div class="relative">
                    <select id="selectDesa" disabled class="w-full bg-gray-50 text-gray-700 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none disabled:opacity-50">
                        <option value="">Semua Desa</option>
                    </select>
                </div>
            </div>

            {{-- Tombol Reset --}}
            <div class="md:col-span-2">
                <button onclick="resetMap()" class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 font-bold py-3 px-4 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    {{-- CONTENT AREA (Tabel & Peta) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LIST DATA (Kiri) --}}
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden h-[500px] md:h-[600px] flex flex-col order-2 lg:order-1">
            <div class="bg-gradient-to-r from-primary to-green-600 px-6 py-4">
                <h3 class="font-bold text-white text-lg">Data Wilayah</h3>
            </div>
            
            <div class="overflow-y-auto flex-1 p-0 custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3">Nama Kecamatan</th>
                            <th class="px-4 py-3 text-center">Jml</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($dataKecamatan as $kec)
                        <tr class="hover:bg-green-50 transition-colors group">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $kec->nama }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full">
                                    {{ $kec->destinasi_wisata_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{-- Tombol Zoom ke Kecamatan --}}
                                <button onclick="filterByKecamatanID({{ $kec->id }})" class="text-blue-500 hover:text-blue-700 text-xs font-bold border border-blue-200 hover:bg-blue-50 px-3 py-1 rounded-lg transition-all">
                                    Lihat
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t text-center text-xs text-gray-500 font-medium">
                Total Wisata: <span class="text-green-600 text-lg font-bold ml-1">{{ $allWisata->count() }}</span>
            </div>
        </div>

        {{-- CONTAINER PETA (Kanan) --}}
        <div class="lg:col-span-2 order-1 lg:order-2">
            {{-- Pastikan ID map ini ada --}}
            <div id="map" class="w-full h-[400px] md:h-[600px] rounded-2xl shadow-lg border border-gray-200 z-0"></div>
        </div>
    </div>
</section>

{{-- 2. LOAD JS LEAFLET (Wajib ada) --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // --- 1. INISIALISASI PETA ---
    // Koordinat Default Kabupaten Tasikmalaya
    var defaultLat = -7.3582; 
    var defaultLng = 108.2256;
    var defaultZoom = 10;

    var map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

    // Tambahkan Layer OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // --- 2. LOAD DATA DARI CONTROLLER KE JS ---
    var wisataData = @json($allWisata);
    var markers = []; // Array untuk menyimpan semua marker agar bisa difilter nanti

    // Custom Icon (Opsional, pakai default dulu biar aman)
    // var myIcon = L.icon({ ... });

    // --- 3. LOOPING MARKER KE PETA ---
    wisataData.forEach(function(wisata) {
        if(wisata.latitude && wisata.longitude) {
            
            // Buat Konten Popup
            var popupContent = `
                <div class="text-center min-w-[150px]">
                    <h3 class="font-bold text-gray-800 mb-1">${wisata.nama}</h3>
                    <p class="text-xs text-gray-500 mb-2">${wisata.kecamatan ? wisata.kecamatan.nama : ''}</p>
                    <a href="/wisata/${wisata.slug}" class="inline-block bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700 transition">Detail</a>
                </div>
            `;

            // Tambahkan Marker ke Map
            var marker = L.marker([wisata.latitude, wisata.longitude])
                .addTo(map)
                .bindPopup(popupContent);
            
            // Simpan data tambahan ke marker untuk keperluan filter
            marker.kecamatanId = wisata.kecamatan_id;
            markers.push(marker);
        }
    });

    // --- 4. FUNGSI FILTER & INTERAKSI ---

    // Fungsi saat Dropdown Kecamatan berubah
    function filterByKecamatan() {
        var select = document.getElementById('selectKecamatan');
        var selectedKecamatanId = select.value;

        // Loop semua marker
        var bounds = L.latLngBounds(); // Untuk auto zoom
        var countVisible = 0;

        markers.forEach(function(marker) {
            if (selectedKecamatanId === "" || marker.kecamatanId == selectedKecamatanId) {
                // Jika cocok atau "Semua", Tampilkan
                if(!map.hasLayer(marker)) {
                    marker.addTo(map);
                }
                bounds.extend(marker.getLatLng());
                countVisible++;
            } else {
                // Jika tidak cocok, Sembunyikan
                if(map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            }
        });

        // Zoom otomatis ke area marker yang aktif
        if (countVisible > 0 && selectedKecamatanId !== "") {
            map.fitBounds(bounds, { padding: [50, 50] });
        } else if (selectedKecamatanId === "") {
            resetMap();
        }
    }

    // Fungsi panggil dari Tombol "Lihat" di Tabel
    function filterByKecamatanID(id) {
        var select = document.getElementById('selectKecamatan');
        select.value = id;
        filterByKecamatan(); // Panggil fungsi utama
    }

    // Fungsi Reset
    function resetMap() {
        var select = document.getElementById('selectKecamatan');
        select.value = "";
        
        // Tampilkan semua marker
        markers.forEach(function(marker) {
            if(!map.hasLayer(marker)) marker.addTo(map);
        });

        // Balik ke zoom awal
        map.setView([defaultLat, defaultLng], defaultZoom);
    }

</script>
@endsection