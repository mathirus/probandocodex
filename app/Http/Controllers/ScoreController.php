<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $result = DB::selectOne('SELECT COALESCE(SUM(puntaje),0) AS total FROM scores WHERE user_id = ?', [$user->id]);

        return response()->json(['total' => $result ? $result->total : 0]);
    }
}
