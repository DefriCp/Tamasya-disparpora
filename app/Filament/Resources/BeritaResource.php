<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Filament\Resources\BeritaResource\RelationManagers;
use App\Models\Berita;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class BeritaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Informasi';
    
    public static function getNavigationLabel(): string
    {
        return 'Berita'; // Ubah nama menu di sini
    }
    public static function getLabel(): string
    {
        return 'Berita'; // Singular
    }

    public static function getPluralLabel(): string
    {
        return 'Berita'; // Tetap tunggal jika kamu ingin breadcrumb-nya "Berita > Membuat"
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Berita')
                    ->schema([
                        Textarea::make('judul')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('photo')
                            ->image()
                            ->required()
                            ->maxSize(3000)
                            ->placeholder('Silahkan Upload Photo Anda')
                            ->directory('berita')
                            ->disk('public')
                            ->required()
                            ->helperText('Rekomendasi Ukuran Image 1920 x 1080')
                            ->deleteUploadedFileUsing(function ($file, $record) {
                                $filePath = $record?->photo;

                                if ($filePath && Storage::disk('public')->exists($filePath)) {
                                    Storage::disk('public')->delete($filePath);
                                }
                            })
                            ->image(),
                        RichEditor::make('isi')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                            ])
                            ->maxLength(3000)
                            ->required(),
                    ]),
                Section::make('Status dan Tag')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'publish' => 'Publish',
                                        'arsip' => 'Arsip'
                                    ])
                                    ->placeholder('Silahkan Pilih Status')
                                    ->searchable()
                                    ->required()
                                    ->live(),

                                DateTimePicker::make('waktu_publish')
                                    ->required()
                                    ->visible(fn ($get) => $get('status') === 'publish'),
                        ]),

                        TextInput::make('dilihat')
                            ->numeric()
                            ->default(0)
                            ->hidden()
                            ->disabled(),
                        TagsInput::make('tags')
                            ->label('Tag')
                            ->placeholder('Masukkan tag dan tekan enter'),
                        Select::make('header_id')
                            ->label('Penulis')
                            ->relationship('header', 'singkatan_skpd')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->default(1) 
                            ->dehydrated(true)
                            ->required(),

                    ])

                


            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->wrap()
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'danger',     // Merah
                        'publish' => 'success', // Hijau
                        'arsip' => 'warning',     // Kuning
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'arsip' => 'Arsip',
                    ])
                    ->searchable()
                    ->placeholder('Semua Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Hapus Berita')
                    ->modalDescription('Apakah Anda yakin ingin menghapus berita ini?')
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
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
