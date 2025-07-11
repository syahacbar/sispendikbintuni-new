<?php

namespace App\Filament\Pages;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Kalender;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Tables\Columns\IconColumn;

class Kalenders extends Page implements HasTable, HasActions, HasForms
{
    use InteractsWithTable, InteractsWithForms, InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static string $view = 'filament.pages.kalender';



    public function createAction(): CreateAction
    {
        return CreateAction::make()
            ->createAnother(false)
            ->label('Tambah Kegiatan')
            ->modalHeading('Tambah Kegiatan Kalender')
            ->model(\App\Models\Kalender::class)
            ->form([
                TextInput::make('nama')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255),


                TextInput::make('deskripsi')
                    ->label('Deskripsi')
                    ->maxLength(255),

                Toggle::make('waktu')
                    ->default(0)
                    ->label('Waktu')
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state) {
                        if (!$state) {
                            $set('waktu_mulai', null);
                            $set('wakt_akhir', null);
                        }
                    }),

                DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->native(false),

                DatePicker::make('tanggal_akhir')
                    ->label('Tanggal Akhir')
                    ->required()
                    ->native(false),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->withoutSeconds()
                    ->disabled(fn(Get $get) => !$get('waktu'))
                    ->required(fn(Get $get) => $get('waktu'))
                    ->dehydrated(),

                TimePicker::make('jam_akhir')
                    ->label('Jam Akhir')
                    ->disabled(fn(Get $get) => !$get('waktu'))
                    ->required(fn(Get $get) => $get('waktu'))
                    ->withoutSeconds()
                    ->dehydrated(),
            ])

            ->successNotification(function () {
                Notification::make()
                    ->title('Settings Updated')
                    ->body('Basic settings have been successfully updated.')
                    ->success()
                    ->send();
            })
            ->failureNotification(function () {
                Notification::make()
                    ->title('Settings Updated')
                    ->body('Basic settings have been successfully updated.')
                    ->success()
                    ->send();
            })
            ->after(function () {
                // 
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Kalender::query())
            ->columns([
                TextColumn::make('nama')->label('Nama Kegiatan')->searchable(),
                TextColumn::make('deskripsi')->label('Deskripsi')->searchable(),
                TextColumn::make('tanggal_mulai')->label('Tanggal Mulai')->date(),
                TextColumn::make('tanggal_akhir')->label('Tanggal Akhir')->date(),
                IconColumn::make('waktu')
                    ->boolean(),
                TextColumn::make('jam_mulai')->label('Jam Mulai'),
                TextColumn::make('jam_akhir')->label('Jam Akhir'),
                TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
