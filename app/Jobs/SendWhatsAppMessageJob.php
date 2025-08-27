<?php

namespace App\Jobs;

use App\Models\MessageOutbox;
use App\Services\ZenzivaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $recipientName;
    protected string $recipientNumber;
    protected string $message;
    protected string $outboxId;

    public function __construct(
        string $recipientName,
        string $recipientNumber,
        string $message,
        string $outboxId
    ) {
        $this->recipientName = $recipientName;
        $this->recipientNumber = $recipientNumber;
        $this->message = $message;
        $this->outboxId = $outboxId;
    }

    public function handle(ZenzivaService $zenziva)
    {
        try {
            Log::info('Memproses job WA untuk nomor: ' . $this->recipientNumber, [
                'outbox_id' => $this->outboxId,
                'message_preview' => substr($this->message, 0, 50) . '...'
            ]);

            $response = $zenziva->sendMessage($this->recipientNumber, $this->message);

            Log::info('Response Zenziva:', [
                'outbox_id' => $this->outboxId,
                'response' => $response
            ]);

            // Update outbox status
            $outbox = MessageOutbox::find($this->outboxId);
            if ($outbox) {
                $status = isset($response['status']) && $response['status'] == 1 ? 'sent' : 'failed';

                $outbox->update([
                    'status' => $status,
                    'provider_message_id' => $response['messageId'] ?? null,
                    'provider_raw' => $response,
                    'sent_at' => now(),
                ]);

                Log::info('Status outbox diperbarui: ' . $status, [
                    'outbox_id' => $this->outboxId
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error dalam SendWhatsAppMessageJob:', [
                'outbox_id' => $this->outboxId,
                'recipient_number' => $this->recipientNumber,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);

            // Update status failed
            $outbox = MessageOutbox::find($this->outboxId);
            if ($outbox) {
                $outbox->update([
                    'status' => 'failed',
                    'provider_raw' => [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ],
                ]);
            }

            throw $e; // Re-throw untuk queue retry
        }
    }
}
