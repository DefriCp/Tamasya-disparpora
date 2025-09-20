<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YoutubeResource\Pages;
use App\Filament\Resources\YoutubeResource\RelationManagers;
use App\Models\Youtube;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YoutubeResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Youtube::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Dokumentasi';
    
    public static function getNavigationLabel(): string
    {
        return 'Youtube'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Youtube'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Youtube'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Link Youtube')
                    ->schema([
                        Group::make()
                            ->schema([
                               TextInput::make('nama')
                                    ->label('Nama')
                                    ->maxLength(100)
                                    ->required(),

                                TextInput::make('link')
                                    ->label('Link Youtube')
                                    ->placeholder('https://youtube.com/')
                                    ->prefixIcon('heroicon-o-link')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Masukkan link lengkap'),
                            ])
                            ->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->limit(30)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('link')
                    ->label('Link'),
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
                    ->modalHeading('Hapus Youtube')
                    ->modalDescription('Apakah Anda yakin ingin menghapus youtube ini?')
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
            'index' => Pages\ListYoutubes::route('/'),
            'create' => Pages\CreateYoutube::route('/create'),
            'edit' => Pages\EditYoutube::route('/{record}/edit'),
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
