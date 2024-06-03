<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendingRequests extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['email', 'book_request', 'request_date', 'request_type', 'request_status', 'id','expiration_time', 'notification_sent', 'initial_notification_sent', 'request_number', 'request_status_notif', 'college', 'course'];

    protected $table = 'library_pending_requests';

    public $timestamps = true;
}
