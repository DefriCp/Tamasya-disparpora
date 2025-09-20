@extends('fe.layouts.main')
@push('meta-seo')
    <title>Dokumen - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Kumpulan dokumen resmi {{ $header->skpd }}, Kabupaten Tasikmalaya. Akses laporan, kebijakan, regulasi, dan file penting lainnya secara online dan mudah.">
    <meta name="keywords"
        content="dokumen {{ $header->skpd }}, dokumen pemerintah tasikmalaya, laporan skpd tasikmalaya, regulasi daerah tasikmalaya, download dokumen publik, e-government tasikmalaya">
    <meta name="author" content="Sony Maulana M, S.Kom., Dinda Fazryan, S.Kom.">
@endpush

@push('custom-css')
@endpush

@section('content')
    <!-- Hero Section with Background -->
    <section class="relative h-96 md:h-[520px] bg-green-500 overflow-hidden">
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
                    <span class="text-white">Dokumen</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Dokumen</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Akses informasi produk hukum terpadu dan
                    dokumen resmi yang telah dirancang dan disusun
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Content Section -->
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 -mt-[150px] md:-mt-[220px] z-10 relative">
                <div class="justify-between gap-3 mb-8 space-y-4 md:space-y-0 sm:flex sm:items-center">
                    <form action="{{ route('fe.dokumen') }}" method="GET" class="w-full max-w-md">
                        <div class="relative group">
                            <!-- Input Search -->
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full px-4 py-3 text-base transition-all duration-300 border border-gray-300 custom-focus rounded-xl focus:shadow-md"
                                placeholder="Cari dokumen">
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                            <!-- Submit Button -->
                            <button type="submit"
                                class="absolute px-4 py-2 text-sm font-medium text-white transition duration-150 rounded-lg right-2 bottom-1.5 btn-color-primary focus:ring-2 focus:ring-slate-300">
                                Cari
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('fe.dokumen') }}" method="GET" class="w-full max-w-md">
                        <div class="flex items-center gap-4">
                            <select name="tahun"
                                class="block w-full px-4 py-3 text-base transition-all duration-300 border border-gray-300 custom-focus rounded-xl focus:shadow-md">
                                <option value="">Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <div class="flex items-center gap-3">
                                <button type="submit"
                                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition duration-150 rounded-lg btn-color-primary focus:ring-2 focus:ring-slate-300">
                                    Filter
                                </button>
                                <a href="{{ route('fe.dokumen') }}"
                                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition duration-150 rounded-lg btn-color-primary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Document Card -->
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($dokumen as $item)
                        <div class="p-6 duration-150 bg-white border border-gray-300 rounded-2xl hover:shadow">
                            <span style="color:{{ $header->warna_text_utama }}"
                                class="inline-flex items-center px-3 py-2 text-xs font-medium bg-gray-100 border border-gray-200 rounded-lg">
                                Tanggal Publikasi : Jumat,
                                05/07/2024
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-gray-800 capitalize line-clamp-2">
                                {{ $item->nama }}</h3>

                            <div class="flex items-center justify-start mt-4 space-x-6">
                                {{-- <button style="color:{{ $header->warna_text_utama }}"
                                        class="inline-flex items-center text-sm transition duration-150">
                                        <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                    </button> --}}
                                <a href="{{ asset('storage/' . $item->file) }}" download="{{ $item->nama }}"
                                    style="color:{{ $header->warna_text_utama }}"
                                    class="inline-flex items-center text-sm transition duration-150">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 p-6 text-center md:col-span-2 lg:col-span-3">
                            <p class="text-gray-500">Tidak ada dokumen yang ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $dokumen->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
@endpush
