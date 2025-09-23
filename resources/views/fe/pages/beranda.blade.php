@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $header->skpd ?? 'Template SKPD' }} - Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Selamat datang di {{ $header->skpd ?? 'Template SKPD' }}, portal resmi pemerintah daerah Kabupaten Tasikmalaya. Layanan publik terpadu, cepat, dan akurat untuk masyarakat.">
    <meta name="keywords"
        content="{{ $header->skpd ?? 'Template SKPD' }}, Pemerintah Kabupaten Tasikmalaya, Layanan Publik Tasikmalaya, E-Government Tasikmalaya, Informasi Daerah Tasikmalaya, Portal Resmi Pemkab Tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Swiper -->
    <section>
        <div class="relative swiper heroSwiper h-96 md:h-dvh">

            <!-- Swiper Slide Hanya Gambar -->
            @php
                // Jika $header ada dan punya foto, gunakan foto tersebut
                $photos = $header?->photos ?? collect();
            @endphp
            <div class="swiper-wrapper">
                @if ($photos->isNotEmpty())
                    @foreach ($photos as $slider)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $slider->photo) }}" alt="Slide"
                                class="object-cover w-full h-full" />
                        </div>
                    @endforeach
                @else
                    <!-- Default Slider jika tidak ada data header/photo -->
                    <div class="swiper-slide">
                        <img src="{{ asset('images/placeholder-hero.jpg') }}" alt="Default Slide"
                            class="object-cover w-full h-full" />
                    </div>
                @endif
            </div>

            <!-- Text Tetap -->
            <div class="absolute inset-0 z-10 bg-gradient-to-r from-black/60 to-black/30"></div>
            <div class="absolute inset-0 z-20 flex flex-col items-center justify-center px-4 text-center text-white">
                <h1 class="mb-4 text-3xl font-bold md:text-5xl">{{ $header->skpd ?? 'Template SKPD' }}</h1>
                <p class="mb-6 text-xl md:text-2xl">Kabupaten Tasikmalaya</p>
            </div>

            <!-- Pagination -->
            <div class="z-30 swiper-pagination custom-pagination"></div>
        </div>
    </section>

    <!-- Berita Kab Tasik -->
    <section class="mt-8 md:mt-12">
        <div class="container px-4 mx-auto">
            <h3 class="my-5 text-xl font-medium text-center lg:text-left lg:text-2xl">Berita Kabupaten Tasikmalaya</h3>
            <div class="swiper beritaTasikKabSwiper">
                <div class="py-5 swiper-wrapper" id="news-container">
                    <!-- Loading animation -->
                    <div id="loading" class="w-full text-center">
                        <svg class="w-8 h-8 mx-auto text-gray-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">Memuat berita...</p>
                    </div>
                </div>
                {{-- <div class="swiper-pagination"></div> --}}
            </div>
        </div>
    </section>

    <!-- Berita SKPD -->
    <section class="mt-4 md:mt-12">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Content -->
                <div class="space-y-8 lg:col-span-2">
                    <section id="berita" class="scroll-mt-24">
                        <div class="beritaSKPDSwiper swiper">
                            <div class="swiper-wrapper">
                                @foreach ($beritaSkpd as $item)
                                    <div class="swiper-slide">
                                        <div class="relative overflow-hidden bg-white shadow-md rounded-3xl">
                                            <!-- Gambar -->
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="Tasikmalaya Maju"
                                                class="object-cover w-full aspect-[4/3]">

                                            <!-- Overlay Transparan -->
                                            <div style="background-image: linear-gradient(to top, {{ $header->warna_pertama }}, transparent); height: 50%; opacity: 10;"
                                                class="absolute inset-x-0 bottom-0">
                                            </div>

                                            <!-- Overlay Teks -->
                                            <div
                                                class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                                                <h2 class="text-3xl font-bold text-white">{{ $item->judul }}</h2>
                                                <p class="my-4 text-gray-300">
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }} |
                                                    Penulis: {{ $item->header->singkatan_skpd }}
                                                </p>
                                                <a href="{{ route('fe.berita.detail', $item->slug) }}"
                                                    class="bg-yellow-300 text-green-800 text-sm font-medium px-5 py-2.5 rounded-full focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-colors hover:bg-yellow-400">
                                                    Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Pagination -->
                            <div class="swiper-pagination mt"></div>
                        </div>
                    </section>

                    <section>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button id="btn-terbaru"
                                class="px-4 py-2 text-sm transition-colors border rounded-full btn-tab btn-color-primary hover:border-transparent focus:ring-2 focus:ring-slate-300">
                                TERBARU
                            </button>
                            <button id="btn-terpopuler"
                                class="px-4 py-2 text-sm transition-colors border rounded-full btn-tab btn-color-custom hover:border-transparent focus:ring-2 focus:ring-slate-300">
                                TERPOPULER
                            </button>
                            <button id="btn-pengumuman"
                                class="px-4 py-2 text-sm transition-colors border rounded-full btn-tab btn-color-custom hover:border-transparent focus:ring-2 focus:ring-slate-300">
                                PENGUMUMAN
                            </button>
                        </div>
                    </section>

                    <section>
                        {{-- TERBARU --}}
                        <div id="konten-terbaru" class="space-y-4">
                            @foreach ($beritaTerbaru as $berita)
                                <div class="p-6 duration-150 bg-white border rounded-3xl hover:shadow"
                                    style="border-color: var(--hover-border, rgb(229 231 235))"
                                    onmouseover="this.style.setProperty('--hover-border', '{{ $header->warna_text_utama }}')"
                                    onmouseout="this.style.setProperty('--hover-border', 'rgb(229 231 235)')">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 w-2 h-16 rounded-full"
                                            style="background-color: {{ $header->warna_text_utama }}">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-sm font-medium"
                                                    style="color: {{ $header->warna_text_utama }}">
                                                    Kegiatan {{ $header->skpd }}
                                                </span>
                                                <span class="px-2 py-0.5 text-xs font-light text-white rounded-full"
                                                    style="background: {{ $header->warna_text_utama }}">
                                                    Berita
                                                </span>
                                            </div>
                                            <a href="{{ route('fe.berita.detail', $berita->slug) }}"
                                                class="mt-1 mb-2 text-lg font-semibold text-gray-800 line-clamp-2">
                                                {{ $berita->judul }}
                                            </a>
                                            <p class="text-sm text-gray-600">
                                                <i class="mr-1 fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($berita->waktu_publish)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- TERPOPULER --}}
                        <div id="konten-terpopuler" class="hidden space-y-4">
                            @foreach ($beritaTerpopuler as $berita)
                                <div class="p-6 duration-150 bg-white border rounded-3xl hover:shadow"
                                    style="border-color: var(--hover-border, rgb(229 231 235))"
                                    onmouseover="this.style.setProperty('--hover-border', '{{ $header->warna_text_utama }}')"
                                    onmouseout="this.style.setProperty('--hover-border', 'rgb(229 231 235)')">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 w-2 h-16 rounded-full"
                                            style="background-color: {{ $header->warna_text_utama }}">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-sm font-medium"
                                                    style="color: {{ $header->warna_text_utama }}">
                                                    Kegiatan {{ $header->skpd }}
                                                </span>
                                                <span class="px-2 py-0.5 text-xs font-light text-white rounded-full"
                                                    style="background: {{ $header->warna_text_utama }}">
                                                    Berita
                                                </span>
                                            </div>
                                            <a href="{{ route('fe.berita.detail', $berita->slug) }}"
                                                class="mt-1 mb-2 text-lg font-semibold text-gray-800 line-clamp-2">
                                                {{ $berita->judul }}
                                            </a>
                                            <p class="text-sm text-gray-600">
                                                <i class="mr-1 fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($berita->waktu_publish)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="btn-lihatSemuaBerita" class="mt-6 text-center md:text-start">
                            <a href="{{ route('fe.berita') }}"
                                class="px-4 py-3 text-sm font-medium duration-150 border rounded-xl hover:text-white focus:ring-2 group btn-color-custom">
                                Lihat Semua Berita
                                <i class="fas fa-arrow-right ms-1 group-hover:text-white"></i>
                            </a>
                        </div>

                        {{-- PENGUMUMAN --}}
                        <div id="konten-pengumuman" class="hidden space-y-4">
                            @forelse ($pengumumanSkpd as $item)
                                <div class="p-6 duration-150 bg-white border cursor-pointer rounded-3xl hover:shadow"
                                    style="border-color: var(--hover-border, rgb(229 231 235))"
                                    onmouseover="this.style.setProperty('--hover-border', '{{ $header->warna_text_utama }}')"
                                    onmouseout="this.style.setProperty('--hover-border', 'rgb(229 231 235)')"
                                    onclick="showModalPengumuman({{ $item->id }})">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 w-2 h-16 rounded-full"
                                            style="background-color: {{ $header->warna_text_utama }}">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-sm font-medium"
                                                    style="color: {{ $header->warna_text_utama }}">
                                                    Pengumuman {{ $header->skpd }}
                                                </span>
                                                <span class="px-2 py-0.5 text-xs font-light text-white rounded-full"
                                                    style="background: {{ $header->warna_text_utama }}">
                                                    Pengumuman
                                                </span>
                                            </div>
                                            <h3 class="mt-1 mb-2 text-lg font-semibold text-gray-800 line-clamp-2">
                                                {{ $item->judul }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                <i class="mr-1 fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 bg-white border rounded-3xl">
                                    <p class="text-center text-gray-500">Tidak ada pengumuman SKPD untuk saat ini.</p>
                                </div>
                            @endforelse
                        </div>

                    </section>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-8">
                    <!-- Agenda -->
                    <section id="agenda"
                        class="p-6 text-white bg-green-700 rounded-3xl"style="background-image: linear-gradient(to bottom right, {{ $header->warna_pertama ?? 'bg-blue-400' }}, {{ $header->warna_kedua ?? 'bg-blue-400' }})">
                        <h2 class="mb-4 text-lg font-bold text-center text-white lg:text-3xl">Agenda</h2>
                        <p class="mb-4 text-base text-center text-white">Jadwal kegiatan dan acara
                            penting {{ $header->skpd ?? 'Template SKPD' }}
                            Kabupaten
                            Tasikmalaya</p>

                        <div class="mb-6">
                            <h3 class="mb-3 font-semibold text-center">{{ $currentMonthYear }}</h3>
                            <div class="grid grid-cols-7 gap-1 text-sm text-center">
                                <div class="text-white-200">Min</div>
                                <div class="text-white-200">Sen</div>
                                <div class="text-white-200">Sel</div>
                                <div class="text-white-200">Rab</div>
                                <div class="text-white-200">Kam</div>
                                <div class="text-white-200">Jum</div>
                                <div class="text-white-200">Sab</div>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-white">
                                @foreach ($calendar as $week)
                                    @foreach ($week as $day)
                                        @php
                                            $isActive = $day === $currentDay;
                                            $hasAgenda = $day && in_array($day, $agendaDates);
                                        @endphp
                                        <div class="relative">
                                            <div class="day-cell h-8 flex items-center justify-center rounded-full cursor-pointer hover:bg-white hover:text-blue-700 transition {{ $isActive ? 'bg-white text-blue-700 font-bold' : '' }}"
                                                data-day="{{ $day }}"
                                                onclick="loadAgenda({{ $day }}, {{ $month }}, {{ $year }}, this)">
                                                {{ $day ?? '' }}
                                            </div>

                                            @if ($hasAgenda)
                                                <span
                                                    class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1 w-1.5 h-1.5 rounded-full bg-red-800"></span>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="agendaLoading" class="hidden my-4 text-center">
                            <div class="w-8 h-8 mx-auto border-4 border-white rounded-full animate-spin border-t-blue-500">
                            </div>
                            <div class="mt-2 text-sm text-white">Memuat agenda...</div>
                        </div>

                        <div id="agendaResult" class="space-y-3">
                            @forelse ($todayAgenda as $agenda)
                                <div class="p-4 bg-slate-200/30 rounded-2xl">
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="font-medium">{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d F Y') }}</span>
                                        <span class="text-sm font-medium">{{ $agenda->status }}</span>
                                    </div>
                                    <p class="mt-1 text-sm text-white line-clamp-2">{{ $agenda->judul }}</p>
                                </div>
                            @empty
                                <div class="p-4 bg-slate-200/30 rounded-2xl">
                                    <p class="text-center text-white">Tidak ada agenda untuk hari ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- GPR bg-[#262879]-->
                    <section class="p-6 bg-white border shadow-sm rounded-3xl"
                        style="border-color: {{ $header->warna_text_utama ?? 'bg-blue-400' }};">
                        <h2 class="mb-2 text-lg font-bold text-center lg:text-3xl"
                            style="background: linear-gradient(90deg, #f58529 0%, #dd2a7b 50%, #515bd4 100%);
                                   -webkit-background-clip: text;
                                   -webkit-text-fill-color: transparent;
                                   background-clip: text;
                                   color: transparent;">
                            Instagram
                        </h2>
                        {{-- <p class="mb-4 text-base text-center text-white">Postingan {{ $header->skpd }}
                            Kabupaten
                            Tasikmalaya</p> --}}

                        <div class="space-y-3">
                            <div class="flex items-center justify-center p-4 space-y-1 rounded-2xl">
                                <blockquote class="instagram-media"
                                    data-instgrm-permalink="https://www.instagram.com/reel/CxrWxu6pVHV/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="
                                    data-instgrm-version="14" style="background:#FFF; border:0; border-radius:1rem;">
                                    <a href="https://www.instagram.com/reel/CxrWxu6pVHV/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=="
                                        target="_blank">...</a>
                                </blockquote>
                                <script async src="//www.instagram.com/embed.js"></script>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Kegiatan -->
    <section>
        <div class="container px-4 mx-auto">
            <div id="galeri" class="mt-12 md:mt-28 scroll-mt-24">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-medium md:text-4xl text-slate-800">Photo Kegiatan</h2>
                    <p class="mt-3 text-gray-600">Dokumentasi foto kegiatan
                        yang
                        dilaksanakan {{ $header->skpd ?? 'Template SKPD' }} dalam mendukung pembangunan, pelayanan publik,
                        dan ketertiban di
                        wilayah Kabupaten
                        Tasikmalaya.</p>
                </div>
                <!-- Slider Photo Grid -->
                <div class="my-10 swiper photoSwiper">
                    <div class="mb-16 swiper-wrapper">
                        @forelse ($fotoKegiatan as $item)
                            <div class="swiper-slide">
                                <div
                                    class="flex flex-col h-full overflow-hidden transition-shadow bg-white shadow-md rounded-3xl hover:shadow-lg">
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto Kegiatan"
                                            class="object-cover w-full h-64 transition-transform duration-300 transform-gpu group-hover:scale-110">
                                    </div>
                                </div>
                            </div>
                        @empty
                            @for ($i = 0; $i < 6; $i++)
                                <div class="swiper-slide">
                                    <div
                                        class="flex flex-col h-full overflow-hidden transition-shadow bg-white shadow-md rounded-3xl hover:shadow-lg">
                                        <div class="relative group">
                                            <img src="{{ asset('images/placeholder-hero.jpg') }}" alt="Foto Kegiatan"
                                                class="object-cover w-full h-64 transition-transform duration-300 transform-gpu group-hover:scale-110">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination custom-pagination"></div>

                    <div class="swiper-button-next">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section class="py-6 md:py-12 bg-gray-50">
        <div class="container px-4 mx-auto">
            <div id="layanan" class="mt-12 scroll-mt-24">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-medium md:text-4xl text-slate-800">Layanan</h2>
                    <p class="mt-3 text-gray-600">
                        Layanan publik yang kami sediakan untuk memudahkan masyarakat dalam
                        mengakses informasi, pengajuan dokumen, dan program bantuan dari instansi kami.
                    </p>
                </div>
                <div class="my-10">
                    <div class="flex flex-wrap justify-center gap-3 my-2 md:gap-4">
                        @forelse ($layanan as $item)
                            <div class="flex items-center justify-center w-full px-3 py-8 transition-all duration-300 transform bg-white border md:w-1/3 lg:w-1/4 xl:w-1/5 rounded-3xl group hover:-translate-y-2"
                                style="border-color: rgb(229 231 235);"
                                onmouseover="this.style.borderColor='{{ $header->warna_text_utama }}'; this.querySelector('h3').style.color='{{ $header->warna_text_utama }}'"
                                onmouseout="this.style.borderColor='rgb(229 231 235)'; this.querySelector('h3').style.color='#030817'">

                                <div class="text-center">
                                    <h3 class="mb-2 text-base font-semibold text-gray-800 duration-150 lg:text-lg line-clamp-2"
                                        style="color: #374151;">
                                        {{ $item->nama }}
                                    </h3>

                                    <p class="mb-5 text-sm text-gray-600 line-clamp-2">{{ $item->deskripsi }}</p>

                                    <a href="{{ $item->url }}" target="_blank"
                                        class="px-6 py-2.5 text-sm transition-colors duration-200 btn-color-primary focus:ring-2 focus:ring-slate-300 rounded-xl">
                                        Akses Layanan
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="w-full px-3 py-8 text-center bg-white border rounded-3xl md:w-1/3 lg:w-1/4 xl:w-1/5"
                                style="border-color: rgb(229 231 235);">
                                <p class="text-gray-500">Tidak ada layanan yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('fe.layanan') }}"
                            class="px-6 py-3 text-sm transition-colors duration-200 btn-color-primary focus:ring-2 focus:ring-slate-300 rounded-xl">
                            Lihat Semua Layanan
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Link Terkait -->
    <section>
        <div class="container px-4 mx-auto">
            <div class="mt-12 md:mt-28">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-medium md:text-4xl text-slate-800">Link Terkait</h2>
                    <p class="mt-3">Simak cerita menarik dari mereka yang telah membuktikan bahwa teknologi dapat
                        mengubah
                        cara
                        kerja,
                        meningkatkan efisiensi, dan mendapatkan hasil yang lebih baik.</p>
                </div>
                <!-- Video/Link YouTube Section with Swiper -->
                <div class="my-10">
                    <div class="my-10 swiper linkSwiper">
                        <div class="justify-center mb-16 swiper-wrapper">
                            @forelse ($linkYoutube as $link)
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
        </div>
    </section>

    <!-- Modal Pengumuman Ketika diKlik-->
    <div id="pengumumModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-xl bg-white shadow-xl rounded-3xl slide-down">
                <!-- Header -->
                <div class="px-6 py-4 text-white bg-blue-600 rounded-t-3xl">
                    <div class="flex items-center justify-between">
                        <h3 class="flex items-center text-lg font-medium">
                            <i class="mr-2 fas fa-bullhorn"></i>
                            Pengumuman
                        </h3>
                        <button onclick="closeModal('pengumumModal')" class="text-white hover:text-gray-200">
                            <i class="text-xl fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="mb-4 text-center">
                        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full">
                            <i class="text-3xl text-blue-600 fas fa-info-circle"></i>
                        </div>
                        <h4 id="judulPengumum" class="mb-2 text-xl font-bold text-gray-800"></h4>
                        <p id="tglPengumum" class="mb-4 text-sm text-gray-600">
                    </div>

                    <div id="isiPengumum" class="mb-6 text-sm leading-relaxed text-gray-700">

                    </div>

                    <div class="flex justify-end space-x-3">
                        <button onclick="closeModal('pengumumModal')"
                            class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pengumuman-->
    @if ($pengumuman)
        <div id="pengumumanModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 modal-backdrop">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="w-full max-w-xl bg-white shadow-xl rounded-3xl slide-down">
                    <!-- Header -->
                    <div class="px-6 py-4 text-white bg-blue-600 rounded-t-3xl">
                        <div class="flex items-center justify-between">
                            <h3 class="flex items-center text-lg font-medium">
                                <i class="mr-2 fas fa-bullhorn"></i>
                                Pengumuman
                            </h3>
                            <button onclick="closeModal('pengumumanModal')" class="text-white hover:text-gray-200">
                                <i class="text-xl fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="mb-4 text-center">
                            <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full">
                                <i class="text-3xl text-blue-600 fas fa-info-circle"></i>
                            </div>
                            <h4 class="mb-2 text-xl font-bold text-gray-800">{{ $pengumuman->judul }}</h4>
                            <p class="mb-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal_publish)->translatedFormat('d F Y') }}</p>
                        </div>

                        <div class="mb-6 text-sm leading-relaxed text-gray-700">
                            {!! $pengumuman->isi !!}
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button onclick="closeModal('pengumumanModal')"
                                class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script src="{{ asset('js/frontend/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/frontend/ajaxget.js') }}"></script>

    {{-- untuk block instagram --}}
    <script async src="//www.instagram.com/embed.js"></script>

    <script>
        $(document).ready(function() {
            if ($('#pengumumanModal').length) {
                $('#pengumumanModal').removeClass('hidden');
            }
        });

        function closeModal(modalId) {
            $('#' + modalId).addClass('hidden');
        }
    </script>

    <script>
        function loadAgenda(day, month, year, element) {
            const loading = $('#agendaLoading');
            const result = $('#agendaResult');

            // 🔄 Hapus class aktif dari semua tanggal
            $('.day-cell').removeClass('bg-white text-blue-700 font-bold');

            // ✅ Tambahkan class aktif ke elemen yang diklik
            $(element).addClass('bg-white text-blue-700 font-bold');

            // Tampilkan loading
            loading.removeClass('hidden');
            result.empty();

            $.ajax({
                url: '{{ route('fe.getAgenda') }}',
                method: 'POST',
                data: {
                    day: day,
                    month: month,
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    loading.addClass('hidden'); // Sembunyikan loading

                    if (data.length === 0) {
                        result.html(
                            `
                            <div class="p-4 bg-slate-200/30 rounded-2xl">
                                <p class="text-center text-white">Tidak ada agenda untuk tanggal ${day}</p>
                            </div>
                            `
                        );
                    } else {
                        let html = '';
                        data.forEach(item => {
                            html += `
                            <div class="p-4 bg-slate-200/30 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium">${item.tanggal}</span>
                                    <span class="text-sm font-medium">${item.status}</span>
                                </div>
                                <p class="mt-1 text-sm text-white line-clamp-2">${item.judul}</p>
                            </div>
                        `;
                        });
                        result.html(html);
                    }
                },
                error: function() {
                    loading.addClass('hidden');
                    result.html(`<div class="text-center text-red-600">Gagal memuat data.</div>`);
                }
            });
        }

        function showModalPengumuman(id) {
            // Langsung tampilkan modal (dengan loading state)
            $('#pengumumModal').removeClass('hidden');

            // Kosongkan dulu atau tampilkan loading text
            $('#pengumumModal #judulPengumum').text('Memuat...');
            $('#pengumumModal #tglPengumum').text('');
            $('#pengumumModal #isiPengumum').html('<i>Harap tunggu sebentar...</i>');

            // Baru lakukan AJAX request
            $.ajax({
                url: '/api/pengumuman/' + id,
                method: 'GET',
                success: function(response) {
                    // Isi modal dengan data dari response
                    $('#pengumumModal #judulPengumum').text(response.judul);
                    $('#pengumumModal #tglPengumum').text(response.tanggal_publish);
                    $('#pengumumModal #isiPengumum').html(response.isi);
                },
                error: function() {
                    $('#pengumumModal #judulPengumum').text('Error!');
                    $('#pengumumModal #isiPengumum').html(
                        '<span class="text-red-500">Gagal memuat data pengumuman.</span>');
                }
            });
        }
    </script>
@endpush
