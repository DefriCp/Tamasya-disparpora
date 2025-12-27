<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderResource\Pages;
use App\Filament\Resources\HeaderResource\RelationManagers;
use App\Models\Header;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class HeaderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Header::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-pointing-in';
    protected static ?string $navigationGroup = 'Tema';
    protected static ?int $navigationSort = 0;

    public static function getNavigationLabel(): string
    {
        return 'Header'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Header'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Header'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Logo Navbar')
                    ->schema([
                        Repeater::make('logos')
                            ->relationship('logos')
                            ->label('Logo')
                            ->maxItems(2)
                            ->grid(2)
                            ->schema([
                                FileUpload::make('logo')
                                    ->label('logo')
                                    ->directory('header/logo')
                                    ->disk('public')
                                    ->maxSize(2000)
                                    ->required()
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
                Section::make('🗂️ Informasi SKPD')
                    ->description('Masukkan nama instansi dan singkatannya.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('skpd')
                                    ->label('Nama SKPD')
                                    ->placeholder('Contoh: Dinas Komunikasi dan Informatika')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('singkatan_skpd')
                                    ->label('Singkatan')
                                    ->placeholder('Contoh: KOMINFO')
                                    ->required()
                                    ->maxLength(30),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(false),


                Section::make('Photo Header')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship('photos')
                            ->label('Photo')
                            ->maxItems(6)
                            ->grid(2)
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->directory('header')
                                    ->disk('public')
                                    ->maxSize(5120)
                                    ->required()
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
                TextColumn::make('skpd')
                    ->label('Nama SKPD')
                    ->limit(30),

                TextColumn::make('singkatan_skpd')
                    ->label('Singkatan')
                    ->badge()
                    ->color('primary'),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Hapus Header')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Header ini?')
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
            'index' => Pages\ListHeaders::route('/'),
            'create' => Pages\CreateHeader::route('/create'),
            'edit' => Pages\EditHeader::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return Header::count() === 0;
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
