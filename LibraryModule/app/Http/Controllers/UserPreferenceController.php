<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\Books;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    public function save(Request $request)
    {
        $userEmail = Auth::user()->email;

        $request->validate([
            'author' => 'string',
            'publish_location' => 'string',
            'sublocation' => 'string',
        ]);

        // Create a new UserPreference model and save the data
        $user = UserPreference::create([
            'author' => $request->author,
            'publish_location' => $request->publish_location,
            'sublocation' => $request->sublocation,
            'email' => $userEmail,
        ]);

        event(new Registered($user));

        // Redirect back with a success message (you can customize this)
        return redirect()->back()->with('success', 'User preference saved successfully!');
    }

    public function create()
    {
        $publishLocations = Books::distinct('publish_location')->pluck('publish_location');
        
        return view('user_preference', compact('publishLocations'));
    }
}
