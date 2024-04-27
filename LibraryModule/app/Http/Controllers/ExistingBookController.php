<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Session;

class ExistingBookController extends Controller
{
    public function show($id)
    {
        $books = Books::findOrFail($id);

        return view('modify_book', ['books' => $books]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'available_copies' => ['required', 'integer', 'max:10'],
            'total_copies' => ['required', 'integer', 'max:10'],
        ]);
        
        try {
            $book = Books::where('call_number', $request->call_number)->firstOrFail();
    
            $book->update([
                'available_copies' => $request->available_copies,
                'total_copies' => $request->total_copies,
            ]);
    
            Session::flash('success', 'Book acquisition successful.');

            return redirect()->back()->with('success', 'Book copies updated successfully.');
        } catch (\Exception $e) {
            Session::flash('error', 'Book acquisition successful.');
            return redirect()->back()->with('error', 'Failed to update book copies: ' . $e->getMessage());
        }
    }
    
}
