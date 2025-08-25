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

        return response()->json(['dni' => $user->dni]);
    }
}
