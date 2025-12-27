@php
    $isTransparentPage = Route::is(['fe.beranda', 'fe.wisata.detail']);
    $defaultClass = $isTransparentPage ? 'bg-gradient-to-b from-black/60 to-transparent text-white' : 'bg-white/90 backdrop-blur-md text-gray-900 shadow-sm';
@endphp

<header id="main-navbar" class="fixed top-0 left-0 z-50 w-full transition-all duration-300 {{ $defaultClass }}">
    
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-between h-20"> 
            
            {{-- LOGO --}}
            <div class="flex items-center gap-3">
                @php $logos = $header?->logos ?? collect(); @endphp
                @if ($logos->isNotEmpty())
                    @foreach ($logos as $data)
                        <img src="{{ asset('storage/' . $data->logo) }}" alt="logo" class="h-10 md:h-12 w-auto object-contain">
                    @endforeach
                @else
                    <img src="{{ asset('images/logo-default.png') }}" alt="Default Logo" class="h-10 md:h-12 w-auto">
                @endif
            </div>

            {{-- MENU DESKTOP --}}
            <nav class="hidden lg:flex items-center space-x-8 font-medium">
                <a href="{{ route('fe.beranda') }}" class="nav-link hover:text-yellow-400 transition-colors {{ Route::is('fe.beranda') ? 'font-bold' : '' }}">Beranda</a>
                <a href="{{ route('fe.wisata') }}" class="nav-link hover:text-yellow-400 transition-colors {{ Route::is('fe.wisata*') ? 'font-bold' : '' }}">Destinasi</a>
                <a href="{{ route('fe.peta') }}" class="nav-link hover:text-yellow-400 transition-colors {{ Route::is('fe.peta') ? 'font-bold' : '' }}">Peta Interaktif</a>
                <a href="{{ route('fe.galeri') }}" class="nav-link hover:text-yellow-400 transition-colors {{ Route::is('fe.galeri') ? 'font-bold' : '' }}">Galeri</a>
            </nav>

            {{-- TOMBOL MOBILE --}}
            <button class="lg:hidden focus:outline-none transition-colors" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        {{-- MENU MOBILE --}}
        <div id="mobileMenu" class="hidden lg:hidden bg-white/95 backdrop-blur-xl text-gray-800 rounded-b-xl shadow-xl absolute top-full left-0 w-full overflow-hidden border-t border-gray-100">
            <nav class="flex flex-col p-4 space-y-2">
                <a href="{{ route('fe.beranda') }}" class="block px-4 py-2 rounded hover:bg-green-50 hover:text-green-600 font-semibold">Beranda</a>
                <a href="{{ route('fe.wisata') }}" class="block px-4 py-2 rounded hover:bg-green-50 hover:text-green-600 font-semibold">Destinasi</a>
                <a href="{{ route('fe.peta') }}" class="block px-4 py-2 rounded hover:bg-green-50 hover:text-green-600 font-semibold">Peta Interaktif</a>
                <a href="{{ route('fe.galeri') }}" class="block px-4 py-2 rounded hover:bg-green-50 hover:text-green-600 font-semibold">Galeri</a>
            </nav>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    }

    // Navbar Scroll Effect
    const navbar = document.getElementById('main-navbar');
    const isTransparentPage = @json($isTransparentPage);
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            // State: Scrolled (White Glass)
            navbar.classList.remove('bg-gradient-to-b', 'from-black/60', 'to-transparent', 'text-white');
            navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'text-gray-900', 'shadow-sm');
        } else {
            // State: Top
            if (isTransparentPage) {
                // Return to Gradient Transparent on specific pages
                navbar.classList.add('bg-gradient-to-b', 'from-black/60', 'to-transparent', 'text-white');
                navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'text-gray-900', 'shadow-sm');
            } else {
                // Stay White on other pages
               navbar.classList.remove('bg-gradient-to-b', 'from-black/60', 'to-transparent', 'text-white');
               navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'text-gray-900', 'shadow-sm');
            }
        }
    });
</script>