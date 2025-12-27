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
    <main class="px-4 py-8 md:py-12 mt-20 md:mt-28 mx-auto max-w-7xl">
        
        {{-- Header Section --}}
        <div class="mb-8 md:mb-12 text-center max-w-3xl mx-auto animate-fade-in">
            <h1 class="text-2xl md:text-5xl font-extrabold text-gray-900 mb-4 md:mb-6 leading-tight">
                Galeri Foto Wisata <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">
                    Kabupaten Tasikmalaya
                </span>
            </h1>
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach ($galeri as $item)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 overflow-hidden flex flex-col h-full">
                    
                    {{-- Card Header --}}
                    <div class="p-4 md:p-5 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-base md:text-lg text-gray-800 line-clamp-1 group-hover:text-primary transition-colors">
                            {{ $item->nama }}
                        </h2>
                        <span class="text-[10px] md:text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                            {{ $item->photogaleris->count() }} Foto
                        </span>
                    </div>

                    {{-- Main Photo (First) --}}
                    @if($item->photogaleris->isNotEmpty())
                        <div class="relative h-56 md:h-64 overflow-hidden cursor-pointer" onclick="showPopup('{{ asset('storage/' . $item->photogaleris->first()->photo) }}')">
                            <img src="{{ asset('storage/' . $item->photogaleris->first()->photo) }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700"
                                 alt="{{ $item->nama }}">
                            
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="h-56 md:h-64 bg-gray-100 flex items-center justify-center text-gray-400">
                           <span class="text-sm">Belum ada foto</span>
                        </div>
                    @endif

                    {{-- Small Thumbs (Next 3) --}}
                    @if($item->photogaleris->count() > 1)
                        <div class="grid grid-cols-3 divide-x divide-gray-100 border-t border-gray-100 bg-gray-50/50">
                            @foreach ($item->photogaleris->skip(1)->take(3) as $photo)
                                <div class="h-16 md:h-20 overflow-hidden relative cursor-pointer group/thumb" onclick="showPopup('{{ asset('storage/' . $photo->photo) }}')">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" 
                                         class="w-full h-full object-cover hover:opacity-80 transition"
                                         alt="Gallery thumbnail">
                                </div>
                            @endforeach
                            {{-- Fill gaps if less than 3 thumbs --}}
                             @for ($i = 0; $i < (3 - $item->photogaleris->skip(1)->take(3)->count()); $i++)
                                <div class="h-16 md:h-20 bg-gray-50"></div>
                             @endfor
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $galeri->links() }}
        </div>

        <!-- Popup -->
        <div id="photo-popup" class="fixed inset-0 z-[60] flex items-center justify-center hidden bg-black/90 backdrop-blur-sm transition-all duration-300 opacity-0" style="transition: opacity 0.3s ease;">
            <div class="relative w-full max-w-5xl px-4 transform transition-all duration-300 scale-95" id="popup-content">
                <!-- Gambar Popup -->
                 <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img id="popup-image" src="" alt="Popup Image" class="w-full max-h-[85vh] object-contain bg-black">
                 </div>
                
                <!-- Tombol Tutup -->
                <button onclick="closePopup()" class="absolute -top-12 right-4 text-white hover:text-gray-300 focus:outline-none z-50 group">
                     <span class="sr-only">Close</span>
                     <svg class="w-8 h-8 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                     </svg>
                </button>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        function showPopup(imageUrl) {
            const popup = document.getElementById('photo-popup');
            const popupImage = document.getElementById('popup-image');
            const popupContent = document.getElementById('popup-content');

            popupImage.src = imageUrl;
            
            // Show container
            popup.classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                popup.classList.remove('opacity-0');
                popupContent.classList.remove('scale-95');
                popupContent.classList.add('scale-100');
            }, 10);
        }

        function closePopup() {
            const popup = document.getElementById('photo-popup');
            const popupContent = document.getElementById('popup-content');
            
            // Trigger exit animation
            popup.classList.add('opacity-0');
            popupContent.classList.remove('scale-100');
            popupContent.classList.add('scale-95');

            // Find transition duration to hide after animation
            setTimeout(() => {
                popup.classList.add('hidden');
                document.getElementById('popup-image').src = '';
            }, 300); // Match transition duration
        }
        
        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closePopup();
            }
        });
    </script>
@endpush
