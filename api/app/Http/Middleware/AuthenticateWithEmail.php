<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticateWithEmail
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email') ?: $request->header('X-User-Email');

        if (!$email || !User::where('email', $email)->exists()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = User::where('email', $email)->first();
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
