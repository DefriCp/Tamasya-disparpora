@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $detailBerita->judul }} - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description" content="{{ Str::limit(strip_tags($detailBerita->isi), 150, '...') }}">
    <meta name="keywords"
        content="{{ $header->skpd }}, {{ $detailBerita->judul }}, berita tasikmalaya, pemerintah daerah tasikmalaya, layanan publik tasikmalaya, e-government tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-[500px] bg-green-500 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $detailBerita->photo) }}" alt="Background" class="object-cover w-full h-full">
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-80"></div>

        <!-- Content -->
        <div class="container relative flex items-center px-4 mx-auto mt-28 md:mt-40">
            <div class="flex flex-col justify-between w-full text-white lg:w-2/3 lg:items-start lg:text-left">
                <nav class="flex items-center mb-5 space-x-2 text-green-100 lg:mb-12">
                    <a href="#" class="text-white transition-colors hover:text-green-500">Beranda</a>
                    <i class="text-xs fa-solid fa-chevron-right"></i>
                    <span class="text-sm text-white capitalize md:text-base line-clamp-1">{{ $detailBerita->judul }}</span>
                </nav>
                <h1 class="mb-5 text-3xl font-bold capitalize">{{ $detailBerita->judul }}</h1>

                <div class="">
                    <div class="inline-flex items-center px-3 py-2 mb-4 rounded-lg bg-gray-400/30">
                        <i class="fa-regular fa-clock"></i>
                        <span
                            class="ml-2 text-sm text-white">{{ \Carbon\Carbon::parse($detailBerita->waktu_publish)->translatedFormat('d F Y H:i:s') }}</span>
                    </div>
                    <div class="inline-flex items-center px-3 py-2 mb-4 rounded-lg bg-gray-400/30 md:ml-2">
                        <i class="fa-regular fa-eye"></i>
                        <span class="ml-2 text-sm text-white">{{ $detailBerita->dilihat ?? 0 }} Postingan ini dilihat</span>
                    </div>
                    <div class="inline-flex items-center px-3 py-2 mb-4 rounded-lg bg-gray-400/30 md:ml-2">
                        <i class="fa-regular fa-pen-to-square"></i>
                        <span class="ml-2 text-sm text-white">Ditulis Oleh :
                            {{ $detailBerita->header->singkatan_skpd }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto lg:flex xl:gap-12 lg:py-12">
        <!-- left side -->
        <div class="w-full mx-auto lg:w-2/3 lg:mx-4 ">
            <div class="flex flex-col flex-wrap">
                <img src="{{ asset('storage/' . $detailBerita->photo) }}" alt="Berita Image"
                    class="w-full h-80 sm:h-[450px] lg:h-[520px] object-cover rounded-2xl mb-6">
                <div class="mt-2 text-sm leading-relaxed prose-lg text-justify text-gray-700 md:text-lg">
                    {!! $detailBerita->isi !!}
                </div>
                <!-- Tag Berita -->
                <div class="mt-6">
                    <h4 class="mb-2 text-sm font-semibold text-gray-500">Tag:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($detailBerita->tags as $tag)
                            <span class="px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- right side -->
        <div class="w-full mx-auto mt-6 lg:w-1/3 lg:mx-4 lg:mt-0">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">Berita Terbaru</h3>
            <hr class="mb-4 border-2 border-gray-200 rounded-full">
            @foreach ($beritaTerbaru as $item)
                <div class="flex p-3 border-l-[6px] shadow group duration-200 rounded-2xl mb-4 space-y-1"
                    style="border-color: {{ $item->header->warna_text_utama }}"
                    onmouseover="this.style.borderColor='{{ $item->header->warna_text_utama }}'; this.querySelector('a').style.color='{{ $item->header->warna_text_utama }}'"
                    onmouseout="this.style.borderColor='{{ $item->header->warna_text_utama }}'; this.querySelector('a').style.color=null">

                    <img src="{{ asset('storage/' . $item->photo) }}" alt="Berita Thumbnail"
                        class="object-cover w-16 h-16 mr-4 rounded-xl">

                    <div class="space-y-1">
                        <a href="{{ route('fe.berita.detail', $item->slug) }}"
                            class="text-sm font-semibold text-gray-800 xl:text-base line-clamp-2"
                            style="transition: color 0.2s ease;">
                            {{ $item->judul }}
                        </a>
                        <p class="text-xs text-gray-700">
                            <i class="mr-1 fa-regular fa-clock"></i>
                            {{ \Carbon\Carbon::parse($item->waktu_publish)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

@push('js')
@endpush
