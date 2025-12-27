<footer class="relative bg-white pt-20 pb-10 overflow-hidden">
    <!-- Cosmetic Wave -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none rotate-180">
        <svg class="relative block w-[calc(100%+1.3px)] h-12 text-white/5" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
        </svg>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
            
            <!-- IDENTITY / ABOUT -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                     <h2 class="text-3xl font-extrabold text-primary mb-4 tracking-tight drop-shadow-sm">{{ $header->skpd ?? 'Sistem Informasi Pariwisata' }}</h2>
                    <p class="text-gray-600 leading-relaxed text-base text-justify">
                        Jelajahi keindahan alam dan budaya Kabupaten Tasikmalaya. Temukan berbagai destinasi wisata menarik, mulai dari pantai eksotis, pegunungan yang sejuk, hingga kekayaan budaya lokal yang memikat.
                    </p>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="text-gray-700 text-sm leading-snug pt-2">Jl. Mayor Utarya, Tawangsari, Kec. Tawang, Kab. Tasikmalaya, Jawa Barat 46112</span>
                    </div>
                    <div class="flex items-center gap-4 group">
                         <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform flex-shrink-0">
                             <i class="fas fa-phone"></i>
                        </div>
                        <span class="text-gray-700 text-sm font-medium">(0265) 330182</span>
                    </div>
                    <div class="flex items-center gap-4 group">
                         <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform flex-shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span class="text-gray-700 text-sm font-medium">disparpora@tasikmalayakab.go.id</span>
                    </div>
                </div>
            </div>

            <!-- SPONSOR LOGOS -->
            <div class="lg:col-span-7">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b-2 border-yellow-400 inline-block pb-1">Didukung Oleh</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($sponsor->take(8) as $item)
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center h-28 aspect-video shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                             @if (!empty($item->logo) && file_exists(storage_path('app/public/' . $item->logo)))
                                <img src="{{ asset('storage/' . $item->logo) }}" 
                                     alt="{{ $item->nama_instansi }}" 
                                     class="max-h-16 w-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 transform group-hover:scale-105">
                            @else
                                <span class="text-gray-400 text-xs text-center group-hover:text-primary transition-colors">{{ $item->nama_instansi }}</span>
                            @endif
                        </div>
                    @endforeach
                    
                    {{-- Minimal fallback --}}
                     @if($sponsor->count() < 1)
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center h-28 border border-dashed border-gray-300">
                           <span class="text-gray-400 text-xs">Space Iklan</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- COPYRIGHT -->
        <div class="border-t border-gray-200 pt-8 text-center">
            <p class="text-sm text-gray-500">
                &copy; 2025 <span class="font-semibold text-primary">Dinas Pariwisata Pemuda dan Olahraga</span> Kabupaten Tasikmalaya.
            </p>
        </div>
    </div>
</footer>