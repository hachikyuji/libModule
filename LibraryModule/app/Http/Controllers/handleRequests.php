<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
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
}
