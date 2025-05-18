@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Mis Exámenes</h1>

    <a href="{{ route('teacher.exams.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6 transition">
        Crear nuevo examen
    </a>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha de creación</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Submisiones</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
        <tr class="hover:bg-gray-100">
            <td class="px-6 py-4 border-b border-gray-200">{{ $exam->title }}</td>
            <td class="px-6 py-4 border-b border-gray-200">{{ $exam->created_at->format('d/m/Y') }}</td>
            <td class="px-6 py-4 border-b border-gray-200">
                <a href="{{ route('teacher.exams.submissions', $exam->id) }}" class="inline-block bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-2 px-3 rounded transition">
                    Ver submisiones
                </a>
            </td>
            <td class="px-6 py-4 border-b border-gray-200">
                <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este examen?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-2 px-3 rounded transition">
                        Eliminar
                    </button>
                </form>
                <a href="{{ route('teacher.exams.questions.create', $exam->id) }}" class="ml-2 text-blue-600 hover:underline text-xs font-semibold">
                    Añadir preguntas
                </a>
                <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="ml-2 text-green-600 hover:underline text-xs font-semibold">
                    Ver preguntas
                </a>
            </td>
        </tr>
    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection