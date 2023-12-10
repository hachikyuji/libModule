<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use App\Models\AccountHistory;
use App\Models\pendingRequests;

class QueueController extends Controller
{
    public function getUserQueue(Request $request)
    {
        $user = $request->user();
        $pendingRequests = pendingRequests::where('email', $user->email)->get();

        $queueRequest = Queue::where('email', $user->email)->get();
        $accountHistory = AccountHistory::where('email', $user->email)->get();


        return view('queue', ['queueRequest' => $queueRequest, 'accountHistory' => $accountHistory, 'pendingRequests' => $pendingRequests]);
    }
}
