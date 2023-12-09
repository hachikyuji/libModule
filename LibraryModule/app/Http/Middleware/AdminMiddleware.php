<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->account_type === 'admin') {
            return $next($request);
        }

        // return redirect()->route('login'); 

        return response('Forbidden, Admin Access Only.', 403);
    }
}
