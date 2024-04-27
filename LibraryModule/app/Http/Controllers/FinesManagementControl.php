<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountHistory;
use App\Models\User;
use App\Models\pendingRequests;

class FinesManagementControl extends Controller
{
    function index(Request $request) {
        $request_query = AccountHistory::query();
        

        $search_param = $request->query('q');

        if ($search_param) {
            $request_query->where(function ($query) use ($search_param) {
                $query
                    ->orWhere('books_borrowed', 'like', "%$search_param%")
                    ->orWhere('email', 'like', "%$search_param%");
            });
        }

        $request = $request_query->get();

        return view('fines_management', compact('request', 'search_param'));
    }

    public function setFines(Request $request)
    {
        $userEmail = $request->input('email');
        $fines = $request->input('fines');
    
        // Find the corresponding record in the accounthistory table
        $accountHistory = AccountHistory::where('email', $userEmail)->first();

        if ($accountHistory) {
            // Update the 'fines' column with the new value
            $accountHistory->update(['fines' => $fines]);

            return redirect()->back()->with('success', 'Fines set successfully');
        } else {
            // Handle the case where the user with the provided email is not found
            return redirect()->back()->with('error', 'User not found');
        }
    }
}