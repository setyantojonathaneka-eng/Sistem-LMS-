<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Course $course)
    {
        $quizzes = $course->quizzes()
            ->withCount('questions')
            ->get();

        return response()->json($quizzes);
    }

    public function show(Course $course, Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return response()->json($quiz);
    }

    public function store(Request $request, Course $course)
    {
        if (auth()->user()->role === 'instructor' && $course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title'                         => 'required|string|max:255',
            'passing_score'                 => 'nullable|integer|min:0|max:100',
            'questions'                     => 'required|array|min:1',
            'questions.*.question'          => 'required|string',
            'questions.*.answers'           => 'required|array|min:2',
            'questions.*.answers.*.answer'  => 'required|string',
            'questions.*.answers.*.correct' => 'required|boolean',
        ]);

        $quiz = $course->quizzes()->create([
            'title'         => $request->title,
            'passing_score' => $request->passing_score ?? 70,
        ]);

        foreach ($request->questions as $q) {
            $question = $quiz->questions()->create([
                'question' => $q['question'],
            ]);

            foreach ($q['answers'] as $answer) {
                $question->answers()->create([
                    'answer'     => $answer['answer'],
                    'is_correct' => $answer['correct'],
                ]);
            }
        }

        $quiz->load('questions.answers');

        return response()->json([
            'message' => 'Quiz berhasil dibuat',
            'quiz'    => $quiz,
        ], 201);
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        if (auth()->user()->role === 'instructor' && $course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title'         => 'sometimes|string|max:255',
            'passing_score' => 'nullable|integer|min:0|max:100',
        ]);

        $quiz->update($request->only(['title', 'passing_score']));

        return response()->json([
            'message' => 'Quiz berhasil diupdate',
            'quiz'    => $quiz,
        ]);
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        if (auth()->user()->role === 'instructor' && $course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $quiz->delete();

        return response()->json(['message' => 'Quiz berhasil dihapus']);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers'               => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id'   => 'required|exists:answers,id',
        ]);

        $questions    = $quiz->questions()->with('answers')->get();
        $totalPoints  = $questions->count();
        $earnedPoints = 0;
        $snapshot     = [];

        foreach ($questions as $question) {
            $userAnswer     = collect($request->answers)->firstWhere('question_id', $question->id);
            $selectedAnswer = Answer::find($userAnswer['answer_id'] ?? null);
            $isCorrect      = $selectedAnswer && $selectedAnswer->is_correct;

            if ($isCorrect) $earnedPoints++;

            $snapshot[] = [
                'question'       => $question->question,
                'user_answer'    => $selectedAnswer?->answer,
                'correct_answer' => $question->answers->where('is_correct', true)->first()?->answer,
                'is_correct'     => $isCorrect,
            ];
        }

        // Cast ke integer karena kolom score adalah unsignedTinyInteger (0–100)
        $score  = $totalPoints > 0 ? (int) round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $score >= $quiz->passing_score;

        QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score'   => $score,
            'passed'  => $passed,
        ]);

        return response()->json([
            'message'       => $passed ? 'Selamat! Kamu lulus!' : 'Belum lulus, coba lagi',
            'score'         => $score,
            'passing_score' => $quiz->passing_score,
            'passed'        => $passed,
            'details'       => $snapshot,
        ]);
    }

    public function myAttempts(Quiz $quiz)
    {
        $attempts = QuizAttempt::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->get();

        return response()->json([
            'best_score' => $attempts->max('score'),
            'attempts'   => $attempts,
        ]);
    }
}