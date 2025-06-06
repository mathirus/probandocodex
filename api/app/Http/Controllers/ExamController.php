<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        return response()->json(['exams' => []]);
    }

    public function questions($exam)
    {
        return response()->json(['questions' => []]);
    }

    public function submit($exam, Request $request)
    {
        return response()->json(['score' => 0]);
    }
}
