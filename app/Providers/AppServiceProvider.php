<?php

namespace App\Providers;

use App\Models\Header;
use App\Models\Sosmed;
use App\Models\Visitor;

use App\Models\LinkTerkait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cache header sekali per 30 menit agar tidak memanggil query berulang kali.
        $cachedHeader = Cache::remember('header_first', now()->addMinutes(30), function () {
            return Header::with(['logos', 'photos'])->first();
        });

        // Bagikan header ke beberapa layout sekaligus (navbar, head, footer)
        View::composer(['fe.layouts.navbar', 'fe.layouts.head', 'fe.layouts.footer'], function ($view) use ($cachedHeader) {
            $view->with('header', $cachedHeader);
        });

        // Composer khusus untuk footer: data kontak, sosmed, sponsor, visitor stats
        View::composer('fe.layouts.footer', function ($view) use ($cachedHeader) {
            $header = $cachedHeader; // reuse cached header

            $sosmed = Sosmed::all();

            // Ambil sponsor (LinkTerkait) dengan cache singkat
            $sponsor = Cache::remember('linkterkait_all', now()->addMinutes(30), function () {
                return LinkTerkait::all();
            });

            $totalVisitor = Visitor::count();
            $todayVisitor = Visitor::whereDate('visited_at', Carbon::today())->count();

            $view->with([
                'header' => $header,
                // 'kontak' => $kontak,
                'sosmed' => $sosmed,
                'sponsor' => $sponsor,
                'totalVisitor' => $totalVisitor,
                'todayVisitor' => $todayVisitor,
            ]);
        });
    }
}
