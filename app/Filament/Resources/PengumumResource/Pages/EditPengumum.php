<?php

namespace App\Filament\Resources\PengumumResource\Pages;

use App\Filament\Resources\PengumumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditPengumum extends EditRecord
{
    protected static string $resource = PengumumResource::class;

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
                ->label('Simpan Perubahan') // label tombol submit
                ->submit('save') // ini yang benar untuk EditRecord
                ->keyBindings(['mod+s']), // opsional shortcut Ctrl+S
            Action::make('cancel')
                ->label('Batal')
                ->url($this->getResource()::getUrl())
                ->color('gray')
                ->outlined(),
        ];
    }
}
