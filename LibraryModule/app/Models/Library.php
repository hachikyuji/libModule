<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'patron_account';
    protected $fillable = [
        'first_name', 
        'last_name',
        'email',
        'id_number',
        'password',
        'confirm_password',
    ] ;
}
