<?php

namespace App\Filament\Resources\YoutubeTamasyaResource\Pages;

use App\Filament\Resources\YoutubeTamasyaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYoutubeTamasya extends EditRecord
{
    protected static string $resource = YoutubeTamasyaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
