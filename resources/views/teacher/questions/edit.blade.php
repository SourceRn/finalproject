@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Pregunta del Examen: {{ $exam->title }}</h1>

    <form method="POST" action="{{ route('teacher.exams.questions.update', [$exam->id, $question->id]) }}" class="bg-white p-6 rounded shadow-md max-w-xl mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="question_text" class="block text-gray-700 font-semibold mb-2">Texto de la Pregunta</label>
            <input type="text" name="question_text" id="question_text" value="{{ old('question_text', $question->question_text) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tipo de Pregunta</label>
            <input type="text" readonly value="{{ ucfirst(str_replace('_', ' ', $question->type)) }}" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100">
        </div>

        @if ($question->type === 'multiple_choice')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Opciones</label>
                @foreach ($question->options as $index => $option)
                    <div class="mb-2 flex items-center space-x-2">
                        <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }}>
                        <input type="text" name="options[]" value="{{ $option->option_text }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                @endforeach
            </div>
        @elseif ($question->type === 'true_false')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Respuesta Correcta</label>
                <select name="true_false_answer" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ $question->trueFalseAnswer && $question->trueFalseAnswer->correct_answer ? 'selected' : '' }}>Verdadero</option>
                    <option value="0" {{ $question->trueFalseAnswer && !$question->trueFalseAnswer->correct_answer ? 'selected' : '' }}>Falso</option>
                </select>
            </div>
        @endif

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
            Actualizar Pregunta
        </button>
    </form>
</div>
@endsection