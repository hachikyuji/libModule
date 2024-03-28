<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class SearchController extends Controller
{
/*
    public function index()
    {
        // Add your search logic here
        // You can use $request->input('search_query') to get the search query

        // For example, fetching results from a model:
        $books = Books::search(request('search'))->paginate();

        return view('search', compact('books'));
    }
*/
    function index(Request $request) {
        $books_query = Books::query();

        $search_param = $request->query('q');

        $books = [];

        if ($search_param) {
            $books_query->where(function ($query) use ($search_param) {
                $query
                    ->orWhere('call_number', 'like', "%$search_param%")
                    ->orWhere('author', 'like', "%$search_param%")
                    ->orWhere('title', 'like', "%$search_param%")
                    ->orWhere('sublocation', 'like', "%$search_param%")
                    ->orWhere('publish_date', 'like', "%$search_param%")
                    ->orWhere('publisher', 'like', "%$search_param%");
            });
        }

        $books = $books_query->paginate(50);

        return view('search', compact('books', 'search_param'));
    }

    function visitIndex(Request $request) {
        $books_query = Books::query();

        $search_param = $request->query('q');

        $books = [];

        if ($search_param) {
            $books_query->where(function ($query) use ($search_param) {
                $query
                    ->orWhere('call_number', 'like', "%$search_param%")
                    ->orWhere('author', 'like', "%$search_param%")
                    ->orWhere('title', 'like', "%$search_param%")
                    ->orWhere('sublocation', 'like', "%$search_param%")
                    ->orWhere('publish_date', 'like', "%$search_param%")
                    ->orWhere('publisher', 'like', "%$search_param%");
            });
        }

        $books = $books_query->paginate(50);

        return view('plm_search', compact('books', 'search_param'));
    }
}
