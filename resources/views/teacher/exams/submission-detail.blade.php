@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Respuestas de {{ $submission->user->name }}</h1>

    <a href="{{ route('teacher.exams.submissions', $submission->exam_id) }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mb-6 transition">
        Volver
    </a>

    <ul class="space-y-4">
        @foreach ($submission->answers as $answer)
            <li class="bg-white rounded shadow p-4">
                <strong class="block text-gray-700 mb-2">{{ $answer->question->text }}</strong>

                @if ($answer->question->type === 'multiple_choice')
                    <span class="block text-gray-600">Opción seleccionada: <span class="font-semibold">{{ $answer->selectedOption->text ?? 'Ninguna' }}</span></span>
                @elseif ($answer->question->type === 'true_false')
                    <span class="block text-gray-600">Respuesta: <span class="font-semibold">{{ $answer->true_false_answer ? 'Verdadero' : 'Falso' }}</span></span>
                @endif

                <div class="mt-2">
                    <span class="text-gray-700">Resultado:</span>
                    @if ($answer->is_correct === true)
                        <span class="ml-2 text-green-600 font-bold">✅ Correcto</span>
                    @elseif ($answer->is_correct === false)
                        <span class="ml-2 text-red-600 font-bold">❌ Incorrecto</span>
                    @else
                        <span class="ml-2 text-yellow-600 font-bold">⏳ Sin calificar</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection