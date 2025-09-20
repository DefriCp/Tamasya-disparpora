<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TentangKamiResource\Pages;
use App\Filament\Resources\TentangKamiResource\RelationManagers;
use App\Models\TentangKami;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class TentangKamiResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = TentangKami::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Profil Instansi';
    protected static ?int $navigationSort = 0;

    public static function getNavigationLabel(): string
    {
        return 'Profil'; 
    }
    public static function getLabel(): string
    {
        return 'Profil'; 
    }

    public static function getPluralLabel(): string
    {
        return 'Profil'; 
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil Singkat')
                    ->description('Isi konten sejarah, visi, dan misi instansi Anda.')
                    ->schema([
                        RichEditor::make('sejarah')
                            ->label('Sejarah')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                            ])
                            ->placeholder('Masukan Sejarah')
                            ->maxLength(1200)
                            ->required(),
                        FileUpload::make('photo')
                            ->label('Foto Gedung (HD)')
                             ->directory('profil')
                            ->disk('public')
                            ->maxSize(3000)
                            ->required()
                            ->helperText('Rekomendasi Ukuran Image 1920 x 1080 ')
                            ->deleteUploadedFileUsing(function ($file, $record) {
                            
                                $filePath = $record?->photo;

                                if ($filePath && Storage::disk('public')->exists($filePath)) {
                                    Storage::disk('public')->delete($filePath);
                                }
                            })
                            ->image(),

                        Group::make()
                            ->schema([
                                RichEditor::make('visi')
                                    ->label('Visi')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                                    ])
                                    ->placeholder('Tulis Visi')
                                    ->maxLength(1000)
                                    ->required(),

                                RichEditor::make('misi')
                                    ->label('Misi')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'bulletList', 'orderedList',
                                    ])
                                    ->placeholder('Tulis Misi')
                                    ->maxLength(1000)
                                    ->required(),
                            ])
                            ->columns(2),
                        Group::make()
                            ->schema([
                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->placeholder('Masukan Alamat Instansi')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('no_hp')
                                    ->label('Kontak')
                                    ->required()
                                    ->placeholder('Masukan Kontak Instansi')
                                    ->maxLength(20),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->placeholder('Masukan Email Instansi')
                                    ->maxLength(100)
                                    ->required(),
                            ])
                            ->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sejarah')
                    ->label('Sejarah')
                    ->limit(20)
                    ->wrap(),

                TextColumn::make('visi')
                    ->label('Visi')
                    ->limit(20)
                    ->wrap(),

                TextColumn::make('misi')
                    ->label('Misi')
                    ->limit(20)
                    ->wrap(),
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
                    ->modalHeading('Hapus Profil')
                    ->modalDescription('Apakah Anda yakin ingin menghapus Profil ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                
                
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
            'index' => Pages\ListTentangKamis::route('/'),
            'create' => Pages\CreateTentangKami::route('/create'),
            'edit' => Pages\EditTentangKami::route('/{record}/edit'),
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
