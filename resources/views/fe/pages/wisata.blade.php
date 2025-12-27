@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $header->skpd ?? 'Destinasi Wisata' }} - Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Informasi destinasi wisata di Kabupaten Tasikmalaya. Temukan keindahan alam dan budaya Tasikmalaya.">
@endpush

@section('content')

{{-- ================= CONTENT ================= --}}
<main class="px-4 py-6 md:py-12 mt-20 md:mt-28 mx-auto max-w-7xl">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="col-span-1 md:col-span-3">
            <div class="sticky top-24 md:top-28 bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                
                {{-- Header Mobile Toggle --}}
                <div class="p-4 md:p-5 border-b border-gray-200 flex items-center justify-between cursor-pointer md:cursor-default bg-gray-50 md:bg-white" onclick="toggleFilterMobile()">
                    <h3 class="text-lg md:text-xl font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter Destinasi
                    </h3>
                    <i class="fas fa-chevron-down md:hidden text-gray-500 transition-transform duration-300" id="filterArrow"></i>
                </div>

                {{-- Filter Content (Hidden on Mobile by default) --}}
                <div id="filterContent" class="hidden md:block p-4 md:p-5">
                    {{-- Kecamatan Filter --}}
                    <div class="mb-4">
                        <label class="block mb-1.5 text-xs font-bold uppercase text-gray-500 tracking-wider">
                            Kecamatan
                        </label>
                        <select id="kecamatanSelect" 
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 hover:bg-white text-gray-700">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatanList as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Desa Filter --}}
                    <div class="mb-5 pb-5 border-b border-gray-200">
                        <label class="block mb-1.5 text-xs font-bold uppercase text-gray-500 tracking-wider">
                            Desa
                        </label>
                        <select id="desaSelect" 
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 hover:bg-white text-gray-700">
                            <option value="">Semua Desa</option>
                            @foreach ($desaList as $desa)
                                <option value="{{ $desa }}">{{ $desa }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jenis Wisata --}}
                    <div>
                        <label class="block mb-2 text-xs font-bold uppercase text-gray-500 tracking-wider">
                            Kategori
                        </label>

                        <div class="grid grid-cols-2 gap-2">
                            {{-- Semua --}}
                            <a href="{{ route('fe.wisata') }}"
                               class="px-3 py-2 rounded-lg text-xs font-bold text-center transition-all duration-200 border
                                      {{ empty($jenisFilter) 
                                         ? 'bg-blue-600 text-white border-blue-600 shadow-md' 
                                         : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400 hover:text-blue-600' }}">
                                Semua
                            </a>

                            {{-- Loop Jenis Wisata --}}
                            @foreach ($jenisWisata as $jenis)
                                <a href="{{ route('fe.wisata', array_filter([
                                    'search' => request('search'),
                                    'jenis' => $jenis
                                ])) }}"
                                   class="px-3 py-2 rounded-lg text-xs font-bold text-center transition-all duration-200 border
                                          {{ $jenisFilter === $jenis 
                                             ? 'bg-blue-600 text-white border-blue-600 shadow-md' 
                                             : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400 hover:text-blue-600' }}">
                                    {{ $jenis }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <section class="col-span-1 md:col-span-9 pl-0 md:pl-4">
            
            {{-- Title & Description Section --}}
            <div class="mb-8 md:mb-10 text-center md:text-left animate-fade-in">
                <h1 class="text-2xl md:text-5xl font-extrabold text-gray-900 mb-4 md:mb-6 leading-tight">
                    Temukan dan jelajahi <br class="hidden md:block">destinasi terbaik <br class="md:hidden">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">
                        di Kabupaten Tasikmalaya
                    </span>
                </h1>
                <p class="text-gray-600 text-sm md:text-lg leading-relaxed max-w-4xl md:text-justify mx-auto md:mx-0">
                    Selamat datang di Kabupaten Tasikmalaya, surga tersembunyi di Jawa Barat yang menawarkan keindahan alam, budaya yang kaya, dan pengalaman yang tak terlupakan. Temukan dan jelajahi destinasi terbaik di wilayah ini.
                </p>
            </div>

            {{-- Grid Destinasi --}}
            <div id="destinasiGrid" class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($wisata as $item)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 destination-card h-full flex flex-col"
                         data-kecamatan="{{ $item->kecamatan?->nama }}"
                         data-desa="{{ $item->desa?->nama }}"
                         data-jenis="{{ implode(',', $item->jenis ?? []) }}">

                        {{-- FOTO --}}
                        <div class="relative overflow-hidden rounded-t-2xl h-56">
                            <img src="{{ $item->photos->first() ? asset('storage/' . $item->photos->first()->photo) : asset('images/placeholder.jpg') }}"
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700"
                                 alt="{{ $item->nama }}">
                            
                            {{-- Badge Jenis --}}
                             <div class="absolute top-3 right-3 flex flex-wrap gap-1 justify-end">
                                @foreach ($item->jenis ?? [] as $j)
                                    <span class="px-3 py-1 text-xs font-bold text-white bg-black/50 backdrop-blur-md rounded-full border border-white/20">
                                        {{ $j }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-2">
                                {{ $item->nama }}
                            </h3>
                            
                            <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="line-clamp-1">
                                    {{ $item->desa?->nama ?? '-' }}, {{ $item->kecamatan?->nama ?? '-' }}
                                </span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <a href="{{ route('fe.wisata.detail', $item->slug) }}" class="text-sm font-semibold text-primary hover:text-blue-700 transition-colors flex items-center gap-1">
                                    Jelajahi
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-4 bg-gray-50 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Belum ada destinasi ditemukan</h3>
                        <p class="text-gray-500">Coba ubah filter pencarian Anda</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $wisata->links() }}
            </div>
        </section>
    </div>
</main>
@endsection

@push('js')
<script>
function toggleFilterMobile() {
    const content = document.getElementById('filterContent');
    const arrow = document.getElementById('filterArrow');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        arrow.style.transform = 'rotate(0deg)';
    }
}

function filterDestinasi(jenis = null) {
    const cards = document.querySelectorAll('.destination-card');
    const kecamatan = document.getElementById('kecamatanSelect').value;
    const desa = document.getElementById('desaSelect').value;

    cards.forEach(card => {
        let show = true;
        if (kecamatan && card.dataset.kecamatan !== kecamatan) show = false;
        if (desa && card.dataset.desa !== desa) show = false;
        if (jenis && !card.dataset.jenis.includes(jenis)) show = false;

        card.style.display = show ? 'block' : 'none';
    });
}

document.getElementById('kecamatanSelect').addEventListener('change', () => filterDestinasi());
document.getElementById('desaSelect').addEventListener('change', () => filterDestinasi());

document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function () {
        filterDestinasi(this.dataset.jenis);
    });
});
</script>
@endpush
