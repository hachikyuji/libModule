<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\pendingRequests;
use Illuminate\Http\Request;
use App\Models\AccountHistory;

class PatronQueueControl extends Controller
{
    public function getUserQueue(Request $request
    )
    {
        $user = $request->user();
        $pendingRequests = pendingRequests::where('email', $user->email)->get();

        $queueRequest = Queue::where('email', $user->email)->get();
        $accountHistory = AccountHistory::where('email', $user->email)->get();


        return view('patron_queue', ['queueRequest' => $queueRequest, 'accountHistory' => $accountHistory, 'pendingRequests' => $pendingRequests]);
    }

}
