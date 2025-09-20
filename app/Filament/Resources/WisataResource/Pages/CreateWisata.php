<?php

namespace App\Filament\Resources\WisataResource\Pages;

use App\Filament\Resources\WisataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateWisata extends CreateRecord
{
    protected static string $resource = WisataResource::class;
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
