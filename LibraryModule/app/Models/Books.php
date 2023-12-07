<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $primaryKey = 'call_number';

    protected $fillable = [
        'call_number',
        'author',
        'title',
        'publish_location',
        'publish_date',
        'available_copies',
        'total_copies',
        'sublocation',
        'book_description',
    ];
}
