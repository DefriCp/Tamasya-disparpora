<?php

namespace App\Filament\Resources\PengumumResource\Pages;

use App\Filament\Resources\PengumumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreatePengumum extends CreateRecord
{
    protected static string $resource = PengumumResource::class;
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
