<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;
    
    // Specify the table associated with the model
    protected $table = 'books';

    // Specify the columns that can be mass-assigned
    protected $fillable = ['title', 'author', 'publish_date', 'publish_location', 'sublocation', 'call_number'];
}
