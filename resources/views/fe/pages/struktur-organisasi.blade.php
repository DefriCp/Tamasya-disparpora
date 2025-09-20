@extends('fe.layouts.main')

@push('meta-seo')
    <title>Struktur Organisasi - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Struktur organisasi resmi {{ $header->skpd }}, Kabupaten Tasikmalaya. Lihat bagan instansi, divisi, dan unit kerja yang mendukung pelayanan masyarakat secara efektif dan transparan.">
    <meta name="keywords"
        content="struktur organisasi {{ $header->skpd }}, bagan organisasi skpd tasikmalaya, struktur pemkab tasikmalaya, susunan lembaga pemerintah, organisasi dinas daerah">
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
                    <span class="text-white">Struktur Organisasi</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Struktur Organisasi</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Dirancang sedemikian rupa untuk meningkatkan
                    koordinasi dan produktivitas dalam menjalankan fungsi-fungsi organisasi, guna mendorong akselerasi
                    transformasi digital di lingkungan instansi.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Content Section -->
            <div class="relative z-10 p-8 -mt-[120px] md:-mt-[220px] bg-white shadow-lg rounded-3xl md:p-12">
                <img src="{{ asset('storage/' . $struktur->photo) }}"
                    class="object-contain w-full mb-16 aspect-[3/2] rounded-2xl">

                {{-- Bidang SKPD --}}
                <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($struktur->bidangs as $bidang)
                        <div class="p-6 transition duration-300 bg-white border shadow-sm border-slate-200 rounded-2xl hover:shadow-md"
                            onmouseover="this.style.backgroundColor='{{ $header->warna_text_utama }}'; this.querySelector('h3').style.color='white'; this.querySelector('p').style.color='white'"
                            onmouseout="this.style.backgroundColor='white'; this.querySelector('h3').style.color='#1F2937'; this.querySelector('p').style.color='#4B5563'">

                            <h3 class="text-lg font-bold text-gray-800 transition duration-200">
                                {{ $bidang->nama }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-600 transition duration-200">
                                {{ $bidang->deskripsi }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
@endpush
