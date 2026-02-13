<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not authenticated, skip timeout check
        if (!Auth::check()) {
            return $next($request);
        }

        $timeout = 120 * 60;

        $lastActivity = DB::table('sessions')
            ->where('id', session()->getId())
            ->first();

        if ($lastActivity && (time() - $lastActivity->last_activity) > $timeout) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Your session has expired due to inactivity.');
        }

        return $next($request);
    }
}
