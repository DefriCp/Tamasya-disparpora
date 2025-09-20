@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $wisata->nama }} - Wisata {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description" content="{{ Str::limit(strip_tags($wisata->deskripsi), 150, '...') }}">
    <meta name="keywords"
        content="{{ $header->skpd }}, {{ $wisata->nama }}, wisata tasikmalaya, destinasi wisata tasikmalaya, tempat wisata tasikmalaya, objek wisata tasikmalaya, pariwisata tasikmalaya">
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('storage/' . $wisata->foto_utama) }}');
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
            <img src="{{ asset('storage/' . $wisata->photowisatas->first()->photo) }}" alt="Background"
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
                <h1 class="text-2xl font-bold md:text-4xl">{{ $wisata->nama }}</h1>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto lg:flex md:gap-4 xl:gap-12 lg:py-12">
        <!-- Content Area -->
        <div class="lg:w-2/3">
            <!-- Informasi Umum -->
            <div class="mb-8 bg-white rounded-3xl">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Tentang {{ $wisata->nama }}</h2>
                <div class="leading-relaxed prose prose-lg text-gray-600 max-w-none">
                    {!! $wisata->deskripsi !!}
                </div>

                <!-- Galeri Foto -->
                @if ($wisata->photowisatas && count($wisata->photowisatas) > 0)
                    <div class="my-8">
                        <h2 class="mb-6 text-2xl font-bold text-gray-800">Galeri Foto</h2>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                            @foreach ($wisata->photowisatas as $foto)
                                <div class="relative overflow-hidden cursor-pointer rounded-2xl gallery-image group"
                                    onclick="openModal('{{ asset('storage/' . $foto->photo) }}')">

                                    <img src="{{ asset('storage/' . $foto->photo) }}" alt="{{ $wisata->nama }}"
                                        class="object-cover w-full h-32 md:h-40">

                                    <div
                                        class="absolute inset-0 flex items-center justify-center transition-all duration-300 bg-black bg-opacity-0 group-hover:bg-opacity-30">

                                        <!-- Ikon Zoom -->
                                        <svg class="w-8 h-8 text-white transition-opacity duration-300 opacity-0 group-hover:opacity-100"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                            </path>
                                        </svg>
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
            <!-- Info Praktis -->
            <div class="sticky p-6 mb-8 bg-white border border-gray-200 shadow-sm rounded-3xl top-4">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Wisata Lainnya</h3>

                <div class="space-y-4">
                    @foreach ($wisatalain as $item)
                        <a href="{{ route('fe.wisata.detail', $item->slug) }}" class="flex items-center space-x-3">
                            <img src="{{ asset('storage/' . $item->photowisatas->first()->photo) }}"
                                alt="Foto {{ $item->nama }}"
                                class="flex-shrink-0 object-cover w-12 h-12 mr-2 rounded-xl md:w-14 md:h-14" loading="lazy">
                            <div>
                                <h4 class="font-semibold text-gray-800 line-clamp-1">{{ $item->nama }}</h4>
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ \Illuminate\Support\Str::words(strip_tags($item->deskripsi), 20, '...') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
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
