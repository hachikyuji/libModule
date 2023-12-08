<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class Books extends Model
{
    use HasFactory, HasApiTokens, Notifiable, Searchable;

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

    public function toSearchableArray()
    {
        return [
            'call_number' => $this->call_number,
            'title' => $this->title,
            'author' => $this->author,
        ];
    }

    
}
