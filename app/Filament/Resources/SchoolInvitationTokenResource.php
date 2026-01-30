<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolInvitationTokenResource\Pages;
use App\Models\SchoolInvitationToken;
use App\Models\MstSekolah;
use App\Mail\SchoolInvitationMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SchoolInvitationTokenResource extends Resource
{
    protected static ?string $model = SchoolInvitationToken::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Manajemen Akses';

    protected static ?string $navigationLabel = 'Token Undangan';

    protected static ?string $modelLabel = 'Token Undangan';

    protected static ?string $pluralLabel = 'Token Undangan';

    protected static ?string $slug = 'token-undangan';

    protected static ?int $navigationSort = 12;

    /**
     * Scope query berdasarkan role user
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Admin sekolah hanya bisa melihat token untuk sekolahnya sendiri
        if (auth()->user()->hasRole('admin_sekolah')) {
            $sekolah = auth()->user()->sekolah;
            if ($sekolah) {
                $query->where('npsn', $sekolah->npsn);
            }
        }

        return $query->with(['sekolah', 'consumer', 'creator'])->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Token')
                    ->schema([
                        Forms\Components\Select::make('npsn')
                            ->label('Sekolah')
                            ->options(function () {
                                // Super admin bisa pilih semua sekolah yang belum punya akun
                                if (auth()->user()->hasRole('super_admin')) {
                                    return MstSekolah::query()
                                        ->whereNull('users_id') // 🔐 hanya sekolah belum punya admin
                                        ->orderBy('nama')
                                        ->pluck('nama', 'npsn');
                                }

                                // Admin sekolah hanya bisa pilih sekolahnya sendiri (jika belum punya admin)
                                $sekolah = auth()->user()->sekolah;
                                if ($sekolah && $sekolah->users_id === null) {
                                    return [$sekolah->npsn => $sekolah->nama];
                                }

                                return [];
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(function () {
                                // Auto-fill untuk admin sekolah
                                if (auth()->user()->hasRole('admin_sekolah')) {
                                    return auth()->user()->sekolah?->npsn;
                                }
                                return null;
                            })
                            ->disabled(fn() => auth()->user()->hasRole('admin_sekolah')),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Spesifik (Opsional)')
                            ->email()
                            ->helperText('Jika diisi, hanya email ini yang dapat menggunakan token. Kosongkan jika token dapat digunakan siapa saja.')
                            ->maxLength(255),

                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Berlaku Hingga')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->default(now()->addDays(7))
                            ->minDate(now())
                            ->helperText('Token akan otomatis kadaluarsa setelah tanggal ini.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('token')
                    ->label('Token')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Token berhasil disalin!')
                    ->icon('heroicon-o-clipboard-document')
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->default('Semua Email')
                    ->placeholder('Semua Email')
                    ->color('gray'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderByRaw("CASE 
                                WHEN used_at IS NOT NULL THEN 2
                                WHEN expires_at <= NOW() THEN 3
                                ELSE 1
                            END {$direction}");
                    })
                    ->color(fn(SchoolInvitationToken $record) => $record->status_color),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Berlaku Hingga')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('consumer.name')
                    ->label('Digunakan Oleh')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('used_at')
                    ->label('Digunakan Pada')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'used' => 'Sudah Digunakan',
                        'expired' => 'Kadaluarsa',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['value'])) {
                            return $query;
                        }

                        if ($data['value'] === 'active') {
                            return $query->active();
                        } elseif ($data['value'] === 'used') {
                            return $query->used();
                        } elseif ($data['value'] === 'expired') {
                            return $query->expired();
                        }

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('send_email')
                    ->label('Kirim Email')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->visible(fn(SchoolInvitationToken $record) => $record->email !== null && $record->isValid())
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Email Undangan')
                    ->modalDescription(fn(SchoolInvitationToken $record) => "Email akan dikirim ke {$record->email}")
                    ->action(function (SchoolInvitationToken $record) {
                        try {
                            Mail::to($record->email)->send(new SchoolInvitationMail($record));

                            Notification::make()
                                ->title('Email berhasil dikirim!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal mengirim email')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('copy_registration_link')
                    ->label('Salin Link Registrasi')
                    ->icon('heroicon-o-link')
                    ->color('info')
                    ->visible(fn(SchoolInvitationToken $record) => $record->isValid())
                    ->action(function (SchoolInvitationToken $record) {
                        $url = route('filament.paneladmin.auth.register') . '?token=' . $record->token;

                        Notification::make()
                            ->title('Link registrasi disalin!')
                            ->body('Link: ' . $url)
                            ->success()
                            ->send();
                    }),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->visible(fn(SchoolInvitationToken $record) => $record->isValid()),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus Token'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Token Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListSchoolInvitationTokens::route('/'),
            'create' => Pages\CreateSchoolInvitationToken::route('/create'),
            'view' => Pages\ViewSchoolInvitationToken::route('/{record}'),
            'edit' => Pages\EditSchoolInvitationToken::route('/{record}/edit'),
        ];
    }
}
