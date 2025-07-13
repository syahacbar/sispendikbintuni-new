<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Tables;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveUsers extends BaseWidget
{
    protected static ?string $heading = 'Pengguna Aktif Saat Ini';
    protected static ?int $sort = 6;
    protected int $pollInterval = 10;

    protected function getTableQuery(): Builder
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10)->timestamp;

        return User::query()
            ->select([
                'users.*',
                'sessions.last_activity',
                'sessions.ip_address',
                'sessions.user_agent'
            ])
            ->join('sessions', 'users.id', '=', 'sessions.user_id')
            ->where('sessions.last_activity', '>=', $tenMinutesAgo)
            ->orderBy('sessions.last_activity', 'desc')
            ->distinct();
    }

    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    public function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama'),
            Tables\Columns\TextColumn::make('email')
                ->label('Email'),
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Role')
                ->badge()
                ->color(fn($state) => match ($state) {
                    'super_admin' => 'danger',
                    'admin' => 'warning',
                    'guest' => 'gray',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('last_activity')
                ->label('Terakhir Aktif')
                ->formatStateUsing(function ($state) {
                    return $state ? Carbon::createFromTimestamp($state)->diffForHumans() : '-';
                })
                ->sortable(),
        ];
    }
}
