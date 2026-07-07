<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttemptAnswer;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Quiz $quiz)
    {
        $quiz->load(['questions' => fn($q) => $q->where('type', 'essay'), 'attempts.attemptAnswers.question', 'attempts.user']);
        return view('admin.grade-essay', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($validated['scores'] as $answerId => $score) {
            $answer = AttemptAnswer::find($answerId);
            if ($answer && $answer->attempt_id === $attempt->id) {
                $answer->update(['score' => $score !== '' ? (int) $score : null]);
            }
        }

        // Recalculate total score (MC + essay)
        $totalMC = $quiz->questions()->where('type', '!=', 'essay')->count();
        $correctMC = 0;
        $attempt->load('attemptAnswers.question');

        foreach ($attempt->attemptAnswers as $aa) {
            if ($aa->question->type === 'essay') continue;
            if ($aa->score) $correctMC++;
        }

        $essayPoints = $attempt->attemptAnswers->whereNotNull('score')->sum('score');
        $essayCount = $quiz->questions()->where('type', 'essay')->count();
        $maxEssay = $essayCount * 100;
        $essayScore = $maxEssay > 0 ? ($essayPoints / $maxEssay) * 100 : 0;

        $totalQuestions = $totalMC + $essayCount;
        $score = $totalQuestions > 0
            ? round((($totalMC > 0 ? ($correctMC / $totalMC) * 100 : 0) + $essayScore) / 2)
            : 0;
        $passed = $score >= $quiz->passing_score;

        $attempt->update(['score' => $score, 'passed' => $passed]);

        return back()->with('success', 'Nilai essay berhasil disimpan.');
    }
}
