<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesaResource\Pages;
use App\Filament\Resources\DesaResource\RelationManagers;
use App\Models\Desa;
use App\Models\Kecamatan;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DesaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Desa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Desa'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Desa'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Desa'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Desa')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('id_desa_bps')
                    ->label('ID Desa (BPS)')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('id_desa_kemendagri')
                    ->label('ID Desa (Kemendagri)')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Desa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('id_desa_bps')
                    ->label('ID Desa (BPS)')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('id_desa_kemendagri')
                    ->label('ID Desa (Kemendagri)')
                    ->sortable()
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
            'index' => Pages\ListDesas::route('/'),
            'create' => Pages\CreateDesa::route('/create'),
            'edit' => Pages\EditDesa::route('/{record}/edit'),
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
