<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\ExtKalender;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Filament\Actions\CreateAction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Kalenders extends Page implements HasTable, HasActions, HasForms
{
    use InteractsWithTable, InteractsWithForms, InteractsWithActions, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Kalender Pendidikan';
    protected static ?string $modelLabel = 'Kalender Pendidikan';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $title = 'Kalender Pendidikan';
    protected static string $view = 'filament.pages.kalender';

    public ?string $startDate = null;
    public ?string $endDate = null;

    public $events;

    public function createAction(): Action
    {
        return CreateAction::make('create')
            ->createAnother(false)
            ->label('Tambah Kegiatan')
            ->modalHeading('Tambah Kegiatan Kalender')
            ->model(ExtKalender::class)
            ->form(function (Form $form) {
                return $form->schema([
                    TextInput::make('nama')
                        ->label('Nama Kegiatan')
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),

                    TextInput::make('deskripsi')
                        ->label('Deskripsi')
                        ->columnSpanFull()
                        ->maxLength(255),

                    DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->native(false)
                        ->default(fn(Kalenders $livewire) => $livewire->startDate ?? now()),

                    DatePicker::make('tanggal_akhir')
                        ->label('Tanggal Akhir')
                        ->native(false)
                        ->default(fn(Kalenders $livewire) => $livewire->endDate ?? now())
                        ->rules(['after_or_equal:tanggal_mulai']),

                    Toggle::make('waktu')
                        ->columnSpanFull()
                        ->default(false)
                        ->label('Atur Jam')
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            if (!$state) {
                                $set('jam_mulai', null);
                                $set('jam_akhir', null);
                            }
                        }),

                    TimePicker::make('jam_mulai')
                        ->label('Jam Mulai')
                        ->withoutSeconds()
                        ->visible(fn(Get $get) => $get('waktu')) // hanya tampil jika waktu aktif
                        ->required(fn(Get $get) => $get('waktu'))
                        ->dehydrated(),

                    TimePicker::make('jam_akhir')
                        ->label('Jam Akhir')
                        ->withoutSeconds()
                        ->visible(fn(Get $get) => $get('waktu')) // hanya tampil jika waktu aktif
                        ->required(fn(Get $get) => $get('waktu'))
                        ->dehydrated(),
                ])->columns(2);
            })

            ->successNotification(function () {
                return Notification::make()
                    ->title('Berhasil')
                    ->body('Kegiatan berhasil ditambahkan.')
                    ->success();
            })
            ->failureNotification(function () {
                return Notification::make()
                    ->title('Gagal')
                    ->body('Terjadi kesalahan saat menambahkan kegiatan.')
                    ->danger();
            })
            ->after(function () {
                $this->dispatch('refresh-calendar')->self();
            });
    }


    public function editAction(): Action
    {
        return EditAction::make('edit')
            ->label('Ubah Kegiatan')
            ->modalHeading('Tambah Kegiatan')
            ->record(function (array $arguments) {
                return ExtKalender::query()->where('id', $arguments['id'])->first();
            })
            // ->model(Kalender::class)
            ->form(function (Form $form) {
                return $form->schema([
                    TextInput::make('nama')
                        ->label('Nama Kegiatan')
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),

                    TextInput::make('deskripsi')
                        ->label('Deskripsi')
                        ->columnSpanFull()
                        ->maxLength(255),

                    Toggle::make('waktu')
                        ->columnSpanFull()
                        ->default(false)
                        ->label('Atur Jam')
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            if (!$state) {
                                $set('jam_mulai', null);
                                $set('jam_akhir', null);
                            }
                        }),

                    DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->native(false)
                        ->default(fn(Kalenders $livewire) => $livewire->startDate ?? now()),

                    DatePicker::make('tanggal_akhir')
                        ->label('Tanggal Akhir')
                        ->native(false)
                        ->default(fn(Kalenders $livewire) => $livewire->endDate ?? now())
                        ->rules(['after_or_equal:tanggal_mulai']),

                    TimePicker::make('jam_mulai')
                        ->label('Jam Mulai')
                        ->withoutSeconds()
                        ->visible(fn(Get $get) => $get('waktu'))
                        ->required(fn(Get $get) => $get('waktu'))
                        ->dehydrated(),

                    TimePicker::make('jam_akhir')
                        ->label('Jam Akhir')
                        ->withoutSeconds()
                        ->visible(fn(Get $get) => $get('waktu'))
                        ->required(fn(Get $get) => $get('waktu'))
                        ->dehydrated(),
                ])->columns(2);
            })

            ->successNotification(function () {
                return Notification::make()
                    ->title('Berhasil')
                    ->body('Kegiatan berhasil diperbarui.')
                    ->success();
            })
            ->failureNotification(function () {
                return Notification::make()
                    ->title('Gagal')
                    ->body('Terjadi kesalahan saat meperbarui kegiatan.')
                    ->danger();
            })
            ->after(function () {
                $this->dispatch('refresh-calendar')->self();
            });
    }

    public function viewAction(): Action
    {
        return ViewAction::make('view')
            ->record(function (array $arguments) {
                return ExtKalender::query()->where('id', $arguments['id'])->first();
            })
            ->infolist(function (Infolist $infolist) {
                return $infolist
                    ->schema([
                        Section::make()
                            ->columns(4)
                            ->schema([
                                TextEntry::make('nama')
                                    ->columnSpanFull(),
                                TextEntry::make('deskripsi')
                                    ->columnSpanFull(),
                                TextEntry::make('tanggal_mulai'),
                                TextEntry::make('tanggal_akhir'),
                                TextEntry::make('jam_mulai'),
                                TextEntry::make('jam_akhir'),
                            ])
                    ]);
            })
            ->modalHeading('Detail Kegiatan')
            ->extraModalFooterActions(function (array $arguments) {
                return [
                    Action::make('edit')
                        ->action(function () use ($arguments) {
                            $this->replaceMountedAction('edit', [
                                'id' => $arguments['id']
                            ]);
                        }),
                    Action::make('delete')
                        ->color('danger')
                        ->action(function () use ($arguments) {
                            $this->replaceMountedAction('delete', [
                                'id' => $arguments['id']
                            ]);
                        })
                ];
            });
    }


    public function deleteAction(): Action
    {
        return DeleteAction::make('delete')
            ->record(function (array $arguments) {
                return ExtKalender::query()->where('id', $arguments['id'])->first();
            })

            ->after(function () {
                $this->dispatch('refresh-calendar')->self();
            });
    }


    public function droppedEvent(): Action
    {
        return Action::make('droppedevent')
            ->action(function (array $arguments) {

                $id = $arguments['id'];

                if (preg_match('#T#', $arguments['startDate']) || preg_match('#T#', $arguments['endDate'])) {

                    $startDate = Carbon::parse($arguments['startDate'])->format('Y-m-d');
                    $endDate = Carbon::parse($arguments['endDate'])->subDay()->format('Y-m-d');
                } else {
                    $startDate = Carbon::parse($arguments['startDate'])->format('Y-m-d');
                    $endDate = Carbon::parse($arguments['endDate'])->subDay()->format('Y-m-d');
                }

                $event = ExtKalender::query()->where('id', $id)->first();
                $if_updated =  $event->update(
                    [
                        'tanggal_mulai' => $startDate,
                        'tanggal_akhir' => $endDate,
                    ]
                );

                if ($if_updated) {
                    Notification::make()
                        ->title('Berhasil')
                        ->body('Kegiatan berhasil diperbarui.')
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title('Gagal')
                        ->body('Coba lagi nanti.')
                        ->danger()
                        ->send();
                }

                $this->dispatch('refresh-calendar')->self();
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ExtKalender::query())
            ->columns([
                TextColumn::make('nama')->label('Nama Kegiatan')->searchable(),
                TextColumn::make('deskripsi')->label('Deskripsi')->searchable(),
                TextColumn::make('tanggal_mulai')->label('Tanggal Mulai')->date()->sortable(),
                TextColumn::make('tanggal_akhir')->label('Tanggal Akhir')->date(),
                IconColumn::make('waktu')
                    ->boolean(),
                TextColumn::make('jam_mulai')->label('Jam Mulai'),
                TextColumn::make('jam_akhir')->label('Jam Akhir'),
                TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(function () {
                        $this->dispatch('refresh-calendar')->self();
                    }),
            ]);
    }

    public function render(): View
    {
        $events = ExtKalender::all();
        $arr = [];
        foreach ($events as $event) {

            if (!empty($event->jam_mulai) && !empty($event->jam_akhir)) {
                $tanggal_mulai = Carbon::parse($event->tanggal_mulai)->format('Y-m-d');
                $tanggal_akhir = Carbon::parse($event->tanggal_akhir)->format('Y-m-d');
                $jam_mulai = Carbon::parse($event->jam_mulai)->format('H:i');
                $jam_akhir = Carbon::parse($event->jam_akhir)->format('H:i');


                $start_date_time = $tanggal_mulai . 'T' . $jam_mulai;
                $end_date_time = $tanggal_akhir . 'T' . $jam_akhir;
            } else {
                $tanggal_mulai = Carbon::parse($event->tanggal_mulai)->format('Y-m-d');
                $tanggal_akhir = Carbon::parse($event->tanggal_akhir)->addDay()->format('Y-m-d');


                $start_date_time = $tanggal_mulai;
                $end_date_time = $tanggal_akhir;
            }


            $arr[] = [
                'id' => $event->id,
                'title' => $event->nama,
                'start' => $start_date_time,
                'end' => $end_date_time,
            ];

            $this->events = json_encode($arr);
        }

        return parent::render();
    }
}
