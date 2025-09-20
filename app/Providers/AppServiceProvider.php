<?php

namespace App\Providers;

use App\Models\header;
use App\Models\sosmed;
use App\Models\visitor;
use App\Models\tentangKami;
use Illuminate\Support\Carbon;
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
        View::composer(['fe.layouts.navbar', 'fe.layouts.head', 'fe.layouts.footer'], function ($view) {
            $header = Header::with(['logos', 'photos'])->first();
            $view->with('header', $header);
        });

        View::composer('fe.layouts.footer', function ($view) {
            $header = Header::with(['logos', 'photos'])->first(); // tetap diambil juga
            $kontak = TentangKami::first();
            $sosmed = Sosmed::get();
            $totalVisitor = Visitor::count();
            $todayVisitor = Visitor::whereDate('visited_at', \Carbon\Carbon::today())->count();

            $view->with([
                'header' => $header,
                'kontak' => $kontak,
                'sosmed' => $sosmed,
                'totalVisitor' => $totalVisitor,
                'todayVisitor' => $todayVisitor,
            ]);
        });
    }
}
