<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\PendingRequests;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\ExpiredRequestNotification;
use App\Mail\InitialRequestNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PatronBookControll extends Controller
{
    private $books;

    public function show($id)
    {
        $books = Books::findOrFail($id);

        $similarAuthorsBooks = Books::where('author', $books->author)
            ->where('id', '!=', $books->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $similarSublocationBooks = Books::where('sublocation', $books->sublocation)
            ->where('id', '!=', $books->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        //Initial Notification

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->whereNotIn('request_type', ['Reserve'])
        ->get();

        foreach ($sendIRequests as $sendRequests) {
            $this->sendInitialNotification($sendRequests);
        }

        //

        return view('patron_view', ['books' => $books, 
        'similarAuthorsBooks' => $similarAuthorsBooks,
        'similarSublocationBooks' => $similarSublocationBooks,]);
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
    
        $filteredBooks = []; 
    
        if ($userPreferences) {
            $filteredBooks = Books::where(function($query) use ($userPreferences) {
                $author = trim($userPreferences->author);
                $publishLocation = trim($userPreferences->publish_location);
                $sublocation = trim($userPreferences->sublocation);
        
                $query->orWhereRaw("author = ?", [$author])
                    ->orWhereRaw("publish_location = ?", [$publishLocation])
                    ->orWhereRaw("sublocation = ?", [$sublocation]);
            })
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
        }

        $now = Carbon::now('Asia/Manila');

        $threeHoursBeforeExpiry = clone $now;
        $threeHoursBeforeExpiry->addHours(3);

        $sendRequests = PendingRequests::where('expiration_time', '>', $now)
        ->where('expiration_time', '<=', $threeHoursBeforeExpiry)
        ->where('request_status', 'Pending')
        ->get();

        foreach ($sendRequests as $sendRequests) {
            $this->sendExpiryNotification($sendRequests);
        }

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->get();

        foreach ($sendIRequests as $sendRequests) {
            $this->sendInitialNotification($sendRequests);
        }

        // Request Expiry Handling
        $expiredCheckOutRequests = PendingRequests::where('request_type', 'Check Out')
        ->where('request_status', 'Pending')
        ->where('expiration_time', '<=', $now)
        ->get();

        foreach ($expiredCheckOutRequests as $expiredRequest) {

            $book = Books::where('title', $expiredRequest->book_request)->first();

            if ($book) {
                $book->increment('available_copies');
            }

            $expiredRequest->update(['request_status' => 'Expired']);
        }
    
        return view('patron_dashboard', compact('booksWithHighestCount', 'filteredBooks'));
    }

    protected function sendExpiryNotification($sendRequests)
    {
        if (!$sendRequests->notification_sent) {
            $emailData = [
                'title' => $sendRequests->book_request,
                'expiration_time' => $sendRequests->expiration_time,
            ];
    
            Mail::to($sendRequests->email)->send(new ExpiredRequestNotification($emailData['title'], $emailData['expiration_time']));

            $sendRequests->update(['notification_sent' => true]);
        }
    }

    protected function sendInitialNotification($sendRequests)
    {
        if (!$sendRequests->initial_notification_sent) {
            $emailData = [
                'title' => $sendRequests->book_request,
            ];
    
            Mail::to($sendRequests->email)->send(new InitialRequestNotification($emailData));
    
            $sendRequests->update(['initial_notification_sent' => true]);
        }
    }
    

    public function checkIn($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
    
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
    
        /* Library does not have a fine system anymore
        $borrowedDate = Carbon::parse($checkOutRecord->borrowed_date);
        $daysPassed = $borrowedDate->diffInDays($now);
    
        if ($daysPassed > 3) {
            $fineAmount = ($daysPassed - 3) * 50;
            $checkOutRecord->update(['fines' => $fineAmount]);
        }
        */
    
        PendingRequests::where('id', $pendingCheckOutRequest->id)->delete();
    
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
            'expiration_time' => $now->copy()->addHours(24),
        ]);
    
        $expirationTime = Carbon::parse($pendingCheckOutRequest->expiration_time);
        if ($now->greaterThan($expirationTime)) {
            return redirect()->back()->with('error', 'This check-out request has expired.');
        }
    
        return redirect()->back()->with('success', 'Check-in request submitted successfully!');
    }
    
    
    
    public function checkOut($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
        $now = Carbon::now('Asia/Manila');
    
        $book = Books::where('title', $title)->first();

        if ($book && $book->available_copies > 0) {
            $book->decrement('available_copies');
    
        }
    
        if (!$book || $book->available_copies <= 0) {
            return redirect()->back()->with('error', 'This book is not available for check-out.');
        }
    
        $expirationTime = $now->copy()->addHours(1);

        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check Out',
            'request_status' => 'Pending',
            'expiration_time' => $expirationTime,
        ]);
    
        Books::where('title', $title)->update(['count' => DB::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }
    
    public function Reserve($title, $sublocation)
    {
        $userEmail = Auth::user()->email;
        $now = Carbon::now('Asia/Manila');
    
        $book = Books::where('title', $title)->first();

        if ($book && $book->available_copies > 0) {
            $book->decrement('available_copies');
    
        }
        
        
        if (!$book || $book->available_copies == 0) {
            return redirect()->back()->with('error', 'This book is not available for reservation.');
        }
        
    
        $expirationTime = $now->copy()->addHours(72); // Adjusts here the expiry date/hour!
        $requestNumber = uniqid();
    
        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Reserve',
            'request_status' => 'Pending',
            'expiration_time' => $expirationTime,
            'request_number' => $requestNumber,
        ]);
    
        Books::where('title', $title)->update(['count' => DB::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Reservation request submitted successfully!');
    }

    

}
