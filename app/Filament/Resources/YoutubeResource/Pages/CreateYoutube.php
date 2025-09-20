<?php

namespace App\Filament\Resources\YoutubeResource\Pages;

use App\Filament\Resources\YoutubeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateYoutube extends CreateRecord
{
    protected static string $resource = YoutubeResource::class;
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
