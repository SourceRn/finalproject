<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
       $exams = Exam::where('created_by', Auth::id())->get();  // Solo los del profesor logueado
        return view('teacher.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('teacher.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('teacher.exams.index')->with('success', 'Examen creado correctamente');
    }

    public function submissions($examId)
    {
        $exam = Exam::where('id', $examId)->where('created_by', Auth::id())->firstOrFail();
        $submissions = ExamSubmission::where('exam_id', $examId)->with('user')->get();

        return view('teacher.exams.submissions', compact('exam', 'submissions'));
    }

    public function showSubmission($examId, $submissionId)
    {
        $submission = ExamSubmission::with(['answers.question', 'user'])
            ->where('exam_id', $examId)
            ->where('id', $submissionId)
            ->firstOrFail();

        return view('teacher.exams.submission-detail', compact('submission'));
    }

    public function destroy($id)
    {
        $exam = Exam::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
        $exam->delete();

        return redirect()->route('teacher.exams.index')
            ->with('success', 'Examen eliminado correctamente.');
    }
}