<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use App\Models\TrueFalseAnswer;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        if ($exam->created_by !== auth()->id()) {
            abort(403);
        }

        $questions = $exam->questions;
        return view('teacher.questions.index', compact('exam', 'questions'));
    }

    public function create($examId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', auth()->id())->firstOrFail();
        return view('teacher.questions.create', compact('exam'));
    }

    public function store(Request $request, $examId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', auth()->id())->firstOrFail();

        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false',
            'options' => 'array|nullable',
            'options.*' => 'nullable|string',
            'correct_option' => 'nullable|integer',
            'true_false_answer' => 'nullable|boolean',
        ]);

        $question = $exam->questions()->create([
            'question_text' => $request->question_text,
            'type' => $request->type,
        ]);

        if ($request->type === 'multiple_choice') {
            if ($request->has('options')) {
                foreach ($request->options as $index => $optionText) {
                    if (!is_null($optionText)) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'is_correct' => ($index == $request->correct_option),
                        ]);
                    }
                }
            }
        } elseif ($request->type === 'true_false') {
            $question->trueFalseAnswer()->create([
                'correct_answer' => $request->true_false_answer,
            ]);
        }

        return redirect()->route('teacher.exams.questions.index', $examId)->with('success', 'Pregunta añadida al examen.');
    }

    public function edit($examId, $questionId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', auth()->id())->firstOrFail();
        $question = $exam->questions()->where('id', $questionId)->firstOrFail();

        return view('teacher.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, $examId, $questionId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', auth()->id())->firstOrFail();
        $question = $exam->questions()->where('id', $questionId)->firstOrFail();

        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false',
            'options' => 'array|nullable',
            'options.*' => 'nullable|string',
            'correct_option' => 'nullable|integer',
            'true_false_answer' => 'nullable|boolean',
        ]);

        $question->update([
            'question_text' => $request->question_text,
        ]);

        if ($request->type === 'multiple_choice') {
            $question->options()->delete();
            if ($request->has('options')) {
                foreach ($request->options as $index => $optionText) {
                    if (!is_null($optionText)) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'is_correct' => ($index == $request->correct_option),
                        ]);
                    }
                }
            }
            $question->trueFalseAnswer()->delete();
        } elseif ($request->type === 'true_false') {
            $question->options()->delete();
            $question->trueFalseAnswer()->updateOrCreate(
                ['question_id' => $question->id],
                ['correct_answer' => $request->true_false_answer == '1']
            );
        }

        return redirect()->route('teacher.exams.questions.index', $examId)
            ->with('success', 'Pregunta actualizada correctamente.');
    }

    public function destroy($examId, $questionId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', auth()->id())->firstOrFail();
        $question = $exam->questions()->where('id', $questionId)->firstOrFail();
        $question->delete();

        return redirect()->route('teacher.exams.questions.index', $examId)->with('success', 'Pregunta eliminada correctamente.');
    }
}

