@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $berita->judul }} - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description" content="{{ Str::limit(strip_tags($berita->isi), 150, '...') }}">
    <meta name="keywords"
        content="{{ $header->skpd }}, {{ $berita->judul }}, berita tasikmalaya, pemerintah daerah tasikmalaya, layanan publik tasikmalaya, e-government tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <nav class="flex text-sm text-gray-500">
                <a href="{{ route('fe.beranda') }}" class="hover:text-green-600 transition">Beranda</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-800 line-clamp-1">{{ $berita->judul }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container px-4 py-8 mx-auto lg:flex xl:gap-12 lg:py-12">
        <!-- Left Side: News Detail Card -->
        <div class="w-full mx-auto lg:w-2/3">
            <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-10">
                    <!-- Header -->
                    <header class="mb-8">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                            {{ $berita->judul }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar text-green-500"></i>
                                <span>{{ \Carbon\Carbon::parse($berita->waktu_publish)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-user text-blue-500"></i>
                                <span>{{ $berita->header->singkatan_skpd ?? 'Admin' }}</span>
                            </div>
                             <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-eye text-orange-500"></i>
                                <span>{{ $berita->dilihat ?? 0 }} Dilihat</span>
                            </div>
                        </div>


                    </header>

                    <!-- Featured Image -->
                    <figure class="mb-8 overflow-hidden rounded-2xl shadow-md border border-gray-100">
                        <img src="{{ asset('storage/' . $berita->photo) }}" 
                             alt="{{ $berita->judul }}" 
                             class="w-full h-auto object-cover transform hover:scale-105 transition duration-700 ease-in-out">
                    </figure>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8">
                        {!! $berita->isi !!}
                    </div>

                    <!-- Footer / Tags -->
                    @if(count($berita->tags) > 0)
                    <div class="pt-6 border-t border-gray-100">
                        <h4 class="mb-3 text-sm font-bold text-gray-500 uppercase tracking-wider">Topik Terkait:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($berita->tags as $tag)
                                <a href="#" class="px-4 py-1.5 text-sm font-medium text-green-700 bg-green-50 rounded-full hover:bg-green-100 transition">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </article>
        </div>

        <!-- Right Side: Sidebar -->
        <aside class="w-full mx-auto mt-8 lg:w-1/3 lg:mt-0">
             <div class="sticky top-24">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="flex items-center gap-2 mb-6 text-xl font-bold text-gray-900 border-b pb-4">
                        <i class="fa-solid fa-newspaper text-green-600"></i> Berita Terbaru
                    </h3>
                    
                    <div class="space-y-6">
                        @foreach ($beritaLain as $item)
                        <article class="group flex gap-4">
                            <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('storage/' . $item->photo) }}" 
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div class="flex flex-col justify-center">
                                <a href="{{ route('fe.berita.detail', $item->slug) }}" class="font-bold text-gray-800 leading-snug hover:text-green-600 transition line-clamp-2 mb-1">
                                    {{ $item->judul }}
                                </a>
                                <time class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($item->waktu_publish)->diffForHumans() }}
                                </time>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <a href="{{ route('fe.berita') }}" class="inline-block px-6 py-2 text-sm font-bold text-green-600 border border-green-600 rounded-full hover:bg-green-600 hover:text-white transition">
                            Lihat Semua Berita
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </main>
@endsection

@push('js')
@endpush
