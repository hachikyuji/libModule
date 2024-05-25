<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use App\Models\AccountHistory;
use App\Models\pendingRequests;
use Carbon\Carbon;
use App\Models\Books;

class QueueController extends Controller
{
    public function getUserQueue(Request $request)
    {
        $user = $request->user();
        $pendingRequests = pendingRequests::where('email', $user->email)->get();

        $queueRequest = Queue::where('email', $user->email)->get();
        $accountHistory = AccountHistory::where('email', $user->email)->get();

        // Request Expiry Handling
        $now = Carbon::now('Asia/Manila');

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

        // ends here

        return view('queue', ['queueRequest' => $queueRequest, 'accountHistory' => $accountHistory, 'pendingRequests' => $pendingRequests]);
    }
}
