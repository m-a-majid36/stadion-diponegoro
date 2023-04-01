<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check())
        {
            return redirect('login');
        }

        if (in_array($request->user()->role, $roles))
        {
            return $next($request);
        }
        
        if (Auth::user()->role == 'M' || Auth::user()->role == 'A') {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('/');
        }
    }
}
