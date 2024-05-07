<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use App\Mail\ExpiredRequestNotification;
use App\Mail\RequestDecisionNotification;
use App\Mail\ReserveRequestNotification;
use Carbon\Carbon;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendingRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\InitialRequestNotification;

class handleRequests extends Controller
{
    public function getRequests(Request $request)
    {
        $now = Carbon::now('Asia/Manila');
    
        $expiredRequests = PendingRequests::where('expiration_time', '<=', $now)
                                          ->where('request_status', 'Pending')
                                          ->get();

        $threeHoursBeforeExpiry = clone $now;
        $threeHoursBeforeExpiry->addHours(1);

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

        /*
        foreach ($sendRequests as $sendRequests) {
            $this->sendExpiryNotification($sendRequests);
        }
        */
    
        $pendingRequests = PendingRequests::where('expiration_time', '>', $now)
                                          ->where('request_status', 'Pending')
                                          ->get();
    
        $accountHistory = AccountHistory::all();
        
        //  Reservation Notification

        $sendRRequests = PendingRequests::where('initial_notification_sent', 0)
            ->where('request_type', 'Reserve')
            ->get();

        foreach ($sendRRequests as $sendRequests){
            $this->sendReservationNotification($sendRequests);
        }

        //  Accept & Deny Notification

        $sendResponse = PendingRequests::where('request_status_notif', 0)
        ->where(function($query) {
            $query->where('request_status', 'Approved')
                ->orWhere('request_status', 'Denied');
        })
        ->get();

        foreach ($sendResponse as $sendRequests){
            $this->sendAcceptDenyNotification($sendRequests);
        }
        //
    
        return view('requests', ['pendingRequests' => $pendingRequests, 'accountHistory' => $accountHistory]);
    }

