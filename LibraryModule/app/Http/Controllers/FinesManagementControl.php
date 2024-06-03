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
    
        $accountHistory = AccountHistory::where('email', $userEmail)->first();

        if ($accountHistory) {
            $accountHistory->update(['fines' => $fines]);

            return redirect()->back()->with('success', 'Fines set successfully.');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
}