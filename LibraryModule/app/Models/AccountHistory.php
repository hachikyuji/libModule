<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHistory extends Model
{
    use HasFactory;

    protected $fillable =[
        'email',
        'books_borrowed',
        'borrowed_date',
        'returned_date',
        'fines',
        'sublocation',
        'request_status',
        'request_number',
        'book_deadline',
        'deadline_notif',
        'college',
        'course',
    ];
    protected $table = 'library_account_history';

    public $timestamps = true;
}
