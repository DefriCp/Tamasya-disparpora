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
                    satu
                    klik.
                    Tetap
                    terinformasi dengan rangkuman
                    berita paling relevan dan terpercaya.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto xl:gap-12 lg:pt-12 lg:pb-20">
        <!-- berita popular -->
        <h2 class="mb-6 text-2xl font-bold text-gray-900 lg:mb-8">Berita Terpopuler</h2>
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($beritaPopuler as $item)
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
                            Rabu, 19 Juni 2025
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

        <div class="mb-6 md:flex md:items-center md:justify-between lg:mb-8">
            <div class="w-full mb-4 lg:w-2/3 md:mb-0">
                <h2 class="text-2xl font-bold text-gray-900">Berita Terbaru</h2>
            </div>
            {{-- <div class="w-full lg:w-1/3">
                <input type="text" placeholder="Cari berita..."
                    class="block w-full px-4 py-2 text-base transition-all duration-300 border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:shadow-md">
            </div> --}}
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
                            Rabu, 19 Juni 2025
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
        {{-- <div class="items-center justify-between mt-8 md:flex lg:mt-16">
            <div class="mb-4 text-sm text-gray-500 md:mb-0">
                Page <span class="font-medium text-gray-900">1</span> of <span class="font-medium text-gray-900">10</span>
            </div>

            <div class="flex items-center space-x-2">
                <!-- Previous Button -->
                <button
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-500 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Previous
                </button>

                <!-- Page Numbers -->
                <div class="flex items-center space-x-2">
                    <button
                        class="w-10 h-10 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        1
                    </button>
                    <button
                        class="w-10 h-10 text-sm font-medium text-gray-500 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700">
                        2
                    </button>
                    <button
                        class="w-10 h-10 text-sm font-medium text-gray-500 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700">
                        3
                    </button>
                    <button
                        class="w-10 h-10 text-sm font-medium text-gray-500 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700">
                        4
                    </button>
                </div>

                <!-- Next Button -->
                <button
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-500 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700">
                    Next
                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div> --}}
    </main>
@endsection

@push('js')
@endpush
