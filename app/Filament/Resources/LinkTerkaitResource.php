<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkTerkaitResource\Pages;
use App\Filament\Resources\LinkTerkaitResource\RelationManagers;
use App\Models\LinkTerkait;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LinkTerkaitResource extends Resource
{
    protected static ?string $model = LinkTerkait::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Tamasya Wisata';
    
    public static function getNavigationLabel(): string
    {
        return 'Link Terkait'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Link Terkait'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Link Terkait'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Link Terkait')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_instansi')
                                    ->label('Nama Instansi')
                                    ->placeholder('Masukkan Nama Layanan')
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
                //
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
            'index' => Pages\ListLinkTerkaits::route('/'),
            'create' => Pages\CreateLinkTerkait::route('/create'),
            'edit' => Pages\EditLinkTerkait::route('/{record}/edit'),
        ];
    }
}
