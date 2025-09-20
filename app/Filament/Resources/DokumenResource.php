<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenResource\Pages;
use App\Filament\Resources\DokumenResource\RelationManagers;
use App\Models\Dokumen;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class DokumenResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Layanan dan Dokumen';
    protected static ?int $navigationSort = 0;

    public static function getNavigationLabel(): string
    {
        return 'Dokumen'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Dokumen'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Dokumen'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Upload Dokumen')
                    ->icon('heroicon-o-document-arrow-up')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Dokumen')
                                    ->placeholder('Contoh: Dokumen Publik')
                                    ->required()
                                    ->maxLength(100)
                                    ->autofocus()
                                    ->columnSpan(1),
                                
                                Select::make('tahun')
                                    ->label('Tahun')
                                    ->options(collect(range(date('Y'), 2021))->mapWithKeys(fn($year) => [$year => $year])->toArray())
                                    ->required()
                                    ->placeholder('Silahkan Pilih Tahun')
                                    ->searchable()
                                    ->columnSpan(1),
                                
                                FileUpload::make('file')
                                    ->label('Unggah File')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(7000) 
                                    ->directory('dokumen')
                                    ->placeholder('Masukkan dokumen dalam format PDF')
                                    ->required()
                                    ->downloadable()
                                    ->previewable(true)
                                    ->columnSpan(1)
                                    ->deleteUploadedFileUsing(function ($file, $record) {
                                        // Ambil path file dari kolom 'photo'
                                        $filePath = $record?->photo;

                                        if ($filePath && Storage::disk('public')->exists($filePath)) {
                                            Storage::disk('public')->delete($filePath);
                                        }
                                    }),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama')
                    ->label('Nama Dokumen')
                    ->searchable()
                    ->limit(25)
                    ->wrap(),
                TextColumn::make('tahun')
                    ->label('Tahun'),

                TextColumn::make('file')
                    ->label('File')
                    ->url(fn ($record) => \Storage::url($record->file))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => 'Lihat File')
                    ->color('primary'),
            ])
            ->filters([
                //
                SelectFilter::make('tahun')
                    ->label('Filter Tahun')
                    ->options(
                        collect(range(date('Y'), 2021))
                            ->mapWithKeys(fn ($year) => [$year => $year])
                            ->toArray()
                    )
                    ->searchable()
                    ->placeholder('Semua Tahun'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Hapus Dokumen')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Dokumen ini?')
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
            'index' => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit' => Pages\EditDokumen::route('/{record}/edit'),
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
