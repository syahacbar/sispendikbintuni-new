<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtPengaduanResource\Pages;
use App\Filament\Resources\ExtPengaduanResource\RelationManagers;
use App\Models\ExtPengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtPengaduanResource extends Resource
{
    protected static ?string $model = ExtPengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $navigationLabel = 'Pengaduan';
    protected static ?string $pluralLabel = 'Pengaduan';
    protected static ?string $slug = 'pegaduan-layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_laporan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pelapor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('judul_laporan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dok_lampiran')
                    ->maxLength(255),
                Forms\Components\Textarea::make('isi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('terkirim'),
                Forms\Components\TextInput::make('ip_address'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pelapor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dok_lampiran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListExtPengaduans::route('/'),
            'create' => Pages\CreateExtPengaduan::route('/create'),
            'edit' => Pages\EditExtPengaduan::route('/{record}/edit'),
        ];
    }
}
