<?php

namespace App\Filament\Resources\YoutubeResource\Pages;

use App\Filament\Resources\YoutubeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditYoutube extends EditRecord
{
    protected static string $resource = YoutubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan') 
                ->submit('save') 
                ->keyBindings(['mod+s']), 
            Action::make('cancel')
                ->label('Batal')
                ->url($this->getResource()::getUrl())
                ->color('gray')
                ->outlined(),
        ];
    }
}
