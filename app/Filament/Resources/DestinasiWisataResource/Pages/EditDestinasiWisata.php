<?php

namespace App\Filament\Resources\DestinasiWisataResource\Pages;

use App\Filament\Resources\DestinasiWisataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDestinasiWisata extends EditRecord
{
    protected static string $resource = DestinasiWisataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
