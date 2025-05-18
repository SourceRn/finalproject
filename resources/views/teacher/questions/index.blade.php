@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Preguntas del Examen: {{ $exam->title }}
    </h1>

    <a href="{{ route('teacher.exams.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Volver a mis exámenes
    </a>

    <a href="{{ route('teacher.exams.questions.create', $exam->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6 transition">
        Añadir nueva pregunta
    </a>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($questions->isEmpty())
        <p class="text-gray-600">Este examen aún no tiene preguntas.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Texto</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Tipo</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Opción Correcta</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b border-gray-200">{{ $question->question_text }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 capitalize">{{ str_replace('_', ' ', $question->type) }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                @if($question->type === 'multiple_choice')
                                    @php
                                        $correct = $question->options->where('is_correct', true)->first();
                                    @endphp
                                    <span class="text-green-700 font-semibold">
                                        {{ $correct ? $correct->option_text : 'Sin opción correcta' }}
                                    </span>
                                @elseif($question->type === 'true_false')
                                    @php
                                        $correct = $question->options->where('is_correct', true)->first();
                                    @endphp
                                    <span class="text-green-700 font-semibold">
                                        {{ $correct ? $correct->option_text : 'Sin opción correcta' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                <a href="{{ route('teacher.exams.questions.edit', [$exam->id, $question->id]) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
                                <form action="{{ route('teacher.exams.questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta pregunta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection