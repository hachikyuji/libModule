<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountHistory;

class PatronHistoryControl extends Controller
{
    public function getUserAccountHistory(Request $request)
    {
        $user = $request->user();

        $accountHistory = AccountHistory::where('email', $user->email)->get();

        return view('patron_history', ['accountHistory' => $accountHistory]);
    }
}

