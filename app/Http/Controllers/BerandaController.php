<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\DestinasiWisata;
use App\Models\Galeri;
use App\Models\Dokumen;
use App\Models\Header;
use App\Models\Layanan;
use App\Models\Youtube;
use App\Models\Pengumum;
use App\Models\Pimpinan;
use App\Models\PhotoGaleri;
use App\Models\TentangKami;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StrukturOrganisasi;
use App\Models\Visitor;
use App\Models\Wisata;
use App\Models\YoutubeTamasya;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BerandaController extends Controller
{
    public function beranda()
    {
        $header = Header::with(['logos', 'photos'])->first();
        $pengumuman = Pengumum::where('tanggal_publish', '<=', Carbon::now())
            ->where('selesai_publish', '>=', Carbon::now())
            ->latest()
            ->first();

        // Kode Untuk Fitur Agenda
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        // $endOfMonth = $now->copy()->endOfMonth();
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // Senin = 1, Minggu = 7
        $totalDays = $now->daysInMonth;

        // Siapkan array tanggal (1..jumlah hari)
        $dates = collect(range(1, $totalDays));

        // Padding kosong di awal (misal kalau tanggal 1 jatuh di Kamis → perlu 3 kolom kosong)
        $padding = collect(range(1, $startDayOfWeek))->map(fn() => null);

        // Gabungkan padding dan tanggal, lalu pecah jadi minggu (7 kolom)
        $calendar = $padding->merge($dates)->chunk(7);

        $agendaDates = Agenda::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->pluck('tanggal')
            ->map(function ($date) {
                return Carbon::parse($date)->day; // Ambil hanya tanggal-nya (1–31)
            })
            ->unique()
            ->toArray();

        // Ambil agenda hari ini
        $todayAgenda = Agenda::whereDate('tanggal', $now->toDateString())->get();

        // Kode Untuk Menu Berita SKPD
        $beritaSkpd = Berita::with('header')->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Kode Untuk Menu Berita Terbaru & Populer
        $beritaTerbaru = Berita::where('status', 'publish')->latest()->limit(4)->get();
        $beritaTerpopuler = Berita::where('status', 'publish')->orderByDesc('dilihat')->limit(4)->get();

        // Kode Untuk Menu pengumuman
        $pengumumanSkpd = Pengumum::latest()->take(4)->get();

        // Kode Untuk Menu Wisata
        $wisata = Wisata::with('photowisatas')->latest()->take(4)->get();

        // Kode Untuk Menu Photo Kegiatan
        $fotoKegiatan = PhotoGaleri::latest()->take(8)->get();

        // Kode Untuk Menu Layanan
        $layanan = Layanan::latest()->take(4)->get();

        // Kode Untuk Menu Link
        $linkYoutube = Youtube::get();

        // Kode untuk cek visitor
        $ip = request()->ip();
        $cacheKey = "visitor_{$ip}_beranda";

        if (!Cache::has($cacheKey)) {
            visitor::create([
                'visited_at' => now(), // Waktu saat ini, sesuai zona waktu Laravel
            ]);
            Cache::put($cacheKey, true, now()->addDay());
        }

        return view('fe.pages.beranda', [
            'header' => $header,
            'pengumuman' => $pengumuman,
            'pengumumanSkpd' => $pengumumanSkpd,
            'calendar' => $calendar,
            'currentDay' => $now->day,
            'month' => $now->month,
            'year' => $now->year,
            'agendaDates' => $agendaDates,
            'todayAgenda' => $todayAgenda,
            'beritaSkpd' => $beritaSkpd,
            'beritaTerbaru' => $beritaTerbaru,
            'beritaTerpopuler' => $beritaTerpopuler,
            'wisata' => $wisata,
            'fotoKegiatan' => $fotoKegiatan,
            'layanan' => $layanan,
            'linkYoutube' => $linkYoutube,
            'currentMonthYear' => $now->translatedFormat('F Y'),
        ]);
    }

    // --------------------------------------------------
    // Ambil berita Kabtsm
    // --------------------------------------------------
    public function getBeritaKabTsm()
    {
        try {
            $response = Http::get('https://tasikmalayakab.go.id/wp-json/wp/v2/posts');

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Gagal ambil data.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // --------------------------------------------------
    // Ambil agenda
    // --------------------------------------------------
    public function getAgenda(Request $request)
    {
        $date = Carbon::createFromDate($request->year, $request->month, $request->day)->format('Y-m-d');

        // Ambil agenda berdasarkan tanggal (contoh dummy)
        $agendas = Agenda::whereDate('tanggal', $date)->get();

        // Format tanggal & tambahkan status (asumsi ada kolom `status`)
        $agendas = $agendas->map(function ($agenda) {
            return [
                'judul' => $agenda->judul,
                'tanggal' => Carbon::parse($agenda->tanggal)->translatedFormat('d F Y'),
                'deskripsi' => $agenda->deskripsi,
                'status' => $agenda->status, // tambahkan ini jika kolom ada
            ];
        });

        return response()->json($agendas);
    }

    // --------------------------------------------------
    // Halaman tentang
    // --------------------------------------------------
    public function tentang()
    {
        $header = Header::with('photos')->first();
        $tentang = TentangKami::first();

        return view('fe.pages.tentang-kami', compact('header', 'tentang'));
    }

    // --------------------------------------------------
    // Halaman profile
    // --------------------------------------------------
    public function profilePimpinan()
    {
        $header = Header::with('photos')->first();
        $profile = Pimpinan::with(['photopimpinans', 'riwayatjabatans'])->first();

        return view('fe.pages.profile-pimpinan', compact('header', 'profile'));
    }

    // --------------------------------------------------
    // Halaman struktur
    // --------------------------------------------------
    public function strukturOrganisasi()
    {
        $header = Header::with('photos')->first();
        $struktur = StrukturOrganisasi::with('bidangs')->first();

        return view('fe.pages.struktur-organisasi', compact('header', 'struktur'));
    }

    // --------------------------------------------------
    // Halaman berita
    // --------------------------------------------------
    public function berita()
    {
        $berita = Berita::where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $beritaPopuler = Berita::where('status', 'publish')
            ->orderBy('dilihat', 'desc')
            ->take(4)
            ->get();

        $header = Header::with('photos')->first();
        return view('fe.pages.berita', compact('berita', 'beritaPopuler', 'header'));
    }

    public function detailBerita($slug = null)
    {
        $header = Header::first();
        $detailBerita = Berita::with('header')->where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrfail();


        $beritaTerbaru = Berita::with('header')->where('status', 'publish')
            ->orderBy('waktu_publish', 'desc')
            ->take(4)
            ->get();

        // Increment view count jika belum ada di session
        // if (!session()->has("viewed_berita_{$slug}")) {
        //     $detailBerita->dilihat += 1; // Tambahkan 1 ke nilai 'dilihat'
        //     $detailBerita->save(); // Simpan perubahan ke database
        //     session()->put("viewed_berita_{$slug}", true); // Tandai berita telah dilihat di sesi
        // }

        // Cek berdasarkan IP address
        $ip = request()->ip();
        $cacheKey = "viewed_berita_{$slug}_{$ip}";

        if (!Cache::has($cacheKey)) {
            $detailBerita->dilihat += 1;
            $detailBerita->save(); // Tambahkan jumlah dilihat
            Cache::put($cacheKey, true, now()->addDay()); // Cache hanya berlaku 1 hari
        }

        return view('fe.pages.detail-berita', compact('header', 'detailBerita', 'beritaTerbaru'));
    }

    // --------------------------------------------------
    // Halaman wisata
    // --------------------------------------------------
    public function wisata(Request $request)
    {
        $header = Header::with('photos')->first();
        $search = $request->input('search');

        $wisataQuery = Wisata::with('photowisatas');

        if ($search) {
            $wisataQuery->where('nama', 'like', '%' . $search . '%');
        }

        $wisata = $wisataQuery->paginate(12);

        // Pastikan hasil pencarian membawa query sebelumnya
        $wisata->appends(['search' => $search]);

        $youtubeTamasya = YoutubeTamasya::get();

        return view('fe.pages.wisata', compact('header', 'wisata', 'search', 'youtubeTamasya'));
    }

    public function detailWisata($slug = null)
    {
        $header = Header::with('photos')->first();
        $wisata = Wisata::with('photowisatas')->where('slug', $slug)->first();
        $wisatalain = Wisata::with('photowisatas')->take(5)->get();


        return view('fe.pages.detail-wisata', compact('header', 'wisata', 'wisatalain'));
    }
    
    public function detailTamsyaWisata($slug = null)
    {
        $header = Header::with('photos')->first();
        $destinasiwisata = DestinasiWisata::with('desa', 'kecamatan', 'utilitas', 'photos')->where('slug', $slug)->first();
        $destinasiwisatalain = DestinasiWisata::with('desa', 'kecamatan', 'photos')->take(2)->get();

        return view('fe.pages.detail-tamsyawisata', compact('header', 'destinasiwisata', 'destinasiwisatalain' ));
    }

    

    // --------------------------------------------------
    // Halaman galeri
    // --------------------------------------------------
    public function galeri()
    {
        $header = Header::with('photos')->first();
        $galeri = Galeri::with('photogaleris')->paginate(6);

        return view('fe.pages.galeri', compact('header', 'galeri'));
    }

    // --------------------------------------------------
    // Halaman layanan
    // --------------------------------------------------
    public function layanan()
    {
        $header = Header::with('photos')->first();
        $layanan = Layanan::all();
        return view('fe.pages.layanan', compact('header', 'layanan'));
    }

    // --------------------------------------------------
    // Halaman dokumen
    // --------------------------------------------------
    public function dokumen(Request $request)
    {
        $header = Header::with('photos')->first();
        $search = $request->input('search');
        $tahun = $request->input('tahun');

        // Cek jika ada kata kunci pencarian atau filter tahun, gunakan query dengan filter
        $dokumen = Dokumen::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })
            ->when($tahun, function ($query, $tahun) {
                return $query->where('tahun', $tahun); // Filter berdasarkan tahun
            })
            ->paginate(10);

        // Pastikan hasil pencarian membawa query sebelumnya
        $dokumen->appends(['search' => $search, 'tahun' => $tahun]);
        return view('fe.pages.dokumen', compact('header', 'dokumen', 'search', 'tahun'));
    }
}
