@extends('layouts.app')

@section('content')

<form action="{{ route('student.exams.submit', $exam->id) }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-2xl mx-auto mt-8">
    @csrf
    @foreach($exam->questions as $question)
        <div class="mb-6">
            <p class="font-semibold text-gray-800 mb-2">{{ $question->question_text }}</p>
            @if($question->type === 'multiple_choice')
                @foreach($question->options as $option)
                    <label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required
                            class="text-blue-600 focus:ring-blue-500 mr-2">
                        <span class="text-gray-700">{{ $option->option_text }}</span>
                    </label>
                @endforeach
            @else
                <label class="flex items-center mb-2 cursor-pointer">
                    <input type="radio" name="answers[{{ $question->id }}]" value="1" required
                        class="text-blue-600 focus:ring-blue-500 mr-2">
                    <span class="text-gray-700">Verdadero</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="answers[{{ $question->id }}]" value="0" required
                        class="text-blue-600 focus:ring-blue-500 mr-2">
                    <span class="text-gray-700">Falso</span>
                </label>
            @endif
        </div>
    @endforeach

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
        Enviar Examen
    </button>
</form>

@endsection