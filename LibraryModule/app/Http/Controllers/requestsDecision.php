<?php

namespace App\Http\Controllers;

use App\Models\PendingRequests;
use Illuminate\Http\Request;

class requestsDecision extends Controller
{
    public function approveRequest($id)
    {
        $request = PendingRequests::findOrFail($id);
        $request->update(['request_status' => 'Approved']);

        return redirect()->back();
    }

    public function denyRequest($id)
    {
        $request = PendingRequests::findOrFail($id);
        $request->update(['request_status' => 'Denied']);

        return redirect()->back();
    }
}

