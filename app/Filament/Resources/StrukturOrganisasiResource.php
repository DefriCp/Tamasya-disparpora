<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrukturOrganisasiResource\Pages;
use App\Filament\Resources\StrukturOrganisasiResource\RelationManagers;
use App\Models\StrukturOrganisasi;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = StrukturOrganisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = 'Profil Instansi';

    public static function getNavigationLabel(): string
    {
        return 'Struktur Organisasi'; 
    }
    public static function getLabel(): string
    {
        return 'Struktur Organisasi'; 
    }

    public static function getPluralLabel(): string
    {
        return 'Struktur Organisasi'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Struktur Organisasi')
                ->schema([
                    Section::make('Foto Struktur Organisasi')
                        ->description('Unggah gambar struktur organisasi. Maksimal 2MB.')
                        ->schema([
                            FileUpload::make('photo')
                                ->label('Foto Struktur Organisasi')
                                ->directory('strukturorganisasi')
                                ->disk('public')
                                ->image()
                                ->imageEditor()
                                ->maxSize(3000)
                                ->required()
                                ->deleteUploadedFileUsing(function ($file, $record) {
                                    $filePath = $record?->photo;
                                    if ($filePath && Storage::disk('public')->exists($filePath)) {
                                        Storage::disk('public')->delete($filePath);
                                    }
                                }),
                        ])
                        ->collapsible(),

                    Section::make('Bidang atau Unit')
                        ->schema([
                            Repeater::make('bidangs')
                                ->relationship('bidangs')
                                ->label('')
                                ->addActionLabel('Tambah Bidang')
                                ->reorderable()
                                ->grid(2)
                                ->schema([
                                    TextInput::make('nama')
                                        ->label('Nama')
                                        ->maxLength(250)
                                        ->required(),
                                    Textarea::make('deskripsi')
                                        ->label('Deskripsi')
                                        ->maxLength(1000)
                                        ->required(),
                                ])
                        ])
                        ->collapsible(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bidangs_count')
                    ->label('Jumlah Bidang')
                    ->counts('bidangs')
                    ->badge()
                    ->color('primary'),
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
                    ->modalHeading('Hapus Struktur Organisasi')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Struktur Organisasi ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListStrukturOrganisasis::route('/'),
            'create' => Pages\CreateStrukturOrganisasi::route('/create'),
            'edit' => Pages\EditStrukturOrganisasi::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return StrukturOrganisasi::count() === 0;
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
