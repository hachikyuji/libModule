<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Models\Books;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\pendingRequests;

class handleRequests extends Controller
{
    /*
    public function getRequests(Request $request)
    {
        $pendingRequests = PendingRequests::all();
        $accountHistory = AccountHistory::all();

 
        return view('requests', ['pendingRequests' => $pendingRequests, 'accountHistory' => $accountHistory]);
    }

    public function approveRequest($email, $title, $sublocation)
    {
        // Find the corresponding entry in AccountHistory
        $accountHistoryEntry = AccountHistory::where([
            'email' => $email,
            'books_borrowed' => $title,
            'sublocation' => $sublocation,
        ])->firstOrFail();
    
        $accountHistoryEntry->update(['request_status' => 'Approved']);
            
    
        $request = PendingRequests::where('email', $email)->firstOrFail();
        
        
        $request->update(['request_status' => 'Approved']);
        
        return redirect()->back();
    }
    
    
    
    public function denyRequest($email)
    {
        $request = PendingRequests::where('email', $email)->firstOrFail();
        $request->update(['request_status' => 'Denied']);
    
        return redirect()->back();
    }
    */
}