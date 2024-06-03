<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role_management) {
            return $next($request);
        }

        return redirect('admin_restriction')->with('error', 'Forbidden, Contact an admin to access this feature.');
        
        // return response('Forbidden, Contact an admin to access this feature.', 403);
    }
}
