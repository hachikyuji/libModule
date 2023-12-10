<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\Books;
use App\Models\PendingRequests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $booksWithHighestCount = Books::orderBy('count', 'desc')->take(5)->get();
    
        $userEmail = Auth::user()->email;
    
        $mostPopularSublocation = AccountHistory::where('email', $userEmail)
            ->groupBy('sublocation')
            ->select('sublocation', DB::raw('count(*) as count'))
            ->orderByDesc('count')
            ->first();
    
        $mostPopularBooks = collect();
    
        if ($mostPopularSublocation) {
            $mostPopularBooks = Books::where('sublocation', $mostPopularSublocation->sublocation)
                ->orderByDesc('count')
                ->take(5)
                ->get();
        }
    
        return view('dashboard', compact('booksWithHighestCount', 'mostPopularBooks'));
    }

    public function checkIn($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
        
        $now = Carbon::now('Asia/Manila');
    
        // Retrieve the corresponding check-out record for the specific book
        $checkOutRecord = AccountHistory::where('email', $userEmail)
            ->where('books_borrowed', $title)
            ->where('sublocation', $sublocation)
            ->whereNotNull('borrowed_date') // Only consider records with borrowed_date
            ->orderBy('borrowed_date', 'desc') // Assuming you want the latest check-out record
            ->first();
    
        if ($checkOutRecord) {
            $borrowedDate = Carbon::parse($checkOutRecord->borrowed_date);
            $daysPassed = $borrowedDate->diffInDays($now);
    
            // If more than 3 days have passed, calculate fines
            if ($daysPassed > 3) {
                $fineAmount = ($daysPassed - 3) * 50; // 50 is the fine amount per day
                $checkOutRecord->update(['fines' => $fineAmount]);
            }
        }
    
        // Proceed with check-in logic
        pendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check In', 
            'request_status' => 'Pending',
        ]);
    
        AccountHistory::create([
            'email' => $userEmail,
            'books_borrowed' => $title,
            'returned_date' => $now,
            'fines' => 0, // Initialize fines to 0 for check-in
            'sublocation' => $sublocation,
        ]);
    
        return redirect()->back()->with('success', 'Check-in request submitted successfully!');
    }
    
    public function checkOut($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
    
        $now = Carbon::now('Asia/Manila');
    
        pendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check Out', 
            'request_status' => 'Pending',
        ]);
    
        AccountHistory::create([
            'email' => $userEmail,
            'books_borrowed' => $title,
            'borrowed_date' => $now,
            'fines' => 0,
            'sublocation' => $sublocation,
        ]);
    
        Books::where('title', $title)->update(['count' => Books::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }

}
