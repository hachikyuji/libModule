<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestDecisionNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $title;
     public $request_status;
     public $request_type;
     public function __construct($title, $request_status, $request_type)
     {
         $this->title = $title;
         $this->request_status = $request_status;
         $this->request_type = $request_type;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
         return $this->subject('PLM Library - Request Status Notification')
                     ->view('accept_deny_notification')
                     ->with('title', $this->title)
                     ->with('request_type', $this->request_type)
                     ->with('request_status', $this->request_status);
    
     }
}
