<?php

namespace App\Http\Controllers;

class RankingController extends Controller
{
    public function index()
    {
        return response()->json(['ranking' => []]);
    }
}
