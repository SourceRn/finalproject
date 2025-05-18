<?php

namespace Database\seeders;

use App\Models\Exam;
use App\Models\ExamSubmission;
use App\Models\Question;
use App\Models\Option;
use App\Models\QuestionAnswer;
use App\Models\TrueFalseAnswer;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $exam = Exam::first();
        $questions = Question::where('exam_id', $exam->id)->get();
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            $submission = ExamSubmission::create([
                'exam_id' => $exam->id,
                'user_id' => $student->id,
                'submitted_at' => now(),
            ]);

            foreach ($questions as $question) {
                if ($question->type === 'multiple_choice') {
                    // Seleccionar una opción aleatoria
                    $option = Option::where('question_id', $question->id)->inRandomOrder()->first();

                    QuestionAnswer::create([
                        'submission_id' => $submission->id,
                        'question_id' => $question->id,
                        'selected_option_id' => $option?->id,
                        'true_false_answer' => null,
                    ]);
                }

                if ($question->type === 'true_false') {
                    $answer = [true, false][rand(0, 1)];

                    QuestionAnswer::create([
                        'submission_id' => $submission->id,
                        'question_id' => $question->id,
                        'selected_option_id' => null,
                        'true_false_answer' => $answer,
                    ]);
                }
            }
        }
    }
}