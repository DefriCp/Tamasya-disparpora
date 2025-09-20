@extends('fe.layouts.main')

@push('meta-seo')
    <title>{{ $header->skpd ?? 'Template SKPD' }} - Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Informasi destinasi wisata di Kabupaten Tasikmalaya. Temukan keindahan alam, budaya, dan tempat wisata menarik di Tasikmalaya.">
    <meta name="keywords"
        content="wisata tasikmalaya, destinasi wisata tasikmalaya, tempat wisata tasikmalaya, pariwisata tasikmalaya, wisata alam tasikmalaya, wisata budaya tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-80 md:h-[460px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            @if ($header && $header->photos && $header->photos->isNotEmpty())
                <img src="{{ asset('storage/' . $header->photos->first()->photo) }}" alt="Background"
                    class="object-cover w-full h-full opacity-80">
            @else
                {{-- fallback image --}}
                <img src="{{ asset('images/default-bg.jpg') }}" alt="Background Default"
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
                    <span class="text-white">Wisata</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Destinasi Wisata Kabupaten Tasikmalaya</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Jelajahi keindahan alam dan budaya Kabupaten
                    Tasikmalaya yang menawan.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->

    {{-- <main class="container px-4 py-8 mx-auto xl:gap-12 lg:pt-12 lg:pb-20">
        <div id="map"class="w-full h-[700px] z-[10] relative bg-gradient-to-br from-blue-100 to-emerald-100 rounded-lg shadow-lg overflow-hidden">
        </div>
    </main> --}}

    <main class="container px-4 py-8 mx-auto">
        <!-- Filter Panel -->
        <div
            class="flex flex-col gap-4 p-4 mb-6 bg-white shadow-md rounded-2xl md:flex-row md:items-center md:justify-between">
            <div class="flex flex-col items-center gap-4 sm:flex-row">
                <!-- Dropdown Wilayah -->
                <div class="flex flex-col">
                    <label class="mb-1 text-sm font-medium text-gray-600">Kecamatan</label>
                    <div class="relative">
                        <select id="kecamatanSelect"
                            class="w-56 px-4 py-2 pr-10 transition bg-white border border-gray-300 shadow-sm appearance-none rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 text-sm font-medium text-gray-600">Desa</label>
                    <div class="relative">
                        <select id="desaSelect"
                            class="w-56 px-4 py-2 pr-10 transition bg-white border border-gray-300 shadow-sm appearance-none rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Desa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="flex gap-3">
      <button class="px-4 py-2 text-white transition duration-300 bg-blue-500 shadow-md hover:bg-blue-600 rounded-xl">
        Infografis
      </button>
      <button class="px-4 py-2 text-white transition duration-300 shadow-md bg-cyan-500 hover:bg-cyan-600 rounded-xl">
        Pencarian Data
      </button>
    </div> --}}
        </div>

        <!-- Layout Tabel + Peta -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <div class="bg-white rounded-2xl shadow-lg flex flex-col h-[700px]">
                <div class="px-6 py-4 border-b rounded-t-2xl bg-gradient-to-r from-[#009B4C] to-[#166FBE]">
                    <h2 class="text-lg font-semibold text-white">Data Kecamatan</h2>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-sm" id="dataTable">
                        <thead class="sticky top-0 bg-blue-100">
                            <tr class="text-left text-gray-700">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Kecamatan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="sticky bottom-0 bg-blue-50">
                            <tr class="font-bold">
                                <td class="px-4 py-3" colspan="2">TOTAL</td>
                                <td class="px-4 py-3 text-gray-800" id="totalWisata"></td>
                                <td class="px-4 py-3">-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="overflow-hidden shadow-md rounded-2xl">
                <div id="map" class="w-full h-[700px] z-[10] relative bg-white">
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
@endpush
