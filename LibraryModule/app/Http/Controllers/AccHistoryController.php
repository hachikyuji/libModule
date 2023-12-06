<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountHistory;

class AccHistoryController extends Controller
{
    public function getUserAccountHistory(Request $request)
    {
        // Get the current logged-in user
        $user = $request->user();

        // Retrieve account history for the user
        $accountHistory = AccountHistory::where('email', $user->email)->get();

        // You can pass $accountHistory to your view or handle it as needed

        // Example: return a view with the account history data
        return view('history', ['accountHistory' => $accountHistory]);
    }
}
