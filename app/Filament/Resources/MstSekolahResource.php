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
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class MstSekolahResource extends Resource
{
    protected static ?string $model = MstSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    // Menentukan grup navigasi berdasarkan role user
    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();

        // Admin sekolah tidak memiliki group navigasi
        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        // Super admin akan melihat di grup 'Data Master'
        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Sekolah';
    protected static ?string $pluralLabel = 'Sekolah';
    protected static ?string $slug = 'data-sekolah';

    // Menentukan urutan item navigasi
    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 10 : 10;
    }

    // Filter query berdasarkan role user
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Admin sekolah hanya bisa melihat data sekolahnya sendiri
        if (auth()->user()->hasRole('admin_sekolah')) {
            $query->where('users_id', auth()->id());
        }

        return $query;
    }

    // Definisi form untuk create/edit sekolah
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Grid layout dengan 3 kolom
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('npsn')
                            ->label('NPSN')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Sekolah')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('jenjang.kode_jenjang')
                            ->label('Jenjang Pendidikan')
                            ->required()
                            ->relationship('jenjang', 'kode')
                            ->searchable()
                            ->preload(true),
                        Forms\Components\TextInput::make('status')
                            ->label('Status')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('akreditasi')
                            ->label('Akreditasi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('telepon')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('kepemilikan')
                            ->label('Kepemilikan')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('sk_pendirian')
                            ->label('SK Pendirian')
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_sk_pendirian')
                            ->label('Tanggal SK Pendirian')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),
                        Forms\Components\TextInput::make('sk_izin_operasional')
                            ->label('SK Izin Operasional')
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_sk_izin_operasional')
                            ->label('Tanggal SK Izin Operasional')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->maxLength(100),
                    ]),
            ]);
    }


    // Definisi tabel untuk list sekolah
    public static function table(Table $table): Table
    {
        // Admin sekolah tidak melihat tabel (hanya form edit)
        if (auth()->user()->hasRole('admin_sekolah')) {
            return $table->columns([]);
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable()
                    ->label('NPSN'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->label('Nama Sekolah'),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->searchable()
                    ->label('Kode Wilayah'),
                Tables\Columns\TextColumn::make('kode_pos')
                    ->searchable()
                    ->label('Kode Pos'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('kode_jenjang')
                    ->searchable()
                    ->label('Kode Jenjang'),
                Tables\Columns\TextColumn::make('akreditasi')
                    ->searchable()
                    ->label('Akreditasi'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable()
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->searchable()
                    ->label('Kepemilikan'),
                Tables\Columns\TextColumn::make('sk_pendirian')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('SK Pendirian'),
                Tables\Columns\TextColumn::make('tanggal_sk_pendirian')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tanggal SK Pendirian'),
                Tables\Columns\TextColumn::make('sk_izin_operasional')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('SK Izin Operasional'),
                Tables\Columns\TextColumn::make('tanggal_sk_izin_operasional')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tanggal SK Izin Operasional'),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Latitude'),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Longitude'),
                Tables\Columns\TextColumn::make('users_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('ID User'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Pada'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diperbarui Pada'),
            ])
            ->filters([
                //
            ])
            // Konfigurasi tabel: disable klik baris
            ->openRecordUrlInNewTab(false)
            ->recordUrl(null)
            ->recordAction(null)

            ->filters([
                //
            ])

            // Action group untuk setiap baris tabel
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),   // Lihat detail
                    EditAction::make(),   // Edit data
                    DeleteAction::make(), // Hapus data
                ]),
            ])
            // Bulk actions untuk multiple selection
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Hapus massal
                ]),
            ]);
    }

    // Definisi relation managers (saat ini kosong)
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Definisi routing untuk halaman resource
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstSekolahs::route('/'),
            'create' => Pages\CreateMstSekolah::route('/create'),
            'edit' => Pages\EditMstSekolah::route('/{record}/edit'),
        ];
    }
}
