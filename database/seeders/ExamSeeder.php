<?php

namespace Database\seeders;

use App\Models\User;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener un usuario maestro
        $teacher = User::where('role', 'teacher')->first();

        if (!$teacher) {
            $this->command->error('No hay usuarios con rol "teacher". Asegúrate de ejecutar primero el UserSeeder.');
            return;
        }

        $exam = Exam::create([
            'title' => 'Examen de ejemplo',
            'description' => 'Este es un examen de prueba con preguntas mixtas.',
            'created_by' => $teacher->id,
        ]);

        // Pregunta de opción múltiple
        $q1 = Question::create([
            'exam_id' => $exam->id,
            'question_text' => '¿Cuál es la capital de Francia?',
            'type' => 'multiple_choice',
        ]);

        Option::insert([
            ['question_id' => $q1->id, 'option_text' => 'Madrid', 'is_correct' => false],
            ['question_id' => $q1->id, 'option_text' => 'París', 'is_correct' => true],
            ['question_id' => $q1->id, 'option_text' => 'Roma', 'is_correct' => false],
        ]);

        // Pregunta de verdadero/falso
        Question::create([
            'exam_id' => $exam->id,
            'question_text' => 'La Tierra es plana.',
            'type' => 'true_false',
        ]);
    }
}
