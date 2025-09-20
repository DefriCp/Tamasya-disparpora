<?php

namespace App\Filament\Resources\AgendaResource\Pages;

use App\Filament\Resources\AgendaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Agenda;
use Carbon\Carbon;

class ListAgendas extends ListRecords
{
    protected static string $resource = AgendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
             ->label('Tambah Agenda'),
        ];
    }

    protected function mountTable(): void
    {
        parent::mount();

        $now = Carbon::now();

        Agenda::all()->each(function ($agenda) use ($now) {
            $mulai = Carbon::parse($agenda->tanggal . ' ' . $agenda->waktu_mulai);
            $selesai = Carbon::parse($agenda->tanggal . ' ' . $agenda->waktu_selesai);

            $status = match (true) {
                $now->lt($mulai) => 'Belum Dimulai',
                $now->between($mulai, $selesai) => 'Sedang Berlangsung',
                default => 'Telah Selesai',
            };

            if ($agenda->status !== $status) {
                $agenda->update(['status' => $status]);
            }
        });
    }
}
