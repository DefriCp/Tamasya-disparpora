@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $destinasiwisata->nama }} - Tamsya Wisata Kabupaten Tasikmalaya</title>
    {{-- <meta name="description" content="{{ Str::limit(strip_tags($wisata->deskripsi), 150, '...') }}"> --}}
    <meta name="keywords"
        content="{{ $header->skpd }}, {{ $destinasiwisata->nama }}, Tamasya wisata tasikmalaya, destinasi wisata tasikmalaya, tempat wisata tasikmalaya, objek wisata tasikmalaya, pariwisata tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('styles')
    <style>
        .hero-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('storage/' . $destinasiwisata->foto_utama) }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .gallery-image {
            transition: transform 0.3s ease;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }

        .facility-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative h-80 md:h-[400px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $destinasiwisata->photos->first()->photo) }}" alt="Background"
                class="object-cover w-full h-full opacity-80">
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-80"></div>

        <!-- Content -->
        <div class="relative flex items-center px-4 mx-auto mt-32 md:mt-40">
            <div class="flex flex-col items-center justify-center w-full text-white lg:items-center">
                <h1 class="text-2xl font-bold mt-7 md:text-4xl">{{ $destinasiwisata->nama }}</h1>
                <div class="flex flex-wrap gap-2 lg:mt-5">
                    @foreach (collect($destinasiwisata->jenis) as $jenis)
                        <span
                            class="px-3 py-1 text-xs font-medium text-gray-700 bg-green-100 border-green-200 rounded-full">
                            {{ $jenis }}
                        </span>
                    @endforeach
                </div>


            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto lg:flex md:gap-4 xl:gap-12 lg:py-12">
        <!-- Content Area -->
        <div class="lg:w-2/3">
            <!-- Photo Gallery -->
            <div class="mb-8">
                <div class="swiper fotoSwiper">
                    <div class="swiper-wrapper rounded-2xl">
                        @foreach ($destinasiwisata->photos->take(6) as $index => $photo)
                            <div class="swiper-slide">
                                <div class="relative overflow-hidden rounded-2xl">
                                    <img src="{{ asset('storage/' . $photo->photo) }}"
                                        alt="Foto {{ $destinasiwisata->nama }}"
                                        class="object-cover w-full h-64 transition-transform duration-300 cursor-pointer md:h-80 lg:h-96 hover:scale-105">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Informasi Umum -->
            <div class="mb-8 bg-white shadow rounded-3xl">
                <!-- Navs -->
                <div class="border-b border-gray-200">
                    <nav class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">

                        <button class="inline-block p-4 text-green-600 border-b-2 border-green-600 rounded-t-lg tab-btn"
                            data-tab="daya">
                            Detail Wisata
                        </button>
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg tab-btn hover:text-gray-600 hover:border-gray-300"
                            data-tab="amenitas">
                            Amenitas
                        </button>
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg tab-btn hover:text-gray-600 hover:border-gray-300"
                            data-tab="info">
                            Informasi
                        </button>
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg tab-btn hover:text-gray-600 hover:border-gray-300"
                            data-tab="utilitas">
                            Utilitas
                        </button>
                    </nav>
                </div>

                <!-- Content -->
                <div class="p-6">

                    <!-- Detail Destinasi -->
                    <div class="tab-content" id="daya">
                        @if ($destinasiwisata->daya_tarik_wisata)
                            <h3 class="mb-3 text-xl font-semibold text-gray-800">Daya Tarik Wisata</h3>
                            <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                                <p class="text-gray-700">{{ $destinasiwisata->daya_tarik_wisata }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data daya tarik wisata.</p>
                        @endif

                        @if ($destinasiwisata->potensi_unggulan)
                            <h3 class="mt-6 mb-3 text-xl font-semibold text-gray-800">Potensi Unggulan</h3>
                            <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                                <p class="text-gray-700">{{ $destinasiwisata->potensi_unggulan }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data potensi unggulan.</p>
                        @endif
                        @if ($destinasiwisata->produk_unggulan)
                            <h3 class="mt-6 mb-3 text-xl font-semibold text-gray-800">Produk Unggulan</h3>
                            <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                                <p class="text-gray-700">{{ $destinasiwisata->produk_unggulan }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data produk unggulan.</p>
                        @endif
                        @if ($destinasiwisata->aktivitas)
                            <h3 class="mt-6 mb-3 text-xl font-semibold text-gray-800">Aktivitas</h3>
                            <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                                <p class="text-gray-700">{{ $destinasiwisata->aktivitas }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data aktivitas.</p>
                        @endif
                    </div>



                    <!-- Amenitas -->
                    <div class="hidden tab-content" id="amenitas">
                        @if ($destinasiwisata->amenitas)
                            <h3 class="mb-3 text-xl font-semibold text-gray-800">Fasilitas & Amenitas</h3>
                            <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                                <p class="text-gray-700">{{ $destinasiwisata->amenitas }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data amenitas.</p>
                        @endif
                    </div>

                    <!-- Informasi -->
                    <div class="hidden tab-content" id="info">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="p-4 border border-gray-200 rounded-xl">
                                <h4 class="mb-3 font-semibold text-gray-800">Informasi Praktis</h4>
                                <ul class="text-sm text-gray-700">
                                    <li class="grid grid-cols-3 gap-2">
                                        <span>Status Pemilik:</span>
                                        <span
                                            class="col-span-2 font-medium">{{ $destinasiwisata->status_pemilik ?? '-' }}</span>
                                    </li>
                                    <li class="grid grid-cols-3 gap-2">
                                        <span>Luas Area:</span>
                                        <span class="col-span-2 font-medium">{{ $destinasiwisata->luas ?? '-' }}</span>
                                    </li>
                                    <li class="grid grid-cols-3 gap-2">
                                        <span>Jarak Tempuh :</span>
                                        <span
                                            class="col-span-2 font-medium">{{ $destinasiwisata->jarak_tempuh ?? '-' }}</span>
                                    </li>
                                    <li class="grid grid-cols-3 gap-2">
                                        <span>Kondisi:</span>
                                        <span
                                            class="col-span-2 font-medium">{{ $destinasiwisata->kondisi_akses ?? '-' }}</span>
                                    </li>
                                    <li class="grid grid-cols-3 gap-2">
                                        <span>Akses:</span>
                                        <span class="col-span-2 font-medium">{{ $destinasiwisata->akses ?? '-' }}</span>
                                    </li>
                                </ul>

                            </div>
                            <div class="p-4 border border-gray-200 rounded-xl">
                                <h4 class="mb-3 font-semibold text-gray-800">Informasi Pengelola</h4>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    @if ($destinasiwisata->nama_pengelola)
                                        <li class="flex justify-between">
                                            <span>Nama:</span>
                                            <span class="font-medium">{{ $destinasiwisata->nama_pengelola }}</span>
                                        </li>
                                    @endif
                                    @if ($destinasiwisata->nomor_hp)
                                        <li class="flex justify-between">
                                            <span>Kontak:</span>
                                            <a href="tel:{{ $destinasiwisata->nomor_hp }}"
                                                class="font-medium text-green-600 hover:text-green-800">
                                                {{ $destinasiwisata->nomor_hp }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Utilitas -->
                    <div class="hidden tab-content" id="utilitas">
                        @if ($destinasiwisata->utilitas && $destinasiwisata->utilitas->count() > 0)
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-3">
                                @foreach ($destinasiwisata->utilitas as $utilitas)
                                    <div class="flex items-center p-3 border border-gray-200 rounded-xl">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 mr-3 bg-green-100 rounded-full">
                                            <i class="text-sm text-green-600 fas fa-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $utilitas->nama }}</p>
                                            @if ($utilitas->keterangan)
                                                <p class="text-xs text-gray-600">{{ $utilitas->keterangan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada data utilitas.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6 mt-8 bg-white border shadow border-slate-200 rounded-3xl">
                <div class="flex flex-col justify-between gap-3 md:flex-row">
                    <h2 class="mb-2 text-lg text-slate-800">Jumlah Pengunjung {{ $destinasiwisata->nama }}</h2>
                </div>
                <div class="relativemt-4 h-80">
                    <canvas id="chartPengunjung" class="w-full "></canvas>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="mt-8 lg:w-1/3 lg:mt-0">
            <!-- Lokasi -->
            <div class="p-6 mb-8 bg-white border border-gray-200 shadow-sm stickya rounded-3xl top-4">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Lokasi</h3>
                <div class="mb-4 space-y-3">
                    <div class="flex items-center">
                        <i class="w-5 h-5 mr-3 text-green-600 fas fa-map-marker-alt"></i>
                        <div>
                            <p class="font-medium text-gray-800">{{ $destinasiwisata->desa->nama ?? '-' }}</p>
                            <p class="text-sm text-gray-600">{{ $destinasiwisata->kecamatan->nama ?? '-' }}</p>
                        </div>
                    </div>
                    @if ($destinasiwisata->latitude && $destinasiwisata->longitude)
                        <div class="flex items-center">
                            <i class="w-5 h-5 mr-3 text-blue-600 fas fa-compass"></i>
                            <div>
                                <p class="text-sm text-gray-600">Koordinat</p>
                                <p class="font-mono text-sm">{{ $destinasiwisata->latitude }},
                                    {{ $destinasiwisata->longitude }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Map Container -->
                <div id="mapDetail" class="z-10 w-full h-64 mt-4 rounded-2xl"></div>

                <!-- Direction Button -->
                @if ($destinasiwisata->latitude && $destinasiwisata->longitude)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destinasiwisata->latitude }},{{ $destinasiwisata->longitude }}"
                        target="_blank"
                        class="flex items-center justify-center w-full px-4 py-3 mt-4 text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        <i class="mr-2 fas fa-directions"></i>
                        Petunjuk Arah
                    </a>
                @endif
            </div>

            <!-- Quick Contact -->
            @if ($destinasiwisata->nomor_hp)
                <div class="p-6 mb-8 text-white bg-white border shadow-sm border-slate-200 rounded-3xl">
                    <h3 class="mb-3 text-xl font-bold text-slate-700">Butuh Informasi Lebih?</h3>
                    <p class="mb-4 text-slate-700">Hubungi pengelola untuk informasi detail dan reservasi</p>
                    <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $destinasiwisata->nomor_hp) }}"
                        target="_blank"
                        class="flex items-center justify-center w-full px-4 py-3 text-white transition-colors bg-green-600 rounded-lg backdrop-blur hover:bg-green-700">
                        <i class="mr-2 fab fa-whatsapp"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            @endif

            <!-- Wisata Lainnya -->
            <div class="p-6 mb-8 bg-white border border-gray-200 shadow-sm rounded-3xl">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Wisata Lainnya</h3>
                <div class="space-y-4">
                    @foreach ($destinasiwisatalain as $item)
                        <a href="{{ route('fe.wisata.detail', $item->slug) }}"
                            class="flex items-center p-3 transition-colors rounded-lg hover:bg-gray-50 group">
                            <img src="{{ asset('storage/' . $item->photos->first()->photo) }}"
                                alt="Foto {{ $item->nama }}"
                                class="flex-shrink-0 object-cover mr-3 w-14 h-14 rounded-xl" loading="lazy">
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="font-semibold text-gray-800 transition-colors line-clamp-1 group-hover:text-green-600">
                                    {{ $item->nama }}
                                </h4>
                                <p class="text-sm text-gray-600 line-clamp-1">
                                    {{ $item->desa->nama ?? '' }}
                                    {{ $item->kecamatan->nama ? ', ' . $item->kecamatan->nama : '' }}
                                </p>
                            </div>
                            <i
                                class="ml-2 text-gray-400 transition-colors fas fa-chevron-right group-hover:text-green-600"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </main>
@endsection

@push('js')
    <script src="{{ asset('assets/js/leaflet.ajax.js') }}"></script>
    <script src="{{ asset('js/frontend/chart.js') }}"></script>
    <script src="{{ asset('js/frontend/jquery-3.6.0.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mapContainer = document.getElementById("mapDetail");

            if (mapContainer) {
                const lat = {{ $destinasiwisata->latitude ?? 'null' }};
                const lng = {{ $destinasiwisata->longitude ?? 'null' }};

                if (lat && lng) {
                    const map = L.map("mapDetail", {
                        center: [lat, lng],
                        zoom: 15,
                        attributionControl: false,
                        zoomControl: false,
                        maxZoom: 20,
                        minZoom: 9
                    });


                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    }).addTo(map);

                    L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup(
                            `<b>{{ $destinasiwisata->nama }}</b><br>{{ $destinasiwisata->desa->nama ?? '-' }}, {{ $destinasiwisata->kecamatan->nama ?? '-' }}`
                        )
                        .openPopup();
                }
            }
        });
    </script>

    <script>
        const fotoSwiper = new Swiper(".fotoSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,

            // Autoplay (opsional)
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            // Pagination
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <script>
        // Simple tab functionality
        document.querySelectorAll(".tab-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const tab = btn.getAttribute("data-tab");

                // reset active button
                document.querySelectorAll(".tab-btn").forEach((el) => {
                    el.classList.remove("text-green-600", "border-green-600");
                    el.classList.add("hover:text-gray-600", "hover:border-gray-300");
                });
                btn.classList.add("text-green-600", "border-green-600");
                btn.classList.remove("hover:text-gray-600", "hover:border-gray-300");

                // show related content
                document.querySelectorAll(".tab-content").forEach((content) => {
                    content.classList.add("hidden");
                });
                document.getElementById(tab).classList.remove("hidden");
            });
        });
    </script>

    <script>
        let chartDropdown;
        const API_URL = "http://172.16.2.111/api/jumlahkunjunganwisata";

        // di blade ganti string literal ini dengan: 
        const NAMA_DESTINASI = @json($destinasiwisata->nama);
        // const NAMA_DESTINASI = "Cipanas Galunggung";

        document.addEventListener("DOMContentLoaded", async function() {
            const ctx = document.getElementById("chartPengunjung").getContext("2d");
            const labels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

            // helper: normalisasi nama (hapus diakritik, punctuation, multiple spaces, lowercase)
            function normalizeName(s) {
                return (s || "")
                    .toString()
                    .normalize('NFD') // decompose diacritics
                    .replace(/[\u0300-\u036f]/g, '') // remove diacritics
                    .replace(/[^\w\s]/g, ' ') // remove punctuation (keep letters/numbers/space)
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, ' ');
            }

            // helper: Levenshtein distance (untuk fuzzy match)
            function levenshtein(a, b) {
                if (!a) return b.length;
                if (!b) return a.length;
                const m = a.length,
                    n = b.length;
                const dp = Array.from({
                    length: m + 1
                }, (_, i) => new Array(n + 1));
                for (let i = 0; i <= m; i++) dp[i][0] = i;
                for (let j = 0; j <= n; j++) dp[0][j] = j;
                for (let i = 1; i <= m; i++) {
                    for (let j = 1; j <= n; j++) {
                        const cost = a[i - 1] === b[j - 1] ? 0 : 1;
                        dp[i][j] = Math.min(dp[i - 1][j] + 1, dp[i][j - 1] + 1, dp[i - 1][j - 1] + cost);
                    }
                }
                return dp[m][n];
            }

            try {
                const res = await fetch(API_URL);
                const json = await res.json();

                const dataApi = Array.isArray(json.data) ? json.data : [];

                // Debug: tampilkan daftar nama yang tersedia (bisa di-cek di console)
                console.log("Jumlah record statistik:", dataApi.length);
                console.table(dataApi.map(d => ({
                    id: d.id,
                    name: d.destinasi_wisata
                })));

                const normTarget = normalizeName(NAMA_DESTINASI);

                // 1) exact normalized match
                let dataObj = dataApi.find(d => normalizeName(d?.destinasi_wisata) === normTarget);

                // 2) partial (contains) match
                if (!dataObj) {
                    dataObj = dataApi.find(d => {
                        const n = normalizeName(d?.destinasi_wisata);
                        return n.includes(normTarget) || normTarget.includes(n);
                    });
                    if (dataObj) console.warn("Matched by partial include:", dataObj.destinasi_wisata);
                }

                // 3) fuzzy match (levenshtein) - pilih best candidate jika cukup dekat
                if (!dataObj && dataApi.length > 0) {
                    let best = {
                        idx: -1,
                        dist: Infinity
                    };
                    dataApi.forEach((d, i) => {
                        const n = normalizeName(d?.destinasi_wisata);
                        const dist = levenshtein(n, normTarget);
                        if (dist < best.dist) best = {
                            idx: i,
                            dist,
                            name: n
                        };
                    });

                    // threshold: terima jika jarak relatif kecil (mis. <= length/3 atau minimal 3)
                    const threshold = Math.max(3, Math.floor(normTarget.length / 3));
                    if (best.idx >= 0 && best.dist <= threshold) {
                        dataObj = dataApi[best.idx];
                        console.warn(`Fuzzy matched to "${dataObj.destinasi_wisata}" (distance ${best.dist})`);
                    } else {
                        console.warn("No close fuzzy match found (closest):", best);
                    }
                }

                // 4) kalau tetap ga ada, gunakan object kosong (semua bulan 0)
                if (!dataObj) {
                    console.warn("Destinasi tidak ditemukan di API:", NAMA_DESTINASI);
                    dataObj = {
                        januari: 0,
                        february: 0,
                        maret: 0,
                        april: 0,
                        mei: 0,
                        juni: 0,
                        juli: 0,
                        agustus: 0,
                        september: 0,
                        oktober: 0,
                        november: 0,
                        desember: 0
                    };
                    // note: keys di API adalah bahasa indonesia (januari..desember), pastikan mapping di bawah mengikuti itu
                }

                // ambil nilai bulan (pastikan pakai key yang tepat dari API)
                const raw = [
                    dataObj.januari, dataObj.februari || dataObj.february, dataObj.maret, dataObj.april,
                    dataObj.mei, dataObj.juni, dataObj.juli, dataObj.agustus,
                    dataObj.september, dataObj.oktober, dataObj.november, dataObj.desember
                ];

                const datasetValues = raw.map(v => {
                    // beberapa nilai mungkin "Data Belum Ada" (string) atau null -> ubah ke 0
                    if (v === null || v === undefined) return 0;
                    if (typeof v === "number") return v;
                    const n = Number(String(v).replace(/[^0-9\-\.]/g, '')); // ambil angka jika ada
                    return Number.isFinite(n) ? n : 0;
                });

                // helper gradient
                function getGradient(ctx, color1, color2) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, color1);
                    gradient.addColorStop(1, color2);
                    return gradient;
                }

                // shadow plugin (sama style seperti mas)
                const shadowPlugin = {
                    id: "shadow",
                    beforeDatasetsDraw(chart) {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, i) => {
                            const meta = chart.getDatasetMeta(i);
                            meta.data.forEach((bar) => {
                                ctx.save();
                                ctx.shadowColor = "rgba(0,0,0,0.15)";
                                ctx.shadowBlur = 8;
                                ctx.shadowOffsetX = 2;
                                ctx.shadowOffsetY = 4;
                                bar.draw(ctx);
                                ctx.restore();
                            });
                        });
                    }
                };

                // center text plugin: tampilkan "Data belum tersedia" bila semua 0
                const centerTextPlugin = {
                    id: 'centerText',
                    afterDraw(chart) {
                        const allZero = chart.data.datasets[0].data.every(v => v === 0);
                        if (!allZero) return;
                        const ctx = chart.ctx;
                        const {
                            width,
                            height
                        } = chart;
                        ctx.save();
                        ctx.font = '16px Inter, sans-serif';
                        ctx.fillStyle = 'rgba(100,100,100,0.6)';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText('Data belum tersedia', width / 2, height / 2);
                        ctx.restore();
                    }
                };

                // destroy existing chart if any
                if (chartDropdown) chartDropdown.destroy();

                chartDropdown = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels,
                        datasets: [{
                            label: "Jumlah Pengunjung",
                            data: datasetValues,
                            backgroundColor: (ctx) => getGradient(ctx.chart.ctx,
                                "rgba(34,197,94,0.9)", "rgba(34,197,94,0.2)"),
                            borderRadius: 12,
                            barThickness: 30
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: "circle",
                                    padding: 20,
                                    font: {
                                        size: 13
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: "rgba(30,41,59,0.9)",
                                titleFont: {
                                    size: 14,
                                    weight: "bold"
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 10,
                                cornerRadius: 6
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: "rgba(0,0,0,0.05)"
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: "easeOutBounce"
                        }
                    },
                    plugins: [shadowPlugin, centerTextPlugin]
                });

            } catch (error) {
                console.error("Gagal ambil data API:", error);
            }
        });
    </script>
@endpush
