<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatronAccountFormRequest;
use App\Models\Library;
use Illuminate\Http\Request;

class PatronAccountController extends Controller
{
    public function __invoke(PatronAccountFormRequest $request){

        $library = Library::create($request->validated());

        return response()->json([
            'message' => 'Account Creation Successful.',
            'data' => $library,
        ]);
    }
}
