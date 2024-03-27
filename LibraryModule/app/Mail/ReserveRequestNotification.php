<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReserveRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $title;

    public function __construct($data)
    {
        $this->title = $data['title'];
    }
    public function build()
    {
        return $this->subject('PLM Library - Book Reservation')
                    ->view('reserve_requests');
    }
}
