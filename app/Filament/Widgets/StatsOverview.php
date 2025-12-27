<?php

namespace App\Filament\Widgets;


use App\Models\Berita;
use App\Models\DestinasiWisata;
use App\Models\Dokumen;
use App\Models\Layanan;
use App\Models\YoutubeTamasya;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
    {

    public function getStats(): array
    {
        $user = Auth::user();

        if ($user->hasRole(['super_admin', 'admin_skpd'])) {
            return [
                Stat::make('Berita', Berita::count())
                    ->description('Jumlah Berita')
                    ->color('gray')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),



                Stat::make('Dokumen', Dokumen::count())
                    ->description('Jumlah Dokumen')
                    ->color('danger')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),

                Stat::make('Layanan', Layanan::count())
                    ->description('Jumlah Layanan')
                    ->color('primary')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),

                Stat::make('Tamasya Wisata', DestinasiWisata::count())
                    ->description('Jumlah Tamasya Wisata')
                    ->color('success')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),

                Stat::make('Youtube Tamasya', YoutubeTamasya::count())
                    ->description('Jumlah Youtube')
                    ->color('danger')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),
            ];
        }

        if ($user->hasRole('user_tamasya')) {
            return [
                Stat::make('Tamasya Wisata', DestinasiWisata::count())
                    ->description('Jumlah Tamasya Wisata')
                    ->color('success')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),

                Stat::make('Youtube Tamasya', YoutubeTamasya::count())
                    ->description('Jumlah Youtube')
                    ->color('danger')
                    ->chart([7, 3, 4, 5, 6, 3, 5]),
            ];
        }

        return [];
    }

}
