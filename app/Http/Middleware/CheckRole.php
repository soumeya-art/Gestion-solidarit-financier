<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            if (auth()->user()->isAdmin()) return redirect('/dashboard/admin');
            if (auth()->user()->isCaissier()) return redirect('/dashboard/caissier');
            return redirect('/dashboard/membre');
        }

        return $next($request);
    }
}
