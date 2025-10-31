<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user terautentikasi dan role admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Redirect ke home jika bukan admin
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}