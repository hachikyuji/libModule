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
use App\Mail\sendDeadlineNotification;
use App\Mail\ReserveRequestNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class BookController extends Controller
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

        //  Initial Notification

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->where(function($query) {
            $query->where('request_type', 'Check Out')
                  ->orWhere('request_type', 'Check In');
        })
        ->get();

        foreach ($sendIRequests as $sendRequests) {
            $this->sendInitialNotification($sendRequests);
        }
        

        //  Reservation Notification

        $sendRRequests = PendingRequests::where('initial_notification_sent', 0)
            ->where('request_type', 'Reserve')
            ->get();

        foreach ($sendRRequests as $sendRequests){
            $this->sendReservationNotification($sendRequests);
        }

        return view('view', ['books' => $books, 
        'similarAuthorsBooks' => $similarAuthorsBooks,
        'similarSublocationBooks' => $similarSublocationBooks,]);
    }

    public function showBooksWithHighestCount() 
    {
        // This function shows the recommended books on the landing page
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
                $publisher = trim($userPreferences->publisher);
                $sublocation = trim($userPreferences->sublocation);
        
                $query->orWhereRaw("author = ?", [$author])
                    ->orWhereRaw("publisher = ?", [$publisher])
                    ->orWhereRaw("sublocation = ?", [$sublocation]);
            })
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
        }
        

        // Send RequestExpiryNotification
        $now = Carbon::now('Asia/Manila');

        $threeHoursBeforeExpiry = clone $now;
        /*
        $threeHoursBeforeExpiry->addMinutes(5); // Request Expiry

        $sendRequests = PendingRequests::where('expiration_time', '>', $now)
        ->where('expiration_time', '<=', $threeHoursBeforeExpiry)
        ->where('request_status', 'Pending')
        ->get();

        foreach ($sendRequests as $sendRequests) {
            $this->sendExpiryNotification($sendRequests);
        }
        */

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->whereNotIn('request_type', ['Reserve'])
        ->get();

        // Deadline Email
        $deadline = clone $now;
        $deadline->addHours(48);

        $deadlineRequests = AccountHistory::where('book_deadline', '>', $now)
        ->where('deadline_notif', 0)
        ->where('book_deadline', '<=', $deadline)
        ->whereNull('returned_date')
        ->whereNotNull('borrowed_date')
        ->get();

        foreach ($deadlineRequests as $sendDeadRequests){
            $this->sendDeadlineNotification($sendDeadRequests);
        }

        // Request Expiry Handling
        $expiredCheckOutRequests = PendingRequests::where('request_status', 'Pending')
        ->where('expiration_time', '<=', $now)
        ->where(function($query) {
            $query->where('request_type', 'Check Out')
                  ->orWhere('request_type', 'Reserve');
        })
        ->get();

        foreach ($expiredCheckOutRequests as $expiredRequest) {

            $book = Books::where('title', $expiredRequest->book_request)->first();

            if ($book) {
                $book->increment('available_copies');
            }

            $expiredRequest->update(['request_status' => 'Expired']);
        }
        // Request Expiry Handling ends here
    
        return view('dashboard', compact('booksWithHighestCount', 'filteredBooks'));
    }

    public function plmLibrary() 
    {
        // This function shows the recommended books on the landing page
        $booksWithHighestCount = Books::orderBy('count', 'desc')->take(10)->get();
        
        // Send RequestExpiryNotification
        $now = Carbon::now('Asia/Manila');

        $threeHoursBeforeExpiry = clone $now;
        /*
        $threeHoursBeforeExpiry->addMinutes(5);

        $sendRequests = PendingRequests::where('expiration_time', '>', $now)
        ->where('expiration_time', '<=', $threeHoursBeforeExpiry)
        ->where('request_status', 'Pending')
        ->get();

        foreach ($sendRequests as $sendRequests) {
            $this->sendExpiryNotification($sendRequests);
        }
        */
        

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->whereNotIn('request_type', ['Reserve'])
        ->get();

        // Deadline Email
        $deadline = clone $now;
        $deadline->addHours(48);

        $deadlineRequests = AccountHistory::where('book_deadline', '>', $now)
        ->where('book_deadline', '<=', $deadline)
        ->whereNull('returned_date')
        ->whereNotNull('borrowed_date')
        ->get();

        foreach ($deadlineRequests as $sendDeadRequests){
            $this->sendDeadlineNotification($sendDeadRequests);
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
        // ends here
    
        return view('plm_library', compact('booksWithHighestCount'));
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
    
    protected function sendReservationNotification($sendRequests)
    {
        if (!$sendRequests->initial_notification_sent) {
            $emailData = [
                'title' => $sendRequests->book_request,
            ];

            $sendRequests->update(['initial_notification_sent' => true]);
    
            Mail::to($sendRequests->email)->send(new ReserveRequestNotification($emailData));
    
            
        }
    }

    protected function sendDeadlineNotification($sendRequests)
    {
        if (!$sendRequests->deadline_notif) {
            $emailData = [
                'title' => $sendRequests->books_borrowed,
                'expiration_time' => $sendRequests->book_deadline,
            ];
    
            Mail::to($sendRequests->email)->send(new sendDeadlineNotification($emailData['title'], $emailData['expiration_time']));
    
            $sendRequests->update(['deadline_notif' => true]);
        }
    }
    
    public function checkIn($title, $college, $course)
    {
        $userEmail = Auth::user()->email;
    
        // Check for the existence of an approved check-out request
        $pendingCheckOutRequest = AccountHistory::where('email', $userEmail)
            ->where('books_borrowed', $title)
            ->whereNotNull('borrowed_date')
            ->whereNull('returned_date')
            ->first();
    
        if (!$pendingCheckOutRequest) {
            return redirect()->back()->with('error', 'No approved check-out request found for this book.');
        }
    
        $now = Carbon::now('Asia/Manila');
    
        // Create a pending check-in request
        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check In',
            'request_status' => 'Pending',
            'expiration_time' => $now->copy()->addHours(24),
            'request_number' => uniqid(),
            'college' => $college,
            'course' => $course,
        ]);
    
        return redirect()->back()->with('success', 'Check-in request submitted successfully!');
    }
    
    
    
    
    public function checkOut($title, $course, $college, $sublocation)
    {
        $userEmail = Auth::user()->email;
        $now = Carbon::now('Asia/Manila');

        $borrowedBooksCount = AccountHistory::where('email', $userEmail)
            ->whereNull('returned_date')
            ->count();

        if ($borrowedBooksCount >= 2) {
            return redirect()->back()->with('error', 'You have reached the maximum limit of borrowed books.');
        }
    
        $book = Books::where('title', $title)->first();

        if ($book && $book->available_copies > 0) {
            $book->decrement('available_copies');
    
        }
        
        
        if (!$book || $book->available_copies == 0) {
            return redirect()->back()->with('error', 'This book is not available for check-out.');
        }
    
        $expirationTime = $now->copy()->addHours(1); // Adjusts here the expiry date/hour!
        $requestNumber = uniqid();
    
        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Check Out',
            'request_status' => 'Pending',
            'expiration_time' => $expirationTime,
            'request_number' => $requestNumber,
            'college' => $college,
            'course' => $course,
        ]);
    
        Books::where('title', $title)->update(['count' => DB::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Check-out request submitted successfully!');
    }

    public function Reserve($title, $course, $college, $sublocation)
    {
        $userEmail = Auth::user()->email;
        $now = Carbon::now('Asia/Manila');

        $borrowedBooksCount = AccountHistory::where('email', $userEmail)
            ->whereNull('returned_date')
            ->count();

        if ($borrowedBooksCount >= 2) {
            return redirect()->back()->with('error', 'You have reached the maximum limit of borrowed books.');
        }
    
        $book = Books::where('title', $title)->first();

        if ($book && $book->available_copies > 0) {
            $book->decrement('available_copies');
    
        }
        
        if (!$book || $book->available_copies == 0) {
            return redirect()->back()->with('error', 'This book is not available for reservation.');
        }
        
    
        $expirationTime = $now->copy()->addHours(24); // Adjusts here the expiry date/hour!
        $requestNumber = uniqid();
    
        PendingRequests::create([
            'email' => $userEmail,
            'book_request' => $title,
            'request_date' => $now,
            'request_type' => 'Reserve',
            'request_status' => 'Pending',
            'expiration_time' => $expirationTime,
            'request_number' => $requestNumber,
            'college' => $college,
            'course' => $course,
        ]);
    
        Books::where('title', $title)->update(['count' => DB::raw('count + 1')]);
    
        return redirect()->back()->with('success', 'Reservation request submitted successfully!');
    }

    public function plmShow($id)
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

        //  Initial Notification

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
            ->whereNotIn('request_type', ['Reserve'])
            ->get();

        foreach ($sendIRequests as $sendRequests) {
            $this->sendInitialNotification($sendRequests);
        }

        //  Reservation Notification

        $sendRRequests = PendingRequests::where('initial_notification_sent', 0)
            ->where('request_type', 'Reserve')
            ->get();

        foreach ($sendRRequests as $sendRequests){
            $this->sendReservationNotification($sendRequests);
        }

        //

        return view('plm_view', ['books' => $books, 
        'similarAuthorsBooks' => $similarAuthorsBooks,
        'similarSublocationBooks' => $similarSublocationBooks,]);
    }
}