    public function getReserveRequests(Request $request)
    {
        $now = Carbon::now('Asia/Manila');

        $sendIRequests = PendingRequests::where('initial_notification_sent', 0)
        ->where(function($query) {
            $query->where('request_type', 'Check Out')
                  ->orWhere('request_type', 'Check In');
        })
        ->get();

        foreach ($sendIRequests as $sendRequests) {
            $this->sendInitialNotification($sendRequests);
        }
    
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
        
        /*
        foreach ($sendRequests as $sendRequest) {
            $this->sendExpiryNotification($sendRequest);
        }
        */
    
        $pendingRequests = PendingRequests::where('expiration_time', '>', $now)
                                          ->where('request_status', 'Pending')
                                          ->where('request_type', 'Reserve')
                                          ->get();
    
        $accountHistory = AccountHistory::all();

        $sendResponse = PendingRequests::where('request_status_notif', 0)
        ->where(function($query) {
            $query->where('request_status', 'Approved')
                ->orWhere('request_status', 'Denied');
        })
        ->get();

        foreach ($sendResponse as $sendRequests){
            $this->sendAcceptDenyNotification($sendRequests);
        }
    
        return view('reservations', ['pendingRequests' => $pendingRequests, 'accountHistory' => $accountHistory]);
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
    
    protected function sendReservationNotification($sendRequests)
    {
        if (!$sendRequests->initial_notification_sent) {
            $emailData = [
                'title' => $sendRequests->book_request,
            ];
    
            Mail::to($sendRequests->email)->send(new ReserveRequestNotification($emailData));
    
            $sendRequests->update(['initial_notification_sent' => true]);
        }
    }

    protected function sendAcceptDenyNotification($sendRequests)
    {
        if (!$sendRequests->request_status_notif) {
            $emailData = [
                'title' => $sendRequests->book_request,
                'request_status' => $sendRequests->request_status,
                'request_type' => $sendRequests->request_type,
            ];
    
            Mail::to($sendRequests->email)->send(new RequestDecisionNotification($emailData['title'], $emailData['request_status'], $emailData['request_type']));
    
            $sendRequests->update(['request_status_notif' => true]);
        }
    }

    public function approveRequest($email, $title, $sublocation, $id, $course, $college)
    {
        // $request = PendingRequests::find($id);
        
        $request = PendingRequests::where('email', $email)
        ->where('request_status', 'Pending')
        ->where('book_request', $title)
        ->first();

        if (!$request || $request->request_status !== 'Pending') {
            return redirect()->back()->with('error', 'Invalid or already processed request.');
        }
    
        if ($request) {
            $request->update(['request_status' => 'Approved']);
            $now = Carbon::now('Asia/Manila');
            $user = User::where('email', $email)->first();
    
            if ($request->request_type === 'Check In') {
                $this->handleCheckIn($request, $now, $title, $sublocation);

                return redirect()->route('requests');

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
                    'college' => $college,
                    'course' => $course,
                ]);

                return redirect()->route('requests');
            }
            
        }
    }

    public function approveReserve($email, $title, $id, $course, $college)
    {
        // $request = PendingRequests::find($id);

        $request = PendingRequests::where('email', $email)
        ->where('request_type', 'Reserve')
        ->where('request_status', 'Pending')
        ->where('book_request', $title)
        ->first();

        if (!$request) {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        if ($request->request_status !== 'Pending') {
            return redirect()->back()->with('error', 'Request has already been processed.');
        }

        if ($request->request_type == 'Reserve') {
            $request->update(['request_status' => 'Approved']);

            $now = Carbon::now('Asia/Manila');
            $expirationTime = $now->copy()->addHours(4); // Adjusts here the expiry date/hour!
            $requestNumber = uniqid();
        
            PendingRequests::create([
                'email' => $email,
                'book_request' => $title,
                'request_date' => $now,
                'request_type' => 'Check Out',
                'request_status' => 'Pending',
                'expiration_time' => $expirationTime,
                'request_number' => $requestNumber,
                'college' => $college,
                'course' => $course,
            ]);
        }

        return redirect()->route('reservations');
    }
    
    private function calculateBookDeadline($accountType)
    {
        $weeksToAdd = ($accountType === 'admin') ? 3 : 2;
        return Carbon::now()->addWeeks($weeksToAdd);
        // return Carbon::now()->addHours(12); // For testing
    }
    
    
    public function denyRequest($email, $title, $id)
{
    $request = PendingRequests::where('email', $email)
        ->where('request_status', 'Pending')
        ->where('book_request', $title)
        ->first();

    if ($request) {
        $book = Books::where('title', $request->book_request)->first();

        if ($book && $request->request_type === 'Check Out' || $request->request_type == 'Reserve') {
            $book->increment('available_copies');
        }

        $request->update(['request_status' => 'Denied']);
    }

    if ($request->request_type == 'Check Out' || $request->request_type == 'Check In'){
        return redirect()->route('requests');
    } elseif($request->request_type == 'Reserve'){
        return redirect()->route('reservations');
    }
    
}

    
    
    private function handleCheckIn($request, $now, $title, $sublocation)
    {
        $userEmail = $request->email;
    
        // Find the corresponding check-out record
        $checkOutRecord = AccountHistory::where('email', $userEmail)
            ->where('books_borrowed', $title)
            ->where('sublocation', $sublocation)
            ->whereNotNull('borrowed_date')
            ->whereNull('returned_date')
            ->orderBy('borrowed_date', 'desc')
            ->first();
    
        if ($checkOutRecord) {
            $checkOutRecord->update([
                'returned_date' => $now,
                'request_number' => $request->id,
            ]);
            $book = Books::where('title', $request->book_request)->first();
            $book->increment('available_copies');
        } else {
            session()->flash('error', 'No corresponding check-out record found for this check-in request.');
        }
    }
    
    protected function handleCheckOut($request)
    {
    $book = Books::where('title', $request->book_request)->first();
    
    // Redundant Code, Keeping for debugging purposes
    /* 
    if ($book && $book->available_copies > 0) {
        // $book->decrement('available_copies');
    }
    */
    }

}