@extends('fe.layouts.main')

@push('meta-seo')
    <title>Profil Pimpinan - {{ $header->skpd }} Kabupaten Tasikmalaya</title>
    <meta name="description"
        content="Profil lengkap pimpinan {{ $header->skpd }}, Kabupaten Tasikmalaya. Simak riwayat karier, visi misi, dan peran kepemimpinan dalam mendukung layanan publik yang lebih baik.">
    <meta name="keywords"
        content="profil pimpinan {{ $header->skpd }}, biografi kepala skpd tasikmalaya, pimpinan pemkab tasikmalaya, profil pejabat daerah, tentang kepemimpinan skpd">
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
                    <span class="text-white">Profile Pimpinan</span>
                </nav>
                <h1 class="text-2xl font-bold md:text-4xl">Profile Pimpinan</h1>
                <p class="mt-3 text-sm text-center lg:text-left md:text-base">Kepala {{ $header->skpd }} Kabupaten
                    Tasikmalaya</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Content Section -->
            <div class="relative z-10 p-8 -mt-[120px] md:-mt-[220px] bg-white shadow-lg rounded-3xl md:p-12">
                <h2 class="mb-10 text-base font-semibold text-center lg:text-3xl">{{ $profile->nama }}</h2>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($profile->photopimpinans as $foto)
                        <img src="{{ asset('storage/' . $foto->photo) }}" alt="{{ $profile->nama }}"
                            onclick="showPopup('{{ asset('storage/' . $foto->photo) }}')"
                            class="object-cover w-full h-64 transition-transform duration-300 cursor-pointer md:h-96 rounded-2xl hover:scale-105">
                    @endforeach
                </div>

                <div class="text-gray-700 mt-14">
                    <h3 class="mb-3 text-base font-semibold md:text-xl">Riwayat Jabatan</h3>
                    <ul class="pl-5 list-disc">
                        @foreach ($profile->riwayatjabatans as $jabatan)
                            <li class="mb-1">
                                <span>{{ $jabatan->nama }}</span>
                            </li>
                        @endforeach
                    </ul>
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
                <button onclick="closePopup()" class="absolute text-3xl font-bold text-white top-4 right-4">&times;</button>
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
