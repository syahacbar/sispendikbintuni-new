<?php

namespace App\Mail;

use App\Models\SchoolInvitationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public SchoolInvitationToken $invitationToken;

    /**
     * Create a new message instance.
     */
    public function __construct(SchoolInvitationToken $invitationToken)
    {
        $this->invitationToken = $invitationToken;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $sekolahNama = $this->invitationToken->sekolah?->nama ?? 'Sekolah';

        return new Envelope(
            subject: "Undangan Bergabung sebagai Admin Sekolah - {$sekolahNama}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.school-invitation',
            with: [
                'token' => $this->invitationToken->token,
                'sekolah' => $this->invitationToken->sekolah,
                'expiresAt' => $this->invitationToken->expires_at,
                'registrationUrl' => route('filament.paneladmin.auth.register') . '?token=' . $this->invitationToken->token,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
