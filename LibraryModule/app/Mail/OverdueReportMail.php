<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $overdueHistories;

    public function __construct($overdueHistories)
    {
        $this->overdueHistories = $overdueHistories;
    }

    public function build()
    {
        return $this->view('overdue_report');
    }
}

