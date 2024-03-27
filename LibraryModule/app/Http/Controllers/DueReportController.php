<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccountHistory;
use Carbon\Carbon;
use App\Mail\OverdueReportMail;
use Illuminate\Support\Facades\Mail;

class DueReportController extends Controller
{
    public function overdueBooks()
    {
        $overdueHistories = AccountHistory::select('account_history.*', 'users.name as user_name')
            ->join('users', 'users.email', '=', 'account_history.email')
            ->whereNull('returned_date')
            ->where('book_deadline', '<', Carbon::now())
            ->get();
    

        return view('due_report', ['overdueHistories' => $overdueHistories]);
    }

    public function sendReport(Request $request)
    {
        $overdueHistories = AccountHistory::select('account_history.*', 'users.name as user_name')
            ->join('users', 'users.email', '=', 'account_history.email')
            ->whereNull('returned_date')
            ->where('book_deadline', '<', Carbon::now())
            ->get();

        $email = $request->input('email');

        Mail::to($email)->send(new OverdueReportMail($overdueHistories));

        return redirect()->back()->with('success', 'Report sent successfully.');
    }
}
