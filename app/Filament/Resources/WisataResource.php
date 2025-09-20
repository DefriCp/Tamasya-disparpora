<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataResource\Pages;
use App\Filament\Resources\WisataResource\RelationManagers;
use App\Models\Wisata;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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

class WisataResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Wisata::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationGroup = 'Dokumentasi';
    protected static ?int $navigationSort = 0;

    public static function getNavigationLabel(): string
    {
        return 'Wisata'; 
    }
    public static function getLabel(): string
    {
        return 'Wisata'; 
    }

    public static function getPluralLabel(): string
    {
        return 'Wisata'; 
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Wisata')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Masukkan Nama Wisata')
                    ->columnSpanFull(),

                Textarea::make('alamat')
                    ->label('Alamat Wisata')
                    ->required()
                    ->rows(3)
                    ->maxLength(100)
                    ->placeholder('Tulis alamat Wisata di sini...')
                    ->columnSpanFull(),

                RichEditor::make('deskripsi')
                    ->label('Deskripsi')
                    ->placeholder('Tulis deskripsi secara detail...')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link'
                    ])
                    ->maxLength(500)
                    ->columnSpanFull(),
                Section::make('Photo Wisata')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship('photowisatas')
                            ->label('Galeri')
                            ->maxItems(4)
                            ->grid(2)
                            ->schema([
                                
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->directory('wisata')
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
                
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('alamat')
                    ->label('Alamat'),
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
                    ->modalHeading('Hapus Wisata')
                    ->modalDescription('Apakah Anda yakin ingin menghapus berita ini?')
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
            'index' => Pages\ListWisatas::route('/'),
            'create' => Pages\CreateWisata::route('/create'),
            'edit' => Pages\EditWisata::route('/{record}/edit'),
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
