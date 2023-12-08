<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendingRequests extends Model
{
    use HasFactory;
    protected $table = 'pending_requests';
    protected $primaryKey = 'email';
    public $incrementing = false;

    protected $fillable = ['email', 'book_request', 'request_date', 'request_type', 'request_status'];



    public $timestamps = true;
}
