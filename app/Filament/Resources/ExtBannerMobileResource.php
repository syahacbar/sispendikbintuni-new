<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ExtBannerMobile;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExtBannerMobileResource\Pages;
use App\Filament\Resources\ExtBannerMobileResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;

class ExtBannerMobileResource extends Resource
{
    protected static ?string $model = ExtBannerMobile::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $navigationLabel = 'Banner Mobile';
    protected static ?string $pluralLabel = 'Banner Mobile';
    protected static ?string $slug = 'banner-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('nama')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('banner-mobile')
                    ->image()
                    ->previewable(true)
                    ->openable()
                    ->maxSize(1024),
                Forms\Components\Textarea::make('deskripsi')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ])->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('nama')
                    ->label('Gambar')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListExtBannerMobiles::route('/'),
            'create' => Pages\CreateExtBannerMobile::route('/create'),
            'edit' => Pages\EditExtBannerMobile::route('/{record}/edit'),
        ];
    }
}
