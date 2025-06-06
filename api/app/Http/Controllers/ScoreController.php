<?php

namespace App\Http\Controllers;

class ScoreController extends Controller
{
    public function index()
    {
        return response()->json(['scores' => []]);
    }
}
