<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\Books;
use App\Models\PendingRequests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PatronBookControll extends Controller
{
    private $books;

    public function show($id)
    {
        $this->books = Books::findOrFail($id);
        return view('patron_view', ['books' => $this->books]);
    }

    public function showBooksWithHighestCount()
    {
        // Retrieve books with the highest count
        $booksWithHighestCount = Books::orderBy('count', 'desc')->take(5)->get();
    
        // Retrieve the most popular sublocation for the current user
        $userEmail = Auth::user()->email;
    
        $mostPopularSublocation = AccountHistory::where('email', $userEmail)
            ->groupBy('sublocation')
            ->select('sublocation', DB::raw('count(*) as count'))
            ->orderByDesc('count')
            ->first();
    
        // Retrieve the most popular books for the most popular sublocation
        $mostPopularBooks = collect();
    
        if ($mostPopularSublocation) {
            $mostPopularBooks = Books::where('sublocation', $mostPopularSublocation->sublocation)
                ->orderByDesc('count')
                ->take(5)
                ->get();
        }
    
        // Pass the data to the view
        return view('dashboard', compact('booksWithHighestCount', 'mostPopularBooks'));
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

    public function checkOut($title, $sublocation)
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
            'sublocation' => $sublocation,
        ]);

        Books::where('title', $title)->update(['count' => \App\Models\Books::raw('count + 1')]);


        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }

}
