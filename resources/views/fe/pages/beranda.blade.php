@extends('fe.layouts.main')

@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="relative overflow-hidden"> 
    
    {{-- Swiper Container --}}
    <div class="relative swiper heroSwiper w-full h-[650px] md:h-[750px] lg:h-[90vh]">
        @php
            $photos = $header?->photos ?? collect();
        @endphp

        <div class="swiper-wrapper">
            @if ($photos->isNotEmpty())
                @foreach ($photos as $slider)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $slider->photo) }}"
                            alt="Header Slide"
                            class="w-full h-full object-cover">
                    </div>
                @endforeach
            @else
                <div class="swiper-slide">
                    <div class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
                </div>
            @endif
        </div>
    </div>

    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/50 to-black/70 z-10 pointer-events-none"></div>
    
    {{-- Pattern Overlay --}}
    <div class="absolute inset-0 opacity-10 z-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    {{-- Hero Content --}}
    <div class="absolute inset-0 flex items-center justify-center z-20">
        <div class="text-center text-white px-4 max-w-5xl mx-auto">
            
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-6 py-3 rounded-full mb-6 animate-fade-in">
                <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-semibold">Destinasi Wisata Kabupaten Tasikmalaya</span>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight animate-slide-up">
                Jelajahi Wisata<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-blue-100 to-white">
                    Penuh Keindahan
                </span>
            </h1>

            {{-- Description --}}
            <p class="text-lg md:text-xl text-blue-100 max-w-3xl mx-auto mb-10 leading-relaxed animate-slide-up-delay">
                Temukan destinasi wisata unggulan dan keindahan alam daerah Kabupaten Tasikmalaya. 
                Nikmati pengalaman berwisata yang tak terlupakan bersama keluarga.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap justify-center gap-4 animate-fade-in-delay">
                <a href="{{ route('fe.wisata') }}" 
                    class="group bg-white text-blue-700 font-bold px-8 py-4 rounded-full hover:bg-blue-50 transform hover:scale-105 transition duration-300 shadow-xl inline-flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Jelajahi Destinasi
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('fe.berita') }}" 
                    class="bg-transparent border-2 border-white text-white font-bold px-8 py-4 rounded-full hover:bg-white hover:text-blue-700 transform hover:scale-105 transition duration-300 backdrop-blur-sm inline-flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Baca Berita
                </a>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Wave SVG Bottom --}}
    <div class="absolute bottom-0 left-0 right-0 z-20">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="#F9FAFB"/> 
        </svg>
    </div>
</section>

{{-- Swiper Initialization --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.heroSwiper')) {
            new Swiper('.heroSwiper', {
                loop: true,
                effect: 'fade',
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
            });
        }
    });
</script>

{{-- Destinasi Wisata Section --}}
<section class="py-12 md:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Section Header --}}
        <div class="text-center mb-12">
            <div class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                🏖️ Eksplorasi
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                Destinasi Wisata Unggulan
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai destinasi wisata menarik yang siap memanjakan liburan Anda
            </p>
        </div>

        {{-- Destinasi Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($destinasiWisata as $wisata)
                <a href="{{ route('fe.wisata.detail', $wisata->slug) }}"
                   class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">

                    {{-- Image --}}
                    <div class="relative overflow-hidden">
                        @if($wisata->photos->count())
                            <img src="{{ asset('storage/' . $wisata->photos->first()->photo) }}"
                                 alt="{{ $wisata->nama }}"
                                 class="w-full h-56 object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-blue-200 to-blue-400 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                        <div class="absolute top-4 right-4">
                            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                ⭐ Populer
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition duration-300">
                            {{ $wisata->nama }}
                        </h3>
                        <p class="text-sm text-gray-600 line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit(strip_tags($wisata->deskripsi), 120) }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2 text-gray-500 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="text-xs">Lokasi</span>
                            </div>
                            <span class="text-blue-600 font-semibold text-sm group-hover:translate-x-1 transition inline-flex items-center gap-1">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Data wisata belum tersedia</p>
                </div>
            @endforelse
        </div>

        {{-- View All Button --}}
        @if(count($destinasiWisata) > 0)
        <div class="text-center">
            <a href="{{ route('fe.wisata') }}"
               class="inline-flex items-center gap-3 bg-blue-600 text-white font-bold px-8 py-4 rounded-full hover:bg-blue-700 transform hover:scale-105 transition duration-300 shadow-lg">
                Lihat Semua Destinasi
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Berita Wisata Section --}}
<section class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Section Header --}}
        <div class="text-center mb-12">
            <div class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                📰 Update Terbaru
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                Berita & Informasi Wisata
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Dapatkan informasi terkini seputar destinasi wisata dan event menarik
            </p>
        </div>

        {{-- Berita Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($beritaWisata as $berita)
                <article class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 border border-gray-100">

                    {{-- Image --}}
                    <div class="relative overflow-hidden">
                        @if($berita->photo)
                            <img src="{{ asset('storage/' . $berita->photo) }}"
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-52 object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-52 bg-gradient-to-br from-green-200 to-green-400 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                Berita
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-gray-500 text-xs mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <time>{{ $berita->created_at->translatedFormat('d F Y') }}</time>
                        </div>

                        <h3 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition duration-300 leading-snug">
                            {{ $berita->judul }}
                        </h3>

                        <p class="text-sm text-gray-600 line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit(strip_tags($berita->konten), 120) }}
                        </p>

                        <a href="{{ route('fe.berita.detail', $berita->slug) }}"
                           class="inline-flex items-center gap-2 text-green-600 font-semibold text-sm hover:gap-3 transition-all duration-300">
                            Baca Selengkapnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Berita belum tersedia</p>
                </div>
            @endforelse
        </div>

        {{-- View All Button --}}
        @if(count($beritaWisata) > 0)
        <div class="text-center">
            <a href="{{ route('fe.berita') }}"
               class="inline-flex items-center gap-3 bg-green-600 text-white font-bold px-8 py-4 rounded-full hover:bg-green-700 transform hover:scale-105 transition duration-300 shadow-lg">
                Lihat Semua Berita
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Custom Animations --}}
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(30px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-fade-in-delay {
        animation: fadeIn 1s ease-out 0.3s both;
    }
    
    .animate-slide-up {
        animation: slideUp 0.8s ease-out;
    }
    
    .animate-slide-up-delay {
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

@endsection