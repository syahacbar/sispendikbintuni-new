<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstPembelajaranResource\Pages;
use App\Filament\Resources\MstPembelajaranResource\RelationManagers;
use App\Models\MstPembelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class MstPembelajaranResource extends Resource
{
    protected static ?string $model = MstPembelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Pembelajaran';
    protected static ?string $pluralLabel = 'Pembelajaran';
    protected static ?string $slug = 'data-pembelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rombongan_belajar_id')
                    ->required(),
                Forms\Components\TextInput::make('mata_pelajaran_id')
                    ->required(),
                Forms\Components\TextInput::make('gtk_id'),
                Forms\Components\TextInput::make('semester_id')
                    ->required(),
                Forms\Components\TextInput::make('jam_mengajar_per_minggu')
                    ->numeric(),
                Forms\Components\TextInput::make('jenis_pembelajaran')
                    ->maxLength(50),
                Forms\Components\Toggle::make('status_aktif')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_mulai'),
                Forms\Components\DatePicker::make('tgl_selesai'),
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

                TextColumn::make('mapel.nama')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gtk.nama')
                    ->label('GTK')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('semester.nama_semester')
                    ->label('Semester')
                    ->sortable(),

                TextColumn::make('jam_mengajar_per_minggu')
                    ->numeric()
                    ->label('Jam/Minggu')
                    ->sortable(),

                TextColumn::make('jenis_pembelajaran')
                    ->label('Jenis')
                    ->searchable(),

                IconColumn::make('status_aktif')
                    ->boolean()
                    ->label('Aktif?'),

                TextColumn::make('tgl_mulai')
                    ->date()
                    ->label('Mulai')
                    ->sortable(),

                TextColumn::make('tgl_selesai')
                    ->date()
                    ->label('Selesai')
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
            'index' => Pages\ListMstPembelajarans::route('/'),
            // 'create' => Pages\CreateMstPembelajaran::route('/create'),
            // 'edit' => Pages\EditMstPembelajaran::route('/{record}/edit'),
        ];
    }
}
