<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstPembelajaranResource\Pages;
use App\Filament\Resources\MstPembelajaranResource\RelationManagers;
use App\Models\MstPembelajaran;
use App\Models\MstRombel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class MstPembelajaranResource extends Resource
{
    protected static ?string $model = MstPembelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();

        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Pembelajaran';
    protected static ?string $pluralLabel = 'Pembelajaran';
    protected static ?string $slug = 'data-pembelajaran';

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 50 : 50;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rombongan_belajar_id')
                    ->label('Rombel')
                    ->relationship(
                        'rombel',
                        'nama',
                        fn(Builder $query) => auth()->user()->hasRole('admin_sekolah')
                        ? $query->where('sekolah_id', auth()->user()->sekolah?->id)
                        : $query
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Forms\Components\Select::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->relationship(
                        'mapel',
                        'nama',
                        fn(Builder $query, Get $get) => ($rombelId = $get('rombongan_belajar_id'))
                        ? $query->where('tingkat', (string) (MstRombel::find($rombelId, ['*'])?->tingkat))
                        : $query
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nama} - {$record->kode}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('gtk_id')
                    ->label('GTK')
                    ->relationship(
                        'gtk',
                        'nama',
                        fn(Builder $query) => auth()->user()->hasRole('admin_sekolah')
                        ? $query->where('tempat_tugas', auth()->user()->sekolah?->npsn)
                        : $query
                    )
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('semester_id')
                    ->label('Semester')
                    ->relationship('semester', 'nama_semester')
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->tahun_ajaran} - {$record->nama_semester}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('jam_mengajar_per_minggu')
                    ->label('Jam Mengajar/Minggu')
                    ->numeric(),
                Forms\Components\TextInput::make('jenis_pembelajaran')
                    ->label('Jenis Pembelajaran')
                    ->maxLength(50),
                Forms\Components\DatePicker::make('tgl_mulai')
                    ->label('Tanggal Mulai')
                    ->native(false),
                Forms\Components\DatePicker::make('tgl_selesai')
                    ->label('Tanggal Selesai')
                    ->native(false),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status_aktif')
                    ->label('Status Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),

                TextColumn::make('rombel.sekolah.nama')
                    ->label('Sekolah')
                    ->visible(fn() => !auth()->user()->hasRole('admin_sekolah'))
                    ->sortable()
                    ->searchable(),

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
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                // ...
            ])

            ->openRecordUrlInNewTab(false)
            ->recordUrl(null)
            ->recordAction(null)
            // ->actions([
            //     // Tables\Actions\EditAction::make(),
            // ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user->hasRole('admin_sekolah')) {
            $sekolahId = $user->sekolah?->id;

            if (!$sekolahId) {
                return $query->whereRaw('1=0');
            }

            return $query->whereHas('rombel', function ($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            });
        }

        return $query;
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
