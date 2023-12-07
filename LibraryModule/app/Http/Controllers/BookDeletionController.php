<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Session;

class BookDeletionController extends Controller
{
    public function destroy(Request $request)
    { 
        $callNumber = $request->input('call_number');
        $book = Books::where('call_number', $callNumber)->first();
    
        if ($book) {
            $book->delete();
            Session::flash('success', 'Book terminated successfully!');
        } else {
            Session::flash('error', 'Book not found or could not be terminated.');
        }
    
        return redirect(RouteServiceProvider::MANAGEMENT);
    }

}