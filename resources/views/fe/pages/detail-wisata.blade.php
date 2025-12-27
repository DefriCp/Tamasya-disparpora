@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $wisata->nama ?? 'Wisata' }} - Wisata {{ $header->skpd ?? '' }} Kabupaten Tasikmalaya</title>
    {{-- Gunakan daya_tarik_wisata sebagai fallback jika deskripsi kosong --}}
    <meta name="description" content="{{ Str::limit(strip_tags($wisata->deskripsi ?? $wisata->daya_tarik_wisata ?? ''), 150, '...') }}">
    <meta name="keywords"
        content="{{ $header->skpd ?? '' }}, {{ $wisata->nama ?? '' }}, wisata tasikmalaya, destinasi wisata, {{ $wisata->kecamatan->nama ?? '' }}">
@endpush

@push('styles')
    <style>
        /* Gallery hover effect */
        .gallery-image {
            transition: transform 0.3s ease;
        }
        .gallery-image:hover {
            transform: scale(1.03);
        }
    </style>
@endpush

@section('content')
    @php
        $bgImage = 'assets/img/default-wisata.jpg'; // Default fallback
        
        if (!empty($wisata->cover_image)) {
            $bgImage = 'storage/' . $wisata->cover_image;
        } elseif ($wisata->photos && $wisata->photos->first()) {
            $bgImage = 'storage/' . $wisata->photos->first()->photo;
        }
    @endphp

    <section class="relative h-64 md:h-[500px] overflow-hidden bg-gray-900">
        {{-- Hero Image as IMG tag for better visibility/debugging --}}
        <img src="{{ asset($bgImage) }}" 
             alt="{{ $wisata->nama ?? 'Hero Image' }}" 
             class="absolute inset-0 w-full h-full object-contain">
             
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gray-900 bg-opacity-60"></div>
        
        <div class="container relative flex items-center px-4 mx-auto mt-24 md:mt-40">
            <div class="flex flex-col items-center justify-between w-full text-white lg:w-3/4 lg:items-start lg:text-left">
                <nav class="flex items-center mb-4 space-x-2 text-xs md:text-base text-green-100">
                    <a href="{{ route('fe.beranda') }}" class="text-white transition-colors hover:text-green-400">Beranda</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <a href="{{ route('fe.wisata') }}" class="text-white transition-colors hover:text-green-400">Wisata</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <span class="font-semibold text-green-300 truncate max-w-[100px] md:max-w-none">{{ $wisata->nama }}</span>
                </nav>
                <h1 class="text-2xl font-bold leading-tight md:text-5xl drop-shadow-lg text-center md:text-left">{{ $wisata->nama ?? '-' }}</h1>
                
                {{-- Tampilkan Lokasi Singkat --}}
                @if($wisata->desa || $wisata->kecamatan)
                <p class="mt-2 text-sm md:text-lg text-gray-200">
                    <i class="mr-1 fa-solid fa-location-dot"></i> 
                    {{ $wisata->desa->nama ?? '' }}, {{ $wisata->kecamatan->nama ?? '' }}
                </p>
                @endif
            </div>
        </div>
    </section>

    <main class="container px-4 py-8 mx-auto lg:flex md:gap-8 xl:gap-12 lg:py-16">
        <div class="lg:w-2/3">
            
            <div class="p-6 mb-8 bg-white border border-gray-100 shadow-sm rounded-3xl md:p-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-800 border-b pb-4">Tentang Destinasi</h2>
                
                <div class="leading-relaxed prose prose-lg text-gray-600 max-w-none">
                    {{-- Prioritaskan deskripsi, jika kosong tampilkan daya tarik --}}
                    @if(!empty($wisata->deskripsi))
                        {!! $wisata->deskripsi !!}
                    @else
                        <p>{{ $wisata->daya_tarik_wisata ?? 'Informasi detail belum tersedia.' }}</p>
                    @endif
                </div>

                {{-- INFORMASI DETAIL (Berdasarkan kolom di Database) --}}
                <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
                    @if($wisata->potensi_unggulan)
                    <div class="p-4 rounded-xl bg-blue-50">
                        <h4 class="font-semibold text-blue-800 mb-2">✨ Potensi Unggulan</h4>
                        <p class="text-sm text-gray-700">{{ $wisata->potensi_unggulan }}</p>
                    </div>
                    @endif

                    @if($wisata->amenitas)
                    <div class="p-4 rounded-xl bg-green-50">
                        <h4 class="font-semibold text-green-800 mb-2">🏨 Fasilitas / Amenitas</h4>
                        <p class="text-sm text-gray-700">{{ $wisata->amenitas }}</p>
                    </div>
                    @endif

                    @if($wisata->aktivitas)
                    <div class="p-4 rounded-xl bg-orange-50">
                        <h4 class="font-semibold text-orange-800 mb-2">🏃 Aktivitas</h4>
                        <p class="text-sm text-gray-700">{{ $wisata->aktivitas }}</p>
                    </div>
                    @endif

                    @if($wisata->kondisi_akses)
                    <div class="p-4 rounded-xl bg-gray-50">
                        <h4 class="font-semibold text-gray-800 mb-2">🚗 Aksesibilitas</h4>
                        <p class="text-sm text-gray-700">{{ $wisata->kondisi_akses }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if ($wisata->photos && $wisata->photos->count() > 0)
            <div class="p-6 mb-8 bg-white border border-gray-100 shadow-sm rounded-3xl md:p-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-800">Galeri Foto</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                    @foreach ($wisata->photos as $foto)
                        <div class="relative overflow-hidden cursor-pointer rounded-2xl gallery-image group aspect-square"
                             onclick="openModal('{{ asset('storage/' . $foto->photo) }}')">
                            <img src="{{ asset('storage/' . $foto->photo) }}" alt="{{ $wisata->nama }}"
                                 class="object-cover w-full h-full shadow-md">
                            <div class="absolute inset-0 flex items-center justify-center transition-all duration-300 bg-black bg-opacity-0 group-hover:bg-opacity-30">
                                <i class="text-3xl text-white opacity-0 fa-solid fa-magnifying-glass-plus group-hover:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <aside class="mt-8 lg:w-1/3 lg:mt-0">
            @if($wisata->nomor_hp || $wisata->nama_pengelola)
            <div class="p-6 mb-6 text-white bg-gradient-to-br from-green-600 to-teal-700 shadow-lg rounded-3xl">
                <h3 class="mb-4 text-xl font-bold">Info Kontak</h3>
                @if($wisata->nama_pengelola)
                    <div class="mb-3">
                        <span class="block text-xs text-green-200 uppercase">Pengelola</span>
                        <span class="font-medium">{{ $wisata->nama_pengelola }}</span>
                    </div>
                @endif
                @if($wisata->nomor_hp)
                    <div>
                        <span class="block text-xs text-green-200 uppercase">Telepon / WhatsApp</span>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $wisata->nomor_hp)) }}" 
                           target="_blank" class="flex items-center gap-2 mt-1 font-bold hover:underline">
                            <i class="fa-brands fa-whatsapp"></i> {{ $wisata->nomor_hp }}
                        </a>
                    </div>
                @endif
            </div>
            @endif

            <div class="sticky p-6 bg-white border border-gray-200 shadow-sm rounded-3xl top-24">
                <h3 class="mb-4 text-xl font-bold text-gray-800 border-b pb-2">Wisata Lainnya</h3>
                <div class="space-y-4">
                    @foreach ($wisatalain as $item)
                        @php
                            // Mengambil foto pertama atau default
                            $itemPhoto = $item->photos?->first()?->photo ?? 'assets/img/default-wisata.jpg'; 
                        @endphp
                        <a href="{{ route('fe.wisata.detail', $item->slug) }}" class="flex items-start p-2 transition-colors rounded-xl hover:bg-gray-50 group">
                            <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $itemPhoto) }}"
                                     alt="{{ $item->nama }}"
                                     class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" 
                                     loading="lazy"
                                     onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-2 group-hover:text-green-600">{{ $item->nama }}</h4>
                                <p class="mt-1 text-xs text-gray-500 line-clamp-1">
                                    <i class="fa-solid fa-map-pin mr-1"></i> {{ $item->kecamatan->nama ?? 'Tasikmalaya' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('fe.wisata') }}" class="inline-block px-6 py-2 text-sm font-semibold text-green-600 transition-colors border border-green-600 rounded-full hover:bg-green-600 hover:text-white">
                        Lihat Semua Wisata
                    </a>
                </div>
            </div>
        </aside>
    </main>
