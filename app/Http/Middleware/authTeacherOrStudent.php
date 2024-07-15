<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class authTeacherOrStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(!(Auth::guard('student')->check() || Auth::guard('teacher')->check())) 
      {
        abort(401);
      }
      return $next($request);
    }
}
