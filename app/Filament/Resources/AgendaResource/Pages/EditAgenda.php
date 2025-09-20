<?php

namespace App\Filament\Resources\AgendaResource\Pages;

use App\Filament\Resources\AgendaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Carbon\Carbon;
use Filament\Actions\Action;

class EditAgenda extends EditRecord
{
    protected static string $resource = AgendaResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->updateStatus($data);
    }

    private function updateStatus(array $data): array
    {
        $now = Carbon::now();
        $mulai = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai']);
        $selesai = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_selesai']);

        if ($now->lt($mulai)) {
            $data['status'] = 'Belum Dimulai';
        } elseif ($now->between($mulai, $selesai)) {
            $data['status'] = 'Sedang Berlangsung';
        } else {
            $data['status'] = 'Telah Selesai';
        }

        return $data;
    }
}
