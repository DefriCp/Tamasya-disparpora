@extends('fe.layouts.main')

@push('meta-seo')
    <title>Galeri - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Jelajahi galeri kegiatan {{ $header->skpd }}, Kabupaten Tasikmalaya. Lihat foto dan video terkini dari berbagai program dan aktivitas pemerintah daerah.">
    <meta name="keywords"
        content="galeri kegiatan {{ $header->skpd }}, foto kegiatan pemkab tasikmalaya, dokumentasi kegiatan skpd, video pemerintah tasikmalaya, galeri pemerintah daerah">
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
                    <span class="text-white">Galeri</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Galeri</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">
                    Dokumentasi kegiatan sebagai wujud transparansi dan informasi publik.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 -mt-[150px] md:-mt-[220px] z-10 relative">
                {{-- <h1 class="mb-6 text-2xl font-bold text-center">Galeri Kegiatan</h1> --}}
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($galeri as $item)
                        <!-- Card -->
                        <div class="p-4 border border-gray-300 shadow rounded-xl bg-gray-50">
                            <div class="flex items-center justify-center p-4 mb-4 bg-gray-200 rounded-lg">
                                <h2 class="text-base font-semibold text-center text-gray-800 md:text-lg">{{ $item->nama }}
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                                @foreach ($item->photogaleris->take(4) as $photo)
                                    <div class="overflow-hidden rounded-lg">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="{{ $item->nama }}"
                                            class="object-cover w-full cursor-pointer h-80"
                                            onclick="showPopup('{{ asset('storage/' . $photo->photo) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <p class="mt-4">{{ $galeri->links() }}</p>
                </div>
            </div>
        </div>

        <!-- Popup -->
        <div id="photo-popup" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-75">
            <div class="relative mx-4 mx:md-0">
                <!-- Gambar Popup -->
                <img id="popup-image" src="" alt="Popup Image"
                    class="object-cover w-full h-96 md:h-[620px] rounded-xl">
                <!-- Tombol Tutup -->
                <button onclick="closePopup()"
                    class="absolute text-3xl font-bold text-gray-700 top-4 right-4">&times;</button>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        function showPopup(imageUrl) {
            // Ambil elemen popup
            const popup = document.getElementById('photo-popup');
            const popupImage = document.getElementById('popup-image');

            // Atur URL gambar dan tampilkan popup
            popupImage.src = imageUrl;
            popup.classList.remove('hidden');
        }

        function closePopup() {
            // Sembunyikan popup
            const popup = document.getElementById('photo-popup');
            popup.classList.add('hidden');
        }
    </script>
@endpush
