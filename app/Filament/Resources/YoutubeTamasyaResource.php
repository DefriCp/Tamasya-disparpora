<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YoutubeTamasyaResource\Pages;
use App\Filament\Resources\YoutubeTamasyaResource\RelationManagers;
use App\Models\YoutubeTamasya;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YoutubeTamasyaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = YoutubeTamasya::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Youtube Tamasya'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Youtube Tamasya'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Youtube Tamasya'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListYoutubeTamasyas::route('/'),
            'create' => Pages\CreateYoutubeTamasya::route('/create'),
            'edit' => Pages\EditYoutubeTamasya::route('/{record}/edit'),
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
