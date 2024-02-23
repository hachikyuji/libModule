<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Mail\ExpiredRequestNotification;
use Carbon\Carbon;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendingRequests;
use Illuminate\Support\Facades\Mail;

class handleRequests extends Controller
{
    public function getRequests(Request $request)
    {
        $now = Carbon::now('Asia/Manila');
    
        $expiredRequests = PendingRequests::where('expiration_time', '<=', $now)
                                          ->where('request_status', 'Pending')
                                          ->get();

        $threeHoursBeforeExpiry = clone $now;
        $threeHoursBeforeExpiry->addHours(3);

        $sendRequests = PendingRequests::where('expiration_time', '>', $now)
                        ->where('expiration_time', '<=', $threeHoursBeforeExpiry)
                        ->where('request_status', 'Pending')
                        ->get();
    
        foreach ($expiredRequests as $expiredRequest) {
            $book = Books::where('title', $expiredRequest->book_request)->first();
    
            if ($book) {
                $book->increment('available_copies');
            }
    
            $expiredRequest->update(['request_status' => 'Expired']);
        }

        foreach ($sendRequests as $sendRequests) {
            $this->sendExpiryNotification($sendRequests);
        }
    
        $pendingRequests = PendingRequests::where('expiration_time', '>', $now)
                                          ->where('request_status', 'Pending')
                                          ->get();
    
        $accountHistory = AccountHistory::all();
    
        return view('requests', ['pendingRequests' => $pendingRequests, 'accountHistory' => $accountHistory]);
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
    
    

    public function approveRequest($email, $title, $sublocation)
    {
        $request = PendingRequests::where('email', $email)->where('request_status', 'Pending')->first();
    
        if ($request) {
            $request->update(['request_status' => 'Approved']);
            $now = Carbon::now('Asia/Manila');
            $user = User::where('email', $email)->first();
    
            if ($request->request_type === 'Check In') {
                $this->handleCheckIn($request, $now, $title, $sublocation);
            } elseif ($request->request_type === 'Check Out') {
                $this->handleCheckOut($request);
                $bookDeadline = $this->calculateBookDeadline($user->account_type);
    
                AccountHistory::create([
                    'email' => $email,
                    'books_borrowed' => $title,
                    'borrowed_date' => $now,
                    'fines' => 0,
                    'sublocation' => $sublocation,
                    'request_number' => $request->request_number,
                    'book_deadline' => $bookDeadline,
                ]);
            }
        }
    
        return redirect()->route('requests');
    }
    
    private function calculateBookDeadline($accountType)
    {
        $weeksToAdd = ($accountType === 'admin') ? 3 : 2;
        return Carbon::now()->addWeeks($weeksToAdd);
        // return Carbon::now()->addHours(12); // For testing
    }
    
    
    public function denyRequest($email)
    {
        $request = PendingRequests::where('email', $email)->where('request_status', 'Pending')->first();

        if ($request) {
            $book = Books::where('title', $request->book_request)->first();
    
            if ($book && $request->request_type === 'Check Out') {
                $book->increment('available_copies');
            }
    
            $request->update(['request_status' => 'Denied']);
        }
    
        return redirect()->route('requests');
    }
    
    
    private function handleCheckIn($request, $now, $title, $sublocation)
    {
        $userEmail = $request->email;
        $book = Books::where('title', $request->book_request)->first();
    
        // Find the corresponding check-out record
        $checkOutRecord = AccountHistory::where('email', $userEmail)
            ->where('books_borrowed', $title)
            ->where('sublocation', $sublocation)
            ->whereNotNull('borrowed_date')
            ->whereNull('returned_date')
            ->orderBy('borrowed_date', 'desc')
            ->first();
    
        if ($checkOutRecord) {
            // Update the existing check-out record with returned date and request number
            $checkOutRecord->update([
                'returned_date' => $now,
                'request_number' => $request->id, // Assuming request id is unique
            ]);
    
            $book->increment('available_copies');
        } else {
            // No corresponding check-out record found, store error message in session
            session()->flash('error', 'No corresponding check-out record found for this check-in request.');
        }
    }
    
    protected function handleCheckOut($request)
    {
    $book = Books::where('title', $request->book_request)->first();
    
    if ($book && $book->available_copies > 0) {
        // $book->decrement('available_copies');
    }
}

}