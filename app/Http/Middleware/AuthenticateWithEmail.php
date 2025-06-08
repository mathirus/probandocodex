<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticateWithEmail
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $hashed = hash('sha256', $token);
        $record = DB::selectOne('SELECT tokenable_id FROM personal_access_tokens WHERE token = ?', [$hashed]);

        if (!$record) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = DB::selectOne('SELECT * FROM users WHERE id = ?', [$record->tokenable_id]);

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
