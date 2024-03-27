<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatronMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->account_type === 'patron') {
            return $next($request);
        }

        // return redirect()->route('login'); 

        return response('Forbidden, Patron Access Only.', 403);
    }
}
