<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendingRequests extends Model
{
    use HasFactory;

    protected $primaryKey = 'email';
    public $incrementing = false;

    protected $fillable = [
        'email',
        'request_status',
    ];
    protected $table = 'pending_requests';

    public $timestamps = true;
}
