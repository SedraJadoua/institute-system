<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class authTeacherOrStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(auth()->guard('student')->user() || auth()->guard('teacher')->user()) 
      {
        return $next($request);
      }
      return response()->json([
        'message' => 'Unauthenticated',
      ] , 403);
    }
}
