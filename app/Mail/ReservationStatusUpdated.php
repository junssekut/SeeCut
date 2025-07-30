<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;
    public $statusMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation, string $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
        $this->statusMessage = $this->getStatusMessage($status);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Reservasi SeeCut - ' . $this->statusMessage,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-status-updated',
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

    /**
     * Get status message in Indonesian
     */
    private function getStatusMessage(string $status): string
    {
        return match($status) {
            'confirmed' => 'Dikonfirmasi',
            'pending' => 'Sedang Diproses',
            'finished' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Diperbarui'
        };
    }
}