@endsection

@push('js')
<script>
    // Simple Modal Image Viewer
    function openModal(imageUrl) {
        const modalOverlay = document.createElement('div');
        Object.assign(modalOverlay.style, {
            position: 'fixed', top: 0, left: 0, width: '100vw', height: '100vh',
            background: 'rgba(0,0,0,0.9)', display: 'flex', alignItems: 'center',
            justifyContent: 'center', zIndex: 9999, opacity: 0, transition: 'opacity 0.3s'
        });

        const img = document.createElement('img');
        img.src = imageUrl;
        Object.assign(img.style, {
            maxWidth: '90%', maxHeight: '85vh', borderRadius: '8px', 
            boxShadow: '0 0 20px rgba(0,0,0,0.5)', transform: 'scale(0.9)', transition: 'transform 0.3s'
        });

        modalOverlay.appendChild(img);
        
        // Close button
        const closeBtn = document.createElement('div');
        closeBtn.innerHTML = '&times;';
        Object.assign(closeBtn.style, {
            position: 'absolute', top: '20px', right: '30px', color: '#fff',
            fontSize: '40px', cursor: 'pointer', zIndex: 10000
        });
        
        closeBtn.onclick = () => removeModal();
        modalOverlay.onclick = (e) => { if(e.target === modalOverlay) removeModal(); };
        modalOverlay.appendChild(closeBtn);
        document.body.appendChild(modalOverlay);

        // Animation in
        requestAnimationFrame(() => {
            modalOverlay.style.opacity = 1;
            img.style.transform = 'scale(1)';
        });

        function removeModal() {
            modalOverlay.style.opacity = 0;
            img.style.transform = 'scale(0.9)';
            setTimeout(() => document.body.removeChild(modalOverlay), 300);
        }
    }
</script>
@endpush