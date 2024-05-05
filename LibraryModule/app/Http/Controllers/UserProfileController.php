<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountHistory;
Use App\Models\Books;
use App\Models\User;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $accountHistory = AccountHistory::where('email', $user->email)
            ->where('book_deadline', '<', Carbon::now())
            ->whereNull('returned_date')
            ->get();

        return view('user_profile', ['accountHistory' => $accountHistory]);
    }

    public function pindex(Request $request)
    {
        $user = $request->user();

        $accountHistory = AccountHistory::where('email', $user->email)
            ->where('book_deadline', '<', Carbon::now())
            ->whereNull('returned_date')
            ->get();

        return view('patron_user_profile', ['accountHistory' => $accountHistory]);
    }

    public function patron_view($id)
    {
        $user = User::findOrFail($id);

        $accountHistory = AccountHistory::where('email', $user->email)
            ->where('book_deadline', '<', Carbon::now())
            ->whereNull('returned_date')
            ->get();
        
        return view('view_patron', ['user' => $user, 'accountHistory' => $accountHistory]);
    }
}
