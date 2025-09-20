<?php

namespace App\Filament\Resources\TentangKamiResource\Pages;

use App\Filament\Resources\TentangKamiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateTentangKami extends CreateRecord
{
    protected static string $resource = TentangKamiResource::class;
    protected function getFormActions(): array
    {
        return [
            Action::make('submit') 
                ->label('Simpan')
                ->submit('create'),
            Action::make('cancel')
                ->label('Batal')
                ->url($this->getResource()::getUrl()) 
                ->color('gray')
                ->outlined(),
        ];
    }
}
