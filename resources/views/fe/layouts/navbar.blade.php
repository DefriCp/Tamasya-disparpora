<header class="fixed top-0 left-0 z-50 w-full duration-150 navbar"
    style="color:{{ $header->warna_text_header ?? '#fff' }} !important;">
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-between py-3 md:py-4">
            <!-- Logo -->
            <div class="flex items-center">
                @php
                    // Ambil logos jika $header dan $header->logos tersedia, selain itu gunakan koleksi kosong
                    $logos = $header?->logos ?? collect();
                @endphp

                @if ($logos->isNotEmpty())
                    @foreach ($logos as $data)
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('storage/' . $data->logo) }}" alt="logo" class="w-full h-12 mr-2">
                        </div>
                    @endforeach
                @else
                    <!-- Placeholder default jika tidak ada logo atau header tidak tersedia -->
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/logo-default.png') }}" alt="Default Logo" class="w-full h-12 mr-2">
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="hidden space-x-6 lg:flex">
                <a href="{{ route('fe.beranda') }}" class="transition-colors">Beranda</a>
                <!-- Dropdown Profil -->
                <div class="relative group">
                    <button class="flex items-center transition-colors focus:outline-none">
                        Profil
                        <svg class="w-6 h-6 ml-1 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute left-0 z-10 invisible w-48 mt-2 text-gray-800 transition-all duration-200 bg-white border border-gray-200 shadow opacity-0 rounded-2xl group-hover:opacity-100 group-hover:visible">
                        <a href="{{ route('fe.tentang') }}"
                            class="block px-4 py-2 duration-150 border-b border-gray-200">Tentang
                            Kami</a>
                        <a href="{{ route('fe.profile.pimpinan') }}"
                            class="block px-4 py-2 duration-150 border-b border-gray-200">Profile
                            Pimpinan</a>
                        <a href="{{ route('fe.struktur-organisasi') }}" class="block px-4 py-2 duration-150">Struktur
                            Organisasi</a>
                    </div>
                </div>

                <a href="{{ route('fe.berita') }}" class="transition-colors">Berita</a>
                <a href="{{ route('fe.galeri') }}" class="transition-colors">Galeri</a>
                <a href="{{ route('fe.wisata') }}" class="transition-colors">Tamasya</a>
                <a href="{{ route('fe.layanan') }}" class="transition-colors">Layanan</a>
                <a href="{{ route('fe.dokumen') }}" class="transition-colors">Dokumen</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button class="text-white lg:hidden" onclick="toggleMobileMenu()">
                <i class="text-xl fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="hidden pb-4 lg:hidden">
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('fe.beranda') }}" class="py-2 transition-colors">Beranda</a>
                <div class="relative">
                    <button onclick="toggleMobileDropdown()"
                        class="flex items-center justify-between w-full py-2 text-left transition-colors">
                        Profil
                        <svg id="dropdownArrow" class="w-6 h-6 transition-transform" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>

                    </button>

                    <!-- Mobile Dropdown Content -->
                    <div id="mobileDropdown"
                        class="flex flex-col pl-4 mt-1 space-y-2 overflow-hidden transition-all duration-300 ease-in-out opacity-0 max-h-0">
                        <a href="{{ route('fe.tentang') }}" class="py-1 transition-colors">Tentang
                            Kami</a>
                        <a href="{{ route('fe.profile.pimpinan') }}" class="py-1 transition-colors">Profile
                            Pimpinan</a>
                        <a href="{{ route('fe.struktur-organisasi') }}" class="py-1 transition-colors">Struktur
                            Organisasi</a>
                    </div>
                </div>

                <a href="{{ route('fe.berita') }}" class="py-2 transition-colors">Berita</a>
                <a href="{{ route('fe.galeri') }}" class="py-2 transition-colors">Galeri</a>
                <a href="{{ route('fe.wisata') }}" class="py-2 transition-colors">Tamasya</a>
                <a href="{{ route('fe.layanan') }}" class="py-2 transition-colors">Layanan</a>
                <a href="{{ route('fe.dokumen') }}" class="py-2 transition-colors">Dokumen</a>
            </nav>
        </div>
    </div>
</header>
