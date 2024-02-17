<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\Books;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class PatronUserPreference extends Controller
{

    public function save(Request $request)
    {
        $userEmail = Auth::user()->email;
    
        $request->validate([
            'author' => 'string',
            'publish_location' => 'string',
            'sublocation' => 'string',
        ]);
    
        $existingPreference = UserPreference::where('email', $userEmail)->first();
    
        if ($existingPreference) {
            $existingPreference->update([
                'author' => $request->author,
                'publish_location' => $request->publish_location,
                'sublocation' => $request->sublocation,
            ]);
    
            $message = 'User preference updated successfully!';
        } else {
            $user = UserPreference::create([
                'author' => $request->author,
                'publish_location' => $request->publish_location,
                'sublocation' => $request->sublocation,
                'email' => $userEmail,
            ]);
    
            event(new Registered($user));
    
            $message = 'User preference saved successfully!';
        }
    
        return redirect()->back()->with('success', $message);
    }

    public function create()
    {
        $publishLocations = Books::distinct('publish_location')->pluck('publish_location');
        
        return view('patron_user_preference', compact('publishLocations'));
    }
}
