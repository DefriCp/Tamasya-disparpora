<?php

namespace App\Filament\Resources\SosmedResource\Pages;

use App\Filament\Resources\SosmedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditSosmed extends EditRecord
{
    protected static string $resource = SosmedResource::class;

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
