<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
        if ($request->user() && $request->user()->approval) {
            $user = $request->user();
            Log::info('User approval status:', ['approval' => $user->approval]);
            return $next($request);
        }

        return redirect('admin_restriction')->with('error', 'Forbidden, Contact an admin to access this feature.');
    }
}
