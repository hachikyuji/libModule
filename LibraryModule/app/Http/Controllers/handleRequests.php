<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Mail\ExpiredRequestNotification;
use Carbon\Carbon;
use App\Models\Books;
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
    
    

    public function approveRequest($email,  $title, $sublocation)
    {
        $request = PendingRequests::where('email', $email)->where('request_status', 'Pending')->first();
    
        if ($request) {
            $request->update(['request_status' => 'Approved']);
            $now = Carbon::now('Asia/Manila');
    
            if ($request->request_type === 'Check In') {
                $this->handleCheckIn($request);
                AccountHistory::create([
                    'email' => $email,
                    'books_borrowed' => $title,
                    'returned_date' => $now,
                    'fines' => 0,
                    'sublocation' => $sublocation,
                ]);
            } elseif ($request->request_type === 'Check Out') {
                $this->handleCheckOut($request);
                AccountHistory::create([
                    'email' => $email,
                    'books_borrowed' => $title,
                    'borrowed_date' => $now,
                    'fines' => 0,
                    'sublocation' => $sublocation,
                ]);
            }
        }




    
        return redirect()->route('requests');
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
    
    
    protected function handleCheckIn($request)
    {
        $book = Books::where('title', $request->book_request)->first();
        
        if ($book) {
            $book->increment('available_copies');
            AccountHistory::where('books_borrowed', $request->book_request)
            ->where('email', $request->email)
            ->update(['fines' => null]);
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