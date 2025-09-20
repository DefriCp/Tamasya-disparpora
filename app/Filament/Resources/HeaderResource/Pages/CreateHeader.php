<?php

namespace App\Filament\Resources\HeaderResource\Pages;

use App\Filament\Resources\HeaderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateHeader extends CreateRecord
{
    protected static string $resource = HeaderResource::class;
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
