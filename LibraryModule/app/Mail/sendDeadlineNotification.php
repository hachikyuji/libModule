<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendDeadlineNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $expiration_time;

    public function __construct($title, $expiration_time)
    {
        $this->title = $title;
        $this->expiration_time = $expiration_time;
    }
    public function build()
    {
        return $this->subject('PLM Library - Book Return Due')
                    ->view('send_deadline_notification')
                    ->with('title', $this->title)
                    ->with('expiration_time', $this->expiration_time);
    }
}
