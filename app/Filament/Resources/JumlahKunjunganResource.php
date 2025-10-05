<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JumlahKunjunganResource\Pages;
use App\Filament\Resources\JumlahKunjunganResource\RelationManagers;
use App\Models\JumlahKunjungan;
use App\Models\JumlahKunjunganWisata;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JumlahKunjunganResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = JumlahKunjunganWisata::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Jumlah Kunjungan Wisata'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Jumlah Kunjungan Wisata'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Jumlah Kunjungan Wisata'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('📊 Informasi Utama')
                    ->description('Isi data kunjungan wisata berdasarkan destinasi dan tahun.')
                    ->collapsible() // biar bisa dilipat
                    ->schema([
                        Forms\Components\Grid::make()
                            ->columns([
                                'default' => 2,
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ])
                            ->schema([
                                Forms\Components\Select::make('destinasi_wisata_id')
                                    ->label('🏝️ Destinasi Wisata')
                                    ->relationship('destinasiwisata', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->required()
                                    ->placeholder('Pilih destinasi wisata yang ingin diinput')
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('tahun')
                                    ->label('📅 Tahun')
                                    ->options(
                                        collect(range(date('Y'), 2020))
                                            ->mapWithKeys(fn($year) => [$year => $year])
                                            ->toArray()
                                    )
                                    ->required()
                                    ->placeholder('Silahkan Pilih Tahun')
                                    ->searchable()
                                    ->hint('Tahun laporan data kunjungan')
                                    ->columnSpan(1),

                                Forms\Components\Fieldset::make('Data Kunjungan per Bulan')
                                    ->columns(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('januari')->label('Januari')->numeric(),
                                        Forms\Components\TextInput::make('februari')->label('Februari')->numeric(),
                                        Forms\Components\TextInput::make('maret')->label('Maret')->numeric(),
                                        Forms\Components\TextInput::make('april')->label('April')->numeric(),
                                        Forms\Components\TextInput::make('mei')->label('Mei')->numeric(),
                                        Forms\Components\TextInput::make('juni')->label('Juni')->numeric(),
                                        Forms\Components\TextInput::make('juli')->label('Juli')->numeric(),
                                        Forms\Components\TextInput::make('agustus')->label('Agustus')->numeric(),
                                        Forms\Components\TextInput::make('september')->label('September')->numeric(),
                                        Forms\Components\TextInput::make('oktober')->label('Oktober')->numeric(),
                                        Forms\Components\TextInput::make('november')->label('November')->numeric(),
                                        Forms\Components\TextInput::make('desember')->label('Desember')->numeric(),
                                    ])
                                    ->extraAttributes([
                                        'class' => 'bg-gray-50 dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-200 dark:border-gray-700'
                                    ])
                                    ->columns([
                                        'default' => 3,
                                        'sm' => 2,
                                        'md' => 3,
                                    ]),
                            ]),
                    ])
                    ->extraAttributes([
                        'class' => 'rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm p-6'
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('destinasiwisata.nama')
                    ->label('🏝️ Destinasi Wisata')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('tahun')
                    ->label('📅 Tahun')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(
                        collect(range(date('Y'), 2020))
                            ->mapWithKeys(fn($year) => [$year => $year])
                            ->toArray()
                    )
                    ->placeholder('Silahkan Pilih Tahun')
                    ->searchable()
                    ->label('Tahun'),
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
            'index' => Pages\ListJumlahKunjungans::route('/'),
            'create' => Pages\CreateJumlahKunjungan::route('/create'),
            'edit' => Pages\EditJumlahKunjungan::route('/{record}/edit'),
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
