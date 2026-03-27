<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AutoLogout {
    public function handle($request, Closure $next) {
        if (Auth::check()) {
            $timeout = 1800; // 30 minutes
            if (session('last_activity') && (time() - session('last_activity') > $timeout)) {
                Auth::logout();
                session()->flush();
                return redirect('/login')->with('error', 
                    '⏱️ Session expirée. Reconnectez-vous.');
            }
            session(['last_activity' => time()]);
        }
        return $next($request);
    }
}