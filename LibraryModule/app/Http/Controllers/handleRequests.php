<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\pendingRequests;

class handleRequests extends Controller
{
    public function getRequests(Request $request)
    {
        $pendingRequests = PendingRequests::all();
        $accountHistory = AccountHistory::all();

 
        return view('requests', ['pendingRequests' => $pendingRequests, 'accountHistory' => $accountHistory]);
    }

    public function approveRequest($email)
    {
        // Find the first pending request for the given email
        $request = PendingRequests::where('email', $email)->where('request_status', 'Pending')->first();
    
        if ($request) {
            // Update the specific request to 'Approved'
            $request->update(['request_status' => 'Approved']);
    
            // Handle Check In or Check Out based on request type
            if ($request->request_type === 'Check In') {
                $this->handleCheckIn($request);
            } elseif ($request->request_type === 'Check Out') {
                $this->handleCheckOut($request);
            }
        }
    
        return redirect()->route('requests');
    }
    
    public function denyRequest($email)
    {
        // Find the first pending request for the given email
        $request = PendingRequests::where('email', $email)->where('request_status', 'Pending')->first();
    
        if ($request) {
            // Update the specific request to 'Denied'
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
        $book->decrement('available_copies');


    }
}

}