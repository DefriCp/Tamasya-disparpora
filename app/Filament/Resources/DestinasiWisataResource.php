<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinasiWisataResource\Pages;
use App\Filament\Resources\DestinasiWisataResource\RelationManagers;
use App\Models\DestinasiWisata;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class DestinasiWisataResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = DestinasiWisata::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Destinasi Wisata'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Destinasi Wisata'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Destinasi Wisata'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\CheckboxList::make('jenis')
                                    ->label('Jenis Destinasi')
                                    ->options([
                                        'Alam' => 'Alam',
                                        'Buatan' => 'Buatan',
                                        'Budaya' => 'Budaya',
                                        'Desa Wisata' => 'Desa Wisata'
                                    ])
                                    ->columns(2) // biar tampil 2 kolom
                                    ->required(),
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Destinasi')
                                    ->required()
                                    ->maxLength(255),

                                
                            ]),

                    ]),

                Forms\Components\Section::make('Lokasi')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('kecamatan_id')
                                    ->label('Kecamatan')
                                    ->relationship('kecamatan', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->reactive()
                                    ->required(),

                                Forms\Components\Select::make('desa_id')
                                    ->label('Desa')
                                    ->options(function (callable $get) {
                                        $kecamatanId = $get('kecamatan_id');
                                        if (!$kecamatanId) {
                                            return [];
                                        }

                                        return \App\Models\Desa::where('kecamatan_id', $kecamatanId)
                                            ->pluck('nama', 'id'); // gunakan id (FK)
                                    })
                                    ->searchable()
                                    ->reactive()
                                    ->required(),
                                Forms\Components\TextInput::make('latitude')
                                    ->required()
                                    ->numeric(),

                                Forms\Components\TextInput::make('longitude')
                                    ->required()
                                    ->numeric(),
                            ]),
                    ]),

                Forms\Components\Section::make('Detail Destinasi')
                    ->schema([
                        Forms\Components\Textarea::make('potensi_unggulan')
                            ->required()
                            ->label('Potensi Unggulan'),

                        Forms\Components\Textarea::make('produk_unggulan')
                            ->required()
                            ->label('Produk Unggulan'),

                        Forms\Components\Textarea::make('daya_tarik_wisata')
                            ->required()
                            ->label('Daya Tarik Wisata'),
                        Forms\Components\Textarea::make('amenitas')
                            ->required()
                            ->label('Amenitas'),
                    ]),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('status_pemilik')
                                    ->required(),

                                Forms\Components\TextInput::make('luas')
                                    ->required(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('aktivitas')
                                    ->required(),

                                Forms\Components\TextInput::make('kondisi_akses')
                                    ->required(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_pengelola')
                                    ->required(),

                                Forms\Components\TextInput::make('nomor_hp')
                                    ->numeric()
                                    ->prefix('+62')
                                    ->required(),
                            ]),

                        Forms\Components\TextInput::make('jarak_tempuh')
                            ->required(),
                    ]),

                Section::make('Utilitas')
                    ->schema([
                        Repeater::make('utilitas')
                            ->relationship('utilitas')
                            ->label('Utilitas')
                            ->grid(2)
                            ->schema([
                                Forms\Components\Select::make('nama')
                                    ->options([
                                            'Listrik' => 'Listrik',
                                            'Air' => 'Air',
                                            'Tempat Sampah' => 'Tempat Sampah',
                                            'Telekomunikasi' => 'Telekomunikasi'
                                        ])
                                    ->placeholder('Silahkan Pilih Utilitas')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Textarea::make('keterangan')
                                    ->required(),
                            ])
                    ]),

                Section::make('Photo')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship('photos')
                            ->label('Photo')
                            ->maxItems(3)
                            ->grid(2)
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->directory('tamasya')
                                    ->disk('public')
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
                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('kecamatan.nama')
                    ->label('Kecamatan')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('latitude')
                    ->label('Latitude')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('longitude')
                    ->label('Longitude')
                    ->searchable()
                    ->limit(25)
                    ->wrap()

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
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDestinasiWisatas::route('/'),
            'create' => Pages\CreateDestinasiWisata::route('/create'),
            'edit' => Pages\EditDestinasiWisata::route('/{record}/edit'),
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
