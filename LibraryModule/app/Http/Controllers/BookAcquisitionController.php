<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookAcquisitionController extends Controller
{
    public function create(): View
    {
        return view('book_acquisition');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'call_number' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'publish_location' => ['required', 'string', 'max:255'],
            'publish_date' => ['required', 'date'],
            'available_copies' => ['required', 'integer', 'max:10'],
            'total_copies' => ['required', 'integer', 'max:10'],
            'sublocation' => ['required', 'string', 'max:255'],
            'book_description' => ['required', 'string', 'max:255'],
        ]);
    
        $user = Books::create([
            'call_number' => $request->call_number,
            'author' => $request->author,
            'title' => $request->title,
            'publish_location' => $request->publish_location,
            'publish_date' => $request->publish_date,
            'available_copies' => $request->available_copies,
            'total_copies' => $request->total_copies,
            'sublocation' => $request->sublocation,
            'book_description' => $request->book_description,

        ]);
    
        event(new Registered($user));
    
    
        return redirect(RouteServiceProvider::MANAGEMENT);
    }
}
