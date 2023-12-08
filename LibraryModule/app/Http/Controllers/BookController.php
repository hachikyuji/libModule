<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\Books;
use App\Models\PendingRequests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $books;

    public function show($id)
    {
        $this->books = Books::findOrFail($id);
        return view('view', ['books' => $this->books]);
    }

    public function showBooksWithHighestCount()
    {
        $booksWithHighestCount = Books::orderBy('count', 'desc')->take(5)->get(); // Adjust the query as needed
        return view('dashboard', compact('booksWithHighestCount'));
    }

    public function checkIn($title)
    {
        $userEmail = Auth::user()->email;
        
        pendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => Carbon::now(),
            'request_type' => 'Check In', 
            'request_status' => 'Pending',
        ]);

        AccountHistory::create([
            'email' => $userEmail,
            'books_borrowed' => $title,
            'returned_date' => Carbon::now(),
            'fines' => 0,
        ]);

        return redirect()->back()->with('success', 'Check-in request submitted successfully!');
    }

    public function checkOut($title)
    {
        $userEmail = Auth::user()->email;
        
        pendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => Carbon::now(),
            'request_type' => 'Check Out', 
            'request_status' => 'Pending',
        ]);

        AccountHistory::create([
            'email' => $userEmail,
            'books_borrowed' => $title,
            'borrowed_date' => Carbon::now(),
            'fines' => 0,
        ]);

        Books::where('title', $title)->increment('count');

        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }

}
