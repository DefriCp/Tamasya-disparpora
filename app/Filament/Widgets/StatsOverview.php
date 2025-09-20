<?php

namespace App\Filament\Widgets;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Layanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                label: 'Berita',
                value: Berita::count()
            )
                ->description('Jumlah Berita')
                ->color('gray')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
            Stat::make(
                label: 'Agenda',
                value: Agenda::count()
            )
                ->description('Jumlah Agenda')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
            Stat::make(
                label: 'Dokumen',
                value: Dokumen::count()
            )
                ->description('Jumlah Dokumen')
                ->color('danger')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
            Stat::make(
                label: 'Layanan',
                value: Layanan::count()
            )
                ->description('Jumlah Layanan')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
        ];
    }
}
