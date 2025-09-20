<?php

namespace App\Filament\Resources\DestinasiWisataResource\Pages;

use App\Filament\Resources\DestinasiWisataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDestinasiWisatas extends ListRecords
{
    protected static string $resource = DestinasiWisataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
