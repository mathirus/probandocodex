<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticateWithDni
{
    public function handle(Request $request, Closure $next)
    {
        $dni = $request->header('dni');

        if (!$dni) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = DB::selectOne('SELECT * FROM users WHERE dni = ?', [$dni]);

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
