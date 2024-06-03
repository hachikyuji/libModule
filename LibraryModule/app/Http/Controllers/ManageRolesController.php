<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ManageRolesController extends Controller
{
    public function show($id)
    {
        $users = User::findOrFail($id);

        return view('manage_roles', ['users' => $users]);
    }

    public function updateAdmin(Request $request) {
        $users = User::where('name', $request->input('name'))
            ->where('email',  $request->input('email'))
            ->firstOrFail();
    
        $users->approval = $request->has('approval') ? 1 : 0;
        $users->fines = $request->has('fines') ? 1 : 0;
        $users->report = $request->has('report') ? 1 : 0;
        $users->book_management = $request->has('book_management') ? 1 : 0;
        $users->role_management = $request->has('role_management') ? 1 : 0;
    
        $users->save();
    
        return redirect()->back()->with('success', 'Admin roles updated successfully!');
    }
    


}
