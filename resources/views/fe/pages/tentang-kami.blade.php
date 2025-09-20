@extends('fe.layouts.main')

@push('meta-seo')
    <title>Tentang Kami - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Tentang {{ $header->skpd }}, Kabupaten Tasikmalaya. Pelajari lebih lanjut mengenai sejarah singkat, visi misi, tujuan, dan peran kami dalam mendukung pembangunan dan pelayanan masyarakat.">
    <meta name="keywords"
        content="tentang {{ $header->skpd }}, profil lembaga pemkab tasikmalaya, sejarah skpd tasikmalaya, visi misi skpd, informasi dinas daerah">
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
                    <span class="text-white">Tentang Kami</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Tentang Kami</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base"> Visi yang menjadi panduan, serta misi yang
                    kami jalankan untuk terus memberikan nilai terbaik dalam setiap langkah.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Content Section -->
            <div class="relative z-10 p-8 -mt-[120px] md:-mt-[220px] bg-white shadow-lg rounded-3xl md:p-12">
                <img src="{{ asset('storage/' . $tentang->photo) }}"
                    class="object-cover w-full mb-8 aspect-[3/2] rounded-2xl">
                <h2 class="mb-6 text-3xl font-bold text-center text-gray-800 md:text-4xl">Sejarah</h2>

                <div class="leading-relaxed prose prose-lg text-gray-700 max-w-none">
                    <p class="mb-6 text-justify">
                        {!! $tentang->sejarah !!}
                    </p>

                    <h3 class="mt-6 text-lg font-medium">Visi</h3>
                    <p>
                        {!! $tentang->visi !!}

                    </p>

                    <h3 class="mt-6 text-lg font-medium">Misi</h3>
                    <div>{!! $tentang->misi !!}</div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
@endpush
