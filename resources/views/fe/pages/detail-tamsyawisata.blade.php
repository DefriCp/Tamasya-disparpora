@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $destinasiwisata->nama }} - Tamsya Wisata Kabupaten Tasikmalaya</title>
    {{-- <meta name="description" content="{{ Str::limit(strip_tags($wisata->deskripsi), 150, '...') }}"> --}}
    <meta name="keywords"
        content="{{ $header->skpd }}, {{ $destinasiwisata->nama }}, Tamasya wisata tasikmalaya, destinasi wisata tasikmalaya, tempat wisata tasikmalaya, objek wisata tasikmalaya, pariwisata tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
    {{-- 
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $wisata->nama }} - Wisata Kabupaten Tasikmalaya">
    <meta property="og:description" content="{{ Str::limit(strip_tags($wisata->deskripsi), 150, '...') }}">
    <meta property="og:image" content="{{ asset('storage/' . $wisata->foto_utama) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $wisata->nama }} - Wisata Kabupaten Tasikmalaya">
    <meta property="twitter:description" content="{{ Str::limit(strip_tags($wisata->deskripsi), 150, '...') }}">
    <meta property="twitter:image" content="{{ asset('storage/' . $wisata->foto_utama) }}"> --}}
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
    <section class="relative h-80 md:h-[460px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $destinasiwisata->photos->first()->photo) }}" alt="Background"
                class="object-cover w-full h-full opacity-80">
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-80"></div>

        <!-- Content -->
        <div class="container relative flex items-center px-4 mx-auto mt-32 md:mt-40">
            <div class="flex flex-col items-center justify-between w-full text-white lg:w-2/3 lg:items-start lg:text-left">
                <nav class="flex items-center mb-2 space-x-2 text-green-100 lg:mb-4">
                    <a href="#" class="text-white transition-colors hover:text-green-500">Beranda</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <span class="text-white">Wisata</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">{{ $destinasiwisata->nama }}</h1>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto lg:flex md:gap-4 xl:gap-12 lg:py-12">
        <!-- Content Area -->
        <div class="lg:w-2/3">
            <!-- Photo Gallery -->
            <div class="mb-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($destinasiwisata->photos->take(6) as $index => $photo)
                        <div
                            class="relative overflow-hidden rounded-2xl {{ $index == 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                            <img src="{{ asset('storage/' . $photo->photo) }}" alt="Foto {{ $destinasiwisata->nama }}"
                                class="object-cover w-full h-48 transition-transform duration-300 cursor-pointer hover:scale-105 {{ $index == 0 ? 'md:h-96' : '' }}">
                        </div>
                    @endforeach
                </div>
                @if ($destinasiwisata->photos->count() > 6)
                    <button class="px-4 py-2 mt-4 text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        Lihat Semua Foto ({{ $destinasiwisata->photos->count() }})
                    </button>
                @endif
            </div>

            <!-- Informasi Umum -->
            <div class="mb-8 bg-white rounded-3xl">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Tentang {{ $destinasiwisata->nama }}</h2>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <div class="prose prose-lg max-w-none">
                        <p class="leading-relaxed text-gray-700">
                            {{ $destinasiwisata->potensi_unggulan ?? 'Deskripsi wisata akan ditampilkan di sini.' }}
                        </p>
                        @if ($destinasiwisata->produk_unggulan)
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-800">Produk Unggulan:</h4>
                                <p class="text-gray-700">{{ $destinasiwisata->produk_unggulan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Daya Tarik -->
                @if ($destinasiwisata->daya_tarik_wisata)
                    <div class="mb-6">
                        <h3 class="mb-3 text-xl font-semibold text-gray-800">Daya Tarik Wisata</h3>
                        <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                            <p class="text-gray-700">{{ $destinasiwisata->daya_tarik_wisata }}</p>
                        </div>
                    </div>
                @endif

                <!-- Amenitas -->
                @if ($destinasiwisata->amenitas)
                    <div class="mb-6">
                        <h3 class="mb-3 text-xl font-semibold text-gray-800">Fasilitas & Amenitas</h3>
                        <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                            <p class="text-gray-700">{{ $destinasiwisata->amenitas }}</p>
                        </div>
                    </div>
                @endif

                <!-- Informasi Tambahan -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Status & Info Praktis -->
                    <div class="p-4 border border-gray-200 rounded-xl">
                        <h4 class="mb-3 font-semibold text-gray-800">Informasi Praktis</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex justify-between">
                                <span>Status:</span>
                                <span class="font-medium">{{ $destinasiwisata->status_pemilik ?? '-' }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Luas Area:</span>
                                <span class="font-medium">{{ $destinasiwisata->luas ?? '-' }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Jarak Tempuh:</span>
                                <span class="font-medium">{{ $destinasiwisata->jarak_tempuh ?? '-' }}</span>
                            </li>
                            @if ($destinasiwisata->aktivitas)
                                <li class="flex flex-col">
                                    <span>Aktivitas:</span>
                                    <span class="mt-1 font-medium">{{ $destinasiwisata->aktivitas }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Pengelola -->
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
                            @if ($destinasiwisata->kondisi_akses)
                                <li class="flex flex-col">
                                    <span>Kondisi Akses:</span>
                                    <span class="mt-1 font-medium">{{ $destinasiwisata->kondisi_akses }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Utilitas/Fasilitas -->
                @if ($destinasiwisata->utilitas && $destinasiwisata->utilitas->count() > 0)
                    <div class="mt-8">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Utilitas & Fasilitas</h3>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-3">
                            @foreach ($destinasiwisata->utilitas as $utilitas)
                                <div class="flex items-center p-3 border border-gray-200 rounded-xl">
                                    <div class="flex items-center justify-center w-8 h-8 mr-3 bg-green-100 rounded-full">
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
                    </div>
                @endif
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
                <div id="map" class="z-10 w-full h-64 mt-4 rounded-2xl"></div>

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

            <!-- Wisata Lainnya -->
            <div class="p-6 mb-8 bg-white border border-gray-200 shadow-sm rounded-3xl">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Wisata Lainnya</h3>
                <div class="space-y-4">
                    @foreach ($destinasiwisatalain as $item)
                        <a href="{{ route('fe.wisata.detail', $item->slug) }}"
                            class="flex items-center p-3 transition-colors rounded-lg hover:bg-gray-50 group">
                            <img src="{{ asset('storage/' . $item->photos->first()->photo) }}"
                                alt="Foto {{ $item->nama }}" class="flex-shrink-0 object-cover mr-3 w-14 h-14 rounded-xl"
                                loading="lazy">
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

            <!-- Quick Contact -->
            @if ($destinasiwisata->nomor_hp)
                <div class="p-6 text-white bg-gradient-to-br from-green-600 to-green-700 rounded-3xl">
                    <h3 class="mb-3 text-xl font-bold">Butuh Informasi Lebih?</h3>
                    <p class="mb-4 text-green-100">Hubungi pengelola untuk informasi detail dan reservasi</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $destinasiwisata->nomor_hp) }}"
                        target="_blank"
                        class="flex items-center justify-center w-full px-4 py-3 text-green-600 transition-colors bg-white rounded-lg hover:bg-green-50">
                        <i class="mr-2 fab fa-whatsapp"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            @endif
        </aside>
    </main>
@endsection

@push('js')
    <script>
        function openModal(imageUrl) {
            // Create modal overlay
            const modalOverlay = document.createElement('div');
            modalOverlay.id = 'image-modal-overlay';
            modalOverlay.style.position = 'fixed';
            modalOverlay.style.top = 0;
            modalOverlay.style.left = 0;
            modalOverlay.style.width = '100vw';
            modalOverlay.style.height = '100vh';
            modalOverlay.style.background = 'rgba(0,0,0,0.8)';
            modalOverlay.style.display = 'flex';
            modalOverlay.style.alignItems = 'center';
            modalOverlay.style.justifyContent = 'center';
            modalOverlay.style.zIndex = 9999;

            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.style.position = 'relative';
            modalContent.style.maxWidth = '90vw';
            modalContent.style.maxHeight = '90vh';

            // Create image element
            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = 'Galeri Foto';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '80vh';
            img.style.borderRadius = '1rem';
            img.style.boxShadow = '0 4px 32px rgba(0,0,0,0.5)';

            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.position = 'absolute';
            closeBtn.style.top = '0';
            closeBtn.style.right = '0';
            closeBtn.style.transform = 'translateY(-50%) translateX(50%)';
            closeBtn.style.background = '#fff';
            closeBtn.style.color = '#333';
            closeBtn.style.border = 'none';
            closeBtn.style.fontSize = '2rem';
            closeBtn.style.width = '40px';
            closeBtn.style.height = '40px';
            closeBtn.style.borderRadius = '50%';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
            closeBtn.onclick = function() {
                document.body.removeChild(modalOverlay);
            };

            // Close modal on overlay click
            modalOverlay.onclick = function(e) {
                if (e.target === modalOverlay) {
                    document.body.removeChild(modalOverlay);
                }
            };

            modalContent.appendChild(img);
            modalContent.appendChild(closeBtn);
            modalOverlay.appendChild(modalContent);
            document.body.appendChild(modalOverlay);
        }
    </script>
@endpush
