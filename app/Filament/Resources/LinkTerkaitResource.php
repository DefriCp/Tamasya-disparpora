<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkTerkaitResource\Pages;
use App\Filament\Resources\LinkTerkaitResource\RelationManagers;
use App\Models\LinkTerkait;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LinkTerkaitResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = LinkTerkait::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Sponsor Kami'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Sponsor Kami'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Sponsor Kami'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sponsor Kami')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_instansi')
                                    ->label('Nama Sponsor')
                                    ->placeholder('Masukkan Nama Sponsor')
                                    ->required()
                                    ->maxLength(100)
                                    ->prefixIcon('heroicon-o-building-storefront'),

                                TextInput::make('link_web')
                                    ->label('Link Web')
                                    ->required()
                                    ->maxLength(100)
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),
                            ]),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->required()
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->placeholder('Upload Logo Disini')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_instansi')
                    ->label('Nama Sponsor')
                    ->wrap()
                    ->limit(15)
                    ->searchable(),

                TextColumn::make('link_web')
                    ->label('Link Web')
                    ->openUrlInNewTab()
                    ->color('primary'),
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
            'index' => Pages\ListLinkTerkaits::route('/'),
            'create' => Pages\CreateLinkTerkait::route('/create'),
            'edit' => Pages\EditLinkTerkait::route('/{record}/edit'),
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
