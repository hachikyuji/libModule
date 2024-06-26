<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountHistory;

class AccHistoryController extends Controller
{
    public function getUserAccountHistory(Request $request)
    {
        $user = $request->user();

        $accountHistory = AccountHistory::where('email', $user->email)->get();
        
        return view('history', ['accountHistory' => $accountHistory]);
    }
}
