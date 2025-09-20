<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use App\Filament\Resources\BeritaResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateBerita extends CreateRecord
{
    protected static string $resource = BeritaResource::class;
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
