<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\PendingRequests;
use App\Models\Books;
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
    
        $userPreferences = DB::table('user_preferences')->where('email', $userEmail)->first();
    
        $filteredBooks = []; // Initialize an empty array
    
        // Check if user preferences are found
        if ($userPreferences) {
            $filteredBooks = Books::join('user_preferences', function($join) use ($userPreferences) {
                    $join->on('Books.author', '=', DB::raw("'".$userPreferences->author."'"))
                         ->orOn('Books.publish_location', '=', DB::raw("'".$userPreferences->publish_location."'"))
                         ->orOn('Books.sublocation', '=', DB::raw("'".$userPreferences->sublocation."'"));
                })
                ->select('Books.*')
                ->orderBy('Books.count', 'desc')
                ->take(10)
                ->get();
        }
    
        return view('dashboard', compact('booksWithHighestCount', 'filteredBooks'));
    }

    public function checkIn($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
    
        // Check if there is a pending check-out request for the specific book and user
        $pendingCheckOutRequest = PendingRequests::where('email', $userEmail)
            ->where('book_request', $title)
            ->where('request_type', 'Check Out')
            ->where('request_status', 'Approved')
            ->first();
    
        if (!$pendingCheckOutRequest) {
            return redirect()->back()->with('error', 'No pending check-out request found for this book.');
        }
    
        $now = Carbon::now('Asia/Manila');
    
        $checkOutRecord = AccountHistory::where('email', $userEmail)
            ->where('books_borrowed', $title)
            ->where('sublocation', $sublocation)
            ->whereNotNull('borrowed_date') 
            ->orderBy('borrowed_date', 'desc') 
            ->first();
    
        if (!$checkOutRecord) {
            return redirect()->back()->with('error', 'No check-out record found for this book.');
        }
    
        if ($checkOutRecord->returned_date !== null) {
            return redirect()->back()->with('error', 'This book has already been checked in.');
        }
    
        // If more than 3 days have passed, calculate fines
        $borrowedDate = Carbon::parse($checkOutRecord->borrowed_date);
        $daysPassed = $borrowedDate->diffInDays($now);
    
        if ($daysPassed > 3) {
            $fineAmount = ($daysPassed - 3) * 50; // 50 is the fine amount per day
            $checkOutRecord->update(['fines' => $fineAmount]);
        }
    
        PendingRequests::where('id', $pendingCheckOutRequest->id)->delete(); // Remove the pending check-out request
    
        /*
        AccountHistory::create([
            'email' => $userEmail,
            'books_borrowed' => $title,
            'returned_date' => $now,
            'fines' => 0, // Initialize fines to 0 for check-in
            'sublocation' => $sublocation,
        ]);
        */
    
        pendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check In',
            'request_status' => 'Pending',
            'expiration_time' => $now->copy()->addHours(1), // Set expiration time for checking in
        ]);
    
        // Check if the request has expired
        $expirationTime = Carbon::parse($pendingCheckOutRequest->expiration_time);
        if ($now->greaterThan($expirationTime)) {
            // The request has expired, show error or redirect as needed
            return redirect()->back()->with('error', 'This check-out request has expired.');
        }
    
        return redirect()->back()->with('success', 'Check-in request submitted successfully!');
    }
    
    
    
    public function checkOut($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
        $now = Carbon::now('Asia/Manila');
    
        // Check if available_copies is greater than 0
        $book = Books::where('title', $title)->first();

        if ($book && $book->available_copies > 0) {
            $book->decrement('available_copies');
    
        }
    
        if (!$book || $book->available_copies <= 0) {
            return redirect()->back()->with('error', 'This book is not available for check-out.');
        }
    
        $expirationTime = $now->copy()->addHours(1);
    
        // Create the check-out request with the expiration time
        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check Out',
            'request_status' => 'Pending',
            'expiration_time' => $expirationTime,
        ]);
    
    
        // Update available_copies in the Books table
        Books::where('title', $title)->update(['count' => DB::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }

}
