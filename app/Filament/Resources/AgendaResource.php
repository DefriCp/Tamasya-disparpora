<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaResource\Pages;
use App\Filament\Resources\AgendaResource\RelationManagers;
use App\Models\Agenda;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Agenda::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';
    protected static ?string $navigationGroup = 'Informasi';
    
    public static function getNavigationLabel(): string
    {
        return 'Agenda';
    }
    public static function getLabel(): string
    {
        return 'Agenda';
    }

    public static function getPluralLabel(): string
    {
        return 'Agenda';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('📝 Informasi Kegiatan')
                    ->description('Masukkan detail lengkap tentang kegiatan yang akan ditambahkan.')
                    ->icon('heroicon-o-calendar')
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([

                        Grid::make(2)
                            ->schema([
                                TextInput::make('judul')
                                    ->label('Judul Kegiatan')
                                    ->placeholder('Contoh: Live Mojang Jajaka Sukapura')
                                    ->required()
                                    ->maxLength(100)
                                    ->autofocus(),

                                TextInput::make('lokasi')
                                    ->label('Lokasi')
                                    ->maxLength(100)
                                    ->placeholder('Contoh: Aula Gedung Singaparna')
                                    ->required(),
                            ]),

                        RichEditor::make('deskripsi')
                            ->label('Deskripsi Kegiatan')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                            ])
                            ->required()
                            ->maxLength(3000)
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                DatePicker::make('tanggal')
                                    ->label('Tanggal Kegiatan')
                                    ->required(),

                                TextInput::make('link')
                                    ->label('Link Terkait (Opsional)')
                                    ->placeholder('https://contoh.link')
                                    ->url()
                                    ->maxLength(100)
                                    ->suffixIcon('heroicon-o-link'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TimePicker::make('waktu_mulai')
                                    ->label('Waktu Mulai')
                                    ->required(),

                                TimePicker::make('waktu_selesai')
                                    ->label('Waktu Selesai')
                                    ->required(),
                            ]),

                       
                    ]),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->judul),

                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->limit(20),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y'),

                TextColumn::make('waktu_mulai')
                    ->label('Mulai')
                    ->time('H:i'),

                TextColumn::make('waktu_selesai')
                    ->label('Selesai')
                    ->time('H:i'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Belum Dimulai' => 'danger',
                        'Sedang Berlangsung' => 'success',
                        'Telah Selesai' => 'warning',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Hapus Agenda')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Agenda ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Data')
                        ->icon('heroicon-o-trash')
                        ->modalHeading('Hapus Data')
                        ->requiresConfirmation()
                        ->modalDescription('Apakah Anda yakin ingin menghapus ini?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),
                ]),
                
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }
}
