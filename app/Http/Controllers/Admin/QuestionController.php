<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Tampilkan halaman kelola soal untuk 1 quiz tertentu.
     */
    public function index(Quiz $quiz)
    {
        $quiz->load(['questions.answers', 'course']);

        return view('admin.quiz-questions', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * Simpan soal baru + pilihan jawabannya untuk quiz ini.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $rules = [
            'question' => 'required|string|max:1000',
            'type'     => 'required|in:multiple_choice,essay',
        ];

        if ($request->input('type') === 'essay') {
            $rules['key_answer'] = 'nullable|string|max:5000';
        } else {
            $rules['answers']        = 'required|array|min:2|max:6';
            $rules['answers.*']      = 'required|string|max:500';
            $rules['correct_answer'] = 'required|integer|min:0';
        }

        $validated = $request->validate($rules);

        if (($validated['type'] ?? 'multiple_choice') !== 'essay') {
            if (!array_key_exists($validated['correct_answer'], $validated['answers'])) {
                return back()->withErrors([
                    'correct_answer' => 'Pilih salah satu jawaban sebagai kunci yang benar.',
                ])->withInput();
            }
        }

        DB::transaction(function () use ($validated, $quiz) {
            $question = Question::create([
                'quiz_id'  => $quiz->id,
                'question' => $validated['question'],
                'type'     => $validated['type'] ?? 'multiple_choice',
            ]);

            if (($validated['type'] ?? 'multiple_choice') === 'essay') {
                if (!empty($validated['key_answer'])) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer'      => $validated['key_answer'],
                        'is_correct'  => true,
                    ]);
                }
            } else {
                foreach ($validated['answers'] as $index => $answerText) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer'      => $answerText,
                        'is_correct'  => (int) $index === (int) $validated['correct_answer'],
                    ]);
                }
            }
        });

        return redirect()->route('admin.quizzes.questions.index', $quiz->id)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Hapus 1 soal (otomatis hapus jawabannya lewat cascade).
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $question->delete();

        return redirect()->route('admin.quizzes.questions.index', $quiz->id)
            ->with('success', 'Soal berhasil dihapus.');
    }
}