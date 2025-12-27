@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $header->skpd ?? 'Template SKPD' }} - Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Berita terbaru dari {{ $header->skpd ?? 'Template SKPD' }}, Kabupaten Tasikmalaya. Dapatkan informasi resmi, update layanan publik, dan kegiatan pemerintah secara online dan terkini.">
    <meta name="keywords"
        content="berita {{ $header->skpd ?? 'Template SKPD' }}, berita tasikmalaya, pemerintah kabupaten tasikmalaya, e-government tasikmalaya, informasi daerah tasikmalaya, layanan publik terkini">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-80 md:h-[460px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            @if($header && $header->photos && $header->photos->isNotEmpty())
                <img src="{{ asset('storage/' . $header->photos->first()->photo) }}" 
                    alt="Background"
                    class="object-cover w-full h-full opacity-80">
            @else
                {{-- fallback image --}}
                <img src="{{ asset('images/default-bg.jpg') }}" 
                    alt="Background Default"
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
                    <span class="text-white">Berita</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Temukan Informasi Terbaru</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Akses berita terkini dari berbagai topik
                    hanya dalam
                    satu klik. Tetap terinformasi dengan rangkuman
                    berita paling relevan dan terpercaya.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto xl:gap-12 lg:pt-12 lg:pb-20">

        <div class="mb-6 md:flex md:items-center md:justify-between lg:mb-8">
            <div class="w-full mb-4 lg:w-2/3 md:mb-0">
                <h2 class="text-2xl font-bold text-gray-900">Berita Terbaru</h2>
            </div>
        </div>

        <!-- berita terbaru -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($berita as $item)
                <div style="border-color: var(--hover-border, rgb(229 231 235))"
                    onmouseover="this.style.setProperty('--hover-border', '{{ $header->warna_text_utama }}'); this.querySelector('.judul-hover').style.color = '{{ $header->warna_text_utama }}'"
                    onmouseout="this.style.setProperty('--hover-border', 'rgb(229 231 235)'); this.querySelector('.judul-hover').style.color = null"
                    class="block w-full max-w-md mx-auto overflow-hidden transition duration-300 bg-white border border-gray-200 group rounded-3xl hover:shadow-md">

                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $item->photo) }}" alt="Blog Image"
                            class="object-cover w-full h-48 transition-transform duration-500 ease-in-out transform group-hover:scale-105">
                    </div>

                    <div class="p-5">
                        <span class="flex items-center text-sm font-medium text-gray-500">
                            <i class="mr-1 fa-regular fa-clock"></i>
                            {{ $item->created_at->translatedFormat('l, d F Y') }}
                        </span>

                        <a href="{{ route('fe.berita.detail', $item->slug) }}" class="block mt-2">
                            <h3
                                class="text-lg font-bold text-gray-900 transition-colors duration-300 judul-hover line-clamp-2">
                                {{ $item->judul }}
                            </h3>
                        </a>

                        <p class="mt-1 text-sm text-gray-600 line-clamp-3">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginasi -->
        <div class="mt-8">
            {{ $berita->links('pagination::tailwind') }}
        </div>
    </main>
@endsection

@push('js')
@endpush
