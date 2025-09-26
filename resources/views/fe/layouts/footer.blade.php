<!-- Footer -->
<footer class="py-8 border-t border-gray-200"
    style="background: linear-gradient(to right, {{ $header->warna_pertama ?? '#377ded' }}, {{ $header->warna_kedua ?? '#377ded' }}) !important;  
    color:{{ $header->warna_text_header ?? '#fff' }} !important;">
    <div class="container px-4 py-6 mx-auto lg:pt-8">
        {{-- <div class="lg:flex lg:justify-between"> --}}
        <div class="flex flex-wrap md:gap-6">
            <!-- Kolom 1: Logo & Nama SKPD -->
            <div class="w-full p-4 md:w-1/2 lg:w-1/4">
                <div class="flex flex-col items-start mb-4 space-y-3">
                    <div class="flex items-center">
                        @php
                            // Ambil logos jika $header dan $header->logos tersedia, selain itu gunakan koleksi kosong
                            $logos = $header?->logos ?? collect();
                        @endphp

                        @if ($logos->isNotEmpty())
                            @foreach ($logos as $data)
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $data->logo) }}" alt="logo"
                                        class="w-full h-12 mr-2">
                                </div>
                            @endforeach
                        @else
                            <!-- Placeholder default jika tidak ada logo atau header tidak tersedia -->
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('images/logo-default.png') }}" alt="Default Logo"
                                    class="w-full h-12 mr-2">
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="mb-2 text-base font-bold">{{ $header->skpd ?? 'Template' }}</h3>
                        <p class="text-sm">Kabupaten Tasikmalaya</p>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Menu Utama -->
            <div class="w-full p-4 md:w-1/3 lg:w-1/6">
                <h2 class="mb-6 text-sm font-semibold uppercase">menu utama</h2>
                <ul class="space-y-3">
                    <li><a href="{{ route('fe.berita') }}" class="duration-150 hover:underline">Berita</a></li>
                    <li><a href="{{ route('fe.galeri') }}" class="duration-150 hover:underline">Galeri</a></li>
                    <li><a href="{{ route('fe.layanan') }}" class="duration-150 hover:underline">Layanan</a></li>
                    <li><a href="{{ route('fe.dokumen') }}" class="duration-150 hover:underline">Dokumen</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <div class="w-full p-4 md:w-1/2 lg:w-1/3">
                <h2 class="mb-6 text-sm font-semibold uppercase">kontak</h2>
                <ul class="space-y-4">
                    <li>
                        <p class="flex items-start">
                            <i class="mt-1 mr-2 fas fa-map-marker-alt"></i>
                            <span>{{ $kontak->alamat ?? '-' }}</span>
                        </p>
                    </li>
                    <li>
                        <p class="flex items-center">
                            <i class="mr-2 fas fa-phone"></i>
                            {{ $kontak->no_hp ?? '-' }}
                        </p>
                    </li>
                    <li>
                        <p class="flex items-center">
                            <i class="mr-2 fas fa-envelope"></i>
                            {{ $kontak->email ?? '-' }}
                        </p>
                    </li>
                </ul>
            </div>

            <!-- Kolom 4: Sosial Media -->
            <div class="w-full p-4 md:w-1/4 lg:w-1/6">
                <h2 class="mb-6 text-sm font-semibold uppercase">Sosial Media</h2>
                <div class="flex flex-wrap gap-4 space-x-1 font-medium">
                    @foreach ($sosmed as $item)
                        <a href="{{ $item->url }}" target="_blank" class="color-sosmed">
                            <span class="inline-flex items-center w-5 h-5">
                                {!! str_replace(
                                    '<svg',
                                    '<svg style="fill: currentColor;"',
                                    file_get_contents(public_path('storage/' . $item->icon)),
                                ) !!}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </div>
    <div class="container px-4 py-6 mx-auto lg:pt-8">
        <!-- <hr class="my-6 border-gray-100 sm:mx-auto lg:my-8" /> -->
        <div class="flex items-center justify-between max-w-md mx-auto mt-8">
            <div class="text-center">
                <h2 class="mb-2 text-sm font-semibold uppercase">Pengunjung Hari Ini</h2>
                <span class="text-xl font-bold">{{ $todayVisitor }}</span>
            </div>
            <div class="text-center">
                <h2 class="mb-2 text-sm font-semibold text-right uppercase">Total Pengunjung</h2>
                <span class="text-xl font-bold">{{ $totalVisitor }}</span>
            </div>
        </div>

        <div class="mt-8 text-center">
            <span class="text-base">&copy; 2025 Dishubkominfo - Disparpora Kabupaten Tasikmalaya. Semua hak dilindungi.
            </span>
        </div>
    </div>
</footer>
