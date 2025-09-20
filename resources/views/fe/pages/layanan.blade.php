@extends('fe.layouts.main')

@push('meta-seo')
    <title>Layanan - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Layanan publik dari {{ $header->skpd }}, Kabupaten Tasikmalaya. Temukan informasi layanan online, prosedur, persyaratan, dan alur pelayanan resmi terkini secara mudah dan cepat.">
    <meta name="keywords"
        content="layanan {{ $header->skpd }}, layanan publik tasikmalaya, layanan online pemkab tasikmalaya, prosedur layanan skpd, e-government tasikmalaya, pelayanan masyarakat tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-96 md:h-[520px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $header->photos->first()->photo) }}" alt="Background"
                class="object-cover w-full h-full opacity-80">
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-80"></div>

        <!-- Content -->
        <div class="container relative flex items-center px-4 mx-auto mt-32 md:mt-38">
            <div class="flex flex-col items-center justify-between w-full text-white lg:w-2/3 lg:items-start lg:text-left">
                <nav class="flex items-center mb-2 space-x-2 text-green-100 lg:mb-4">
                    <a href="#" class="text-white transition-colors hover:text-green-500">Beranda</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <span class="text-white">Layanan</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Layanan</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">
                    Dirancang untuk memberikan kemudahan akses dan meningkatkan kualitas pelayanan publik
                    di lingkungan instansi melalui solusi digital yang inovatif dan responsif.
                </p>
            </div>

        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Content Section -->
            <div class="relative z-10 p-8 -mt-[220px] bg-white shadow-lg rounded-3xl md:p-12">
                {{-- Layanan SKPD --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($layanan as $item)
                        <!-- Card Layanan -->
                        <div class="p-6 transition duration-200 bg-white border border-gray-300 rounded-2xl hover:shadow"
                            onmouseover="this.style.backgroundColor='{{ $header->warna_text_utama }}'; this.querySelector('a').style.color='white'; this.querySelector('h4').style.color='white'; this.querySelector('p').style.color='white'"
                            onmouseout="this.style.backgroundColor='white'; this.querySelector('a').style.color='{{ $header->warna_text_utama }}'; this.querySelector('h4').style.color='#1F2937'; this.querySelector('p').style.color='#1F2937'">

                            <h4 class="mb-2 text-lg font-semibold text-gray-800 transition-colors duration-200">
                                {{ $item->nama }}
                            </h4>

                            <p class="mb-4 text-sm text-gray-600 transition duration-200 line-clamp-3">
                                {{ $item->deskripsi }}
                            </p>

                            <a href="{{ $item->url }}" target="_blank" style="color: {{ $header->warna_text_utama }}"
                                class="inline-flex items-center text-sm transition duration-200">
                                Akses <i class="ml-1 fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
@endpush
