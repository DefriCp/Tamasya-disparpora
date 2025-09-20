<?php

namespace App\Filament\Resources\GaleriResource\Pages;

use App\Filament\Resources\GaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateGaleri extends CreateRecord
{
    protected static string $resource = GaleriResource::class;
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
