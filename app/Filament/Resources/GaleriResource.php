<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriResource\Pages;
use App\Filament\Resources\GaleriResource\RelationManagers;
use App\Models\Galeri;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class GaleriResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Galeri::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Dokumentasi';
    
    public static function getNavigationLabel(): string
    {
        return 'Galeri SKPD'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Galeri SKPD'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Galeri SKPD'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                 TextInput::make('nama')
                    ->label('Keterangan')
                    ->placeholder('Masukan Keterangan')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Keterangan'),
                
                Section::make('Galeri')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship('photogaleris')
                            ->label('Galeri')
                            ->maxItems(4)
                            ->grid(2)
                            ->schema([
                                
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->directory('galeriskpd')
                                    ->disk('public')
                                    ->required()
                                    ->helperText('Rekomendasi Ukuran Image 1920 x 1080')
                                    ->deleteUploadedFileUsing(function ($file, $record) {
                                        // Ambil path file dari kolom 'photo'
                                        $filePath = $record?->photo;

                                        if ($filePath && Storage::disk('public')->exists($filePath)) {
                                            Storage::disk('public')->delete($filePath);
                                        }
                                    })
                                    ->image()
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama')
                    ->label('Keterangan')
                    ->limit(30),
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
                    ->modalHeading('Hapus Galeri')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Galeri ini?')
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
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
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
