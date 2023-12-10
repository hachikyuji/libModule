<?php

namespace App\Http\Controllers;

use App\Models\AccountHistory;
use Illuminate\Http\Request;
use App\Models\pendingRequests;

class RequestHistory extends Controller
{
    function index(Request $request) {
        $request_query = pendingRequests::query();

        $search_param = $request->query('q');

        if ($search_param) {
            $request_query->where(function ($query) use ($search_param) {
                $query
                    ->orWhere('book_request', 'like', "%$search_param%")
                    ->orWhere('email', 'like', "%$search_param%")
                    ->orWhere('request_status', 'like', "%$search_param%")
                    ->orWhere('request_type', 'like', "%$search_param%")
                    ->orWhere('id', 'like', "%$search_param%");
            });
        }

        $request = $request_query->get();

        return view('requests_history', compact('request', 'search_param'));
    }
}
