<?php

namespace App\Filament\Resources\PengumumResource\Pages;

use App\Filament\Resources\PengumumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengumums extends ListRecords
{
    protected static string $resource = PengumumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengumuman'),
        ];
    }
}
