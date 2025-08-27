<?php

namespace App\Filament\Pages;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\MessageOutbox;
use App\Models\MstSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class KirimPesanMassal extends Page implements Forms\Contracts\HasForms
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $title = 'WhatsApp';
    protected static string $view = 'filament.pages.kirim-pesan-massal';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';

    public ?string $message = null;
    public ?string $numbers = null;
    public bool $sendToAll = false;
    public array $selectedSchools = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('sendToAll')
                    ->label('Kirim ke semua sekolah')
                    ->reactive(),

                Forms\Components\Select::make('selectedSchools')
                    ->label('Pilih Sekolah')
                    ->multiple()
                    ->searchable()
                    ->options(MstSekolah::pluck('nama', 'id'))
                    ->visible(fn($get) => !$get('sendToAll')),

                Forms\Components\Textarea::make('message')
                    ->label('Isi Pesan')
                    ->placeholder('Tulis pesan Anda...')
                    ->rows(6)
                    ->required()
                    ->maxLength(1000),
            ]);
    }


    private function normalizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0 → ganti 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Jika diawali 8 → tambahkan 62
        if (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    public function send(): void
    {
        $data = $this->form->getState();
        $numbers = [];

        if ($data['sendToAll']) {
            $numbers = MstSekolah::whereNotNull('telepon')
                ->pluck('telepon')
                ->map(fn($telp) => $this->normalizePhone($telp))
                ->filter()
                ->toArray();
        } elseif (!empty($data['selectedSchools'])) {
            $numbers = MstSekolah::whereIn('id', $data['selectedSchools'])
                ->whereNotNull('telepon')
                ->pluck('telepon')
                ->map(fn($telp) => $this->normalizePhone($telp))
                ->filter()
                ->toArray();
        }

        if (count($numbers) === 0) {
            Notification::make()
                ->title('Tidak ada nomor telepon sekolah ditemukan.')
                ->danger()
                ->send();
            return;
        }

        // Tambahkan footer otomatis
        $finalMessage = $data['message']
            . "\n\n---\nPesan ini dikirim otomatis oleh sistem. Mohon tidak membalas (No Reply).";

        foreach ($numbers as $number) {
            $outbox = MessageOutbox::create([
                'recipient_name'   => null,
                'recipient_number' => $number,
                'message'          => $finalMessage,
                'status'           => 'queued',
            ]);

            dispatch(new SendWhatsAppMessageJob(
                '',
                $number,
                $finalMessage,
                $outbox->id
            ))->onQueue('default');
        }

        Notification::make()
            ->title('Antrian pesan dibuat')
            ->body('Pesan sedang dikirim ke ' . count($numbers) . ' sekolah.')
            ->success()
            ->send();

        $this->form->fill([
            'message' => null,
            'selectedSchools' => [],
            'sendToAll' => false,
        ]);
    }
}
