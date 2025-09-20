<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PimpinanResource\Pages;
use App\Filament\Resources\PimpinanResource\RelationManagers;
use App\Models\Pimpinan;
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

class PimpinanResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Pimpinan::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationGroup = 'Profil Instansi';

    public static function getNavigationLabel(): string
    {
        return 'Pimpinan'; 
    }
    public static function getLabel(): string
    {
        return 'Pimpinan'; 
    }

    public static function getPluralLabel(): string
    {
        return 'Pimpinan'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Pimpinan')
                    ->maxLength(150)
                    ->placeholder('Masukkan Nama Pimpinan')
                    ->prefixIcon('heroicon-o-user-circle')
                    ->required(),

                Section::make('Foto Pimpinan')
                    ->collapsible()
                    ->schema([
                        Repeater::make('photopimpinans')
                            ->relationship('photopimpinans')
                            ->label('')
                            ->addActionLabel('Tambah Foto')
                            ->reorderable()
                            ->maxItems(3)
                            ->grid(2)
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Foto')
                                    ->directory('pimpinan')
                                    ->disk('public')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->required()
                                    ->helperText('Rekomendasi Photo Portrait (9:16)')
                                    ->deleteUploadedFileUsing(function ($file, $record) {
                                        $filePath = $record?->photo;
                                        if ($filePath && Storage::disk('public')->exists($filePath)) {
                                            Storage::disk('public')->delete($filePath);
                                        }
                                    }),
                            ])
                    ]),

                Section::make('Riwayat Jabatan')
                    ->collapsible()
                    ->schema([
                        Repeater::make('riwayatjabatans')
                            ->relationship('riwayatjabatans')
                            ->label('')
                            ->addActionLabel('Tambah Jabatan')
                            ->reorderable()
                            ->grid(2)
                            ->schema([
                                Textarea::make('nama')
                                    ->label('Nama Jabatan')
                                    ->placeholder('Contoh: Kepala Dinas Kominfo (2023 - Sekarang)')
                                    ->required(),
                            ])
                    ]),
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama'),
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
                    ->modalHeading('Hapus Pimpinan')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Pimpinan')
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
            'index' => Pages\ListPimpinans::route('/'),
            'create' => Pages\CreatePimpinan::route('/create'),
            'edit' => Pages\EditPimpinan::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return Pimpinan::count() === 0;
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
