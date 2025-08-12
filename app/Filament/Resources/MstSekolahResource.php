<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstSekolahResource\Pages;
use App\Filament\Resources\MstSekolahResource\RelationManagers;
use App\Models\MstSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MstSekolahResource extends Resource
{
    protected static ?string $model = MstSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Sekolah';
    protected static ?string $pluralLabel = 'Sekolah';
    protected static ?string $slug = 'data-sekolah';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('admin_sekolah')) {
            $query->where('users_id', auth()->id());
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('npsn')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('jenjang.kode_jenjang')
                            ->label('Jenjang Pendidikan')
                            ->required()
                            ->relationship('jenjang', 'kode')
                            ->searchable()
                            ->preload(true),
                        Forms\Components\Textarea::make('alamat')
                            ->columnSpanFull(),
                        // Forms\Components\TextInput::make('kode_wilayah')
                        //     ->maxLength(255),
                        Forms\Components\TextInput::make('status')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('akreditasi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('kepemilikan')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('sk_pendirian')
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_sk_pendirian')
                            ->native(false)
                            ->displayFormat('d/m/Y') // tampil di form
                            ->format('Y-m-d'),       // simpan di DB

                        Forms\Components\TextInput::make('sk_izin_operasional')
                            ->maxLength(100),

                        Forms\Components\DatePicker::make('tanggal_sk_izin_operasional')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),
                        Forms\Components\Textarea::make('alamat')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kode_pos')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('latitude')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('longitude')
                            ->maxLength(100),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        if (auth()->user()->hasRole('admin_sekolah')) {
            return $table->columns([]);
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_jenjang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('akreditasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sk_pendirian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_sk_pendirian')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sk_izin_operasional')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_sk_izin_operasional')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_id')
                    ->numeric()
                    ->sortable(),
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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMstSekolahs::route('/'),
            'create' => Pages\CreateMstSekolah::route('/create'),
            'edit' => Pages\EditMstSekolah::route('/{record}/edit'),
        ];
    }
}
