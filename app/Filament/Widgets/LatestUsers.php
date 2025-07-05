<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestUsers extends BaseWidget
{
    protected static ?string $heading = '5 Pengguna Terbaru';
    protected static ?int $sort = 5;

    protected function getTableQuery(): Builder
    {
        // return User::query()->latest();
        return User::query()->latest()->limit(5);
    }

    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    public function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->label('Nama'),
            Tables\Columns\TextColumn::make('email')->label('Email'),
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Role')
                ->badge()
                ->color(fn($state) => match ($state) {
                    'super_admin' => 'danger',
                    'admin' => 'warning',
                    'guest' => 'gray',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('created_at')->label('Bergabung')->dateTime('d M Y H:i'),
        ];
    }
}
