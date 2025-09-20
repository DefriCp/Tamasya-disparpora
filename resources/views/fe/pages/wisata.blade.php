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
    <div class="bg-white rounded-2xl shadow-md p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-col sm:flex-row items-center gap-4">
        <!-- Dropdown Wilayah -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600 mb-1">Kecamatan</label>
            <div class="relative">
                <select id="kecamatanSelect" 
                class="appearance-none w-56 rounded-xl border border-gray-300 bg-white px-4 py-2 pr-10 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition">
                <option value="">Pilih Kecamatan</option>
                </select>
            </div>
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600 mb-1">Desa</label>
                <div class="relative">
                    <select id="desaSelect" 
                    class="appearance-none w-56 rounded-xl border border-gray-300 bg-white px-4 py-2 pr-10 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Pilih Desa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="flex gap-3">
      <button class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl px-4 py-2 shadow-md transition duration-300">
        Infografis
      </button>
      <button class="bg-cyan-500 hover:bg-cyan-600 text-white rounded-xl px-4 py-2 shadow-md transition duration-300">
        Pencarian Data
      </button>
    </div> --}}
  </div>

  <!-- Layout Tabel + Peta -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

  <div class="bg-white rounded-2xl shadow-lg flex flex-col h-[700px]">
    <div class="px-6 py-4 border-b rounded-t-2xl bg-gradient-to-r from-[#009B4C] to-[#166FBE]">
      <h2 class="text-lg font-semibold text-white">Data Kecamatan</h2>
    </div>

    <div class="overflow-y-auto flex-1">
      <table class="w-full text-sm">
        <thead class="sticky top-0 bg-blue-100">
          <tr class="text-gray-700 text-left">
            <th class="px-4 py-3">No</th>
            <th class="px-4 py-3">Kecamatan</th>
            <th class="px-4 py-3">Jumlah</th>
            <th class="px-4 py-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">1</span>
            </td>
            <td class="px-4 py-3 font-medium">Aceh</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">367</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">2</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Utara</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">583</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
           <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold">3</span>
            </td>
            <td class="px-4 py-3 font-medium">Sumatera Barat</td>
            <td class="px-4 py-3 text-gray-700 font-semibold">611</td>
            <td class="px-4 py-3">
              <a href="#" class="text-blue-600 hover:underline font-medium">Buka</a>
            </td>
          </tr>
        </tbody>
        <tfoot class="sticky bottom-0 bg-blue-50">
          <tr class="font-bold">
            <td class="px-4 py-3" colspan="2">TOTAL</td>
            <td class="px-4 py-3 text-gray-800">1.561</td>
            <td class="px-4 py-3">-</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <div class="rounded-2xl shadow-md overflow-hidden">
    <div id="map" class="w-full h-[700px] z-[10] relative bg-white">
      </div>
  </div>
  </div> 
</main>


@endsection

@push('js')
@endpush
