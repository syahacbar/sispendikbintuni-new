<?php

namespace App\Filament\Resources;

use App\Models\PTK;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PTKResource\Pages;

class PTKResource extends Resource
{
    protected static ?string $model = PTK::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'PTK';
    protected static ?string $pluralModelLabel = 'PTK';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function getEloquentQuery(): Builder
    {
        $user = Filament::auth()->user();

        if ($user->hasRole('admin_sekolah')) {
            return parent::getEloquentQuery()->where('sekolah_id', $user->sekolah_id);
        }

        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('sekolah_id')
                ->label('Sekolah')
                ->relationship('sekolah', 'nama')
                ->searchable()
                ->preload()
                ->default(fn() => Filament::auth()->user()->sekolah_id)
                ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                ->dehydrated(fn() => true)
                ->required(),
            TextInput::make('nama')
                ->required()
                ->label('Nama Lengkap')
                ->maxLength(100),

            TextInput::make('nuptk')
                ->label('NUPTK')
                ->required()
                ->maxLength(20),

            TextInput::make('nik')
                ->label('NIK')
                ->required()
                ->maxLength(20),

            Radio::make('jenis_kelamin')
                ->label('Jenis Kelamin')

                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->inline()
                ->required(),

            DatePicker::make('tgl_lahir')
                ->label('Tanggal Lahir')
                ->nullable()
                ->default(true)
                ->native(false)
                ->seconds(false)
                ->displayFormat('d/m/Y')
                ->default(now())
                ->required(),
            Select::make('status')
                ->options([
                    'GTY' => 'GTY',
                    'Honorer' => 'Honorer',
                    'PNS' => 'PNS',
                ])
                ->required(),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => !auth()->user()->hasRole('admin_sekolah')),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('nuptk')
                    ->searchable(),
                TextColumn::make('nik')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable(),
                TextColumn::make('tgl_lahir')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPTKS::route('/'),
            'create' => Pages\CreatePTK::route('/create'),
            'edit' => Pages\EditPTK::route('/{record}/edit'),
        ];
    }
}
