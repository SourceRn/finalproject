@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Agregar Pregunta al Examen: {{ $exam->title }}</h1>

    <form method="POST" action="{{ route('teacher.exams.questions.store', $exam->id) }}" class="bg-white p-6 rounded shadow-md max-w-xl mx-auto">
        @csrf

        <div class="mb-4">
            <label for="question_text" class="block text-gray-700 font-semibold mb-2">Texto de la Pregunta</label>
            <input type="text" name="question_text" id="question_text" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tipo de Pregunta</label>
            <select name="type" id="type" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required onchange="toggleFields()">
                <option value="multiple_choice">Opción Múltiple</option>
                <option value="true_false">Verdadero/Falso</option>
            </select>
        </div>

        {{-- Opción múltiple --}}
        <div id="multiple_choice_fields">
            <label class="block text-gray-700 font-semibold mb-2">Opciones</label>
            @for ($i = 0; $i < 4; $i++)
                <div class="mb-2 flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="{{ $i }}" class="text-blue-600 focus:ring-blue-500">
                    <input type="text" name="options[]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Opción {{ $i + 1 }}">
                </div>
            @endfor
        </div>

        {{-- Verdadero/Falso --}}
        <div id="true_false_fields" class="hidden">
            <label class="block text-gray-700 font-semibold mb-2">Respuesta correcta</label>
            <div class="mb-2 flex items-center space-x-2">
                <input type="radio" name="true_false_answer" value="1" class="text-blue-600 focus:ring-blue-500">
                <span class="text-gray-700">Verdadero</span>
            </div>
            <div class="mb-2 flex items-center space-x-2">
                <input type="radio" name="true_false_answer" value="0" class="text-blue-600 focus:ring-blue-500">
                <span class="text-gray-700">Falso</span>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mt-4 transition">
            Guardar Pregunta
        </button>
    </form>
</div>

{{-- JavaScript para mostrar/ocultar campos según el tipo de pregunta --}}
<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        const mcFields = document.getElementById('multiple_choice_fields');
        const tfFields = document.getElementById('true_false_fields');

        if (type === 'multiple_choice') {
            mcFields.classList.remove('hidden');
            tfFields.classList.add('hidden');
        } else if (type === 'true_false') {
            mcFields.classList.add('hidden');
            tfFields.classList.remove('hidden');
        }
    }

    // Ejecutar al cargar la página para establecer el estado inicial
    document.addEventListener('DOMContentLoaded', function () {
        toggleFields();
    });
</script>
@endsection