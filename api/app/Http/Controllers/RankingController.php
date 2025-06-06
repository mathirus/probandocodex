<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        $ranking = DB::select(<<<SQL
            SELECT u.nombre, u.apellido, COALESCE(SUM(s.puntaje),0) AS total
            FROM users u
            LEFT JOIN scores s ON s.user_id = u.id
            GROUP BY u.id
            ORDER BY total DESC
        SQL);

        return response()->json(['ranking' => $ranking]);
    }
}
