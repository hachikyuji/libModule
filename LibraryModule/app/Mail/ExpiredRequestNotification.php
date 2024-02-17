<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiredRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $expiration_time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $expiration_time)
    {
        $this->title = $title;
        $this->expiration_time = $expiration_time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PLM Library - Your Request is Expiring Soon')
                    ->view('expired_request_notification')
                    ->with('title', $this->title)
                    ->with('expiration_time', $this->expiration_time);
    }
    
}
