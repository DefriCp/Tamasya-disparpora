@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $header->skpd ?? 'Template SKPD' }} - Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Informasi destinasi wisata di Kabupaten Tasikmalaya. Temukan keindahan alam, budaya, dan tempat wisata menarik di Tasikmalaya.">
    <meta name="keywords"
        content="wisata tasikmalaya, destinasi wisata tasikmalaya, tempat wisata tasikmalaya, pariwisata tasikmalaya, wisata alam tasikmalaya, wisata budaya tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-80 md:h-[460px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            @if ($header && $header->photos && $header->photos->isNotEmpty())
                <img src="{{ asset('storage/' . $header->photos->first()->photo) }}" alt="Background"
                    class="object-cover w-full h-full opacity-80">
            @else
                {{-- fallback image --}}
                <img src="{{ asset('images/default-bg.jpg') }}" alt="Background Default"
                    class="object-cover w-full h-full opacity-80">
            @endif
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-80"></div>

        <!-- Content -->
        <div class="container relative flex items-center px-4 mx-auto mt-32 md:mt-40">
            <div class="flex flex-col items-center justify-between w-full text-white lg:w-2/3 lg:items-start lg:text-left">
                <nav class="flex items-center mb-2 space-x-2 text-green-100 lg:mb-4">
                    <a href="#" class="text-white transition-colors hover:text-green-500">Beranda</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <span class="text-white">TAMASYA</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Teknologi Manajemen Sistem Wisata Tasikmalaya</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Jelajahi keindahan alam dan budaya Kabupaten
                    Tasikmalaya yang menawan.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto">
        <!-- Filter Panel -->
        <div class="flex flex-col items-center gap-4 sm:flex-row">
            <!-- Dropdown Wilayah -->
            <div class="flex flex-col">
                <label class="mb-1 text-sm font-medium text-gray-600">Kecamatan</label>
                <div class="relative">
                    <select id="kecamatanSelect"
                        class="w-56 px-4 py-2 pr-10 transition bg-white border border-gray-300 shadow-sm rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col">
                <label class="mb-1 text-sm font-medium text-gray-600">Desa</label>
                <div class="relative">
                    <select id="desaSelect"
                        class="w-56 px-4 py-2 pr-10 transition bg-white border border-gray-300 shadow-sm rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Desa</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Layout Tabel + Peta -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow flex flex-col h-[700px]">
                <div class="px-6 py-4 border-b rounded-t-2xl bg-gradient-to-r from-[#009B4C] to-[#166FBE]">
                    <h2 class="text-lg font-semibold text-white">Data Kecamatan</h2>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-sm" id="dataTable">
                        <thead class="sticky top-0 bg-blue-100">
                            <tr class="text-left text-gray-700">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Kecamatan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="font-semibold text-gray-700 bg-gray-100">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-left">Total</td>
                                <td id="totalWisata" class="px-4 py-3">0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="overflow-hidden shadow rounded-2xl">
                <div id="map" class="w-full h-[700px] z-[10] relative bg-white">
                </div>
            </div>
        </div>

        <!-- Statistik Wisata -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">

            <!-- Card Kunjungan Perbulan -->
            <div class="p-6 bg-white border shadow border-slate-200 rounded-3xl">
                <h2 class="mb-2 text-xl text-slate-800">Jumlah Kunjungan Wisata Per Bulan</h2>
                <!-- Info ringkas -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-400">Jan - Des 2025</span>
                </div>
                <!-- Chart -->
                <div class="relative h-80">
                    <canvas id="kunjunganChart"></canvas>
                </div>
            </div>

            <!-- Card Top 3 Wisata -->
            <div class="p-6 bg-white border shadow border-slate-200 rounded-3xl">
                <h2 class="mb-2 text-xl text-slate-800">Top 3 Wisata dengan Pengunjung Terbanyak</h2>
                <!-- Info ringkas -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-400">Jan - Des 2025</span>
                </div>
                <!-- Chart -->
                <div class="relative h-80">
                    <canvas id="chartTop5"></canvas>
                </div>
            </div>

        </div>

        <!-- Dropdown Filter Wisata -->
        <div class="p-6 mt-8 bg-white border shadow border-slate-200 rounded-3xl">
            <div class="flex flex-col justify-between gap-3 md:flex-row">
                <h2 class="mb-2 text-xl text-slate-800">Jumlah Pengunjung per Wisata</h2>
                <select id="wisataFilter"
                    class="w-56 p-3 border rounded-lg focus:ring-2 focus:ring-green-600 focus:outline-none">
                    <!-- Option akan diisi lewat JS -->
                </select>
            </div>
            <div class="relativemt-4 h-80">
                <canvas id="chartDropdown" class="w-full "></canvas>
            </div>
        </div>

        <!-- Section Sponsor -->
        <div class="py-10 mt-12 bg-white shadow rounded-2xl">
            <div class="max-w-6xl mx-auto">
                <div
                    class="flex items-center gap-6 px-4 py-4 overflow-x-auto md:justify-center whitespace-nowrap scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                    @forelse ($sponsor as $item)
                        <div class="flex justify-center flex-shrink-0">
                            <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->nama_instansi ?? 'Sponsor' }}"
                                class="object-contain h-24 mix-blend-multiply" />
                        </div>
                    @empty
                        <div class="flex justify-center w-full">
                            <p class="text-gray-500">Tidak ada data sponsor yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>


        <!-- Link Terkait -->
        <div class="mt-12 md:mt-28">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-xl font-medium text-slate-800">Link Youtube</h2>
            </div>
            <!-- Video/Link YouTube Section with Swiper -->
            <div class="my-10">
                <div class="my-10 swiper linkSwiper">
                    <div class="justify-center mb-16 swiper-wrapper">
                        @forelse ($youtubeTamasya as $link)
                            <div class="swiper-slide">
                                <div
                                    class="overflow-hidden transition-shadow bg-white shadow-md cursor-pointer rounded-3xl hover:shadow-lg group">
                                    <a href="{{ $link->link }}" target="_blank" class="relative block">
                                        <img src="{{ getYouTubeThumbnail($link->link) }}" alt="YouTube Thumbnail"
                                            class="object-cover w-full transition-transform duration-300 aspect-video transform-gpu group-hover:scale-110">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center transition-all bg-black bg-opacity-40 hover:bg-opacity-50">
                                            <div class="text-center text-white">
                                                <i class="mb-2 text-3xl text-red-500 fab fa-youtube"></i>
                                                <p class="text-sm font-medium line-clamp-1">{{ $link->nama }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="w-full px-3 py-8 text-center bg-white border rounded-3xl md:w-1/3 lg:w-1/4 xl:w-1/5"
                                style="border-color: rgb(229 231 235);">
                                <p class="text-gray-500">Tidak ada link youtube yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- pagination -->
                    <div class="mt-6 swiper-pagination"></div>


                    <div class="swiper-button-next">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    {{-- <script src="{{ asset('js/frontend/fetchapi.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet.ajax.js') }}"></script>
    <script>
        window.wisataDetailUrl = "{{ url('/tamasya-wisata') }}";
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/frontend/getdata-pengunjung.js') }}"></script>
    <script src="{{ asset('js/frontend/jquery-3.6.0.min.js') }}"></script> --}}
    {{-- <script>
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Data dummy per wisata
        const wisataData = {
            "Kampung Naga": [1200, 1500, 1800, 1400, 2000, 2300, 2200, 2500, 2400, 2600, 2700, 3000],
            "Galunggung": [1000, 1200, 1600, 1300, 1700, 2000, 2100, 2200, 2000, 2100, 2300, 2500],
            "Pantai Cipatujah": [800, 1000, 1200, 1100, 1500, 1800, 1900, 2000, 1800, 1900, 2000, 2100],
            "Situ Gede": [600, 700, 900, 800, 1200, 1500, 1600, 1700, 1500, 1600, 1700, 1800],
            "Rajapolah": [500, 600, 800, 700, 1000, 1200, 1300, 1400, 1300, 1400, 1500, 1600],
            "Karang Tawulan": [400, 500, 700, 600, 900, 1100, 1200, 1300, 1200, 1300, 1400, 1500]
        };

        const colors = [
            'rgba(34,197,94,0.7)', // green
            'rgba(59,130,246,0.7)', // blue
            'rgba(234,88,12,0.7)', // orange
            'rgba(139,92,246,0.7)', // purple
            'rgba(244,63,94,0.7)', // red
            'rgba(16,185,129,0.7)' // teal
        ];

        // Grafik 1: Total Pengunjung Per Bulan
        const totalPerBulan = labels.map((_, i) => {
            return Object.values(wisataData).reduce((sum, arr) => sum + arr[i], 0);
        });

        new Chart(document.getElementById('kunjunganChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Total Pengunjung',
                    data: totalPerBulan,
                    borderColor: 'rgba(34,197,94,1)',
                    backgroundColor: 'rgba(34,197,94,0.3)',
                    fill: true,
                    tension: 0.3
                }]
            }
        });

        // Grafik 2: Top 5 Wisata
        const totalPerWisata = Object.entries(wisataData).map(([wisata, arr]) => ({
            wisata,
            total: arr.reduce((a, b) => a + b, 0)
        }));
        const top5 = totalPerWisata.sort((a, b) => b.total - a.total).slice(0, 5);

        new Chart(document.getElementById('chartTop5'), {
            type: 'bar',
            data: {
                labels: top5.map(x => x.wisata),
                datasets: [{
                    label: 'Total Pengunjung',
                    data: top5.map(x => x.total),
                    backgroundColor: colors
                }]
            },
            options: {
                indexAxis: 'y', // jadi horizontal bar
            }
        });

        // Grafik 3: Dropdown Filter
        const ctxDropdown = document.getElementById('chartDropdown').getContext('2d');
        let chartDropdown = new Chart(ctxDropdown, {
            type: 'bar',
            data: {
                labels,
                datasets: []
            },
            options: {
                responsive: true
            }
        });

        document.getElementById('wisataFilter').addEventListener('change', function() {
            const selected = Array.from(this.selectedOptions).map(o => o.value);

            const datasets = selected.map((wisata, index) => ({
                label: wisata,
                data: wisataData[wisata],
                backgroundColor: colors[index % colors.length]
            }));

            chartDropdown.data.datasets = datasets;
            chartDropdown.update();
        });
    </script> --}}
@endpush
