<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  
     public function handle($request, Closure $next, $permission)
     {
         if (!Auth::check() || !Auth::user()->can($permission)) {
             abort(403, 'Unauthorized');
         }
 
         return $next($request);
     }
}
