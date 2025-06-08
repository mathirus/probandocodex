<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'dni' => 'required|string|max:20',
            'curso' => 'required|string|max:255',
        ]);

        DB::insert(
            'INSERT INTO users (nombre, apellido, email, password, dni, curso, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $data['nombre'],
                $data['apellido'],
                $data['email'],
                Hash::make($data['password']),
                $data['dni'],
                $data['curso'],
            ]
        );

        return response()->json(['message' => 'User created'], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = DB::selectOne('SELECT * FROM users WHERE email = ?', [$data['email']]);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = bin2hex(random_bytes(40));
        $hashed = hash('sha256', $token);
        DB::insert(
            'INSERT INTO personal_access_tokens (tokenable_type, tokenable_id, name, token, abilities, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
            ['user', $user->id, 'auth_token', $hashed, '["*"]']
        );

        return response()->json(['token' => $token]);
    }
}
