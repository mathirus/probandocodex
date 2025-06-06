<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index()
    {
        $exams = DB::select('SELECT id, titulo, fecha_inicio, fecha_fin FROM exams WHERE fecha_inicio <= CURDATE() AND fecha_fin >= CURDATE()');

        return response()->json(['exams' => $exams]);
    }

    public function questions($exam)
    {
        $questions = DB::select('SELECT id, enunciado FROM questions WHERE exam_id = ? ORDER BY RAND() LIMIT 10', [$exam]);

        foreach ($questions as $question) {
            $answers = DB::select('SELECT id, contenido FROM answers WHERE question_id = ?', [$question->id]);
            $question->answers = $answers;
        }

        return response()->json(['questions' => $questions]);
    }

    public function submit($exam, Request $request)
    {
        $user = $request->user();

        $existing = DB::selectOne('SELECT id FROM scores WHERE user_id = ? AND exam_id = ?', [$user->id, $exam]);
        if ($existing) {
            return response()->json(['message' => 'Exam already taken'], 400);
        }

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($answers as $questionId => $answerId) {
            $correct = DB::selectOne('SELECT es_correcta FROM answers WHERE id = ? AND question_id = ?', [$answerId, $questionId]);
            if ($correct && $correct->es_correcta) {
                $score++;
            }
        }

        DB::insert('INSERT INTO scores (user_id, exam_id, puntaje, created_at) VALUES (?, ?, ?, NOW())', [$user->id, $exam, $score]);

        return response()->json(['score' => $score]);
    }
}
