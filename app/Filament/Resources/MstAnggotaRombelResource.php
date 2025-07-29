<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstAnggotaRombelResource\Pages;
use App\Filament\Resources\MstAnggotaRombelResource\RelationManagers;
use App\Models\MstAnggotaRombel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class MstAnggotaRombelResource extends Resource
{
    protected static ?string $model = MstAnggotaRombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Anggota Rombel';
    protected static ?string $pluralLabel = 'Anggota Rombel';
    protected static ?string $slug = 'anggota-rombel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rombel_id')
                    ->required(),
                Forms\Components\TextInput::make('peserta_didik_id')
                    ->required(),
                Forms\Components\Toggle::make('status_keaktifan')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_masuk'),
                Forms\Components\DatePicker::make('tanggal_keluar'),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rombel.nama')
                    ->label('Rombel')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pesertaDidik.nama')
                    ->label('Peserta Didik')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('status_keaktifan')
                    ->boolean()
                    ->label('Aktif?'),

                TextColumn::make('tanggal_masuk')
                    ->date()
                    ->sortable(),

                TextColumn::make('tanggal_keluar')
                    ->date()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
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
            'index' => Pages\ListMstAnggotaRombels::route('/'),
            'create' => Pages\CreateMstAnggotaRombel::route('/create'),
            'edit' => Pages\EditMstAnggotaRombel::route('/{record}/edit'),
        ];
    }
}
