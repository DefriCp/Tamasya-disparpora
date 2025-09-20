<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengumumResource\Pages;
use App\Filament\Resources\PengumumResource\RelationManagers;
use App\Models\Pengumum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Pengumum::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?string $navigationGroup = 'Informasi';
    
    public static function getNavigationLabel(): string
    {
        return 'Pengumuman'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Pengumuman'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Pengumuman'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('judul')
                        ->label('Judul Pengumuman')
                        ->required()
                        ->maxLength(255),
                    Select::make('header_id')
                            ->label('Penulis')
                            ->relationship('header', 'singkatan_skpd')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->dehydrated(true)
                            ->required(),
                ]),

                RichEditor::make('isi')
                    ->label('Isi Pengumuman')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                    ])
                    ->maxLength(3000)
                    ->required(),

                Grid::make(2)->schema([
                    DatePicker::make('tanggal_publish')
                        ->label('Tanggal Mulai Publish')
                        ->required(),

                    DatePicker::make('selesai_publish')
                        ->label('Tanggal Selesai Publish')
                        ->required(),
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
                    ->limit(20),

                TextColumn::make('tanggal_publish')
                    ->label('Mulai Publish')
                    ->date('d M Y'),

                TextColumn::make('selesai_publish')
                    ->label('Selesai Publish')
                    ->date('d M Y'),
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
                    ->modalHeading('Hapus Pengumuman')
                    ->modalDescription('Apakah Anda yakin ingin menghapus pengumuman ini?')
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
            'index' => Pages\ListPengumums::route('/'),
            'create' => Pages\CreatePengumum::route('/create'),
            'edit' => Pages\EditPengumum::route('/{record}/edit'),
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
