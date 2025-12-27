<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\DestinasiWisata;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\LinkTerkait;
use App\Models\YoutubeTamasya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BerandaController extends Controller
{
    /**
     * Constructor: Dijalankan setiap kali Controller dipanggil.
     * Digunakan untuk membagikan variabel $header ke semua view di controller ini.
     */
    public function __construct()
    {
        // Ambil header sekali saja, lalu bagikan ke semua view
        $header = Header::with('photos')->first();
        View::share('header', $header);
    }

    public function beranda()
    {
        $destinasiWisata = DestinasiWisata::with('photos')
            ->latest()
            ->take(6)
            ->get();

        $beritaWisata = Berita::where('status', 'publish')
            ->latest()
            ->take(3)
            ->get();

        return view('fe.pages.beranda', compact('destinasiWisata', 'beritaWisata'));
    }

    public function wisata(Request $request)
{
    $search = $request->input('search');
    $jenisFilter = $request->input('jenis');

    // =============================
    // QUERY LIST WISATA
    // =============================
    $wisataQuery = DestinasiWisata::with(['desa', 'kecamatan', 'photos']);

    if ($search) {
        $wisataQuery->where('nama', 'like', '%' . $search . '%');
    }

    if ($jenisFilter) {
        $wisataQuery->whereJsonContains('jenis', $jenisFilter);
    }

    $wisata = $wisataQuery->latest()->paginate(12);
    $wisata->appends([
        'search' => $search,
        'jenis'  => $jenisFilter,
    ]);

    // =============================
    // DATA SIDEBAR
    // =============================
    $jenisWisata = DestinasiWisata::pluck('jenis')
        ->flatten()
        ->unique()
        ->filter()
        ->values();

    $kecamatanList = Kecamatan::orderBy('nama')->pluck('nama');
    $desaList = Desa::orderBy('nama')->pluck('nama');

    $sponsor = LinkTerkait::all();
    $youtubeTamasya = YoutubeTamasya::all();

    return view('fe.pages.wisata', compact(
        'wisata',
        'search',
        'jenisFilter',
        'jenisWisata',
        'kecamatanList',
        'desaList',
        'sponsor',
        'youtubeTamasya'
    ));
}

    public function detailWisata($slug)
    {
        $wisata = DestinasiWisata::with('photos')->where('slug', $slug)->firstOrFail();

        $wisatalain = DestinasiWisata::with('photos')
            ->where('id', '!=', $wisata->id)
            ->inRandomOrder() // Tips: Gunakan acak agar rekomendasi variatif
            ->limit(4)
            ->get();

        return view('fe.pages.detail-wisata', compact('wisata', 'wisatalain'));
    }

   public function petaWisata()
    {
        // UBAH DARI $list_wisata MENJADI $wisata
        $wisata = DestinasiWisata::select('id', 'nama', 'slug', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('photos') 
            ->get();

        $dataKecamatan = Kecamatan::with(['desas']) 
        ->withCount('destinasi_wisata') 
        ->get();

        $allWisata = DestinasiWisata::with(['kecamatan', 'desa', 'photos'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Kirim sebagai 'wisata' agar sesuai dengan error di blade
        return view('fe.pages.peta', compact('dataKecamatan', 'allWisata'));
    }

    public function galeri()
    {
        $galeri = Galeri::with('photogaleris') // Pastikan nama relasi di Model Galeri benar 'photogaleris'
            ->latest()
            ->paginate(9);

        return view('fe.pages.galeri', compact('galeri'));
    }

    public function beritaWisata()
    {
        $berita = Berita::where('status', 'publish')
            ->latest()
            ->paginate(9);

        return view('fe.pages.berita-wisata', compact('berita'));
    }

    public function detailBeritaWisata($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $beritaLain = Berita::where('id', '!=', $berita->id)
            ->where('status', 'publish')
            ->latest()
            ->take(4)
            ->get();

        return view('fe.pages.detail-berita', compact('berita', 'beritaLain'));
    }
}