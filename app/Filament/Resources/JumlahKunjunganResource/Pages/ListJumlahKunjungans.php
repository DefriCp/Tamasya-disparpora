<?php

namespace App\Filament\Resources\JumlahKunjunganResource\Pages;

use App\Filament\Resources\JumlahKunjunganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJumlahKunjungans extends ListRecords
{
    protected static string $resource = JumlahKunjunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
