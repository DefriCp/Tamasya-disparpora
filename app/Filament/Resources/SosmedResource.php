<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SosmedResource\Pages;
use App\Filament\Resources\SosmedResource\RelationManagers;
use App\Models\Sosmed;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SosmedResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Sosmed::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Profil Instansi';

    public static function getNavigationLabel(): string
    {
        return 'Sosial Media'; 
    }
    public static function getLabel(): string
    {
        return 'Sosial Media'; 
    }

    public static function getPluralLabel(): string
    {
        return 'Sosial Media'; 
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        FileUpload::make('icon')
                            ->label('Icon')
                            ->acceptedFileTypes(['image/svg+xml']) // hanya SVG yang diizinkan
                            ->directory('icons') 
                            ->required(),

                        TextInput::make('url')
                            ->label('Link Sosial Media')
                            ->placeholder('')
                            ->url()
                            ->maxLength(100)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')
                    ->label('Icon')
                    ->disk('public')
                    ->height(70), 

                TextColumn::make('url')
                    ->label('Link')->openUrlInNewTab()
                    ->searchable(),
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
                    ->modalHeading('Hapus Sosial Media')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Sosial Media?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
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
            'index' => Pages\ListSosmeds::route('/'),
            'create' => Pages\CreateSosmed::route('/create'),
            'edit' => Pages\EditSosmed::route('/{record}/edit'),
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
