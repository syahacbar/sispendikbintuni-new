<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengaduan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PengaduanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengaduanResource\RelationManagers;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Fasilitas Sekolah' => 'Fasilitas Sekolah',
                        'Kurikulum dan Pembelajaran' => 'Kurikulum & Pembelajaran',
                        'Guru & Tenaga Kependidikan' => 'Guru & Tenaga Kependidikan',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required(),
                TextInput::make('dok_lampiran')
                    ->maxLength(255),
                RichEditor::make('isi')
                    ->label('Isi Pengaduan')
                    ->required()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status Pengaduan')
                    ->options([
                        'terkirim' => 'Terkirim',
                        'diproses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                        'ditindaklanjuti' => 'Ditindaklanjuti',
                    ])
                    ->default('terkirim')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_laporan')
                    ->label('Nomor Laporan')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Pelapor')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('telepon')
                    ->label('Nomor WA')
                    ->searchable(),
                TextColumn::make('kategori')
                    ->label('Kategori Laporan')
                    ->searchable(),

                TextColumn::make('dok_lampiran')
                    ->label('Lampiran')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';

                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                        return match ($ext) {
                            'pdf' => '📄',
                            'jpg', 'jpeg', 'png', 'webp' => '🖼️',
                            'doc', 'docx' => '📃',
                            default => '📎',
                        };
                    })
                    ->html()
                    ->action(
                        Action::make('preview')
                            ->label('')
                            ->modalHeading('Preview Lampiran')
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                            ->modalWidth('lg')
                            ->modalContent(fn($record) => view('filament.components.preview-lampiran', [
                                'record' => $record,
                            ]))
                    ),

                TextColumn::make('isi')
                    ->label('Isi Pengaduan')
                    ->limit(50)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'terkirim' => 'secondary',
                        'diproses' => 'warning',
                        'ditindaklanjuti' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
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
            'index' => Pages\ListPengaduans::route('/'),
            'create' => Pages\CreatePengaduan::route('/create'),
            'edit' => Pages\EditPengaduan::route('/{record}/edit'),
        ];
    }
}
