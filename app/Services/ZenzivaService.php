<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZenzivaService
{
    protected string $url;
    protected string $userkey;
    protected string $passkey;

    public function __construct()
    {
        $this->url     = config('services.zenziva.url', 'https://console.zenziva.net/wareguler/api/sendWA/');
        $this->userkey = config('services.zenziva.userkey');
        $this->passkey = config('services.zenziva.passkey');
    }

    public function sendMessage(string $phone, string $message)
    {
        try {
            // Format nomor
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }

            Log::info('Mengirim WA ke: ' . $phone);

            $payload = [
                'userkey' => $this->userkey,
                'passkey' => $this->passkey,
                'to'      => $phone,
                'message' => $message,
            ];

            $response = Http::timeout(30)
                ->asForm()
                ->post($this->url, $payload);

            $data = $response->json();
            Log::info('Response Zenziva', $data);

            return $data;
        } catch (\Exception $e) {
            Log::error('Error ZenzivaService: ' . $e->getMessage());
            return [
                'status' => 0,
                'text'   => 'Error: ' . $e->getMessage(),
            ];
        }
    }
}
