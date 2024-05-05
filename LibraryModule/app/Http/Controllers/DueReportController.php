<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccountHistory;
use Carbon\Carbon;
use App\Mail\OverdueReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class DueReportController extends Controller
{
    public function overdueBooks(Request $request)
    {
        $overdueHistoriesQuery = AccountHistory::select('account_history.*', 'users.name as user_name')
            ->join('users', 'users.email', '=', 'account_history.email');
    
        $searchParam = $request->query('q');
    
        if ($searchParam) {
            $overdueHistoriesQuery->where(function ($query) use ($searchParam) {
                $query
                    ->orWhere('account_history.email', 'like', "%$searchParam%")
                    ->orWhere('books_borrowed', 'like', "%$searchParam%")
                    ->orWhere('borrowed_date', 'like', "%$searchParam%")
                    ->orWhere('book_deadline', 'like', "%$searchParam%")
                    ->orWhere('account_history.college', 'like', "%$searchParam%") 
                    ->orWhere('account_history.course', 'like', "%$searchParam%");
            });
        }
    
        $overdueHistories = $overdueHistoriesQuery
            ->whereNull('returned_date')
            ->where('book_deadline', '<', Carbon::now())
            ->paginate(50);
    
        return view('due_report', ['overdueHistories' => $overdueHistories, 'search_param' => $searchParam]);
    }
    
    public function sendReport(Request $request)
    {
        $filter = $request->input('filter');
        $email = $request->input('email');
    
        Log::info("Search Param: $filter");
    
        $overdueHistoriesQuery = AccountHistory::select('account_history.*', 'users.name as user_name')
            ->join('users', 'users.email', '=', 'account_history.email');
    
        if ($filter) {
            $overdueHistoriesQuery->where(function ($query) use ($filter) {
                $query
                    ->orWhere('account_history.email', 'like', "%$filter%")
                    ->orWhere('books_borrowed', 'like', "%$filter%")
                    ->orWhere('borrowed_date', 'like', "%$filter%")
                    ->orWhere('book_deadline', 'like', "%$filter%")
                    ->orWhere('account_history.college', 'like', "%$filter%") 
                    ->orWhere('account_history.course', 'like', "%$filter%");
            });
        }
    
        $overdueHistories = $overdueHistoriesQuery
            ->whereNull('returned_date')
            ->where('book_deadline', '<', Carbon::now())
            ->paginate(50);
    
        Mail::to($email)->send(new OverdueReportMail($overdueHistories));
    
        return redirect()->back()->with('success', 'Report sent successfully.');
    }
        
}
