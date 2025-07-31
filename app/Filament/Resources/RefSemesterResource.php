<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefSemesterResource\Pages;
use App\Filament\Resources\RefSemesterResource\RelationManagers;
use App\Models\RefSemester;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefSemesterResource extends Resource
{
    protected static ?string $model = RefSemester::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Data Referensi';
    protected static ?string $navigationLabel = 'Semester';
    protected static ?string $pluralLabel = 'Semester';
    protected static ?string $slug = 'data-referensi-semester';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_semester')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_ajaran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_semester')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_semester')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListRefSemesters::route('/'),
            // 'create' => Pages\CreateRefSemester::route('/create'),
            // 'edit' => Pages\EditRefSemester::route('/{record}/edit'),
        ];
    }
}
