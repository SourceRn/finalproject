<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSubmission;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{
    public function index()
    {
       $userId = auth()->id();

        $exams = Exam::with(['teacher', 'submissions' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        return view('student.exams.index', compact('exams'));
    }

    public function show($examId)
    {
        $exam = Exam::with('questions.options')->findOrFail($examId);

        // Verificar si ya lo envió
        $alreadySubmitted = ExamSubmission::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadySubmitted) {
            return redirect()->route('student.exams.index')->with('error', 'Ya has enviado este examen.');
        }

        return view('student.exams.show', compact('exam'));
    }

    public function submit(Request $request, $examId)
{
    $exam = Exam::with('questions.trueFalseAnswer', 'questions.options')->findOrFail($examId);

    $submission = ExamSubmission::create([
        'exam_id' => $exam->id,
        'user_id' => Auth::id(),
        'submitted_at' => now(),
    ]);

    $score = 0;
    $total = $exam->questions->count();

    foreach ($exam->questions as $question) {
        $answer = $request->input("answers.{$question->id}");
        $isCorrect = false;

        if ($question->type === 'multiple_choice') {
            $option = $question->options()->where('id', $answer)->first();
            $isCorrect = $option && $option->is_correct;
        } elseif ($question->type === 'true_false') {
            $correctAnswer = $question->trueFalseAnswer ? $question->trueFalseAnswer->correct_answer : null;
            $isCorrect = (string) $correctAnswer === (string) $answer;
        }

        if ($isCorrect) {
            $score++;
        }

        QuestionAnswer::create([
            'submission_id' => $submission->id,
            'question_id' => $question->id,
            'selected_option_id' => $question->type === 'multiple_choice' ? $answer : null,
            'true_false_answer' => $question->type === 'true_false' ? $answer : null,
            'is_correct' => $isCorrect,
        ]);
    }

    $submission->score = $score;
    $submission->save();

    return redirect()->route('student.exams.index')->with('success', 'Examen enviado. Calificación: ' . $score . '/' . $total);
}
}
